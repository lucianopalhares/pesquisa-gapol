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
use App\Question;

class QuestionController extends Controller
{
    protected $model;
    protected $category;
    protected $category_question;

    public function __construct(Question $model){
      $this->model = $model;
      $this->category = \App::make('App\Category');
      $this->category_question = \App::make('App\CategoryQuestion');
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

        if( \Gate::denies('viewAny-question') ){

          $message = 'Acesso não Autorizado: LISTAR perguntas';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        $items = $this->model::all();

        if($is_api) return response()->json($this->model::with('answers')->get());

        return view('questions.index',compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( \Gate::denies('create-question') ){
            $message = 'Acesso não Autorizado: CADASTRAR pergunta';

            return back()->withErrors($message);
        }
        return view('questions.form');
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

          if( \Gate::denies('create-question') ){

            $message = 'Acesso não Autorizado: CADASTRAR pergunta';

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$message]);
            }else{
              return redirect()->back()
                        ->withErrors($message)
                        ->withInput();
            }
          }

          $rules = [
            'description' => ['required', 'string'],
            'status' => ['required', 'string'],
            'required' => ['required', 'string'],
          ];

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

            $model->description = $request->description;
            $model->status = $request->status;
            $model->multiple_choice = $request->multiple_choice;
            $model->required = $request->required;
            $model->tap_answer = $request->tap_answer;

            $save = $model->save();

            $response = 'Pergunta';

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
    public function show(Question $pergunta)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('view-question') ){

          $message = 'Acesso não Autorizado: VISUALIZAR pergunta';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $item = $pergunta;

            if ($is_api) {
              return response()->json(['data'=>$item]);
            }
            $show = true;
            return view('questions.form',compact('item','show'));

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
     * @param  int  $pergunta
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $pergunta)
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

        try {

            $item = $pergunta;

            if ($is_api) {
              return response()->json(['data'=>$item]);
            }

            return view('questions.form',compact('item'));

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
     * @param  int  $pergunta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $pergunta)
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
          'description' => ['required', 'string'],
          'status' => ['required', 'string'],
          'required' => ['required', 'string'],
        ];

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
            $model = $pergunta;

            $model->description = $request->description;
            $model->status = $request->status;
            $model->multiple_choice = $request->multiple_choice;
            $model->required = $request->required;
            $model->tap_answer = $request->tap_answer;

            $save = $model->save();

            $response = 'Pergunta';

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
    public function destroy(Question $pergunta)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('delete-question') ){

          $message = 'Acesso não Autorizado: EXCLUIR pergunta';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $item = $pergunta;

            $item->delete();

            $response = 'Pergunta';

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
    public function categories(Question $pergunta)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('viewAny-category',$pergunta) ){

          $message = 'Acesso não Autorizado: LISTAR categorias';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $items = $pergunta->categories;

            $question = $pergunta;

            if($is_api) return response()->json($items);

            return view('categories.index',compact('items','question'));

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
    public function answers(Question $pergunta)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }

        if( \Gate::denies('viewAny-answer',$pergunta) ){

          $message = 'Acesso não Autorizado: LISTAR respostas';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            $items = $pergunta->answers;

            $question = $pergunta;

            if($is_api) return response()->json($items);

            return view('answers.index',compact('items','question'));

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
    public function changeCategoryQuestion(Request $request)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {

            $is_api = true;
        }

          $rules = [
            'create_delete' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer'],
            'question_id' => ['required', 'integer'],
          ];

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

        if($request->create_delete=='create' && \Gate::denies('create-category_question')){

          $message = 'Acesso não Autorizado: CADASTRAR categoria na pergunta';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }
        if($request->create_delete=='delete' && \Gate::denies('delete-category_question')){

          $message = 'Acesso não Autorizado: EXCLUIR categoria da pergunta';

          if ($is_api) {
            return response()->json(['status'=>false,'msg'=>$message]);
          }else{
            return redirect()->back()
                      ->withErrors($message)
                      ->withInput();
          }
        }

        try {

            if($request->create_delete=='create'){

              $exists = $this->category_question::whereCategoryId($request->category_id)->whereQuestionId($request->question_id)->count();

              if($exists){
                $message = 'Esta Categoria já foi adicionada nesta Pergunta!';

                if ($is_api) {
                  return response()->json(['status'=>false,'msg'=>$message]);
                }else{
                  return redirect()->back()
                            ->withErrors($message)
                            ->withInput();
                }
              }

              $model = new $this->category_question;

              $model->category_id = $request->category_id;
              $model->question_id = $request->question_id;
              $save = $model->save();

              $response = 'Categoria adicionada na Pergunta com Sucesso!';

              if ($is_api) {
                  return response()->json(['status'=>true,'msg'=>$response]);
              }else{
                  return back()->with('successMsg', $response);
              }

          }elseif($request->create_delete=='delete'){

              $this->category_question::whereCategoryId($request->category_id)->whereQuestionId($request->question_id)->delete();

              $response = 'Categoria excluida da Pergunta com Sucesso!';

              if ($is_api) {
                  return response()->json(['status'=>true,'msg'=>$response]);
              }else{
                  return back()->with('successMsg', $response);
              }

          }else{
            $message = 'Impossivel cadastrar ou excluir categoria na pergunta!';

            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$message]);
            }else{
              return redirect()->back()
                        ->withErrors($message)
                        ->withInput();
            }
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
    public function createCategoryQuestion()
    {
      if(\Gate::denies('create-category_question')){

        $message = 'Acesso não Autorizado: CADASTRAR categoria na pergunta';

        if ($is_api) {
          return response()->json(['status'=>false,'msg'=>$message]);
        }else{
          return redirect()->back()
                    ->withErrors($message)
                    ->withInput();
        }
      }
      $categories = $this->category::all();
      $questions = $this->model::all();

      return view('category_questions.form',compact('categories','questions'));
    }
}
