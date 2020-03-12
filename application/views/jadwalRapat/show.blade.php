@extends('layouts/master')

@section('content')
	<div class="container-fluid" >
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Tambah Jadwal Rapat</h1>
		</div>
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list fa-sm"></i> Data Tambah Jadwal Rapat</h6>
			</div>
			<div class="form_error" style="padding:10px;color:red;">
			</div>
			<div class="card-body">
				<div class="table-responsive" style="overflow-x:hidden;">
						<table class="table">
							<tr>
								<td>Ruang Rapat <br><small>*wajib diisi</small></td>
								<td>
								<input type="tes" class="form-control" name="current_id_ruang_rapat" id="current_ruang_rapat_id" value ="{{$jadwalRapat->ruang_rapat_name}}" readonly>
								</td>
							</tr>
							<tr>
								<td>Tanggal Mulai</td>
								<td class="form-inline">
									<input class="form-control" name="tanggal_start" type="text" value="{{$jadwalRapat->tanggal_start}}" readonly> &nbsp s/d &nbsp 
									<input class="form-control" name="tanggal_end" type="text" value="{{$jadwalRapat->tanggal_end}}" readonly>
									
								</td>
							</tr>
							<tr>
								<td>Materi</td>
								<td>
								<input type="text" name="materi" id="jenis_surat" placeholder="Masukkan Materi" class="form-control" value="{{$jadwalRapat->materi}}" readonly>
								</td>
							</tr>
							<tr>
								<td>NRP Pimpinan</td>
								<td>
									<div class="form-inline">
										<input type="text" value="{{$jadwalRapat->nrp_pimpinan}}" id="nrp" class="form-control" readonly>
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
									<input type="text" value="{{$jadwalRapat->jabatan_kepanitiaan_pimpinan}}" name="jabatan_kepanitiaan_pimpinan" id="jenis_surat" placeholder="" class="form-control" readonly>
								</td>
							</tr>
							<tr>
								<td>Waktu memimpin</td>
								<td class="form-inline">
									<input class="form-control" name="waktu_memimpin_start" type="text" value="{{$jadwalRapat->waktu_memimpin_start}}" readonly> &nbsp s/d &nbsp 
									<input class="form-control" name="waktu_memimpin_end" type="text" value="{{$jadwalRapat->waktu_memimpin_end}}" readonly>
								</td>
							</tr>
							<tr >
								<td style="width:200px;">Pejabat</td>
								<td>
									<div class="form-inline">
										@foreach ($pejabat as $key => $item)
											@php
												$dataPersonelExp = explode('/',$item);
												$pejabatId = $dataPersonelExp[0];	
												$namaPersonel = $dataPersonelExp[2];	
											@endphp
											<tr>
												<td></td>
												<td>	
													<div class="form-inline">
														{{$key+1}}.&nbsp;
														<input type='text' class='nama{{$key+1}} form-control removediv' value="{{$namaPersonel}}" id='' min='0' readonly style='width:500px;'>
													</div>
												</td>
											</tr>
										@endforeach
									</div>
								</td>
							</tr>
							<tr >
								<td style="width:200px;">Peserta</td>
								<td>
									<div class="form-inline">
										@foreach ($peserta as $key => $item)
										@php
											$dataPersonelExp = explode('/',$item);
											$lampiranPesertaId = $dataPersonelExp[0];	
											$namaPersonel = $dataPersonelExp[2];	
										@endphp
										<tr>
											<td></td>
											<td>	
												<div class="form-inline">
													{{$key+1}}.&nbsp;
													<input type='text' class='nama{{$key+1}} form-control removediv' value="{{$namaPersonel}}" id='' min='0' readonly style='width:500px;'>	
												</div>
											</td>
										</tr>
									@endforeach
									</div>
								</td>
							</tr>
						</table>		
				</div>
			</div>
		</div>
	</div>
@endsection
