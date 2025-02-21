<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    use HasFactory;

    // Specify the table name explicitly
    protected $table = 'cart';

    protected $fillable = [
        'user_id', 
        'produk_id', 
        'session_id',
        'quantity'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope to get cart items for current user or session
    public function scopeCurrentUserOrSession($query)
    {
        return $query->where(function($q) {
            // If user is authenticated, get their cart items
            if (Auth::check()) {
                $q->where('user_id', Auth::id());
            } 
            // Always include items with current session
            $q->orWhere('session_id', Session::getId());
        });
    }

    // Method to add item to cart
    public static function addToCart($produkId, $quantity = 1)
    {
        $existingCartItem = self::currentUserOrSession()
            ->where('produk_id', $produkId)
            ->first();

        $produk = Produk::findOrFail($produkId);

        // Check stock availability
        if ($produk->stok < $quantity) {
            return false;
        }

        if ($existingCartItem) {
            // Update quantity if item exists
            $newQuantity = $existingCartItem->quantity + $quantity;
            
            // Prevent exceeding stock
            if ($newQuantity > $produk->stok) {
                return false;
            }

            $existingCartItem->update([
                'quantity' => $newQuantity
            ]);
        } else {
            // Create new cart item
            self::create([
                'user_id' => Auth::id(), // Can be null
                'produk_id' => $produkId,
                'session_id' => Session::getId(),
                'quantity' => $quantity
            ]);
        }

        return true;
    }

    // Calculate total price for cart
    public static function calculateTotal()
    {
        return self::currentUserOrSession()
            ->with('produk')
            ->get()
            ->sum(function($item) {
                return $item->produk->harga * $item->quantity;
            });
    }

    // Get cart items
    public static function getCartItems()
    {
        return self::currentUserOrSession()
            ->with('produk')
            ->get();
    }

    // Get cart count
    public static function getCartCount()
    {
        // For authenticated users
        if (Auth::check()) {
            return self::where('user_id', Auth::id())->sum('quantity');
        }
        
        // For guest users
        $sessionId = Session::getId();
        return self::where('session_id', $sessionId)->sum('quantity');
    }
}
