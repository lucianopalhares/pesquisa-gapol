@extends('layouts.app')

@section('content')
<hr>
<div class="text-center">
  <h1 class="h4 text-gray-900 mb-4">Novo Cadastro</h1>
</div>
<hr>

<form class="user" method="POST" action="{{ route('register') }}">
    @csrf
<div class="form-group row">
  <div class="col-sm-12 mb-3 mb-sm-0">
    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror form-control-user" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Seu Nome" autofocus>

    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
</div>
<div class="form-group">
  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror form-control-user" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Seu Email" autofocus>

  @error('email')
      <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
      </span>
  @enderror
</div>
<div class="form-group row">
  <div class="col-sm-6 mb-3 mb-sm-0">
    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror form-control-user" name="password" value="{{ old('password') }}" required autocomplete="new-password" placeholder="Senha">

    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
  </div>
  <div class="col-sm-6">
    <input id="password-confirm" type="password" class="form-control form-control-user" name="password_confirmation" required autocomplete="new-password" placeholder="Repita a Senha">
  </div>
</div>
<button type="submit" class="btn btn-primary btn-user btn-block">
  Cadastrar
</button>
<!--
<hr>
<a href="index.html" class="btn btn-google btn-user btn-block">
  <i class="fab fa-google fa-fw"></i> Registrar com Google
</a>
<a href="index.html" class="btn btn-facebook btn-user btn-block">
  <i class="fab fa-facebook-f fa-fw"></i> Registrar com Facebook
</a>
-->

</form>
@if (Route::has('login'))
  <div class="text-center">
    <a class="small" href="{{ route('login') }}">Já tenho cadastro!</a>
  </div>
@endif
@endsection
