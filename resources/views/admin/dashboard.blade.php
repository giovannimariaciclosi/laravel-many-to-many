@extends('layouts/admin')

@section('content')

<div class="container">
  <h1 class="mt-5">Il tuo porfolio</h1>

  <table class="mt-5 table table-striped">
    <thead>
      <th>Vai a</th>
      <th>Aggiungi un</th>
    </thead>

    <tbody>
        <tr>
          <td><a href="{{route('admin.projects.index')}}" class="btn btn-primary">Tutti i progetti</a></td>
          <td><a href="{{route('admin.projects.create')}}" class="btn btn-success" type="button">Progetto</a>
          </td>
        </tr>
        <tr>
          <td><a href="{{route('admin.types.index')}}" type="button" class="btn btn-primary">Tutti i tipi</a></td>
          <td><a href="{{route('admin.types.create')}}" class="btn btn-success" type="button">Tipo</a>
          </td>
        </tr>
    </tbody>
  </table>
  {{-- <div class="container d-flex justify-content-around align-items-center mt-4">
    <a href="{{route('admin.projects.index')}}" type="button" class="btn btn-primary">Vedi i progetti</a>
    <a href="{{route('admin.projects.create')}}" class="btn btn-success" type="button">Aggiungi un nuovo progetto</a>
  </div>
  <div class="container d-flex justify-content-around align-items-center mt-4">
    <a href="{{route('admin.types.index')}}" type="button" class="btn btn-primary">Vedi i tipi</a>
    <a href="{{route('admin.types.create')}}" class="btn btn-success" type="button">Aggiungi un nuovo tipo</a>
  </div> --}}
</div>

    
@endsection