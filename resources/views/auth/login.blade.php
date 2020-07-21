@extends('layouts.app')

@section('content')

<hr>
<div class="text-center">
  <h1 class="h4 text-gray-900 mb-4">Entrar</h1>
</div>
<hr>

<form class="user" method="POST" action="{{ route('login') }}">
    @csrf
  <div class="form-group">
    <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Digite o Email...">
    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="form-group">
    <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Senha">
  </div>
  <div class="form-group">
    <div class="custom-control custom-checkbox small">
      <input id="customCheck" class="custom-control-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
      <label class="custom-control-label" for="customCheck">Lembrar Senha</label>
    </div>
  </div>
  <br />
  <button type="submit" class="btn btn-primary btn-user btn-block">
    Entrar
  </button>
  <!--
  <hr>
  <a href="index.html" class="btn btn-google btn-user btn-block">
    <i class="fab fa-google fa-fw"></i> Entrar com Google
  </a>
  <a href="index.html" class="btn btn-facebook btn-user btn-block">
    <i class="fab fa-facebook-f fa-fw"></i> Entrar com Facebook
  </a>
-->
</form>
<hr>
  @if (Route::has('password.request'))
    <div class="text-center">
      <a class="small" href="{{ route('password.request') }}">
          Esqueceu a Senha?
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
