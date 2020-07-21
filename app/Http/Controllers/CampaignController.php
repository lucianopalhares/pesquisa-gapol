<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Campaign;
use App\Question;

class CampaignController extends Controller
{
    protected $model;
    protected $city;
    protected $question;
    protected $campaign_answer;
    protected $answer;

    public function __construct(Campaign $model){
      $this->model = $model;
      $this->city = \App::make('App\City');
      $this->question = \App::make('App\Question');
      $this->answer = \App::make('App\Answer');
      $this->campaign_answer = \App::make('App\CampaignAnswer');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

            $is_api = true;
        }

        if( \Gate::denies('viewAny-campaign') ){

          $message = 'Acesso não Autorizado: LISTAR campanhas';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        if(isset($request->status)){
          $items = $this->model::with('campaign_answers')->whereStatus($request->status)->get();
        }else{
          $items = $this->model::with('campaign_answers')->get();
        }

        if($is_api) return response()->json($items);

        return view('campaigns.index',compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( \Gate::denies('create-campaign') ){
            $message = 'Acesso não Autorizado: CADASTRAR campanha';

            return back()->withErrors($message);
        }
        $cities = $this->city::all();

        return view('campaigns.form',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

            $is_api = true;
        }

          if( \Gate::denies('create-campaign') ){

            $message = 'Acesso não Autorizado: CADASTRAR campanha';

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$message]);
            }else{
              return redirect()->back()
                        ->withErrors($message)
                        ->withInput();
            }
          }

          $rules = [
                'name' => 'required',
                //'slug' => ['required', 'string', 'max:255', 'unique:campaigns'],
                'status' => 'required',
                'start' => 'nullable|date_format:d/m/Y',
                'end' => 'nullable|date_format:d/m/Y',
                'city_id' => 'nullable',
          ];

          if($request->status=='Ativa por Data'){
            $rules['start'] = 'required|date_format:d/m/Y';
            $rules['end'] = 'required|date_format:d/m/Y';
          }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$validator->errors()]);
            }else{
              return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
            }
        }

        try {

            $model = new $this->model;

            $slug = str_slug($request->name);
            if($this->model::whereSlug($slug)->count()>0){
              $slug = str_slug($request->name.time());
            }

            $model->name = $request->name;
            $model->slug = $slug;
            $model->status = $request->status;
            $model->city_id = $request->city_id;
            $model->start = strlen($request->start)>0?\Carbon\Carbon::createFromFormat('d/m/Y', $request->start)->format('Y-m-d'):null;
            $model->end = strlen($request->end)>0?\Carbon\Carbon::createFromFormat('d/m/Y', $request->end)->format('Y-m-d'):null;

            $save = $model->save();

            $response = 'Campanha';

            $response .= ' Cadastrado(a) com Sucesso!';

            if ($is_api) {
                return response()->json(['status'=>true,'msg'=>$response]);
            }else{
                return back()->with('successMsg', $response);
            }

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }

        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Campaign $campanha)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('view-campaign') ){

          $message = 'Acesso não Autorizado: VISUALIZAR campanha';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $item = $campanha;

            if ($is_api) {
              return response()->json(['data'=>$item]);
            }
            $show = true;
            $cities = $this->city::all();

            return view('campaigns.form',compact('item','show','cities'));

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withErrors($response);
            }

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $campanha
     * @return \Illuminate\Http\Response
     */
    public function edit(Campaign $campanha)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('update-campaign') ){

          $message = 'Acesso não Autorizado: EDITAR campanha';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $item = $campanha;

            if ($is_api) {
              return response()->json(['data'=>$item]);
            }

            $cities = $this->city::all();

            return view('campaigns.form',compact('item','cities'));

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withErrors($response);
            }

        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $campanha
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Campaign $campanha)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

            $is_api = true;
        }

        if( \Gate::denies('update-question') ){

          $message = 'Acesso não Autorizado: EDITAR pergunta';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        $rules = [
              'name' => 'required',
              //'slug' => ['required', 'string', 'max:255', Rule::unique('campaigns')->ignore($request->id)],
              'status' => 'required',
              'start' => 'nullable|date_format:d/m/Y',
              'end' => 'nullable|date_format:d/m/Y',
              'city_id' => 'nullable',
        ];

        if($request->status=='Ativa por Data'){
          $rules['start'] = 'required|date_format:d/m/Y';
          $rules['end'] = 'required|date_format:d/m/Y';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$validator->errors()]);
            }else{
              return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
            }
        }

        try {
            $model = $campanha;

            $slug = str_slug($request->name);
            if($this->model::whereSlug($slug)->count()>0){
              $slug = str_slug($request->name.time());
            }

            $model->name = $request->name;
            $model->slug = $slug;
            $model->status = $request->status;
            $model->city_id = $request->city_id;
            $model->start = strlen($request->start)>0?\Carbon\Carbon::createFromFormat('d/m/Y', $request->start)->format('Y-m-d'):null;
            $model->end = strlen($request->end)>0?\Carbon\Carbon::createFromFormat('d/m/Y', $request->end)->format('Y-m-d'):null;

            $save = $model->save();

            $response = 'Campanha';

            $response .= ' Editado(a) com Sucesso!';

            if ($is_api) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->with('successMsg', $response);
            }

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Campaign $campanha)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('delete-campaign') ){

          $message = 'Acesso não Autorizado: EXCLUIR campanha';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $item = $campanha;

            $item->delete();

            $response = 'Campanha';

            $response .= ' Deletado(a) com Sucesso!';

            if ($is_api) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }

            return back()->with('successMsg',$response);

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withErrors($response);
            }

        }
    }

    public function saveCampaignAnswer(Request $request)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

            $is_api = true;
        }

          $rules = [
            'campaign_id' => ['required', 'integer'],
          ];

          $messages = [
            'campaign_id.required' => "Selecione o diagnóstico"
          ];

          if(isset($request->question_id)){
            $rules['question_id'] = ['required'];
            $messages['question_id.required'] = 'Selecione a Pergunta';
            if(isset($request->answer_id)){
              $rules['answer_id'] = ['required'];
              $messages['answer_id.required'] = 'Selecione a Resposta';
            }elseif(isset($request->answer_description)){
              $rules['answer_description'] = ['required'];
              $messages['answer_description.required'] = 'Digite a Resposta';
              $rules['save_answer'] = ['required'];
              $messages['save_answer.required'] = 'Escolha se deseja salvar a resposta (Sim/Nao)';
            }else{
              $rules['answers'] = ['required'];
              $messages['answers.required'] = 'Selecione as Respostas';
            }
          }else{

            $rules['save_question_answer'] = ['required'];
            $messages['save_question_answer.required'] = 'Escolha se deseja salvar a pergunta e resposta digitadas (Sim/Nao)';
            $rules['question_description'] = ['required'];
            $messages['question_description.required'] = 'Digite a Pergunta';
            $rules['answer_description'] = ['required'];
            $messages['answer_description.required'] = 'Digite a Resposta';
          }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$validator->errors()]);
            }else{
              return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
            }
        }

        $campaign = $this->model::findOrFail($request->campaign_id);

        if($campaign->status=='Inativa'){

          $message = 'Campanha Inativa';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }
        if($campaign->status=='Ativa por Data'){

          $start = \Carbon\Carbon::parse($campaign->start);
          $end = \Carbon\Carbon::parse($campaign->end);
          $now = \Carbon\Carbon::now()->format('Y-m-d');
          //$diff = $end->diffInDays($now);

          if($start>$now||$end<$now){

            $message = 'Campanha Inativa';

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$message]);
            }else{
              return redirect()->back()
                        ->withErrors($message)
                        ->withInput();
            }
          }
        }

        if(\Gate::denies('create-campaign_answer')){

          $message = 'Acesso não Autorizado: RESPONDER CAMPANHA';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

              if(isset($request->question_id)){

                $exists = $this->campaign_answer::whereCampaignId($request->campaign_id)->whereQuestionId($request->question_id)->count();

                if($exists){
                  $message = 'Pergunta ja Respondida!';

                  if ($is_api) {
                    return response()->json(['status'=>false,'msg'=>$message]);
                  }else{
                    return redirect()->back()
                              ->withErrors($message)
                              ->withInput();
                  }
                }
                if(isset($request->answers)){

                  $answers = $request->input('answers');

                  $multiple_choice = $this->question::findOrFail($request->question_id)->multiple_choice;

                  if($multiple_choice){

                      foreach($answers as $answer){

                          $questionFind = $this->question::findOrFail($request->question_id);
                          $answerFind = $this->answer::findOrFail($answer);

                          $model = new $this->campaign_answer;

                          $model->campaign_id = $request->campaign_id;
                          $model->question_id = $request->question_id;
                          $model->question_description = $questionFind->description;
                          $model->answer_id = $answer;
                          $model->answer_description = $answerFind->description;
                          $save = $model->save();
                      }

                  }else{
                    if(sizeof($answers)>1){
                      $message = 'Escolha apenas uma Opção';

                      if ($is_api) {
                        return response()->json(['status'=>false,'msg'=>$message]);
                      }else{
                        return redirect()->back()
                                  ->withErrors($message)
                                  ->withInput();
                      }
                    }
                    $questionFind = $this->question::findOrFail($request->question_id);
                    $answerFind = $this->answer::findOrFail($answers[0]);

                    $model = new $this->campaign_answer;

                    $model->campaign_id = $request->campaign_id;
                    $model->question_id = $request->question_id;
                    $model->question_description = $questionFind->description;
                    $model->answer_id = $answers[0];
                    $model->answer_description = $answerFind->description;
                    $save = $model->save();
                  }
                }else{

                  $questionFind = $this->question::findOrFail($request->question_id);
                  //criar a resposta
                  $answer = new $this->answer;
                  $answer->question_id = $request->question_id;
                  $answer->description = $request->answer_description;
                  $answer->status = 'Ativo';
                  $answer->save();

                  $model = new $this->campaign_answer;
                  $model->campaign_id = $request->campaign_id;
                  $model->question_id = $request->question_id;
                  $model->question_description = $questionFind->description;
                  $model->answer_id = $answer->id;
                  $model->answer_description = $request->answer_description;
                  $save = $model->save();
                }

            }else{

              $question_id = null;
              $answer_id = null;
              if(isset($request->save_question_answer)&&$request->save_question_answer=='Sim'){
                //criar a pergunta
                $question = new $this->question;
                $question->description = $request->question_description;
                $question->status = 'Ativo';
                $question->multiple_choice = 0;
                $question->required = 'Sim';
                $question->tap_answer = 'Nao';
                $question->save();

                $question_id = $question->id;

                //criar a resposta
                $answer = new $this->answer;
                $answer->question_id = $question->id;
                $answer->description = $request->answer_description;
                $answer->status = 'Ativo';
                $answer->save();

                $answer_id = $answer->id;
              }
              $model = new $this->campaign_answer;

              $model->campaign_id = $request->campaign_id;
              $model->question_id = $question_id;
              $model->question_description = $request->question_description;
              $model->answer_id = $answer_id;
              $model->answer_description = $request->answer_description;
              $save = $model->save();
            }

            $response = 'Respondida com Sucesso!';

            if ($is_api) {
                return response()->json(['status'=>true,'msg'=>$response]);
            }else{
                return back()->with('successMsg', $response);
            }

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }

        }
    }
    public function createCampaignAnswer(Campaign $campaign)
    {
      $is_api = false;
      if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

          $is_api = true;
      }

      if(\Gate::denies('create-campaign_answer')){

        $message = 'Acesso não Autorizado: RESPONDER CAMPANHA';

        if ($is_api) {
          return response()->json(['status'=>false,'msg'=>$message]);
        }else{
          return redirect()->back()
                    ->withErrors($message)
                    ->withInput();
        }
      }

      if($campaign->status=='Inativa'){

        $message = 'Campanha Inativa';

        if ($is_api) {
          return response()->json(['status'=>false,'msg'=>$message]);
        }else{
          return redirect()->back()
                    ->withErrors($message)
                    ->withInput();
        }
      }
      if($campaign->status=='Ativa por Data'){

        $start = \Carbon\Carbon::parse($campaign->start);
        $end = \Carbon\Carbon::parse($campaign->end);
        $now = \Carbon\Carbon::now()->format('Y-m-d');
        //$diff = $end->diffInDays($now);

        if($start>$now||$end<$now){

          $message = 'Campanha Inativa';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }
      }

      $question = $this->question::whereDoesntHave('campaigns', function($q)use($campaign){
          $q->where('campaign_id', $campaign->id);
      })->first();


      if(!$question){
        $response = "Campanha Respondida: '".$campaign->name."'";
        if ($is_api) {
            return response()->json(['status'=>true,'msg'=>$response]);
        }else{
            return redirect('/campanhas')->with('successMsg', $response);
        }
      }

      return view('campaign_answers.form',compact('campaign','question'));
    }
    public function answers(Campaign $campaign)
    {
      $is_api = false;
      if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

          $is_api = true;
      }

      if(\Gate::denies('viewAny-campaign_answer')){

        $message = 'Acesso não Autorizado: VISUALIZAR CAMPANHA';

        if ($is_api) {
          return response()->json(['status'=>false,'msg'=>$message]);
        }else{
          return redirect()->back()
                    ->withErrors($message)
                    ->withInput();
        }
      }

      $items = $campaign->campaign_answers;

      return view('campaign_answers.index',compact('campaign','items'));
    }
}
