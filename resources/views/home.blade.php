@extends('layouts.app')

@section('content')
    <App></App>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <form class="hidden" id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
@endsection
