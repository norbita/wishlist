@extends('layouts.app')

@section('content')

    <div class="card-header">Dashboard</div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        You are logged in!
        <br>
        <br>
        <strong><a href="{{ url('/search/create') }}">Search </a></strong> our web site to save appliances into your wish list
    </div>
@endsection
