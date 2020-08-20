<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerDetail extends Model
{
    protected $table = 'answer_details';

    public function quizModelQuestion(){
      return $this->belongsTo('\App\QuizModelQuestion','IDQuizModelQuestion');
    }
}
