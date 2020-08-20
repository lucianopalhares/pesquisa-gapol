@extends('layouts.app')

@section('content')

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

  <!-- Page Heading -->
  <div class="align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-center"><i class="fa fa-dashboard" aria-hidden="true"></i>
      Cruzamento de Perguntas
    </h1>
    <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Gerar Relatorio</a>-->
  </div>

  <div class="row">
    <div class="col-md-12">

          <form>

                    <div class="form-group label-floating">

                        <select required="required" class="form-control" name="questions[]" multiple="multiple" onchange="changeFormAction()">
                          <option value=" ">Selecione as Perguntas</option>
                            @foreach($questions as $q)

                                <option value="{{$q->id}}">
                                  {{$q->description}}
                                </option>

                            @endforeach
                        </select>
                    </div>

        </form>

    </div>
  </div>

  <div id="cruzarButton">
    <div class="row">
      <div class="col-md-12 text-center float-center">

        <button type="button" class="badge badge-success" onclick="cruzeQuestions()"><i class="fa fa-share"></i> Cruzar Perguntas Selecionadas</button>
      </div>
    </div>
  </div>

  <div>
    <div class="row" id="questionsCruzedShow">
      <div class="col-md-12 text-center float-center" >

        <h1>Resultado:</h1>

        <table class="table table-dark">

        <tbody id="questionsCruzed" class="text-center">

        </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" role="dialog" id="modal-loading">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header alert alert-primary">
          <h5 class="modal-title">Cruzando dados ..</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Aguarde o processamento de dados!</p>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" role="dialog" id="modal-error">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header alert alert-danger">
          <h5 class="modal-title">Opa! ocorreu um erro aqui..</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-error-text">
          <p>Aconteceu um erro ao cruzar os dados..</p>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" role="dialog" id="modal-limit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header alert alert-warning">
          <h5 class="modal-title">Ops, muitas perguntas para processar..</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Escolha somente até 5 perguntas, ou pode haver problemas no processamento dos dados!</p>
          <small><i>(exclua algumas perguntas)</i></small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Entendi</button>
        </div>
      </div>
    </div>
  </div>

@endsection


@push('scripts')

<script src="{{asset('/')}}js/select2.min.js"></script>

  <script type="text/javascript">

    var params = null;

    $(document).ready(function(){
      $('select').select2({
        placeholder: "Selecione as Perguntas",
        maximumSelectionLength: 5,
        language: {
            // You can find all of the options in the language files provided in the
            // build. They all must be functions that return the string that should be
            // displayed.
            maximumSelected: function (e) {
                var t = "Você pode selecionar apenas " + e.maximum + " perguntas";
                e.maximum != 1 && (t += "s");
                return t;
            }
        }
      });
      $('#cruzarButton').hide();
      $('#questionsCruzedShow').hide();
      $('#questionsCruzed').html(' ');
      $('#modal-loading').modal('hide');
      $('#modal-error').modal('hide');

      $('#modal-limit').modal('hide');
    });

    function changeFormAction() {

      var questions = $('select').select2('data');

      $('#questionsCruzedShow').hide();
      $('#questionsCruzed').html(' ');

      $('#cruzarButton').hide();
      params = null;

      if(questions.length>0){
        let questionsString = '';
        for (let i = 0; i < questions.length; ++i) {

          let questionOrder = i+1;

          if(i==0){
            questionsString = 'pergunta'+questionOrder+'='+questions[i].id;
          }else{
            questionsString = questionsString + '&&pergunta'+questionOrder+'='+questions[i].id;
          }
        }
        params = "?" +questionsString;

        $('#cruzarButton').show();
      }

    }

    function cruzeQuestions(){//cruza as perguntas

      var questions = $('select').select2('data');

      if(questions.length>5){
        $('#modal-limit').modal('show');
        return false;
      }

      $('#modal-loading').modal('show');
      $('#modal-error').modal('hide');
      var token = $("meta[name='csrf-token']").attr("content");

      $('#questionsCruzedShow').hide();
      $('#questionsCruzed').html(' ');

      var ajax_success = false;

        $.ajax({
          url: "{{url('api/cruzar-perguntas-selecionadas')}}"+params,
          type: 'get',
          dataType: "json",
          data: {
            _token: token,
                _method: 'get'
              },
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data){
              console.log('success');
               if(data.status){

                  if(data.data.length>0){
                    let rows = ' ';
                    for (var i = 0; i < data.data.length; i++) {

                      let tr = "<tr>";
                      tr = tr + "<td>";
                      tr = tr + data.data[i];
                      tr = tr + "</td>";
                      tr = tr + "</tr>";

                      rows = rows + tr
                    }
                    $('#questionsCruzed').html(rows);

                    ajax_success = true;
                  }else{
                    $('#modal-loading').modal('hide');
                    $('#modal-error').modal('show');
                    $('#modal-error-text').html("<p>Talvez seja muitos dados para processar..</p>");

                  }

               }else{
                 $('#modal-loading').modal('hide');
                 $('#modal-error').modal('show');
                 $('#modal-error-text').html("<p>Aconteceu um erro ao cruzar os dados..</p>");

               }
            },
            error: function(jqXHR, textStatus, errorThrown) {

                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);

                $('#modal-error').modal('show');
                $('#modal-error-text').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');

            },
            complete: function(){

              console.log('complete');

              $('#modal-loading').modal('hide');

              if(ajax_success){
                $('#questionsCruzedShow').show();
              }else{
                $('#modal-error').modal('show');
                $('#modal-error-text').html("<p>Erro inesperado..Talvez seja muitos dados para processar..</p>");

              }


            },
        });


    }
  </script>
@endpush
