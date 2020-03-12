@extends('layouts/master')

@section('content')
	<div class="container-fluid" >
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Edit Jadwal Sprin</h1>
		</div>
		@if(isset($alertStatus))
		<div class="card mb-3 @if($alertStatus) border-bottom-success @else border-bottom-danger @endif alert-box">
			<div class="card-body">
			@php
			    print_r($alertMessage);
			@endphp
			</div>
		</div>
		@endif
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list fa-sm"></i> Data Jadwal Sprin</h6>
			</div>
			<div class="form_error" style="padding:10px;color:red;">
					@php
					    echo validation_errors();
					@endphp
			</div>
			<div class="card-body">
				<div class="table-responsive" style="overflow-x:hidden;">
					@php
					echo form_open('sprint/'.$sprint->sprint_id.'/edit', array('class' => 'form', 'id' => 'add'));
					@endphp
						<table class="table">
							<tr>
								<td>Sprin</td>
								<td>
								<input type="text" name="sprint_name" id="sprint_name" placeholder="Masukkan Nama Sprin" class="form-control" value="{{$sprint->sprint_name}}" required>
								</td>
							</tr>
							<tr>
								<td>Nomor Surat <br><small>*wajib diisi</small></td>
								<input type="hidden" name="penomoran_surat_id" id="current_nomor_surat_id" value ="{{set_value('current_nomor_surat_id')}}">
								<input type="hidden" name="page_accessed" value ="{{$page}}">
								<td id="nomor_surat_sprint">
									<select class='selectpicker show-tick mediumForm' id='nomorSuratId' data-live-search='true' name='penomoran_surat_id' required>
										<option value="{{$sprint->penomoran_surat_id}}">{{$sprint->nomor_surat_prefix.$sprint->nomor_surat.$sprint->nomor_surat_suffix}}</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Tanggal Mulai</td>
								<td class="form-inline">
									<input class=" input-append date form_datetime form-control" name="tanggal_start" type="text" value="{{$sprint->tanggal_start}}" readonly> &nbsp s/d &nbsp 
									<input class=" input-append date form_datetime form-control" name="tanggal_end" type="text" value="{{$sprint->tanggal_end}}" readonly>
									<input class=" input-append date form_datetime form-control" name="tanggal_start_old" type="hidden" value="{{$sprint->tanggal_start}}" readonly>  
									<input class=" input-append date form_datetime form-control" name="tanggal_end_old" type="hidden" value="{{$sprint->tanggal_end}}" readonly>
									
								</td>
							</tr>
							<tr>
								<td>Lokasi</td>
								<td>
								<input type="text" name="lokasi" id="lokasi" placeholder="Masukkan Lokasi Sprin" class="form-control" value="{{$sprint->lokasi}}" required>
								<input type="hidden" name="double_sprint" id="lokasi" placeholder="Masukkan Lokasi Sprint" class="form-control" value="{{$sprint->double_sprint}}" required>
							</td>
							</tr>
							
							<tr >
								<td style="width:200px;">Peserta</td>
								<td>
									<div class="form-inline">
										<input type="number" value=""  class="nrp0 form-control" name="" id="nrp-peserta" placeholder="Masukkan NRP Peserta Rapat" min='0' >
										{{-- <a href=""  class=" d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" style="margin-left:10px;">
											<i class="fas fa-plus fa-sm text-white-50"></i> </i>
										</a> --}}
										<a href="javascript:void(0);" onclick="addPeserta('',{{$sprint->penomoran_surat_id}})" id="loading-peserta" class="add_button d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="margin:0px 10px;">
											<i class="fas fa-check fa-sm text-white-50"></i> Cek Data NRP</i>
										</a>

										<div class="toast" id="toast-nrp-peserta" data-autohide="true" data-delay="4000" data-animation="true" style="position:relative; padding:0px; margin:0px;">
											<div class="toast-body" style="padding:7px 10px; margin:0px;">
												<strong class="mr-auto text-danger"><i class="fas fa-times" ></i> Gagal</strong> Data <b>NRP</b> tidak ditemukan
											</div>
										</div>
										<div class="field_wrapper_peserta">
												@php
												!isset($peserta) ? $peserta = [] : "";
												@endphp
												@foreach ($peserta as $key => $item)
												@php
													$namaPersonel = $item['pangkat'].$item['name'];	
													$nrp = $item['nrp'];	
													$lampiranPesertaId = $item['lampiran_peserta_id'];	
												@endphp
												<tr>
													<td></td>
													<td>	
														<div class="form-inline">
															<input type='text' class='nama{{$key+1}} form-control removediv' value="{{$namaPersonel}}" min='0' readonly style='width:500px;'>	
															<input type="text" class="nrp{{$key+1}} form-control" value="{{$nrp}}" name="additional[peserta][]" min='0' hidden>
															<a href="javascript:void(0);" onclick="deletePeserta({{$lampiranPesertaId}})" class="remove_button d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" style="margin-left:10px;"><i class="fas fa-times fa-sm text-white-50"></i> </a>	
														</div>
													</td>
												</tr>
											@endforeach
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td></td>
								<td><button  class=" d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" style="margin:0px 10px; float:right;"><i class="fas fa-save fa-sm text-white-50"></i> Simpan Data</i></button></td>
							</tr>
						</table>
					@php
					echo form_close();
					@endphp		
				</div>
			</div>
		</div>
	</div>
@endsection
