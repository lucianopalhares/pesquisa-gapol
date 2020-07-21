<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $guarded = [];

    public function city(){
      return $this->belongsTo('App\City','city_id');
    }
    public function answers()
    {
        return $this->belongsToMany(\App\Answer::class,'campaign_answers');
    }
    public function campaign_answers()
    {
        return $this->hasMany(\App\CampaignAnswer::class,'campaign_id');
    }
}
