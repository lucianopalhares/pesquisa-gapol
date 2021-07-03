<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\CampaignAnswer;
use App\Models\Campaign;

class HomeController extends Controller
{
    public $question;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->question = \App::Make('\App\Models\Question');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $questions = \App\Models\Question::all();
        $campaigns = \App\Models\Campaign::all();
        $users = \App\Models\User::all();
        $roles = \App\Models\Role::all();

        return view('home',compact('questions','campaigns','users','roles'));
    }
    public function chart0(Request $request,Question $question)
    {
        $questions = $question::whereHas('answers',function($query){
          $query->has('campaign_answers');
        })->get();

        if(isset($request->perguntas)){

            $questions_array = [];

            $questions_params = explode(',',$request->perguntas);
            foreach ($questions_params as $key => $value) {

              $question = $question::whereId($value)->whereHas('answers',function($query){
                $query->has('campaign_answers');
              })->first();
              if(isset($question->id)){
                $questions_array[] = $question;
              }
            }
            $questions = (object) $questions_array;

        }
        $campaign = null;
        if(isset($request->campanha)){
          $campaign = \App\Models\Campaign::find($request->campanha);
          if($campaign) $campaign = $campaign;
        }


        return view('chart',compact('questions','campaign'));
    }
    public function chart(Request $request,Campaign $campaign)
    {
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

        return view('chart',compact('questions','campaign'));
    }
    public function test()
    {
      $quizModelQuestion = \App\Models\AnswerDetail::whereHas('quizModelQuestion',function($query){
        $query->where('ResponseType',50);
      })->get();

      return $quizModelQuestion;
    }
    public function startTestSave(){
      $min = 959561;
      $max = 1244735;

      //$this->saveInterviewee(959561,980000);
      //$this->saveInterviewee(980001,1000000);
      //$this->saveInterviewee(1000001,1020000);
      //$this->saveInterviewee(1020001,1050000);
      //$this->saveInterviewee(1050001,1070000);
      //$this->saveInterviewee(1070001,1100000);
      //$this->saveInterviewee(1100001,1200000);
      //$this->saveInterviewee(1200001,1244735);

      //$this->testSave(959561,980000);
      //$this->testSave(980001,1000000);
      //$this->testSave(1000001,1020000);
      //$this->testSave(1020001,1050000);
      //$this->testSave(1050001,1070000);
      //$this->testSave(1070001,1100000);
      //$this->testSave(1100001,1200000);
      //$this->testSave(1200001,1244735);
    }
    protected function saveInterviewee($min,$max){

      $answer_details = \App\Models\AnswerDetail::where('ID','>=',$min)->where('ID','<=',$max)->get();

      foreach ($answer_details as $k => $v) {

        $inter = new \App\Models\Interviewee;
        $inter->id = $v->IDAnswer;
        $inter->campaign_id = 1;

        $count = \App\Models\Interviewee::whereId($v->IDAnswer)->count();
        if(!$count){
          $inter->save();
        }
      }
    }
    protected function testSave($min,$max){

      $saved = 0;
      $no_question = 0;
      $no_response = 0;
      $no_save = 0;
      $no_find_question = 0;

      $answer_details = \App\Models\AnswerDetail::where('ID','>=',$min)->where('ID','<=',$max)->get();
      //return $answer_details->count();
      foreach ($answer_details as $k => $v) {

        if(strlen($v->Response)>0&&isset($v->IDQuizModelQuestion)){

          $q = \App\Models\Question::find($v->IDQuizModelQuestion);

          if($q){

              $answer_id = null;
              $question_id = $v->IDQuizModelQuestion;

              //salva resposta
              if($v->quizModelQuestion->ResponseType=='50'){

                $exists_answer_question = \App\Models\Answer::whereQuestionId($v->IDQuizModelQuestion)->whereDescription($v->Response)->first();

                if(isset($exists_answer_question->id)){

                  $answer_id = $exists_answer_question->id;

                }else{//se nao encontrar salva resposta

                  $answer = new \App\Models\Answer;
                  $answer->question_id = $v->IDQuizModelQuestion;
                  $answer->description = $v->Response;
                  $answer->save();

                  $answer_id = $answer->id;
                }
              }

              $campaign_answer = new \App\Models\CampaignAnswer;

              $campaign_answer->interviewee_id = $v->IDAnswer;
              $campaign_answer->campaign_id = 1;
              $campaign_answer->answer_id = $answer_id;
              $campaign_answer->answer_description = $v->Response;
              $campaign_answer->question_description = $q->description;
              $campaign_answer->question_id = $v->IDQuizModelQuestion;
              $campaign_answer->save();

              $saved++;
          }else{
              $no_find_question++;
              $errors[] = ['type'=>'no_find_question','error'=>$v->IDQuizModelQuestion];
          }
        }else{

          if(!strlen($v->Response)>0){
            $no_response++;
            $errors[] = ['type'=>'no_response','error'=>$v->Response];
          }
          if(!isset($v->IDQuizModelQuestion)){
            $no_question++;
            $errors[] = ['type'=>'no_question','error'=>$v->IDQuizModelQuestion];
          }
          $no_save++;
        }
      }
      if($no_save>0){
        if(count($errors)>0){
          foreach ($errors as $key => $value) {
            echo $value['type'].' = '.$value['error'].'<br />';
          }
        }
      }
      echo 'salvo: '.$saved.' de '.$answer_details->count().' / da id:'.$min.' para:'.$max.' //Sem resposta: '.$no_response.' e Sem Pergunta: '.$no_question.' e Sem Salvar: '.$no_save.' e Sem Encontrar a Pergunta: '.$no_find_question;
    }
}
