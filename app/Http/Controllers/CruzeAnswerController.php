<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Campaign;
use App\Question;

class CruzeAnswerController extends Controller
{
    public $campaign;
    public $question;
    public $campaign_answer;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->campaign = \App::Make('App\Campaign');
        $this->question = \App::Make('App\Question');
        $this->campaign_answer = \App::Make('App\CampaignAnswer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $questions = $this->question::has('campaigns')->get();

        return view('cruze.answers',compact('questions'));
    }
    public function cruze(Request $request)
    {
        try {

          $request_params = $request->params;

          $interviewees1 = [];
          $interviewees2 = [];
          $interviewees3 = [];
          $interviewees4 = [];
          $interviewees5 = [];
          $interviewees6 = [];
          $interviewees7 = [];
          $interviewees8 = [];
          $interviewees9 = [];
          $interviewees10 = [];

          foreach ($request_params as $pk => $param) {//pega as respostas selecionadas

              if($param['question_order']=='1'){//se foi a primeira selecionada
                //busca todas as respostas de campanhas com esta resposta e pergunta
                $interviewees1 = $this->campaign_answer::whereQuestionId($param['question_id'])->whereAnswerDescription($param['answer_description'])->get()->groupBy('interviewee_id');


              }elseif($param['question_order']=='2'){//se foi a segunda ja filtra dentro

                //na segunda ordem roda as que foram pegas na primeira ordem
                foreach ($interviewees1 as $interview => $campaign_answers) {

                    //busca todas as respostas de campanhas que este entrevistado fez
                    //com mesma
                    $search = $this->campaign_answer::whereQuestionId($param['question_id'])->whereAnswerDescription($param['answer_description'])->whereIntervieweeId($interview)->get();

                    if($search->count()){
                        $interviewees2[$interview] = $search;
                    }
                }

              }elseif($param['question_order']=='3'){

                //na segunda ordem roda as que foram pegas na primeira ordem
                foreach ($interviewees2 as $interview => $campaign_answers) {

                    //busca todas as respostas de campanhas que este entrevistado fez
                    //com mesma
                    $search = $this->campaign_answer::whereQuestionId($param['question_id'])->whereAnswerDescription($param['answer_description'])->whereIntervieweeId($interview)->get();

                    if($search->count()){
                        $interviewees3[$interview] = $search;
                    }
                }
              }elseif($param['question_order']=='4'){

                //na segunda ordem roda as que foram pegas na primeira ordem
                foreach ($interviewees3 as $interview => $campaign_answers) {

                    //busca todas as respostas de campanhas que este entrevistado fez
                    //com mesma
                    $search = $this->campaign_answer::whereQuestionId($param['question_id'])->whereAnswerDescription($param['answer_description'])->whereIntervieweeId($interview)->get();

                    if($search->count()){
                        $interviewees4[$interview] = $search;
                    }
                }
              }elseif($param['question_order']=='5'){

                //na segunda ordem roda as que foram pegas na primeira ordem
                foreach ($interviewees4 as $interview => $campaign_answers) {

                    //busca todas as respostas de campanhas que este entrevistado fez
                    //com mesma
                    $search = $this->campaign_answer::whereQuestionId($param['question_id'])->whereAnswerDescription($param['answer_description'])->whereIntervieweeId($interview)->get();

                    if($search->count()){
                        $interviewees5[$interview] = $search;
                    }
                }
              }elseif($param['question_order']=='6'){

                //na segunda ordem roda as que foram pegas na primeira ordem
                foreach ($interviewees5 as $interview => $campaign_answers) {

                    //busca todas as respostas de campanhas que este entrevistado fez
                    //com mesma
                    $search = $this->campaign_answer::whereQuestionId($param['question_id'])->whereAnswerDescription($param['answer_description'])->whereIntervieweeId($interview)->get();

                    if($search->count()){
                        $interviewees6[$interview] = $search;
                    }
                }
              }elseif($param['question_order']=='7'){

                //na segunda ordem roda as que foram pegas na primeira ordem
                foreach ($interviewees6 as $interview => $campaign_answers) {

                    //busca todas as respostas de campanhas que este entrevistado fez
                    //com mesma
                    $search = $this->campaign_answer::whereQuestionId($param['question_id'])->whereAnswerDescription($param['answer_description'])->whereIntervieweeId($interview)->get();

                    if($search->count()){
                        $interviewees7[$interview] = $search;
                    }
                }
              }elseif($param['question_order']=='8'){

                //na segunda ordem roda as que foram pegas na primeira ordem
                foreach ($interviewees7 as $interview => $campaign_answers) {

                    //busca todas as respostas de campanhas que este entrevistado fez
                    //com mesma
                    $search = $this->campaign_answer::whereQuestionId($param['question_id'])->whereAnswerDescription($param['answer_description'])->whereIntervieweeId($interview)->get();

                    if($search->count()){
                        $interviewees8[$interview] = $search;
                    }
                }
              }elseif($param['question_order']=='9'){

                //na segunda ordem roda as que foram pegas na primeira ordem
                foreach ($interviewees8 as $interview => $campaign_answers) {

                    //busca todas as respostas de campanhas que este entrevistado fez
                    //com mesma
                    $search = $this->campaign_answer::whereQuestionId($param['question_id'])->whereAnswerDescription($param['answer_description'])->whereIntervieweeId($interview)->get();

                    if($search->count()){
                        $interviewees9[$interview] = $search;
                    }
                }
              }elseif($param['question_order']=='10'){

                //na segunda ordem roda as que foram pegas na primeira ordem
                foreach ($interviewees9 as $interview => $campaign_answers) {

                    //busca todas as respostas de campanhas que este entrevistado fez
                    //com mesma
                    $search = $this->campaign_answer::whereQuestionId($param['question_id'])->whereAnswerDescription($param['answer_description'])->whereIntervieweeId($interview)->get();

                    if($search->count()){
                        $interviewees10[$interview] = $search;
                    }
                }
              }
          }
          $string = null;
          foreach ($request_params as $pk => $param) {
            if($param['question_order']=='1'){
              $string = $param['question_description']." ".$param['answer_description']." : ".count($interviewees1);
            }elseif($param['question_order']=='2'){
              $string .= "<br />".$param['question_description']." ".$param['answer_description']." : ".count($interviewees2);
            }elseif($param['question_order']=='3'){
              $string .= "<br />".$param['question_description']." ".$param['answer_description']." : ".count($interviewees3);
            }elseif($param['question_order']=='4'){
              $string .= "<br />".$param['question_description']." ".$param['answer_description']." : ".count($interviewees4);
            }elseif($param['question_order']=='5'){
              $string .= "<br />".$param['question_description']." ".$param['answer_description']." : ".count($interviewees5);
            }elseif($param['question_order']=='6'){
              $string .= "<br />".$param['question_description']." ".$param['answer_description']." : ".count($interviewees6);
            }elseif($param['question_order']=='7'){
              $string .= "<br />".$param['question_description']." ".$param['answer_description']." : ".count($interviewees7);
            }elseif($param['question_order']=='8'){
              $string .= "<br />".$param['question_description']." ".$param['answer_description']." : ".count($interviewees8);
            }elseif($param['question_order']=='9'){
              $string .= "<br />".$param['question_description']." ".$param['answer_description']." : ".count($interviewees9);
            }elseif($param['question_order']=='10'){
              $string .= "<br />".$param['question_description']." ".$param['answer_description']." : ".count($interviewees10);
            }
          }

          return response()->json(['status'=>true,'data'=>$string]);

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
    public function questions()
    {
        try {

            $questions = $this->question::has('campaigns')->get();

            return response()->json(['status'=>true,'data'=>$questions]);

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
    public function answers(Question $question)
    {
        try {
            //$answers = $this->campaign_answer::whereQuestionId($question->id)->get();

            $answers = $question->campaigns->groupBy('answer_description');

            return response()->json(['status'=>true,'data'=>$answers]);

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
    public function index(Request $request,Campaign $campaign)
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
    }

}
