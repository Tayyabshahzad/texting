<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwilioSms extends Model
{
    use HasFactory;


    protected $table = 'twilio_sms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sid',
        'direction',
        'from',
        'to',
        'body',
        'status',
        'to_user_id',
        'coupon_id'
    ];

    protected $guarded = [];
}
