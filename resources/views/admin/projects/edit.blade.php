@extends('layouts.admin')

@section('content')

<main>
  <div class="container mb-3 mt-3">
    <form action="{{route('admin.projects.update', $project)}}" method="POST" enctype="multipart/form-data">
      @csrf

      @method('PUT')
  
      <div class="mb-3">
        <label for="title">Titolo</label>
        {{-- utilizzo le classi di bootstrap per gestire gli errori --}}
        <input class="form-control @error('title') is-invalid @enderror" type="text" id="title" name="title" value="{{old('title') ?? $project->title}}">
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
            <option value="{{$type->id}}" {{$type->id == old('type_id', $project->type_id) ? 'selected' : ''}}>{{$type->name}}</option>
          @endforeach
        </select>

        @error('type_id')
          <div class="invalid-feedback">
            {{$message}}
          </div>
        @enderror
      </div>

      {{-- inserimento file --}}
      <div class="mb-3">
        <label for="cover_image">Immagine di copertina</label>
        <input type="file" id="cover_image" name="cover_image" class="form-control @error('cover_image') is-invalid @enderror">

        @error('cover_image')
        <div class="invalid-feedback">
          {{$message}}
        </div>
      @enderror
      </div>
      {{-- /inserimento file --}}

      <div class="mb-3 form-group">
        <h4>Tecnologie</h4>
  
        @foreach($technologies as $technology)
        <div class="form-check">
          {{-- faccio il controllo dei check con @checked --}}
          <input type="checkbox" id="technology-{{$technology->id}}" name="technologies[]" value="{{$technology->id}}" @checked($project->technologies->contains($technology))>
          <label for="technology-{{$technology->id}}">{{$technology->name}}</label>
        </div>
        @endforeach
  
      </div>
  
      <div class="mb-3">
        <label for="description">Descrizione</label>
        <textarea cols="30" rows="10" class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{old('description') ?? $project->description}}</textarea>
        @error('description')
          {{-- se c'è un errore visualizzo il messaggio di errore del campo specificato --}}
          <div class="invalid-feedback">
            {{$message}}
          </div>
        @enderror
      </div>
  
      <div class="mb-3">
        <label for="slug">Slug</label>
        <input class="form-control @error('slug') is-invalid @enderror" type="text" id="slug" name="slug" value="{{old('title') ?? $project->title}}" placeholder="Deve essere uguale al campo Titolo">
        @error('slug')
          <div class="invalid-feedback">
            {{$message}}
          </div>
        @enderror
      </div>
  
      <div class="mb-3">
        <label for="github_repository">Link Repository Github</label>
        <input class="form-control @error('github_repository') is-invalid @enderror" type="text" id="github_repository" name="github_repository" value="{{old('github_repository') ?? $project->github_repository}}">
        @error('github_repository')
          {{-- se c'è un errore visualizzo il messaggio di errore del campo specificato --}}
          <div class="invalid-feedback">
            {{$message}}
          </div>
        @enderror
      </div>

      <button class="btn btn-success" type="submit">Salva modifiche</button>
    </form>
  </div>
</main>
@endsection