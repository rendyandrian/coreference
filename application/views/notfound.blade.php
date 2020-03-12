@extends('layouts/master')

@section('content')
	<div class="container-fluid">

      <!-- 404 Error Text -->
      <div class="text-center">
        <div class="error mx-auto" data-text="404">404</div>
        <p class="lead text-gray-800 mb-5">Page Not Found</p>
        <p class="text-gray-500 mb-0">{{$message}}</p>
        <a href="{{$redirectUrl}}">← Back</a>
      </div>

    </div>
@endsection