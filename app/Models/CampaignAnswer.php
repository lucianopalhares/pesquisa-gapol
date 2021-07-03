<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignAnswer extends Model
{
    protected $guarded = [];

    public function campaign(){
      return $this->belongsTo('App\Models\Campaign','campaign_id');
    }
    public function answer(){
      return $this->belongsTo('App\Models\Answer','answer_id');
    }
    public function question(){
      return $this->belongsTo('App\Models\Question','question_id');
    }
}
