@extends('layouts.app')

@push('css')
  <link href="{{asset('/')}}css/select2.min.css" rel="stylesheet" />
  <style>
      .note-group-select-from-files {
        display: none;
      }
      .select2-container {
      width: 100% !important;
      padding: 0;
      }
  </style>
@endpush

@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-random"></i> Cadastrar Categoria na Pergunta</h1>
  <p class="mb-4">Formulário</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">
        @if(isset($item))
          @if(isset($show))
            Visualizar
          @else
            Editar
          @endif
        @else
          Cadastrar
        @endif
          Categoria na Pergunta
      </h6>
    </div>
    <div class="card-body">


        {!! Form::open(['url' => 'salvar-vincular-categoria','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}

            <input type="hidden" name="create_delete" value="create" />
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group label-floating">
                        <label class="control-label">Categoria *</label>
                        <select required="required" class="form-control" name="category_id">
                          <option value=" ">Selecione</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" {{ old('category_id') == $category->id ? "selected='selected'" : (isset($item->category_id) && $item->category_id == $category->id ? "selected='selected'" : '') }}>
                                  {{$category->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                    <div class="form-group label-floating">
                        <label class="control-label">Pergunta *</label>
                        <select required="required" class="form-control" name="question_id">
                          <option value=" ">Selecione</option>
                            @foreach($questions as $question)

                                <option value="{{$question->id}}" {{ old('question_id') == $question->id ? "selected='selected'" : (isset($item->question_id) && $item->question_id == $question->id ? "selected='selected'" : '') }}>
                                  ({{$question->id}}): {{$question->description}}
                                </option>

                            @endforeach
                        </select>
                    </div>
                </div>
            </div>



            <a href="{{ url('categorias') }}" class="btn btn-danger"> <i class="fa fa-list"></i> Ver Lista de Categorias</a>



            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>



        {{ Form::close() }}

    </div>
  </div>
@endsection

@push('scripts')
<script src="{{asset('/')}}js/select2.min.js"></script>

  <script type="text/javascript">

    $(document).ready(function(){
      $('select').select2();
    });

  </script>
@endpush
