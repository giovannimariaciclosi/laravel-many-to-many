@extends('layouts.admin')

@section('content')
<div class="container">
  <h1 class="mb-3">Aggiungi una tecnologia</h1>
  
  <form action="{{route('admin.technologies.store')}}" method="POST">
    @csrf
  
  
    <div class="mb-3">
      <label for="name">Nome</label>
      <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" type="text" value="{{old('name')}}">
      @error('name')
        <div class="invalid-feedback">
          {{$message}}
        </div>
      @enderror
    </div>
  
    <div class="mb-3">
      <label for="color">Colore</label>
      <textarea id="color" name="color" class="form-control @error('color') is-invalid @enderror">{{old('color')}}</textarea>

      @error('color')
      <div class="invalid-feedback">
        {{$message}}
      </div>
      @enderror
    </div>

    <button class="btn btn-primary" type="submit">Aggiungi</button>
  
  </form>

</div>

@endsection