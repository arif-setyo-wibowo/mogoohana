<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Cart;
use App\Models\Kupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderNotificationMail;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ValidateCouponRequest;

class ShopCheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = Cart::getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home.index')->with('error', 'Your cart is empty. Please add products first.');
        }
        $total = Cart::calculateTotal();

        return view('shop-checkout', compact('cartItems', 'total'));
    }

    public function processCheckout(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'username' => 'required|string|max:255',
                'facebook' => 'required|string|max:255',
                'link' => 'required|string',
                'payment_option' => 'required|in:PayPal,CashApp,Usdt',
                'coupon_code' => 'nullable|string|max:50'
            ], [
                'name.required' => 'Full name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Invalid email format',
                'username.required' => 'Username is required',
                'facebook.required' => 'Facebook is required',
                'link.required' => 'Link is required',
                'payment_option.required' => 'Please select a payment method',
            ]);

            $buktiPath = null;
            $paymentMethod = $request->input('payment_option');

            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $buktiPath = $file->storeAs('payment_proofs', $fileName, 'public');

            $cartItems = Cart::where('user_id', Auth::id())
                ->with(['produk' => function($query) {
                    $query->select('id', 'nama_produk', 'harga', 'id_kategori');
                }])
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect(route('home.index'));
            }

            $totalPrice = 0;
            foreach ($cartItems as $item) {
                $totalPrice += $item->quantity * $item->produk->harga;
            }

            // Coupon validation and application
            $discountAmount = 0;
            $couponApplied = null;
            if ($request->filled('coupon_code')) {
                $coupon = Kupon::where('kode', $request->input('coupon_code'))->first();

                if (!$coupon) {
                    return redirect()->back()->withErrors(['coupon_code' => 'Coupon code not found.']);
                }

                if ($coupon->status !== 'aktif') {
                    return redirect()->back()->withErrors(['coupon_code' => 'Coupon is not active.']);
                }

                $now = now();
                if (($coupon->tanggal_mulai && $now < $coupon->tanggal_mulai) ||
                    ($coupon->tanggal_berakhir && $now > $coupon->tanggal_berakhir)) {
                    return redirect()->back()->withErrors(['coupon_code' => 'Coupon is expired or not yet valid.']);
                }

                if ($coupon->minimal_belanja && $totalPrice < $coupon->minimal_belanja) {
                    return redirect()->back()->withErrors(['coupon_code' => 'Minimum purchase amount not met.']);
                }

                if ($coupon->jumlah_kupon !== null && $coupon->jumlah_kupon <= $coupon->jumlah_terpakai) {
                    return redirect()->back()->withErrors(['coupon_code' => 'Coupon has reached its usage limit.']);
                }

                // Calculate actual discount amount
                $discountAmount = $coupon->calculateDiscount($totalPrice);
                $couponApplied = $coupon;
                $coupon->markAsUsed();
            }

            $finalPrice = $totalPrice - $discountAmount;

            do {
                $nomerOrder = mt_rand(10000000, 99999999);
            } while (Pembelian::where('nomer_order', $nomerOrder)->exists());

            $pembelianData = [
                'nomer_order' => $nomerOrder,
                'tanggal_order' => now(),
                'total_harga' => floatval(str_replace(',', '', $finalPrice)),
                'harga_asli' => floatval(str_replace(',', '', $totalPrice)),
                'diskon' => floatval(str_replace(',', '', $discountAmount)),
                'kode_kupon' => $request->input('coupon_code'),
                'metode_pembayaran' => $paymentMethod,
                'status' => 'pending',
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'note' => $request->input('note'),
                'username' => $validatedData['username'],
                'facebook' => $validatedData['facebook'],
                'link' => $validatedData['link']
            ];

            if (Auth::check()) {
                $pembelianData['user_id'] = Auth::id();
            }

            if ($buktiPath) {
                $pembelianData['bukti_transfer'] = $buktiPath;
            }

            $pembelian = Pembelian::create($pembelianData);

            $productDetails = [];
            foreach ($cartItems as $cartItem) {
                PembelianDetail::create([
                    'pembelian_id' => $pembelian->id,
                    'produk_id' => $cartItem->produk_id,
                    'jumlah' => $cartItem->quantity,
                    'harga' => $cartItem->produk->harga
                ]);

                $productDetails[] = "{$cartItem->quantity}x {$cartItem->produk->nama_produk}";
            }

            try {
                Mail::to($validatedData['email'])->send(new OrderNotificationMail($pembelian));
                Mail::to(config('mail.admin_email'))->send(new OrderNotificationMail($pembelian));
            } catch (\Exception $e) {
                Log::error('Order Email Notification Failed: ' . $e->getMessage());
            }

            Cart::where('user_id', Auth::id())->delete();

            $message = "*Order from MogoOhana*\n\n";
            $message .= "Order Number: " . $nomerOrder . "\n";
            $message .= "Date: " . now()->format('d F Y') . "\n";
            $message .= "Name: " . $validatedData['name'] . "\n";
            $message .= "IGN: " . $validatedData['username'] . "\n";
            $message .= "Facebook: " . $validatedData['facebook'] . "\n";
            $message .= "Link: " . $validatedData['link'] . "\n\n";
            $message .= "Notes: " . ($request->input('note') ?? '-') . "\n\n";
            $message .= "*Products:*\n";
            foreach ($productDetails as $product) {
                $message .= "• " . $product . "\n";
            }
            $message .= "\nPayment Method: " . $paymentMethod . "\n";
            $message .= "Total: $" . number_format($finalPrice, 2, '.', '.') . "\n\n";
            $message .= "Thank you for your order!";

            $encodedMessage = urlencode($message);

            $whatsappUrl = "https://wa.me/628985288600?text=" . $encodedMessage;

            return redirect($whatsappUrl)->with('success', 'Your message has been sent successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            echo print_r($e->getMessage());
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors($e->getMessage());
            echo print_r($e->getMessage());
        }
    }

    /**
     * Validate coupon via AJAX
     */
    public function validateCoupon(ValidateCouponRequest $request)
    {
        try {
            $validatedData = $request->validated();

            // Find the coupon
            $coupon = Kupon::where('kode', $validatedData['coupon_code'])->first();

            // Comprehensive coupon validation checks
            $validationErrors = $this->validateCouponRules($coupon, $validatedData['total_purchase']);

            if ($validationErrors) {
                return response()->json([
                    'valid' => false,
                    'message' => $validationErrors
                ], 200);
            }

            // Calculate discount
            $discountAmount = $coupon->calculateDiscount($validatedData['total_purchase']);

            return response()->json([
                'valid' => true,
                'coupon_code' => $coupon->kode,
                'discount_amount' => $discountAmount,
                'discount_type' => $coupon->tipe,
                'discount_value' => $coupon->nilai
            ], 200);
        } catch (\Exception $e) {
            Log::error('Coupon validation error: ' . $e->getMessage());

            return response()->json([
                'valid' => false,
                'message' => 'An unexpected error occurred. Please try again.'
            ], 200);
        }
    }

    /**
     * Validate coupon against various business rules
     *
     * @param Kupon|null $coupon
     * @param float $totalPurchase
     * @return string|null Validation error message or null if valid
     */
    private function validateCouponRules($coupon, $totalPurchase)
    {
        // Check if coupon exists
        if (!$coupon) {
            return 'Coupon code not found.';
        }

        // Check coupon status
        if ($coupon->status !== 'aktif') {
            return 'Coupon is not active.';
        }

        // Check date range
        $now = now();
        $startDate = $coupon->tanggal_mulai ? $coupon->tanggal_mulai->startOfDay()->subHours(8) : null;
        $endDate = $coupon->tanggal_berakhir ? $coupon->tanggal_berakhir->endOfDay() : null;

        if (($startDate && $now < $startDate) ||
            ($endDate && $now > $endDate)) {
            return 'Coupon is expired or not yet valid.';
        }

        // Check minimum purchase amount
        if ($coupon->minimal_belanja && $totalPurchase < $coupon->minimal_belanja) {
            return 'Minimum purchase amount not met.';
        }

        // Check coupon quantity
        if ($coupon->jumlah_kupon !== null && $coupon->jumlah_kupon <= $coupon->jumlah_terpakai) {
            return 'Coupon has reached its usage limit.';
        }

        // Coupon is valid
        return null;
    }
}
