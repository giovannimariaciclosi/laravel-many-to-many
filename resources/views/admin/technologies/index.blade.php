@extends('layouts/admin')

@section('content')

<div class="container">
  <h1>Tutte le Tecnologie</h1>

  <table class="mt-5 table table-striped">
    <thead>
      <th>Nome</th>
      <th>Slug</th>
      <th>Colore</th>
      <th>N° Progetti</th>
      <th></th>
    </thead>

    <tbody>
      @foreach ($technologies as $technology)
        <tr>
          <td>{{$technology->name}}</td>
          <td>{{$technology->slug}}</td>
          <td>
            <span class="badge rounded-pill mx-1" style="background-color: {{$technology->color}}">{{$technology->color}}</span>
          </td>
          <td>{{ count($technology->projects) }}</td>
          <td><a href="{{route('admin.technologies.show', $technology)}}"><i class="fa-solid fa-magnifying-glass"></i></a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="container">
  <a href="{{route('admin.technologies.create')}}" class="btn btn-success mb-5 mt-2" type="button">Aggiungi una nuova tecnologia</a>
</div>

@endsection