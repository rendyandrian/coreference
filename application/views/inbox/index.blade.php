@extends('layouts/master')

@section('content')
	<div class="container-fluid">
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Coreference Resolution</h1>
    </div>
    <div class="row">
      <div class="col-md-6">
        <table>
          <tr>
            <td><h6 style="float:left; padding-right:10px; padding-top:10px;">Surat </h6></td>
            <td>
              <select class="form-control" id="ayat" style="float:left; margin-right:10px;" onchange="ayat()">
                <option>Silahkan Pilih</option>
                @for ($i = 1; $i < 115; $i++)
                <option value="{{$i}}">{{$i}}</option>
                @endfor
              </select>  
            </td>
          </tr>
        </table>          
          {{-- <button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" style="margin-top:3px;" onclick="ayat()"><i class="fas fa-search fa-sm text-white-50"></i> Cari</i></button> --}}
        </p>
      </div>
      <div class="col-md-6">
        {{-- <p> --}}
          <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" style="float:right;"><i class="fas fa-file-excel fa-sm text-white-50"></i> Export Data</i></a>
        {{-- </p> --}}
      </div>
    </div>
    <div class="row">
      <div class="card mb-12 border-bottom-success alert-box" style=" width:100%; margin-top:10px;">
        <div class="card-body" style="width:100%;">
          <div id="showArab" style="width: 100%; direction: rtl;">
              <center><h6 style="color:red; font-weight:bold;">Silahkan Pilih Surat Terlebih Dahulu</h6></center>
          </div>
        </div>
      </div>
    </div>
  </div>
  
@endsection