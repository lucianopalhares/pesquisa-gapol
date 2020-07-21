@extends('layouts.app')

@section('content')

<hr>
<div class="text-center">
  <h1 class="h4 text-gray-900 mb-4">Recuperar Senha</h1>
</div>
<hr>
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

<form class="user" method="POST" action="{{ route('password.email') }}">
    @csrf
  <div class="form-group">

    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror form-control-user" placeholder="Endereço de Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>

  <div class="form-group">
    <div class="custom-control custom-checkbox small">
      <input id="customCheck" class="custom-control-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
      <label class="custom-control-label" for="customCheck">Lembrar</label>
    </div>
  </div>
  <br />
  <button type="submit" class="btn btn-primary btn-user btn-block">
    Enviar Link de Recuperação
  </button>

</form>
<hr>
  @if (Route::has('login'))
    <div class="text-center">
      <a class="small" href="{{ route('login') }}">
          Entrar
      </a>
    </div>
  @endif
  @if (Route::has('register'))
  <!--
    <div class="text-center">
      <a class="small" href="{{ route('register') }}">Me Cadastrar!</a>
    </div>
  -->
  @endif



@endsection
