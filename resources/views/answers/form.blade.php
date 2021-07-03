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
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-server"></i> Respostas</h1>
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
          Resposta
      </h6>
    </div>
    <div class="card-body">

      @if(isset($item))
        {!! Form::open(['url' => 'respostas/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}

      @else
        {!! Form::open(['url' => 'respostas','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}

      @endif

            @if(isset($item->id))
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group label-floating">
                        <label class="control-label">ID *</label>
                        <input disabled="disabled" type="text" class="form-control" value="{{ $item->id }}">
                    </div>
                </div>
            </div>
            <input type="hidden" value="{{$item->id}}" name="id" />
            @endif

            <div class="row">
              <div class="col-md-12">
                  <div class="form-group label-floating">
                      <label class="control-label">Pergunta *</label>
                      <select required="required" class="form-control" name="question_id">
                        <option value=" ">Selecione</option>
                          @foreach($questions as $question)

                              <option value="{{$question->id}}" {{ old('question_id') == $question->id ? "selected='selected'" : (isset($item->question_id) && $item->question_id == $question->id ? "selected='selected'" : '') }}>
                                {{$question->description}}
                              </option>

                          @endforeach
                      </select>
                  </div>
              </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group label-floating">
                        <label class="control-label">Descrição</label>
                        <textarea {{isset($show)?"disabled='disabled'":''}}  class="form-control" name="description">{{ old('description',isset($item->description)?$item->description:' ') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                  <div class="form-group label-floating">
                      <label class="control-label">Status *</label>
                      <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control" name="status">
                            <option value="Inativo" {{ old('status') == 'Inativo' ? "selected='selected'" : (isset($item->status) && $item->status == 'Inativo' ? "selected='selected'" : '') }}>
                              Inativo
                            </option>
                            <option value="Ativo" {{ old('status') == 'Ativo' ? "selected='selected'" : (isset($item->status) && $item->status == 'Ativo' ? "selected='selected'" : '') }}>
                                Ativo
                            </option>
                      </select>
                  </div>
              </div>

            </div>


            <a href="{{ url('respostas') }}" class="btn btn-danger"> <i class="fa fa-list"></i> Voltar para Lista</a>

            @if(isset($item->id))
            <a href="{{url('respostas/create')}}" class="btn btn-secondary"><i class="fa fa-plus"></i> Cadastrar Novo(a)</a>
            @endif

            @if(!isset($show))
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
            @else
            <a href="{{url('respostas/'.$item->id.'/edit')}}" class="btn btn-secondary">Editar</a>
            @endif


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
