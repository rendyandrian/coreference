@extends('layouts/master')

@section('content')

<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Edit Penomoran Surat</h1>
	</div>
	@if(isset($alertStatus))
	<div class="card mb-3 border-bottom-danger alert-box">
	  <div class="card-body">
		{{$alertMessage}}
	  </div>
	</div>
	@endif
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list fa-sm"></i> Data Ubah Penomoran Surat</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive" id="changeType">					
				@php
				echo form_open('penomoranSurat/'.$penomoranSurat->penomoran_surat_id.'/edit', array('class' => 'form', 'id' => 'add'));
				@endphp
				
					<table class="table mp-0">
						<tr>
							<td class="w-200">Nomor Surat</td>
							<td>
								<div class="form-inline">
									<div class="form-group mb-1" >
									<input type="text" name="nomor_surat_prefix" value="{{$penomoranSurat->nomor_surat_prefix}}" class="form-control" style="width: 100%; align:center;" required>  
									</div>
									<div class="form-group" style="width: 30px; ">
										<h3 style="text-align:center;  width:100%;"> / </h3>
									</div>
									
									<div class="form-group " style="width: 70px;">
										<input type="text" readonly  name="nomor_surat" value="{{$penomoranSurat->nomor_surat}}" maxlength="3" class="form-control" style="width: 100%;"> 
									</div>
									<div class="form-group" style="width: 30px; ">
										<h3 style="text-align:center;  width:100%;"> / </h3>
									</div>
									<div class="form-group mb-1">
										<input type="text" name="nomor_surat_suffix" value="{{$penomoranSurat->nomor_surat_suffix}}" class="form-control" style="width: 100%; align:center;" required> 
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>Jenis Surat</td>
							<td>
								<select class="form-control" id="jenis_surat_id" required name="jenis_surat_id" onchange="valueJenisSurat()">
									<option value="">Silahkan Pilih</option>
									@foreach ($jenisSurats as $jenisSurat)
									<option value="{{$jenisSurat->jenis_surat_id}}" @if ($jenisSurat->jenis_surat_id==$penomoranSurat->jenis_surat_id){{ print_r("selected ")}} @endif>{{$jenisSurat->jenis_surat_name}}</option>
									@endforeach
								</select>
							</td>
						</tr>
						<tr>
							<td>Tanggal Surat</td>
							<td>
								<div class="form-inline">
									<input type="date" id="datefield" min="2019-12-01" readonly value="{{$penomoranSurat->tgl_surat}}" name="tgl_surat" class="form-control" required>
									<div class="toast toast-custom" id="toastDate" data-autohide="true" data-delay="1000" data-animation="true">
										<div class="toast-body toast-body-custom">
											<strong id="changeColorKouta" class="mr-auto "> Kouta Pembuatan Surat Tinggal <b id="countKouta"></b> </strong>
										</div>
									</div>
								</div>
							</td>
						</tr>
						<tr>
							<td>Kepada</td>
							<td>
								<input type="text" name="kepada" class="form-control" value="{{$penomoranSurat->kepada}}" required>
							</td>
						</tr>
						<tr>
							<td>Perihal</td>
							<td>
								<input type="text" name="perihal" class="form-control" value="{{$penomoranSurat->perihal}}" required>
							</td>
						</tr>
						</table>
						<table class="table field_tembusan mp-0">
						@php
							$key=0;	
						@endphp
						@foreach ($tembusans as $tembusan)
							@if ($key==0)
							<tr>
								<td style="width:200px;">Tembusan</td>
								<td>
									<div class="form-inline">
									<input type="text" id="tembusan" name="tembusan[]" value="{{$tembusan->tembusan_name}}"class="form-control" required placeholder="Masukkan Nama">
										<a href="javascript:void(0);" id="tembusanbtn" class="add_tembusan d-none d-sm-inline-block btn btn-sm btn-success shadow-sm ml-10">
											<i class="fas fa-plus fa-sm text-white-50" ></i> </i>
										</a>
									</div>
								</td>
							</tr>
							@else
							<tr class="removediv">
								<td>Tembusan</td>
								<td>	
									<div class="form-inline">
									<input type="text" id="tembusan" class="tembusan{{$key}} form-control" required="" value="{{$tembusan->tembusan_name}}" name="tembusan[]" placeholder="Masukkan Nama" min="0">
									<a href="javascript:void(0);" id="removebtn" class="remove_button d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm ml-10">
										<i class="fas fa-times fa-sm text-white-50"></i>
									</a>
									</div>
								</td>
							</tr>
							@endif
							@php
								$key++;
							@endphp
						@endforeach
						</table>
						<table class="table field_wrapper mp-0">
						<tr >
							<td class="w-200">Peserta</td>
							<td>
								<div class="form-inline">
									<input type="number" value=""  class="nrp0 form-control"  name="" id="nrp" placeholder="Masukkan NRP Anda" min='0' >
									<a href="javascript:void(0);" onclick="getPersonelByNRP()" id="loading" class="add_button d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="margin:0px 10px;">
										<i class="fas fa-check fa-sm text-white-50"></i> Cek Data NRP</i>
									</a>
									<div id="toastCekNrp" class="toast toast-custom" data-autohide="true" data-delay="4000" data-animation="true">
										<div class="toast-body toast-body-custom">
											<strong class="mr-auto text-danger"><i class="fas fa-times" ></i> Gagal</strong> Data <b>NRP</b> tidak ditemukan
										</div>
									</div>
								</div>
							</td>
						</tr>
						@php
							$key=0;	
						@endphp
						@foreach ($lampiranPesertas as $lampiranPeserta)
							<tr class="removediv">
								<td>Peserta </td>
								<td>
									<div class="form-inline">
										<input type="text" class="nama{{$key+1}} form-control" name="nama[]" id="peserta" value="{{$lampiranPeserta->name}}" placeholder="Masukkan NRP Anda" min="0" readonly="" style="width:500px;">
										<input type="text" class="nrp{{$key+1}} form-control" name="peserta[]" id="pesertaHidden" hidden value="{{$lampiranPeserta->nrp}}/{{$lampiranPeserta->pangkat}}/{{$lampiranPeserta->name}}/{{$lampiranPeserta->kode_satuan}}/{{$lampiranPeserta->jabatan_struktur}}" placeholder="Masukkan NRP Anda" min="0">
										<input type="text" class="panitia{{$key+1}} form-control ml-10" name="panitia[]"  value="{{$lampiranPeserta->jabatan_kepanitiaan}}" id="panitia" placeholder="Masukkan Panitia">
										<a href="javascript:void(0);"  id="removePeserta" class="remove_peserta d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm ml-10">
											<i class="fas fa-times fa-sm text-white-50"></i>
										</a>
									</div>
								</td>
							</tr>
							@php
							$key++;
							@endphp
						@endforeach
						</table >
						<table class="table">
						<tr>
							<td></td>
							<td id="btnSave"><button  class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm btn-save-custom"><i class="fas fa-save fa-sm text-white-50"></i> Simpan Data</i></button></td>
						</tr>
					</table>
				@php
				// echo form_submit('', 'Add');
				
				// echo form_input(array('type' => 'text', 'name' => 'username'));
				echo form_close();
				@endphp		
			</div>
		</div>
	</div>

</div>
@endsection