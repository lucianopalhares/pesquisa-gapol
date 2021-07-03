<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $guarded = [];

    public function city(){
      return $this->belongsTo('App\Models\City','city_id');
    }
    public function answers()
    {
        return $this->belongsToMany(\App\Models\Answer::class,'campaign_answers');
    }
    public function campaign_answers()
    {
        return $this->hasMany(\App\Models\CampaignAnswer::class,'campaign_id');
    }
    public function answersCount()
    {
        return \App::make('App\Models\CampaignAnswer')->whereCampaignId($this->id)->count();
    }

}
