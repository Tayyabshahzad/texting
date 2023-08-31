<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;


class UserSubscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'customer_details_id',
        'unsubbed_at'
    ];

    /**
     * Get the user that the details belong to.
     */
    public function users(): hasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the user that the details belong to.
     */
    public function customerDetails(): BelongsTo
    {
        return $this->belongsTo(CustomerDetail::class);
    }
}
