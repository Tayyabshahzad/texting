<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetSms extends Model
{
    use HasFactory;

    protected $table = 'sms_password_resets';

    protected $fillable = [
        'phone',
        'token',
        'complete'
    ];
}
