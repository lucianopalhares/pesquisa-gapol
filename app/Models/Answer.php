<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $guarded = [];

    public function question(){
      return $this->belongsTo('App\Models\Question','question_id');
    }
    public function campaigns()
    {
        return $this->belongsToMany(\App\Models\Campaign::class,'campaign_answers');
    }
    public function campaign_answers()
    {
        return $this->hasMany('App\Models\CampaignAnswer','answer_id');
    }
    public function campaign_answers_count()
    {
        return 1;
    }
}
