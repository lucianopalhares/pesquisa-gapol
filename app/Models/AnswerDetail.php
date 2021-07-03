<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerDetail extends Model
{
    protected $table = 'answer_details';

    public function quizModelQuestion(){
      return $this->belongsTo('\App\Models\QuizModelQuestion','IDQuizModelQuestion');
    }
}
