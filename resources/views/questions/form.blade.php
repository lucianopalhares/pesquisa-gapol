@extends('layouts.app')

@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-question"></i> Perguntas</h1>
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
          Pergunta
      </h6>
    </div>
    <div class="card-body">

      @if(isset($item))
        {!! Form::open(['url' => 'perguntas/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}

      @else
        {!! Form::open(['url' => 'perguntas','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}

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
                        <label class="control-label">Descrição</label>
                        <textarea {{isset($show)?"disabled='disabled'":''}}  class="form-control" name="description">{{ old('description',isset($item->description)?$item->description:' ') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">

              <div class="col-md-6">
                  <div class="form-group label-floating">
                      <label class="control-label">Digitar Resposta *</label>
                      <select {{isset($show)?"disabled='disabled'":''}} required="required" onchange="tapAnswer(this.value)" class="form-control" name="tap_answer">

                            <option value="Nao" {{ old('tap_answer') == 'Nao' ? "selected='selected'" : isset($item->tap_answer) && $item->tap_answer == 'Nao' ? "selected='selected'" : '' }}>
                                Não Digitar, a resposta sera selecionada
                            </option>
                            <option value="Sim" {{ old('tap_answer') == 'Sim' ? "selected='selected'" : isset($item->tap_answer) && $item->tap_answer == 'Sim' ? "selected='selected'" : '' }}>
                              Sim, digitará uma resposta
                            </option>
                      </select>
                  </div>
              </div>

                            <div class="col-md-6" id="multiple_choice">
                                <div class="form-group label-floating">
                                    <label class="control-label">Multipla Escolha </label>
                                    <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control" name="multiple_choice">
                                          <option value="1" {{ old('multiple_choice') == '1' ? "selected='selected'" : isset($item->multiple_choice) && $item->multiple_choice == '1' ? "selected='selected'" : '' }}>
                                            Sim, Escolher Mais de Uma
                                          </option>
                                          <option value="0" {{ old('multiple_choice') == '0' ? "selected='selected'" : isset($item->multiple_choice) && $item->multiple_choice == '0' ? "selected='selected'" : '' }}>
                                              Não, Apenas Uma Escolha
                                          </option>
                                    </select>
                                </div>
                            </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                  <div class="form-group label-floating">
                      <label class="control-label">Status *</label>
                      <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control" name="status">
                            <option value="Inativo" {{ old('status') == 'Inativo' ? "selected='selected'" : isset($item->status) && $item->status == 'Inativo' ? "selected='selected'" : '' }}>
                              Inativo
                            </option>
                            <option value="Ativo" {{ old('status') == 'Ativo' ? "selected='selected'" : isset($item->status) && $item->status == 'Ativo' ? "selected='selected'" : '' }}>
                                Ativo
                            </option>
                      </select>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group label-floating">
                      <label class="control-label">Obrigatório Responder *</label>
                      <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control" name="required">
                            <option value="Sim" {{ old('required') == 'Sim' ? "selected='selected'" : isset($item->required) && $item->required == 'Sim' ? "selected='selected'" : '' }}>
                              Sim, Precisa Responder esta Pergunta
                            </option>
                            <option value="Nao" {{ old('required') == 'Nao' ? "selected='selected'" : isset($item->required) && $item->required == 'Nao' ? "selected='selected'" : '' }}>
                                Não, Nao precisa responder esta Pergunta
                            </option>
                      </select>
                  </div>
              </div>



            </div>


            <a href="{{ url('perguntas') }}" class="btn btn-danger"> <i class="fa fa-list"></i> Voltar para Lista</a>

            @if(isset($item->id))
            <a href="{{url('perguntas/create')}}" class="btn btn-secondary"><i class="fa fa-plus"></i> Cadastrar Novo(a)</a>
            @endif

            @if(!isset($show))
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
            @else
            <a href="{{url('perguntas/'.$item->id.'/edit')}}" class="btn btn-secondary">Editar</a>
            @endif


        {{ Form::close() }}

    </div>
  </div>
@endsection

@push('scripts')

  <script type="text/javascript">

    $(document).ready(function(){
      tapAnswer("{{isset($item->tap_answer)?$item->tap_answer:'Nao'}}");
    });

    function tapAnswer(e){
      $('#multiple_choice').hide();
      if(e=='Nao') $('#multiple_choice').show();
    }

  </script>
@endpush
