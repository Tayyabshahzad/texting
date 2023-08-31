<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'birthday',
        'password',
        'verification_code',
        'phone_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'phone_verified_at' => 'datetime',
    ];

    public function userPhoneVerified()
    {
        return !is_null($this->phone_verified_at);
    }

    public function phoneVerifiedAt()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Get the phone customer details with the user.
     */
    public function customerDetails(): HasOne
    {
        return $this->hasOne(CustomerDetail::class);
    }

    /**
     * Get the phone customer details with the user.
     */
    public function customerCoupons(): hasMany
    {
        return $this->hasMany(Coupon::class, 'created_by_id')->orderByDesc('created_at');
    }

    /**
     * Get the phone customer details with the user.
     */
    public function userSubscriptions(): hasMany
    {
        return $this->hasMany(UserSubscription::class, 'user_id');
    }


    public function stripeSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class, 'user_id');
    }

    public function surveyRecord()
    {
        return $this->hasOne(SurveyAnswer::class);
    }

    public function customerSurvey()
    {
        return $this->hasOne(CustomerSurvey::class);
    }
}
