<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'ssurvey_question_id',
        'survey_question_option_id',
        'user_id'
    ];

    public $timestamps = false;
}
