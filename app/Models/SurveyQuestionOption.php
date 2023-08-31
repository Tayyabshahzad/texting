<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestionOption extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'survey_question_id',
        'survey_question_option'
    ];
}
