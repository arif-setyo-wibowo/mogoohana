<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ShopCartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::getCartItems();
        $total = Cart::calculateTotal();

        return view('shop-cart', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'quantity' => 'sometimes|integer|min:1'
        ]);

        $produkId = $request->input('produk_id');
        $quantity = $request->input('quantity', 1);

        try {
            $result = Cart::addToCart($produkId, $quantity);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => $result,
                    'message' => $result
                        ? 'Product added to cart successfully'
                        : 'Failed to add product to cart'
                ]);
            }
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id',
            'quantity' => 'sometimes|integer|min:1'
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        try {
            $result = Cart::addToCart($productId, $quantity);

            if ($result) {
                $cartCount = Cart::getCartCount();

                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart successfully',
                    'cart_count' => $cartCount
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock or maximum quantity reached'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $cartId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            $cartItem = Cart::where(function($query) use ($cartId) {
                $query->where('id', $cartId);

                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', Session::getId());
                }
            })->firstOrFail();

            $produk = $cartItem->produk;

            $newQuantity = $request->input('quantity');
            if ($newQuantity > $produk->stok) {
                return response()->json([
                    'success' => false,
                    'message' => "The stock is insufficient. Maksimal: {$produk->stok}"
                ], 400);
            }

            $cartItem->update([
                'quantity' => $newQuantity
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Quantity successfully updated'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update quantity: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($cartId)
    {
        try {
            $cartItem = Cart::where(function($query) use ($cartId) {
                $query->where('id', $cartId);

                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', Session::getId());
                }
            })->firstOrFail();

            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product successfully removed from cart.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove product from cart: ' . $e->getMessage()
            ], 500);
        }
    }

    public function clear()
    {
        try {
            $query = Cart::where(function($query) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                } else {
                    $query->where('session_id', Session::getId());
                }
            });

            $deletedCount = $query->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cart successfully emptied',
                'deleted_count' => $deletedCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to emptied Cart : ' . $e->getMessage()
            ], 500);
        }
    }

    public function getDropdownData(Request $request)
    {
        $cartItems = Cart::with('produk')
            ->when(Auth::check(), function($query) {
                return $query->where('user_id', Auth::id());
            })
            ->when(!Auth::check(), function($query) {
                return $query->where('session_id', Session::getId());
            })
            ->get();

        $cartTotal = $cartItems->sum(function($item) {
            return $item->produk->harga * $item->quantity;
        });

        $cartItemCount = $cartItems->unique('produk_id')->count();

        return response()->json([
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'cartItemCount' => $cartItemCount
        ]);
    }

    public function checkout()
    {
        $cartItems = Cart::getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Your cart is empty. Please add products first');
        }

        $total = Cart::calculateTotal();

        return view('shop-checkout', compact('cartItems', 'total'));
    }
}
