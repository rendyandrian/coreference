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
								<input type="text" name="sprint_name" id="sprint_name" placeholder="Masukkan Nama Sprin" class="form-control" value="{{$sprint->sprint_name}}" disabled>
								</td>
							</tr>
							<tr>
								<td>Nomor Surat <br><small>*wajib diisi</small></td>
								<input type="hidden" name="penomoran_surat_id" id="current_nomor_surat_id" value ="{{set_value('current_nomor_surat_id')}}">
								<td id="nomor_surat_sprint">
									<select class='selectpicker show-tick mediumForm' id='nomorSuratId' data-live-search='true' name='penomoran_surat_id' disabled>
										<option value="{{$sprint->penomoran_surat_id}}">{{$sprint->nomor_surat_prefix.$sprint->nomor_surat.$sprint->nomor_surat_suffix}}</option>
									</select>
								</td>
							</tr>
							<tr>
								<td>Tanggal Mulai</td>
								<td class="form-inline">
									<input class=" input-append date form-control" name="tanggal_start" type="text" value="{{$sprint->tanggal_start}}" readonly> &nbsp s/d &nbsp 
									<input class=" input-append date form-control" name="tanggal_end" type="text" value="{{$sprint->tanggal_end}}" readonly>
									
								</td>
							</tr>
							<tr>
								<td>Lokasi</td>
								<td>
								<input type="text" name="lokasi" id="lokasi" placeholder="Masukkan Lokasi Sprin" class="form-control" value="{{$sprint->lokasi}}" disabled>
								</td>
							</tr>
							
							<tr >
								<td style="width:200px;">Peserta</td>
								<td>
									<div class="form-inline">
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
															<input type='text' class='nama{{$key+1}} form-control removediv' value="{{$namaPersonel}}" id='' min='0' readonly style='width:500px;'>	
															<input type="text" class="nrp{{$key+1}} form-control" value="{{$nrp}}" name="additional[peserta][]" id="" placeholder='Masukkan NRP Anda' min='0' hidden>	
														</div>
													</td>
												</tr>
											@endforeach
										</div>
									</div>
								</td>
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
