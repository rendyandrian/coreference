@extends('layouts/master')

@section('content')
	<div class="container">
		<h2>{{ $data->name }}</h2>
		<img src="{{ $data->photo }}" alt="..." width="100px" height="100px">
		<h4>{{ $data->desc }}</h4>
	</div>
@endsection