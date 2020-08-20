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
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-question"></i> Funil de Respostas</h1>
  <p class="mb-4">Selecione as Perguntas para Cruzar as Respostas</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary text-center" id="div_answers">
        Selecione as Respostas
      </h6>
    </div>
    <div class="card-body">

    <div id="show">




        <div class="row">
          <div class="col-md-12">
              <div class="form-group label-floating">
                  <label class="control-label">Escolha a Pergunta *</label>
                  <select required="required" id="questions_campaign" name="questions_campaign" class="form-control" onchange="selectQuestion(this.value)">
                  </select>
              </div>
          </div>
        </div>

        <div class="row" id="show_answers_question">
          <div class="col-md-12">
              <div class="form-group label-floating">
                  <label class="control-label">Escolha a Resposta *</label>
                  <select required="required" id="answers_question" name="answer_id" class="form-control" onchange="selectAnswer(this.value)">
                  </select>
              </div>
          </div>
        </div>

        <div class="divider">

        </div>

        <!--<div class="row">
          <div class="col-md-12">
              <div class="form-group label-floating">
                  <label class="control-label">Respostas Selecionadas:</label>

                  <div id="div_answers">

                  </div>
              </div>
          </div>
        </div>-->

        <button type="button" class="btn btn-success" onclick="cruzeData()"><i class="fa fa-list"></i> Cruzar Dados</button>

      </div>

      <div id="alert" class="float-center">

      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{asset('/')}}js/select2.min.js"></script>

  <script type="text/javascript">

    Array.prototype.contains = function ( needle ) {
       for (i in this) {
           if (this[i] == needle) return true;
       }
       return false;
    }

    var question_description_selected = null;//pergunta que selecionou atual

    var answers = null;//respostas pra mostrar aqui
    var answersParams = [];//respostas que vai na url pra cruzar os dados

    var questions_campaign = null;//select das perguntas
    var answers_question = null;//select das respostas

    var questions_selecteds = [];

    $(document).ready(function(){
      resetQuestionsAnswers();
      $('select').select2();
    });

    //limpa os selects das perguntas e respostas (e esconde)
    function resetQuestionsAnswers(reset_question = true,reset_answer = true){

      if(reset_question){
        questions_campaign = document.getElementById("questions_campaign");
        questions_campaign.options.length = 0;
        question_description_selected = null;

        loadQuestions();
      }

      if(reset_answer){
        answers_question = document.getElementById("answers_question");
        answers_question.options.length = 0;
        $('#show_answers_question').hide();
      }
    }

    function loadQuestions(question_selected = null){//carrega as questoes

      var token = $("meta[name='csrf-token']").attr("content");

        $.ajax({
          url: "{{url('api/questions-cruze/')}}",
          type: 'get',
          dataType: "json",
          data: {
            _token: token,
                _method: 'get'
              },
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data){

               if(data.status){
                  questions_campaign.options[questions_campaign.options.length] = new Option('Selecione',' ');
                  for(index in data.data) {
                    if(!questions_selecteds.contains(data.data[index]['id'])){
                      if(data.data[index]['id']==parseInt(question_selected)){
                        questions_campaign.options[questions_campaign.options.length] = new Option(data.data[index]['description'], data.data[index]['id'],true,true);
                      }else{
                        questions_campaign.options[questions_campaign.options.length] = new Option(data.data[index]['description'], data.data[index]['id']);
                      }
                    }
                  }
               }else{
                 console.log('erro ao buscar questoes da campanha');
               }
            }
        });


    }

    function selectQuestion(value,answer_selected = null){//carrega as respostas da pergunta
      //ajax request

      resetQuestionsAnswers(false,true);

      var token = $("meta[name='csrf-token']").attr("content");

      if(!parseInt(value)) return false;

        $.ajax({
          url: "{{url('api/answers-cruze/')}}"+"/"+value,
          type: 'get',
          dataType: "json",
          data: {
            _token: token,
                id: value,
                _method: 'get'
              },
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (data){

               if(data.status){
                  answers_question.options[answers_question.options.length] = new Option('Selecione',' ');
                  for(index in data.data) {
                      question_description_selected = data.data[index][0]['question_description'];
                      if(index==answer_selected){
                        answers_question.options[answers_question.options.length] = new Option(index, index,true,true);
                      }else{
                        answers_question.options[answers_question.options.length] = new Option(index, index);
                      }
                  }

                  $('#show_answers_question').show();
               }else{
                 console.log('erro ao buscar respostas da pergunta');
               }
            }
        });
    }
    function selectAnswer(value){
      if(value){

        let text = jQuery("#answers_question").find("option[value='" + jQuery("#answers_question").val() + "']").text()
        let question_selected = document.getElementById("questions_campaign").value;
        questions_selecteds.push(question_selected);

        if(answers==null){
          answers = question_description_selected+' '+text;
        }else{
          answers = answers + ', ' + question_description_selected+' '+text;
        }

        answersParams.push({question_id:question_selected, question_description:question_description_selected, answer_description:value, question_order:questions_selecteds.length});

        $('#div_answers').html(" ");

        resetQuestionsAnswers();

        if(questions_selecteds.length==10){
          $("#show").hide();
          $('#alert').html("<span class='badge badge-primary float-center'>Você já selecionou o limite de 10 respostas</span>");
        }

        cruzeData();
      }
    }
    function cruzeData(){// link onde cruza os dados

      var token = $("meta[name='csrf-token']").attr("content");

      $.ajax({
        url: "{{url('api/cruze-data/')}}",
        type: 'post',
        dataType: "json",
        data: {
          _token: token,
              params: answersParams,
              _method: 'post'
            },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          success: function (data){
             $('#div_answers').html(data.data);

          }
      });
    }

  </script>
@endpush
