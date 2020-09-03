@extends('layouts.app')

@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-question"></i> Perguntas {{isset($category)?' da Categoria: '.$category->name:''}}</h1>
  <p class="mb-4">Tabela com todas perguntas</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Tabela</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Id</th>
              <th>Descrição</th>
              <th>Questão</th>
              <th>Status</th>
              <th>Obrigatório</th>
              <th>Opções</th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $item)
            <tr>
              <td>{{$item->id}}</td>
              <td>{{$item->description}}</td>
              <td>
                @if($item->tap_answer=='Nao')

                  @if($item->multiple_choice=='1')
                    Escolher Mais de Uma
                  @else
                    Escolher Apenas Uma
                  @endif

                @else
                  Digitar Uma Resposta
                @endif
              </td>
              <td>{{$item->status}}</td>
              <td>{{$item->required}}</td>
              <td>


                  @can('update-question', $item)
                    <a href="{{ url('perguntas/'.$item->id.'/edit')  }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  @endcan
                  @can('view-question', $item)
                    <a href="{{ url('perguntas/'.$item->id)  }}" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>
                  @endcan
                  @can('delete-question', $item)

                    <form id="delete-form-{{ $item->id }}" action="{{ url('perguntas/'.$item->id) }}" style="display: none;" method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Voce quer mesmo deletar?')){
                        event.preventDefault();
                        document.getElementById('delete-form-{{ $item->id }}').submit();
                    }else {
                        event.preventDefault();
                      }"><i class="fa fa-trash"></i></button>

                  @endcan


                  @can('viewAny-answer', $item)
                    @if($item->answers()->exists())
                      <a href="{{ url('pergunta/'.$item->id.'/respostas')  }}" class="btn btn-primary btn-sm">Respostas</a>
                    @endif
                  @endcan
                  @can('viewAny-category', $item)
                    @if($item->categories()->exists())
                      <a href="{{ url('pergunta/'.$item->id.'/categorias')  }}" class="btn btn-primary btn-sm">Categorias</a>
                    @endif
                  @endcan


                  @if(isset($category))
                    @can('delete-category_question')
                      <form id="delete-category-question-{{ $item->id }}" action="{{ url('/salvar-vincular-categoria') }}" style="display: none;" method="POST">
                          @csrf
                          @method('POST')
                          <input type="hidden" name="create_delete" value="delete" />
                          <input type="hidden" name="category_id" value="{{$category->id}}" />
                          <input type="hidden" name="question_id" value="{{$item->id}}" />
                      </form>
                      <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Voce quer mesmo desvincular?')){
                          event.preventDefault();
                          document.getElementById('delete-category-question-{{ $item->id }}').submit();
                      }else {
                          event.preventDefault();
                        }"><i class="fa fa-window-restore"></i> Desvincular</button>
                    @endcan
                  @endif


              </td>
            </tr>
            @endforeach


          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
