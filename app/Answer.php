<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = [];

    public function question(){
      return $this->belongsTo('App\Question','question_id');
    }
    public function campaigns()
    {
        return $this->belongsToMany(\App\Campaign::class,'campaign_answers');
    }
    public function campaign_answers()
    {
        return $this->hasMany('App\CampaignAnswer','answer_id');
    }
    public function campaign_answers_count()
    {
        return 1;
    }
}
