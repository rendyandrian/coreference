@extends('layouts/master')

@section('content')
	<div class="container-fluid">
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Ruang Rapat</h1>
			<a href="{{ base_url('jadwalRapat/add') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data Jadwal Rapat</i></a>
		</div>
	@if(isset($alertStatus))
    <div class="card mb-3 @if($alertStatus) border-bottom-success @else border-bottom-danger @endif alert-box">
      <div class="card-body">
        {{$alertMessage}}
      </div>
    </div>
    @endif
		<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list fa-sm"></i> Data Ruang Rapat</h6>
		</div>
		<div class="card-body">
		<div>

<table class="table">
			<tr>
				<form action="" method="get">
				<td>Waktu mulai</td>
				<td>
					
					<input type='text' class="input-append date form_datetime form-control" name="tanggal_start"  value="@if(isset($dataFilter['tanggal_start'])){{$dataFilter['tanggal_start']}}@endif"  style='width:180px;' readonly>	
				</td>
				<td>Waktu Selesai</td>
				<td>
					<input type='text' class="input-append date form_datetime form-control" name="tanggal_end"  value="@if(isset($dataFilter['tanggal_end'])){{$dataFilter['tanggal_end']}}@endif"  style='width:180px;' readonly>	
				</td>
				<td>NRP Pimpinan</td>
				<td>
					<input type='text' name="nrp_pimpinan" class="form-control" value="@if(isset($dataFilter['tanggal_end'])){{$dataFilter['nrp_pimpinan']}}@endif" style='width:100px;'>
				</td>
				<td>Ruang Rapat</td>
				<td>
					@php
					    if(isset($dataFilter['ruang_rapat_id'])){
						    $curRuangRapatId = $dataFilter['ruang_rapat_id'];
					    }
					@endphp
					<select name="ruang_rapat_id" id="ruang_rapat_filter"  class="form-control" style ="padding:3px;">
						<option value="">Semua Ruang Rapat</option>
						@foreach ($ruangRapat as $item)
							<option value="{{$item->ruang_rapat_id}}" @if ($item->ruang_rapat_id == $curRuangRapatId)
							    selected
							@endif>{{$item->ruang_rapat_name}}</option>
						@endforeach
					</select>
				</td>
				<td>
					<button class="btn btn-primary shadow-sm">Filter</button>
				</td>
				</form>
			</tr>
			</table>

		</div><br>
		<div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Ruang Rapat</th>
                      <th>Nomor Surat</th>
                      <th>Waktu Rapat</th>
                      <th>Pimpinan</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
						
					@php
						$no=0;
					@endphp
					@foreach ($jadwalRapats as $jadwalRapat) 
						@php
						    $nomorSurat = $jadwalRapat->nomor_surat_prefix.$jadwalRapat->nomor_surat.$jadwalRapat->nomor_surat_suffix;
						@endphp
						<tr>
							<td>{{$no+1}}</td>
							<td>{{$jadwalRapat->ruang_rapat_name}}</td>
							<td>{{$nomorSurat}}</td>
							<td>{{$jadwalRapat->tanggal_start}} s/d {{$jadwalRapat->tanggal_end}}</td>
							<td>{{$jadwalRapat->nama_pimpinan}}</td>
							<td style="width:200px;">
								<div>
									<a href="{{ base_url("/jadwalRapat")."/".$jadwalRapat->jadwal_rapat_id}}"><button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i> Detail</button></a>
									{{-- check jika user login sama dengan pembuatnya --}}
									@if($userLoginId==$jadwalRapat->created_by)
									<a href="{{ base_url("/jadwalRapat")."/".$jadwalRapat->jadwal_rapat_id."/edit"}}"><button class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i> Edit Data</button></a>
									@endif
								</div>
								<div>
									@if($userLoginId==$jadwalRapat->created_by)
									<button class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="confirmDeactivate('{{base_url('jadwalRapat/deactivate/'.$jadwalRapat->jadwal_rapat_id)}}')"><i class="fas fa-trash fa-sm text-white-50"></i> Hapus</button>
									<a href="{{ base_url("/penomoranSurat/add")."?id=".$jadwalRapat->jadwal_rapat_id}}"><button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Buat Nomor</button></a>
									@endif
								</div>
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