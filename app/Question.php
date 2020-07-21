<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    public function answers(){
        return $this->hasMany('App\Answer','question_id');
    }
    public function categories()
    {
        return $this->belongsToMany(\App\Category::class,'category_questions');
    }
    public function campaigns(){
        return $this->hasMany('App\CampaignAnswer','question_id');
    }
    public function campaign_answers()
    {
        return $this->belongsToMany(\App\Answer::class,'campaign_answers');
    }
}
