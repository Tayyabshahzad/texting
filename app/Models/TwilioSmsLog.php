<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwilioSmsLog extends Model
{
    use HasFactory;

    protected $table = 'twilio_sms_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'twilio_sms_id',
        'sms_sid',
        'sms_message_sid',
        'event',
        'new_status',
        'details'
    ];

    protected $guarded = [];
}
