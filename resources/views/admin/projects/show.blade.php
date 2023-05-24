@extends('layouts/admin')

@section('content')

<div class="container">
  <div class="main">
    <h1>{{$project->title}}</h1>

    {{-- se è presente stampo il nome del type --}}
    <span>Tipo: {{$project->type->name ?? 'Nessun Tipo'}}</span>
    
    <hr>
    <span>Descrizione:</span>
    <p>{{$project->description}}</p>
    <span>Link Repository Github:</span>
    <p>{{$project->github_repository}}</p>
    <span>Slug:</span>
    <p>{{$project->slug}}</p>
  </div>
</div>


<div class="container mt-5 mb-5 d-flex justify-content-around">
  <a href="{{route('admin.projects.index')}}"><button class="btn btn-primary">Torna indietro</button></a>
  {{-- EDIT --}}
  <a href="{{route('admin.projects.edit', $project)}}"><button class="btn btn-success">Modifica Progetto</button></a>
  {{-- DELETE --}}
  {{-- Button trigger modal --}}
  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
    Cancella
  </button>

  {{-- Modal --}}
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="deleteModalLabel">ATTENZIONE: Azione irreversibile</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Sei sicuro di voler eliminare il progetto:
          <br>
          "{{$project->title}}"?
          <br><br>
          Questa è un'azione irreversibile. Non potrai tornare indietro in nessun modo.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
          <form action="{{route('admin.projects.destroy', $project)}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Cancella</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- /Modal --}}
</div>
@endsection