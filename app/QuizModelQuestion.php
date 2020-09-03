<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizModelQuestion extends Model
{
    public function answerDetails(){
      return $this->hasMany('\App\AnswerDetail','IDQuizModelQuestion');
    }
}
