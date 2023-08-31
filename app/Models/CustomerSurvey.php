<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSurvey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'survey_question_id_1',
        'survey_question_id_2',
        'survey_question_id_3'
    ];
}
