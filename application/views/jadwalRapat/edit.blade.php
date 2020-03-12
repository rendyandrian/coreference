@extends('layouts/master')

@section('content')
	<div class="container-fluid" >
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Tambah Jadwal Rapat</h1>
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
				<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list fa-sm"></i> Data Tambah Jadwal Rapat</h6>
			</div>
			<div class="form_error" style="padding:10px;color:red;">
					@php
					    echo validation_errors();
					@endphp
			</div>
			<div class="card-body">
				<div class="table-responsive" style="overflow-x:hidden;">
					@php
					echo form_open('jadwalRapat/'.$jadwalRapat->jadwal_rapat_id.'/edit', array('class' => 'form', 'id' => 'add'));
					@endphp
						<table class="table">
							<tr>
								<td>Ruang Rapat <br><small>*wajib diisi</small></td>
								<input type="hidden" name="current_id_ruang_rapat" id="current_ruang_rapat_id" value ="{{$jadwalRapat->ruang_rapat_id}}">
								<td id="ruang_rapat_select">
									
								</td>
							</tr>
							<tr>
								<td>Tanggal Mulai</td>
								<td class="form-inline">
									<input class=" input-append date form_datetime form-control" name="tanggal_start" type="text" value="{{$jadwalRapat->tanggal_start}}" readonly> &nbsp s/d &nbsp 
									<input class=" input-append date form_datetime form-control" name="tanggal_end" type="text" value="{{$jadwalRapat->tanggal_end}}" readonly>
									
								</td>
							</tr>
							<tr>
								<td>Materi</td>
								<td>
								<input type="text" name="materi" id="jenis_surat" placeholder="Masukkan Materi" class="form-control" value="{{$jadwalRapat->materi}}" required>
								</td>
							</tr>
							<tr>
								<td>NRP Pimpinan</td>
								<td>
									<div class="form-inline">
										<input type="text" value="{{$jadwalRapat->nrp_pimpinan}}" id="nrp" placeholder="Masukkan NRP" class="form-control">

										<input type="hidden" value="{{$jadwalRapat->nrp_pimpinan}}" name="nrp_pimpinan" id="nrp-pimpinan" placeholder="Masukkan NRP" class="form-control" required>
										<div id="button-cek-nrp-pimpinan">
											<a href="javascript:void(0);" onclick="fillDataPimpinanRapat()" id="loading-pimpinan" class="add_button d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="margin:0px 10px;">
												<i class="fas fa-check fa-sm text-white-50"></i> Cek Data NRP</i>
											</a>
										</div>
										<div id="button-edit-nrp-pimpinan">
											<a href="javascript:void(0);" id="edit-pimpinan-rapat" class="d-none d-sm-inline-block btn-sm btn-primary shadow-sm" style="margin:0px 10px;">
												<i class="fas fa-check fa-sm text-white-50"></i> Edit</i>
											</a>
										</div>
										<div class="toast" id="toast-nrp-pimpinan" data-autohide="true" data-delay="4000" data-animation="true" style="position:relative; padding:0px; margin:0px;">
											<div class="toast-body" style="padding:7px 10px; margin:0px;">
												<strong class="mr-auto text-danger"><i class="fas fa-times" ></i> Gagal</strong> Data <b>NRP</b> tidak ditemukan
											</div>
										</div>
									</div>	
								</td>
							</tr>
							<tr>
								<td>Nama Pimpinan</td>
								<td>
									<input type="text" value="{{$jadwalRapat->nama_pimpinan}}" name="nama_pimpinan" id="nama_pimpinan" placeholder="" class="form-control" readonly required>
								</td>
							</tr>
							<tr style = "display:none;">
								<td>Pangkat Pimpinan</td>
								<td>
									<input type="text" value="{{$jadwalRapat->pangkat_pimpinan}}" name="pangkat_pimpinan" id="pangkat_pimpinan" placeholder="" class="form-control" readonly required>
								</td>
							</tr>
							<tr>
								<td>Jabatan Struktur Pimpinan</td>
								<td>
									<input type="text" value="{{$jadwalRapat->jabatan_struktur_pimpinan}}" name="jabatan_struktur_pimpinan" id="jabatan_struktur_pimpinan" placeholder="" class="form-control" readonly required>
								</td>
							</tr>
							<tr>
								<td>Jabatan Kepanitiaan Pimpinan</td>
								<td>
									<input type="text" value="{{$jadwalRapat->jabatan_kepanitiaan_pimpinan}}" name="jabatan_kepanitiaan_pimpinan" id="jenis_surat" placeholder="" class="form-control" required>
								</td>
							</tr>
							<tr>
								<td>Waktu memimpin</td>
								<td class="form-inline">
									<input class=" input-append date form_datetime form-control" name="waktu_memimpin_start" type="text" value="{{$jadwalRapat->waktu_memimpin_start}}" readonly> &nbsp s/d &nbsp 
									<input class=" input-append date form_datetime form-control" name="waktu_memimpin_end" type="text" value="{{$jadwalRapat->waktu_memimpin_end}}" readonly>
								</td>
							</tr>
							<tr >
								<td style="width:200px;">Pejabat</td>
								<td>
									<div class="form-inline">
										<input type="number" value=""  class="nrp0 form-control" name="" id="nrp-pejabat" placeholder="Masukkan NRP Pejabat" min='0' >
										{{-- <a href=""  class=" d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" style="margin-left:10px;">
											<i class="fas fa-plus fa-sm text-white-50"></i> </i>
										</a> --}}
										<a href="javascript:void(0);" onclick="addPejabat({{$jadwalRapat->jadwal_rapat_id}})" id="loading-pejabat" class="add_button d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="margin:0px 10px;">
											<i class="fas fa-check fa-sm text-white-50"></i> Cek Data NRP</i>
										</a>

										<div class="toast" id="toast-nrp-pejabat" data-autohide="true" data-delay="4000" data-animation="true" style="position:relative; padding:0px; margin:0px;">
											<div class="toast-body" style="padding:7px 10px; margin:0px;">
												<strong class="mr-auto text-danger"><i class="fas fa-times" ></i> Gagal</strong> Data <b>NRP</b> tidak ditemukan
											</div>
										</div>
										<div class="field_wrapper_pejabat">
											@foreach ($pejabat as $key => $item)
												@php
													$dataPersonelExp = explode('/',$item);
													$pejabatId = $dataPersonelExp[0];	
													$namaPersonel = $dataPersonelExp[4].' '.$dataPersonelExp[2];	
												@endphp
												<tr>
													<td></td>
													<td>	
														<div class="form-inline">
															<input type='text' class='nama{{$key+1}} form-control removediv' value="{{$namaPersonel}}" id='' min='0' readonly style='width:500px;'>	
															<input type="text" class="nrp{{$key+1}} form-control" value="{{$item}}" name="additional[pejabat][]" id="" placeholder='Masukkan NRP Anda' min='0' hidden>
															<a href="javascript:void(0);" onclick="deletePejabat({{$pejabatId}})" class="remove_button d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" style="margin-left:10px;"><i class="fas fa-times fa-sm text-white-50"></i> </a>			
														</div>
													</td>
												</tr>
											@endforeach
										</div>
									</div>
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
										<a href="javascript:void(0);" onclick="addPeserta({{$jadwalRapat->jadwal_rapat_id}})" id="loading-peserta" class="add_button d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="margin:0px 10px;">
											<i class="fas fa-check fa-sm text-white-50"></i> Cek Data NRP</i>
										</a>

										<div class="toast" id="toast-nrp-peserta" data-autohide="true" data-delay="4000" data-animation="true" style="position:relative; padding:0px; margin:0px;">
											<div class="toast-body" style="padding:7px 10px; margin:0px;">
												<strong class="mr-auto text-danger"><i class="fas fa-times" ></i> Gagal</strong> Data <b>NRP</b> tidak ditemukan
											</div>
										</div>
										<div class="field_wrapper_peserta">
												@foreach ($peserta as $key => $item)
												@php
													$dataPersonelExp = explode('/',$item);
													$lampiranPesertaId = $dataPersonelExp[0];	
													$namaPersonel =  $dataPersonelExp[4].' '.$dataPersonelExp[2]	
												@endphp
												<tr>
													<td></td>
													<td>	
														<div class="form-inline">
															<input type='text' class='nama{{$key+1}} form-control removediv' value="{{$namaPersonel}}" id='' min='0' readonly style='width:500px;'>	
															<input type="text" class="nrp{{$key+1}} form-control" value="{{$item}}" name="additional[peserta][]" id="" placeholder='Masukkan NRP Anda' min='0' hidden>
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
