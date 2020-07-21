<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaignAnswer extends Model
{
    protected $guarded = [];

    public function campaign(){
      return $this->belongsTo('App\Campaign','campaign_id');
    }
    public function answer(){
      return $this->belongsTo('App\Answer','answer_id');
    }
    public function question(){
      return $this->belongsTo('App\Question','question_id');
    }
}
