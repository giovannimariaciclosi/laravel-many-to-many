@extends('layouts.app')
@section('content')

<div class="jumbotron p-5 mb-4 bg-light rounded-3">
    <div class="container py-5">
        <h1 class="display-5 fw-bold">Crea il tuo portfolio</h1>
        <p class="col-md-8 fs-4">Crea il tuo porfolio di progetti in pochi semplici step, inzia registrandoti!</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg" type="button">Registrati</a>
    </div>
</div>
@endsection