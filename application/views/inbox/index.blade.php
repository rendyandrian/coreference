@extends('layouts/master')

@section('content')
	<div class="container-fluid">
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Coreference Resolution</h1>
    </div>
    <div class="row">
      <div class="col-md-6">
        <p>
          <h6 style="float:left; padding-right:10px;">Surat </h6>
          <select class="form-control" id="ayat" style="width: 100px; float:left; margin-right:10px;" >
            @for ($i = 1; $i < 115; $i++)
            <option value="{{$i}}">{{$i}}</option>
            @endfor
          </select>  
          <button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" onclick="ayat()"><i class="fas fa-search fa-sm text-white-50"></i> Cari</i></button>
        </p>
      </div>
      <div class="col-md-6">
        {{-- <p>
          <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-excel fa-sm text-white-50"></i> Export Data</i></a>
        </p> --}}
      </div>
    </div>
    <div class="row">
      <div class="card mb-12 border-bottom-success alert-box">
        <div class="card-body" >
          <div class="showArab" style="width: 100%;">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quibusdam veniam molestias odio! In pariatur ex perferendis beatae quisquam consectetur consequuntur cupiditate cumque quidem atque consequatur, exercitationem eos delectus aspernatur iure.
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection