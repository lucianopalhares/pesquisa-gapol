<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizModelQuestion extends Model
{
    public function answerDetails(){
      return $this->hasMany('\App\Models\AnswerDetail','IDQuizModelQuestion');
    }
}
