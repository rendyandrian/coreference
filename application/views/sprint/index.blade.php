@extends('layouts/master')

@section('content')
	<div class="container-fluid">
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Sprin</h1>
			<a href="{{ base_url('sprint/add') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data Sprin</i></a>
		</div>
	@if(isset($alertStatus))
    <div class="card mb-3 @if($alertStatus) border-bottom-success @else border-bottom-danger @endif alert-box">
      <div class="card-body">
        @php
		echo $alertMessage;
	  @endphp
      </div>
    </div>
    @endif
		<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list fa-sm"></i> Data Ruang Rapat</h6>
		</div>
		<div class="card-body">
		<div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Sprin</th>
                      <th>Nomor Surat</th>
                      <th>Waktu Sprin</th>
                      <th>Lokasi</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
						
					@php
						$no=0;
					@endphp
					@foreach ($sprints as $sprint) 
						@php
						    $nomorSurat = $sprint->nomor_surat_prefix.'/'.$sprint->nomor_surat.'/'.$sprint->nomor_surat_suffix;
						@endphp
						<tr>
							@php
							    $pageAccessed = isset($_GET['status']) ? $_GET['status'] :"";
							@endphp
							<td>{{$no+1}}</td>
							<td>{{$sprint->sprint_name}}</td>
							<td>{{$nomorSurat}}</td>
							<td>{{$sprint->tanggal_start}} @if ($sprint->tanggal_start)
								s/d
							@endif {{$sprint->tanggal_end}}</td>
							<td>{{$sprint->lokasi}}</td>
							<td>
							<a href="{{ base_url("/sprint")."/".$sprint->sprint_id}}"><button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i> Detail</button></a>
							<a href="{{ base_url("/sprint")."/".$sprint->sprint_id."/edit?status="}}{{$page}}"><button class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i> Edit</button></a>
							<button class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="confirmDeactivate('{{ base_url('/sprint/deactivate/').$sprint->sprint_id.'?status='.$pageAccessed}}')"><i class="fas fa-trash fa-sm text-white-50"></i> Hapus</button>
							</td> 
						</tr>
						@php
							$no++;
						@endphp
					@endforeach
                  </tbody>
                </table>
              </div>
		</div>
		</div>
	</div>
@endsection