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
            return redirect()->route('home.index')->with('error', 'Keranjang Anda kosong. Silakan tambahkan produk terlebih dahulu.');
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
                'payment_method' => 'required|in:PayPal,CashApp,Venmo,Usdt',
                'bukti_pembayaran_paypal' => $request->input('payment_method') === 'PayPal' ? 'required|file|image|max:5120' : '',
                'bukti_pembayaran_venmo' => $request->input('payment_method') === 'Venmo' ? 'required|file|image|max:5120' : '',
                'bukti_pembayaran_cashapp' => $request->input('payment_method') === 'CashApp' ? 'required|file|image|max:5120' : '',
                'bukti_pembayaran_usdt' => $request->input('payment_method') === 'Usdt' ? 'required|file|image|max:5120' : '',
                'coupon_code' => 'nullable|string|max:50'
            ], [
                'name.required' => 'Full name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Invalid email format',
                'username.required' => 'Username is required',
                'facebook.required' => 'Facebook is required',
                'link.required' => 'Link is required',
                'payment_method.required' => 'Please select a payment method',
                'bukti_pembayaran_paypal.required' => 'Please upload PayPal payment proof',
                'bukti_pembayaran_venmo.required' => 'Please upload Venmo payment proof',
                'bukti_pembayaran_cashapp.required' => 'Please upload CashApp payment proof',
                'bukti_pembayaran_usdt.required' => 'Please upload Usdt payment proof',
                'bukti_pembayaran_paypal.image' => 'PayPal payment proof must be an image',
                'bukti_pembayaran_venmo.image' => 'Venmo payment proof must be an image',
                'bukti_pembayaran_cashapp.image' => 'CashApp payment proof must be an image',
                'bukti_pembayaran_usdt.image' => 'Usdt payment proof must be an image',
                'bukti_pembayaran_paypal.max' => 'PayPal payment proof must not exceed 5MB',
                'bukti_pembayaran_venmo.max' => 'Venmo payment proof must not exceed 5MB',
                'bukti_pembayaran_cashapp.max' => 'CashApp payment proof must not exceed 5MB',
                'bukti_pembayaran_usdt.max' => 'Usdt payment proof must not exceed 5MB'
            ]);

            $buktiPath = null;
            $paymentMethod = $request->input('payment_method');

            switch ($paymentMethod) {
                case 'PayPal':
                    $file = $request->file('bukti_pembayaran_paypal');
                    break;
                case 'Venmo':
                    $file = $request->file('bukti_pembayaran_venmo');
                    break;
                case 'CashApp':
                    $file = $request->file('bukti_pembayaran_cashapp');
                    break;
                case 'Usdt':
                    $file = $request->file('bukti_pembayaran_usdt');
                    break;
                default:
                    throw new \Exception('Invalid payment method');
            }

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
                'total_harga' => number_format($finalPrice, 2, '.', '.'),
                'harga_asli' => number_format($totalPrice, 2, '.', '.'),
                'diskon' => number_format($discountAmount, 2, '.', '.'),
                'kode_kupon' => $couponApplied ? $couponApplied->kode : null,
                'metode_pembayaran' => $paymentMethod,
                'status' => 'pending',

                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'note' => $request->input('note'),

                'username' => $request->input('username', ''),
                'facebook' => $request->input('facebook', ''),
                'link' => $request->input('link', '')
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
                // Send email notification
                Mail::to($validatedData['email'])->send(new OrderNotificationMail($pembelian));

                // Optional: Send a copy to admin
                Mail::to(config('mail.admin_email'))->send(new OrderNotificationMail($pembelian));
            } catch (\Exception $e) {
                // Log the email sending error
                Log::error('Order Email Notification Failed: ' . $e->getMessage());

                // Optionally, you can choose to continue the process or throw the exception
                // Uncomment the next line if you want to stop the process on email failure
                // throw $e;
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
            return redirect()->back()->withErrors($e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
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
