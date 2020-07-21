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
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-registered"></i> Diagnostico: {{$campaign->name}}</h1>
  <p class="mb-4">Responder Pergunta do Diagnostico</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">

        Pergunta: {{$question->description}}

      </h6>
    </div>
    <div class="card-body">


        {!! Form::open(['url' => 'responder-campanha','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}

            <input type="hidden" name="campaign_id" value="{{$campaign->id}}" />
            <input type="hidden" name="question_id" value="{{$question->id}}" />

            @if($question->answers()->exists())

              @foreach($question->answers as $answer)

                @if($answer->status=='Ativo')
                  <div class="row">
                    <div class="col-md-8">
                        <div class="form-group label-floating">
                            <label class="control-label">{{$answer->description}}</label>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group label-floating">
                            <input type="checkbox" class="form-control" name="answers[]" value="{{$answer->id}}" {{ old('answers[]') == $answer->id ? "checked" : '' }}>
                        </div>
                    </div>
                  </div>
                @endif
              @endforeach
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
            @elseif($question->tap_answer=='Sim')
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <label class="control-label">Digite a Resposta</label>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group label-floating">
                        <input type="text" class="form-control" name="answer_description" value="{{old('answer_description')}}">
                    </div>
                </div>
              </div>
                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
            @elseif($question->tap_answer=='Nao')
            <div class="row">
              <div class="col-md-12 text-center">
                  <div class="form-group label-floating">
                      <label class="control-label">Esta pergunta nao tem respostas para escolher e não permite digitar uma resposta.</label>

                  </div>
              </div>
            </div>

            @else
            <div class="row">
              <div class="col-md-12 text-center">
                  <div class="form-group label-floating">
                      <label class="control-label">Erro inesperado ao responder esta pergunta.</label>

                  </div>
              </div>
            </div>
            
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
