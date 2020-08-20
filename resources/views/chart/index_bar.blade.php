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
      Gráficos das Respostas @if($campaign)<i>(Diagnóstico: {{$campaign->name}})</i>@endif
    </h1>
    <!--<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Gerar Relatorio</a>-->
  </div>

  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">

          <form>

                    <div class="form-group label-floating">

                        <select required="required" class="form-control" name="questions[]" multiple="multiple" onchange="changeFormAction()">
                          <option value=" ">Filtrar por Perguntas</option>
                            @foreach($allquestions as $q)

                                <option value="{{$q->id}}">
                                  {{$q->description}}
                                </option>

                            @endforeach
                        </select>
                    </div>

        </form>

    </div>
    <div class="col-md-2"></div>
  </div>

  <div id="verGraficoButton">
    <div class="row">
      <div class="col-md-12 text-center float-center">

        <button type="button" class="badge badge-success" onclick="verGrafico()"><i class="fa fa-share"></i> Ver Gráfico das Perguntas Selecionadas</button>
      </div>
    </div>
  </div>

  @if(\request()->has('perguntas'))
    <div id="verGraficoButton">
      <div class="row">
        <div class="col-md-12 text-center float-center">

            <a href="{{url('/graficos-diagnostico/'.$campaign->id.'?barra=1')}}" class="badge badge-secondary"><i class="fa fa-share"></i>Ver Todas Perguntas</a>

        </div>
      </div>
    </div>
  @endif

<!--
  <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings (Annual)</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                </div>
                <div class="col">
                  <div class="progress progress-sm mr-2">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-comments fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
-->
@foreach($questions as $question)


  <div class="row">

    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-7">
      <div class="card shadow mb-4">
        <!--
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary"></h6>

          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <small><i></i></small>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
              <div class="dropdown-header">Dropdown Header:</div>
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </div>

        </div>-->

        <!-- Card Body -->
        <div class="card-body">
          @if(!$question->answers()->exists())   @endif
          <div class="chart-pie">
            <canvas id="myPieChart{{$question->id}}"></canvas>
          </div>

        </div>
      </div>
    </div>

    <!-- Pie Chart
    <div class="col-xl-4 col-lg-5">
      <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h6 class="m-0 font-weight-bold text-primary">Perguntas</h6>
          <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
              <div class="dropdown-header">Dropdown Header:</div>
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </div>
        </div>

        <div class="card-body">
          <div class="chart-pie pt-4 pb-2">
            <canvas id="myPieChart"></canvas>
          </div>
          <div class="mt-4 text-center small">
            <span class="mr-2">
              <i class="fas fa-circle text-primary"></i> Direct
            </span>
            <span class="mr-2">
              <i class="fas fa-circle text-success"></i> Social
            </span>
            <span class="mr-2">
              <i class="fas fa-circle text-info"></i> Referral
            </span>
          </div>
        </div>
      </div>
    </div>-->
  </div>

@endforeach

<!--
  <div class="row">


    <div class="col-lg-6 mb-4">


      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
        </div>
        <div class="card-body">
          <h4 class="small font-weight-bold">Server Migration <span class="float-right">20%</span></h4>
          <div class="progress mb-4">
            <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <h4 class="small font-weight-bold">Sales Tracking <span class="float-right">40%</span></h4>
          <div class="progress mb-4">
            <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <h4 class="small font-weight-bold">Customer Database <span class="float-right">60%</span></h4>
          <div class="progress mb-4">
            <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <h4 class="small font-weight-bold">Payout Details <span class="float-right">80%</span></h4>
          <div class="progress mb-4">
            <div class="progress-bar bg-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <h4 class="small font-weight-bold">Account Setup <span class="float-right">Complete!</span></h4>
          <div class="progress">
            <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-lg-6 mb-4">
          <div class="card bg-primary text-white shadow">
            <div class="card-body">
              Primary
              <div class="text-white-50 small">#4e73df</div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-4">
          <div class="card bg-success text-white shadow">
            <div class="card-body">
              Success
              <div class="text-white-50 small">#1cc88a</div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-4">
          <div class="card bg-info text-white shadow">
            <div class="card-body">
              Info
              <div class="text-white-50 small">#36b9cc</div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-4">
          <div class="card bg-warning text-white shadow">
            <div class="card-body">
              Warning
              <div class="text-white-50 small">#f6c23e</div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-4">
          <div class="card bg-danger text-white shadow">
            <div class="card-body">
              Danger
              <div class="text-white-50 small">#e74a3b</div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-4">
          <div class="card bg-secondary text-white shadow">
            <div class="card-body">
              Secondary
              <div class="text-white-50 small">#858796</div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 mb-4">
          <div class="card bg-light text-black shadow">
            <div class="card-body">
              Light
              <div class="text-black-50 small">#f8f9fc</div>
            </div>
          </div>
      </div>
      <div class="col-lg-6 mb-4">
        <div class="card bg-dark text-white shadow">
          <div class="card-body">
              Dark
              <div class="text-white-50 small">#5a5c69</div>
          </div>
        </div>
      </div>
    </div>

    </div>

    <div class="col-lg-6 mb-4">


      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
        </div>
        <div class="card-body">
          <div class="text-center">
            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_posting_photo.svg" alt="">
          </div>
          <p>Add some quality, svg illustrations to your project courtesy of <a target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a constantly updated collection of beautiful svg images that you can use completely free and without attribution!</p>
          <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on unDraw &rarr;</a>
        </div>
      </div>


      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
        </div>
        <div class="card-body">
          <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce CSS bloat and poor page performance. Custom CSS classes are used to create custom components and custom utility classes.</p>
          <p class="mb-0">Before working with this theme, you should become familiar with the Bootstrap framework, especially the utility classes.</p>
        </div>
      </div>

    </div>
  </div>
