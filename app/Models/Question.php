<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    public function answers(){
        return $this->hasMany('App\Models\Answer','question_id');
    }
    public function categories()
    {
        return $this->belongsToMany(\App\Models\Category::class,'category_questions');
    }
    public function campaigns(){
        return $this->hasMany('App\Models\CampaignAnswer','question_id');
    }
    public function campaign_answers()
    {
        return $this->belongsToMany(\App\Models\Answer::class,'campaign_answers');
    }
}
