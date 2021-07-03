<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Models\Campaign;
use App\Models\Question;

class CruzeQuestionController extends Controller
{
    public $question;
    public $campaign_answer;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->question = \App::Make('App\Models\Question');
        $this->campaign_answer = \App::Make('App\Models\CampaignAnswer');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $questions = $this->question::has('campaigns')->get();

        return view('cruze.questions',compact('questions'));
    }
    public function cruze(Request $request)
    {
        try {

          $data = [];

          if(isset($request->pergunta1)&&strlen($request->pergunta1)>0&&$request->pergunta1>0){

              $answers1 = $this->campaign_answer::whereQuestionId($request->pergunta1)->get()->groupBy('answer_description');

              foreach ($answers1 as $answer1 => $campaign_answers1) {

                $rows = [];

                $rows[] = [
                  'question_id'=> $request->pergunta1,
                  'question_description'=> $campaign_answers1[0]->question_description,
                  'answer_description' => $answer1,
                  'question_order' => 1,
                ];
                //2 - inicio
                if(isset($request->pergunta2)&&strlen($request->pergunta2)>0&&$request->pergunta2>0){

                    $answers2 = $this->campaign_answer::whereQuestionId($request->pergunta2)->get()->groupBy('answer_description');

                    foreach ($answers2 as $answer2 => $campaign_answers2) {

                      $rows[] = [
                        'question_id'=> $request->pergunta2,
                        'question_description'=> $campaign_answers2[0]->question_description,
                        'answer_description' => $answer2,
                        'question_order' => 2
                      ];

                      //3 - inicio
                      if(isset($request->pergunta3)&&strlen($request->pergunta3)>0&&$request->pergunta3>0){

                          $answers3 = $this->campaign_answer::whereQuestionId($request->pergunta3)->get()->groupBy('answer_description');

                          foreach ($answers3 as $answer3 => $campaign_answers3) {

                            $rows[] = [
                              'question_id'=> $request->pergunta3,
                              'question_description'=> $campaign_answers3[0]->question_description,
                              'answer_description' => $answer3,
                              'question_order' => 3
                            ];

                            //4 - inicio
                            if(isset($request->pergunta4)&&strlen($request->pergunta4)>0&&$request->pergunta4>0){

                                $answers4 = $this->campaign_answer::whereQuestionId($request->pergunta4)->get()->groupBy('answer_description');

                                foreach ($answers4 as $answer4 => $campaign_answers4) {

                                  $rows[] = [
                                    'question_id'=> $request->pergunta4,
                                    'question_description'=> $campaign_answers4[0]->question_description,
                                    'answer_description' => $answer4,
                                    'question_order' => 4
                                  ];

                                  //5 - inicio
                                  if(isset($request->pergunta5)&&strlen($request->pergunta5)>0&&$request->pergunta5>0){

                                      $answers5 = $this->campaign_answer::whereQuestionId($request->pergunta5)->get()->groupBy('answer_description');

                                      foreach ($answers5 as $answer5 => $campaign_answers5) {

                                        $rows[] = [
                                          'question_id'=> $request->pergunta5,
                                          'question_description'=> $campaign_answers5[0]->question_description,
                                          'answer_description' => $answer5,
                                          'question_order' => 5
                                        ];

                                      }
                                  }else{
                                    $string = $this->cruzeRowAnswers($rows);
                                    $data[] = $string;
                                  }
                                  //5 - fim
                                }
                            }else{
                              $string = $this->cruzeRowAnswers($rows);
                              $data[] = $string;
                            }
                            //4 - fim
                          }
                      }else{
                        $string = $this->cruzeRowAnswers($rows);
                        $data[] = $string;
                      }
                      //3 - fim
                    }
                }else{
                  $string = $this->cruzeRowAnswers($rows);
                  $data[] = $string;
                }
                //2 - fim
              }
          }
          //dd($data);
          return response()->json(['status'=>true,'data'=>$data]);

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
    public function cruze0($questionsString)
    {
        try {

          $selecteds = [];

          $questionsArray = explode(",",$questionsString);

          $questions = [];

          foreach ($questionsArray as $k => $question_id) {

              $answers = $this->campaign_answer::whereQuestionId($question_id)->get()->groupBy('answer_description');

              $a = [];
              foreach ($answers as $answer => $campaign_answer) {
                  $a[] = ['answer_description'=>$answer,'answer_status'=>false];

                  $rows[] = [
                    'question_id'=> $question_id,
                    'question_description'=> $campaign_answer[0]->question_description,
                    'answer_description' => $answer,
                    'question_order' => $k+1,
                    'answer_status' => false
                  ];
              }

              $questions[$question_id] = $a;
          }
          $rows = [];

          for ($i=0; $i < count($questions); $i++) {

            $row = [];

            foreach ($questions as $question_id => $answers) {

                $answerSelected = false;
                if(!$answerSelected){
                  foreach ($answers as $a => $answer) {
                    if(!$answer['answer_status']&&!$answerSelected){

                      $questions[$question_id][$a]['answer_status'] = true;

                      $question_description = $this->question::findOrFail($question_id)->description;

                      $row[] = [
                        'question_id'=> $question_id,
                        'question_description'=> $question_description,
                        'answer_description' => $answer['answer_description'],
                        'question_order' => count($row)+1
                      ];

                      $answerSelected = true;
                    }
                  }
                }
            }
            $rows[] = $row;
          }
          //dd($rows);

          return response()->json(['status'=>true,'data'=>$rows]);

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
    public function cruzeRowAnswers($answersArray)
    {
        try {

        //  dd($answersArray);

          $request_params = $answersArray;

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

                $interviewees2 = [];
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

                $interviewees3 = [];

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

                $interviewees4 = [];

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

                $interviewees5 = [];

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

                $interviewees6 = [];

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

                $interviewees7 = [];

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

                $interviewees8 = [];

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

                $interviewees9 = [];
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

                $interviewees10 = [];
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

          $string1 = '';
          $string2 = '';
          $string3 = '';
          $string4 = '';
          $string5 = '';
          $string6 = '';
          $string7 = '';
          $string8 = '';
          $string9 = '';
          $string10 = '';

          foreach ($request_params as $pk => $param) {
            if($param['question_order']=='1'){
              $string1 = $param['question_description']." ".$param['answer_description'];
              if(count($request_params)-1 == $pk){
                $string1 .= ": ".count($interviewees1);
              }
            }elseif($param['question_order']=='2'){
              $string2 = " / ".$param['question_description']." ".$param['answer_description'];
              if(count($request_params)-1 == $pk){
                $string2 .= ": ".count($interviewees2);
              }
            }elseif($param['question_order']=='3'){
              $string3 = " / ".$param['question_description']." ".$param['answer_description'];
              if(count($request_params)-1 == $pk){
                $string3 .= ": ".count($interviewees3);
              }
            }elseif($param['question_order']=='4'){
              $string4 = " / ".$param['question_description']." ".$param['answer_description'];
              if(count($request_params)-1 == $pk){
                $string4 .= ": ".count($interviewees4);
              }
            }elseif($param['question_order']=='5'){
              $string5 = " / ".$param['question_description']." ".$param['answer_description'];
              if(count($request_params)-1 == $pk){
                $string5 .= ": ".count($interviewees5);
              }
            }elseif($param['question_order']=='6'){
              $string6 = " / ".$param['question_description']." ".$param['answer_description'];
              if(count($request_params)-1 == $pk){
                $string6 .= ": ".count($interviewees6);
              }
            }elseif($param['question_order']=='7'){
              $string7 = " / ".$param['question_description']." ".$param['answer_description'];
              if(count($request_params)-1 == $pk){
                $string7 .= ": ".count($interviewees7);
              }
            }elseif($param['question_order']=='8'){
              $string8 = " / ".$param['question_description']." ".$param['answer_description'];
              if(count($request_params)-1 == $pk){
                $string8 .= ": ".count($interviewees8);
              }
            }elseif($param['question_order']=='9'){
              $string9 = " / ".$param['question_description']." ".$param['answer_description'];
              if(count($request_params)-1 == $pk){
                $string9 .= ": ".count($interviewees9);
              }
            }elseif($param['question_order']=='10'){
              $string10 = " / ".$param['question_description']." ".$param['answer_description'];
              if(count($request_params)-1 == $pk){
                $string10 .= ": ".count($interviewees10);
              }
            }
            $string = $string1.$string2.$string3.$string4.$string5.$string6.$string7.$string8.$string9.$string10;
          }

          return $string;

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