-->


@endsection


@push('scripts')
<!-- Page level custom scripts -->
<script type="text/javascript">
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = 'black';



function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

function randomColorGenerator() {
    return '#' + (Math.random().toString(16) + '0000000').slice(2, 8);
}

$(function() {
    window.onbeforeprint = beforePrintHandler;
});
@foreach($questions as $question)

    var answers{{$question->id}} = [];
    var campaign_answers{{$question->id}} = [];
    var campaign_answers_color{{$question->id}} = [];

    var total_answers{{$question->id}} = 0;

      @foreach($question->answers_chart as $answer => $answer_total)

        <?php $random = rand(); ?>

        let description{{$random}} = "{{preg_replace('/\s+/', ' ', $answer)}}";
        let answer_count{{$random}} = "{{$answer_total}}";

        total_answers{{$question->id}} = total_answers{{$question->id}} + "{{$answer_total}}";

          (function($) {
              "use strict"; // Start of use strict
              answers{{$question->id}}.push(description{{$random}});
              campaign_answers{{$question->id}}.push(answer_count{{$random}});
              campaign_answers_color{{$question->id}}.push(randomColorGenerator());
          })(jQuery); // End of use strict

      @endforeach


  // Pie Chart Example
  var ctx{{$question->id}} = document.getElementById("myPieChart{{$question->id}}");

  var myPieChart{{$question->id}} = new Chart(ctx{{$question->id}}, {
    type: 'bar',
    data: {
      labels: answers{{$question->id}},
      datasets: [{
        data: campaign_answers{{$question->id}},
        backgroundColor: campaign_answers_color{{$question->id}} ,
        hoverBackgroundColor: campaign_answers_color{{$question->id}} ,
        borderColor: "#4e73df",
      }],
    },
    /*options: {
      responsive: true,
      maintainAspectRatio: false,
      legend: {
        display: true,
        labels: {
              fontColor: 'black'
             }

      },
      title: {
          display: true,
          fontColor: 'blue',
          text: "{{preg_replace('/\s+/', ' ', $question->description)}}"
      },
      cutoutPercentage: 80,
    },
*/
    options: {
      title: {
          display: true,
          fontColor: 'blue',
          text: "{{preg_replace('/\s+/', ' ', $question->description)}}"
      },
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      legend: {
        display: false
      },
      tooltips: {
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
        callbacks: {
          label: function(tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            return datasetLabel + number_format(tooltipItem.yLabel);
          }
        }
      },
    }
  });

@endforeach
</script>
<script src="{{asset('/')}}js/select2.min.js"></script>

  <script type="text/javascript">

    var url = null;

    $(document).ready(function(){
      $('select').select2({
        placeholder: "Filtrar por Perguntas",
      });
      $('#verGraficoButton').hide();
    });

    function changeFormAction() {
      $('#verGraficoButton').hide();
      url = null;
      var campaign_id = "{{$campaign->id}}";

      var questions = $('select').select2('data');

      if(questions.length>0){
        let questionsString = '';
        for (let i = 0; i < questions.length; ++i) {
          if(i>0){
            questionsString = questionsString + ','
          }
          questionsString = questionsString + questions[i].id;

        }
        url = "/graficos-diagnostico" +"/"+ campaign_id + "?barra=1&&perguntas="+questionsString;
        $('#verGraficoButton').show();
      }
    }

    function verGrafico() {
      if(url){
        this.document.location.href = url;
      }
    }
    function beforePrintHandler () {
      for (var id in Chart.instances) {
        Chart.instances[id].resize()
      }
    }
  </script>
@endpush
