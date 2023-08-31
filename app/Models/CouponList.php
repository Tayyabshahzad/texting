<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CouponList extends Model
{
    use HasFactory;

    protected $table = 'coupons_list';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'coupon_id',
        'user_id,',
        'redeemed'
    ];

    /**
     * Get the user that the details belong to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that the details belong to.
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function couponCompany(): BelongsTo
    {
        return $this->belongsTo(Coupon::class)->with('customer_details')->select(['coupons.*', 'customer_details.*']);
    }
}
