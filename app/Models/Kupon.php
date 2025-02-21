<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kupon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kupon';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode',
        'tipe',
        'nilai',
        'minimal_belanja',
        'tanggal_mulai',
        'tanggal_berakhir',
        'jumlah_kupon',
        'jumlah_terpakai',
        'status',
        'deskripsi'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
        'nilai' => 'float',
        'minimal_belanja' => 'float'
    ];

    /**
     * Validate if the coupon is valid for the given total purchase amount
     *
     * @param float $totalPurchase
     * @return bool
     */
    public function isValid($totalPurchase)
    {
        // Check if coupon is active
        if ($this->status !== 'aktif') {
            \Log::info('Coupon validation failed: status not active', [
                'coupon_code' => $this->kode,
                'status' => $this->status
            ]);
            return false;
        }

        // Check date range
        $now = now();
        $startDate = $this->tanggal_mulai 
            ? $this->tanggal_mulai->startOfDay()->subHours(8) 
            : null;
        $endDate = $this->tanggal_berakhir 
            ? $this->tanggal_berakhir->endOfDay() 
            : null;

        if ($startDate && $now < $startDate) {
            \Log::info('Coupon validation failed: start date not reached', [
                'coupon_code' => $this->kode,
                'now' => $now,
                'start_date' => $startDate,
                'original_start_date' => $this->tanggal_mulai
            ]);
            return false;
        }

        if ($endDate && $now > $endDate) {
            \Log::info('Coupon validation failed: end date passed', [
                'coupon_code' => $this->kode,
                'now' => $now,
                'end_date' => $endDate,
                'original_end_date' => $this->tanggal_berakhir
            ]);
            return false;
        }

        // Check minimum purchase amount
        if ($this->minimal_belanja && $totalPurchase < $this->minimal_belanja) {
            \Log::info('Coupon validation failed: minimum purchase not met', [
                'coupon_code' => $this->kode,
                'total_purchase' => $totalPurchase,
                'minimum_purchase' => $this->minimal_belanja
            ]);
            return false;
        }

        // Check if coupon quantity is available
        if ($this->jumlah_kupon !== null && $this->jumlah_kupon <= $this->jumlah_terpakai) {
            \Log::info('Coupon validation failed: usage limit reached', [
                'coupon_code' => $this->kode,
                'total_coupons' => $this->jumlah_kupon,
                'used_coupons' => $this->jumlah_terpakai
            ]);
            return false;
        }

        return true;
    }

    /**
     * Calculate the discount amount
     *
     * @param float $totalPurchase
     * @return float
     */
    public function calculateDiscount($totalPurchase)
    {
        if (!$this->isValid($totalPurchase)) {
            return 0;
        }

        if ($this->tipe === 'persen') {
            return min($totalPurchase * ($this->nilai / 100), $totalPurchase);
        } else {
            return min($this->nilai, $totalPurchase);
        }
    }

    /**
     * Mark the coupon as used
     *
     * @return void
     */
    public function markAsUsed()
    {
        $this->jumlah_terpakai = ($this->jumlah_terpakai ?? 0) + 1;
        $this->save();
    }

    /**
     * Find a valid coupon by its code
     *
     * @param string $code
     * @param float $totalPurchase
     * @return self|null
     */
    public static function findValidCoupon($code, $totalPurchase)
    {
        $coupon = self::where('kode', $code)->first();
        
        if (!$coupon || !$coupon->isValid($totalPurchase)) {
            return null;
        }

        return $coupon;
    }
}
