@extends('layouts.app')

@section('title', 'Star Wars Planets')

@section('content')
    <div
        id="app"
        data-planets='@json($planets)'
    ></div>

    <div class="pagination-wrapper">
        {{ $planets->links('vendor.pagination.starwars') }}
    </div>

    @include('partials.footer')
@endsection
