@php
    
$routeName = Route::currentRouteName();
function routeNameContains($string) {
    return str_contains( Route::currentRouteName(), $string);
}

@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])

    {{-- fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  @include('partials/navbar')
  <div id="admin-layout">
    <aside id="admin-sidebar"> 
      <div class="card {{ $routeName == 'admin.home' ? 'border-primary' : '' }}">
        <div class="card-header {{ $routeName == 'admin.home' ? 'text-primary' : '' }}">
          Dashboard
        </div>
        <div class="list-group list-group-flush">
          <a href="{{route('admin.home')}}" class="list-group-item list-group-item-action  {{routeNameContains('admin.home') ? 'active' : ''}}">Home</a>
        </div>
      </div>

      <div class="card {{ routeNameContains('projects.') ? 'border-primary' : '' }}">
        <div class="card-header {{ routeNameContains('projects.') ? 'text-primary' : '' }}">
          Progetti
        </div>
        <div class="list-group list-group-flush">
          <a href="{{route('admin.projects.index')}}" class="list-group-item list-group-item-action {{routeNameContains('projects.index') ? 'active' : ''}}">Tutti i progetti</a>
          <a href="{{route('admin.projects.create')}}" class="list-group-item list-group-item-action {{routeNameContains('projects.create') ? 'active' : ''}}">Aggiungi un progetto</a>
        </div>
      </div>

      <div class="card {{ routeNameContains('types.') ? 'border-primary' : '' }}">
        <div class="card-header {{ routeNameContains('types.') ? 'text-primary' : '' }}">
          Tipi
        </div>
        <div class="list-group list-group-flush">
          <a href="{{route('admin.types.index')}}" class="list-group-item list-group-item-action {{routeNameContains('types.index') ? 'active' : ''}}">Tutti i tipi</a>
          <a href="{{route('admin.types.create')}}" class="list-group-item list-group-item-action {{routeNameContains('types.create') ? 'active' : ''}}">Aggiungi un tipo</a>
        </div>
     </div>

    </aside>
    <main>
        @yield('content')
    </main>
  </div>
  @include('partials/footer')


  {{-- <div>
    @include('partials/navbar')
    <main class="container">
        @yield('content')
    </main>
    @include('partials/footer')
  </div> --}}
</body>

</html>