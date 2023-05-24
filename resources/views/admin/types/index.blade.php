@extends('layouts/admin')

@section('content')

<div class="container">
  <h1>Tutti i Tipi</h1>

  <table class="mt-5 table table-striped">
    <thead>
      <th>Nome</th>
      <th>Descrizione</th>
      <th>Slug</th>
      <th>N° Progetti</th>
      <th></th>
    </thead>

    <tbody>
      @foreach ($types as $type)
        <tr>
          <td>{{$type->name}}</td>
          <td>{{$type->description}}</td>
          <td>{{$type->slug}}</td>
          <td>{{ count($type->projects) }}</td>
          <td><a href="{{route('admin.types.show', $type)}}"><i class="fa-solid fa-magnifying-glass"></i></a></td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="container">
  <a href="{{route('admin.types.create')}}" class="btn btn-success mb-5 mt-2" type="button">Aggiungi un nuovo tipo</a>
</div>

@endsection