@extends('layouts/admin')

@section('content')

<div class="container">
  <h1>Tutti i porgetti con tecnologia {{$technology->name}}</h1>

  @if( count($technology->projects) > 0)
  <table class="mt-5 table table-striped">
    <thead>
      <th>Titolo</th>
      <th>Descrizione</th>
      <th>Slug</th>
      <th></th>
    </thead>

    <tbody>
      @foreach ($technology->projects as $project)
        <tr>
          <td>{{$project->title}}</td>
          <td>{{$project->description}}</td>
          <td>{{$project->slug}}</td>
          <td><a href="{{route('admin.projects.show', $project)}}"><i class="fa-solid fa-magnifying-glass"></i></a></td>
        </tr>
      @endforeach
    </tbody>
  </table>

  @else
    <em>Nessun progetto con questa tecnologia.</em>
  @endif  

</div>

<div class="container mt-5 mb-5 d-flex justify-content-around">
  <a href="{{route('admin.technologies.index')}}"><button class="btn btn-primary">Torna indietro</button></a>
  <a href="{{route('admin.technologies.edit', $technology)}}" class="btn btn-success">Modifica la tecnologia</a>

  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
    Elimina
  </button>

  <!-- Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="deleteModalLabel">ATTENZIONE: Azione irreversibile</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Sei sicuro di voler eliminare la tecnologia:
          <br>
          "{{$technology->name}}"?
          <br><br>
          Questa è un'azione irreversibile. Non potrai tornare indietro in nessun modo.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
          
          <form action="{{route('admin.technologies.destroy', $technology)}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Elimina</button>
          </form>

        </div>
      </div>
    </div>
  </div>

</div>


@endsection