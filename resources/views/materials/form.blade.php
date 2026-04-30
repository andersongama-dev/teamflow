@extends('layout')

@section('container')
<div class="container min-vh-100 d-flex align-items-center justify-content-center">
  
  <div>
    <div>

      <h4 class="text-center mb-4">Cadastrar Material</h4>

      @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{$error}}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="/materials/store" method="POST" enctype="multipart/form-data" class="form-register">
        @csrf

        <div class="input-label">
          <label for="nome">Nome</label>
          <input type="text" name="nome" id="nome" placeholder="Nome do material" required>
        </div>

        <div class="input-label">
          <label for="descricao">Descrição</label>
          <textarea name="descricao" id="descricao" placeholder="Descreva o material" required></textarea>
        </div>

        <div class="input-label">
          <label for="arquivo">Arquivo</label>
          <input type="file" name="arquivo" id="arquivo" required>
        </div>

        <div>
          <button type="submit" class="btn-primary">
            Cadastrar Material
          </button>
        </div>

      </form>

    </div>
  </div>

</div>
@endsection