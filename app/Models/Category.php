<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function questions()
    {
        return $this->belongsToMany(\App\Models\Question::class,'category_questions');
    }
}
