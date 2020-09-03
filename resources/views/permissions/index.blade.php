@extends('layouts.app')

@section('content')

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800"><i class="fa fa-key"></i> Permissões {{isset($role)?' do Cargo: '.$role->name:''}}</h1>
  <p class="mb-4">Tabela com todas permissões</p>

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
              <th>Nome</th>
              <th>Slug</th>
              <th>Cadastro</th>
              <th>Opções</th>
            </tr>
          </thead>
          <tbody>
            @foreach($items as $item)
            <tr>
              <td>{{$item->id}}</td>
              <td>{{$item->name}}</td>
              <td>{{$item->slug}}</td>
              <td>{{date("d/m/Y", strtotime($item->created_at))}}</td>
              <td>
                <!--
                @can('update-permission', $item)
                  <a href="{{ url('permissoes/'.$item->id.'/edit')  }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                @endcan
                @can('view-permission', $item)
                  <a href="{{ url('permissoes/'.$item->id)  }}" class="btn btn-secondary btn-sm"><i class="fa fa-eye"></i></a>
                @endcan
                @can('delete-permission', $item)
                  <form id="delete-form-{{ $item->id }}" action="{{ url('permissoes/'.$item->id) }}" style="display: none;" method="POST">
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
              -->
                @if(isset($role))
                  @can('delete-permission_role')
                    <form id="delete-permission-role-{{ $item->id }}" action="{{ url('/salvar-vincular-permissao') }}" style="display: none;" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="create_delete" value="delete" />
                        <input type="hidden" name="role_id" value="{{$role->id}}" />
                        <input type="hidden" name="permission_id" value="{{$item->id}}" />
                    </form>
                    <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Voce quer mesmo desvincular?')){
                        event.preventDefault();
                        document.getElementById('delete-permission-role-{{ $item->id }}').submit();
                    }else {
                        event.preventDefault();
                      }"><i class="fa fa-window-restore"></i> Desvincular</button>
                  @endcan
                @else
                  <i class="fa fa-lock"></i>
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
