@extends('layout')

@section('container')
<div class="container min-vh-100 d-flex align-items-center justify-content-center">
  
  <div>
    <div>

      <h4 class="text-center mb-4">Criar Conta</h4>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{$error}}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="/sign-up" method="POST" class="form-register">
        @csrf
        <div class="input-label">
          <label for="nome" class="">Nome</label>
          <input type="text" class="" name="name" id="name" placeholder="Seu nome completo" required>
        </div>

        <div class="input-label">
          <label for="email" class="">Email</label>
          <input type="email" class="" name="email" id="email" placeholder="seuemail@exemplo.com" required>
        </div>

        <div class="input-label">
          <label for="senha" class="">Senha</label>
          <input type="password" class="" name="password" id="password" placeholder="Digite sua senha" required>
        </div>

        <div class="input-label">
          <label for="confirmarSenha" class="">Repita sua senha</label>
          <input type="password" class="" name="password_confirmation" id="confirmarSenha" placeholder="Digite novamente" required>
        </div>

        <div>
          <button type="submit" class="btn-primary">
            Criar Conta
          </button>
        </div>

      </form>

      <p class="">
        Já possui conta? <a href="#">Entrar</a>
      </p>

    </div>
  </div>

</div>
@endsection