<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Campaign;

class ChartController extends Controller
{
    public $campaign;
    public $question;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->campaign = \App::Make('App\Campaign');
        $this->question = \App::Make('App\Question');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $campaigns = $this->campaign::all();

        return view('chart.form',compact('campaigns'));
    }
    public function index0(Request $request,Campaign $campaign)
    {
        $allquestions = $this->question::whereHas('campaigns',function($query) use ($campaign){
          $query->where('campaign_id',$campaign->id);
        })->get();

        if(isset($request->perguntas)){

            $questions_array = [];

            $questions_params = explode(',',$request->perguntas);
            foreach ($questions_params as $key => $value) {

              $question = $this->question::whereId($value)->whereHas('campaigns',function($query) use ($campaign){
                $query->where('campaign_id',$campaign->id);
              })->first();

              if(isset($question->id)){
                $questions_array[] = $question;
              }
            }
            $questions = (object) $questions_array;

        }else{
            $questions = $this->question::whereHas('campaigns',function($query) use ($campaign){
              $query->where('campaign_id',$campaign->id);
            })->get();
        }

        return view('chart.index',compact('questions','campaign','allquestions'));
    }
    public function index(Request $request,Campaign $campaign)
    {

        try {

        $allquestions = $this->question::whereHas('campaigns',function($query) use ($campaign){
          $query->where('campaign_id',$campaign->id);
        })->get();

        if(isset($request->perguntas)){

            $questions_array = [];

            $questions_params = explode(',',$request->perguntas);
            foreach ($questions_params as $key => $value) {

              $question = $this->question::whereId($value)->whereHas('campaigns',function($query) use ($campaign){
                $query->where('campaign_id',$campaign->id);
              })->first();

              if(isset($question->id)){
                $questions_array[] = $question;
              }
            }
            $questions = (object) $questions_array;

            $questions = collect($questions);

        }else{
            $questions = $this->question::whereHas('campaigns',function($query) use ($campaign){
              $query->where('campaign_id',$campaign->id);
            })->get();


        }

        foreach ($questions as $key => $question) {

          $answers = [];

          foreach ($question->campaigns->groupBy('answer_description') as $answer => $campaign_answers) {

               $string = $answer;
               $string = strtolower(utf8_decode($string));

               $acentos  =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
               $sem_acentos  =  'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
               $string = strtr($string, utf8_decode($acentos), $sem_acentos);

               $string = utf8_decode($string);
               $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");

               if(!array_key_exists($string,$answers)){
                 $answers[$string] = $campaign_answers->count();
               }else{
                 $answers[$string] = $answers[$string] + $campaign_answers->count();
               }
                //return $answer;
                //return $question->campaigns->groupBy('answer_description')[$k]->count();


          }

          $questions[$key]->answers_chart = (object) $answers;

        }
        if($request->has('barra')){
          return view('chart.index_bar',compact('questions','campaign','allquestions'));
        }
        return view('chart.index_pie',compact('questions','campaign','allquestions'));
      } catch (\Exception $e) {//errors exceptions

          $response = null;

          switch (get_class($e)) {
            case QueryException::class:$response = $e->getMessage();
            case Exception::class:$response = $e->getMessage();
            case ValidationException::class:$response = $e;
            default: $response = get_class($e);
          }

          $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

          return response()->json(['status'=>false,'msg'=>$response]);

      }
    }

}
