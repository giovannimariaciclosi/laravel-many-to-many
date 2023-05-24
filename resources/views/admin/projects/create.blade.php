@extends('layouts.admin')

@section('content')

<main>
  <div class="container mb-3 mt-3">
    <form action="{{route('admin.projects.store')}}" method="POST">
      @csrf
  
      <div class="mb-3">
        <label for="title">Titolo</label>
        {{-- utilizzo le classi di bootstrap per gestire gli errori --}}
        <input class="form-control @error('title') is-invalid @enderror" type="text" id="title" name="title" value="{{old('title')}}">
        @error('title')
          {{-- se c'è un errore visualizzo il messaggio di errore del campo specificato --}}
          <div class="invalid-feedback">
            {{$message}}
          </div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="type_id">Tipo</label>
        <select class="form-select @error('type_id') is-invalid @enderror" id="type_id" name="type_id">
          <option value="">Nessun Tipo</option>

          @foreach ($types as $type)
            <option value="{{$type->id}}" {{$type->id == old('type_id') ? 'selected' : ''}}>{{$type->name}}</option>
          @endforeach
        </select>

        @error('type_id')
          <div class="invalid-feedback">
            {{$message}}
          </div>
        @enderror
      </div>
  
      <div class="mb-3">
        <label for="description">Descrizione</label>
        <textarea cols="30" rows="10" class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{old('description')}}</textarea>
        @error('description')
          {{-- se c'è un errore visualizzo il messaggio di errore del campo specificato --}}
          <div class="invalid-feedback">
            {{$message}}
          </div>
        @enderror
      </div>
      
      <div class="mb-3">
        <label for="slug">Slug</label>
        <input class="form-control @error('slug') is-invalid @enderror" type="text" id="slug" name="slug" value="{{old('title')}}" placeholder="Deve essere uguale al campo Titolo">
        @error('slug')
          <div class="invalid-feedback">
            {{$message}}
          </div>
        @enderror
      </div>
  
      <div class="mb-3">
        <label for="github_repository">Link Repository Github</label>
        <input class="form-control @error('github_repository') is-invalid @enderror" type="text" id="github_repository" name="github_repository" value="{{old('github_repository')}}">
        @error('github_repository')
          {{-- se c'è un errore visualizzo il messaggio di errore del campo specificato --}}
          <div class="invalid-feedback">
            {{$message}}
          </div>
        @enderror
      </div>

      <button class="btn btn-success" type="submit">Aggiungi</button>
    </form>
  </div>
</main>
@endsection