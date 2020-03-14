@extends('layouts/master')
@section('content')
	<div class="container-fluid">
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">List Surat</h1>
			
			<a href="{{ base_url('penomoranSurat/add') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Penomoran Surat</i></a>
			
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
			<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list fa-sm"></i> Data Surat</h6>
		</div>
		<div class="card-header py-3">
			<div class="row">
				<div class="col-md-1">
					<div style="hight:5px;width:5px;background-color: #005aa0;padding:10px 30px;"></div>
				</div>
				<div class="col-md-3">
					: File scan sudah di upload
				</div>
			</div>
			<div class="row">
				<div class="col-md-1">
					<div style="hight:5px;width:5px;background-color:#ff0000;padding:10px 30px;"></div>
				</div>
				<div class="col-md-3">
					: File scan belum di upload
				</div>
			</div>
		</div>
		<div class="card-body">
		<div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nomor Surat</th>
                      <th>Tanggal Surat</th>
                      <th>Jenis Surat</th>
                      <th>File Scan Surat</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
					@php
						$no=1;
					@endphp
					@foreach ($penomoranSurats as $penomoranSurat)
						<tr @if ($penomoranSurat->status_file_scan == 'open') style="background-color:#ff0000; color:#fff;" @else  style="background-color: #005aa0; color:#fff;" @endif>
							<input type="hidden" id="penomoran-surat-{{$penomoranSurat->penomoran_surat_id}}" value="{{$penomoranSurat->penomoran_surat_id}}">
							<input type="hidden" id="nomor-surat-{{$penomoranSurat->penomoran_surat_id}}" value="{{$penomoranSurat->nomor_surat_lengkap}}">
							<input type="hidden" id="jenis-surat-{{$penomoranSurat->penomoran_surat_id}}" value="{{$penomoranSurat->jenis_surat_name}}">
							<td>{{$no}}</td>
							@php
							$nomorSurat=$penomoranSurat->nomor_surat;
							$invID = str_pad($nomorSurat, 3, '0', STR_PAD_LEFT);	
							@endphp
							<td>{{$penomoranSurat->nomor_surat_prefix}}/{{$invID}}/{{$penomoranSurat->nomor_surat_suffix}}</td>
							<td>{{$penomoranSurat->tgl_surat}}</td>
							<td>{{$penomoranSurat->jenis_surat_name}}</td>
							<td>
								@php
								    $jenisSurat = preg_replace('/\s+/', '_', strtolower($penomoranSurat->jenis_surat_name));
								    $fileUrl = base_url() . 'uploads/dokumen/'.$jenisSurat.'/surat/'.$penomoranSurat->file_scan_surat;
								    $filename = new SplFileInfo($penomoranSurat->file_scan_surat);
								    $baseImgUrl = base_url().'assets/img/';
								    $extensionFile = $filename->getExtension();
								    (strtolower($extensionFile) == 'pdf') ? $sourceIconUrl = $baseImgUrl.'pdf-icon.png':$sourceIconUrl = $baseImgUrl.'img-icon.png';
								@endphp
								@if ($penomoranSurat->status_file_scan == 'closed')
								<a href="{{$fileUrl}}" target="_blank">
									<img class="view-file" height="27px" width="22px" src="{{$sourceIconUrl}}" href="{{$fileUrl}}">
								</a> {{$penomoranSurat->file_scan_surat}}
								@else 
									Belum di upload
								@endif
							</td>
							<td>
								@if ($penomoranSurat->status_file_scan != 'closed')
									<button type="button" id="{{$penomoranSurat->penomoran_surat_id}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm button-upload-dokumen" data-toggle="modal" data-target="#uploadDokumen"><i class="fas fa-upload"></i> Upload</button>
								@else
									<button disabled type="button" id="{{$penomoranSurat->penomoran_surat_id}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm button-upload-dokumen" data-toggle="modal" data-target="#uploadDokumen"><i class="fas fa-upload"></i> Upload</button>
								@endif
								<a href="{{ base_url("")}}penomoranSurat/{{$penomoranSurat->penomoran_surat_id}}/edit"><button class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i> Edit</button></a>
								<button class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="confirmDelete('penomoranSurat', {{$penomoranSurat->penomoran_surat_id}})"><i class="fas fa-trash fa-sm text-white-50"></i> Hapus</button>
								
								@if($isSuperadmin && $penomoranSurat->status_file_scan != 'open')
								<a href="{{ base_url("")}}penomoranSurat/{{$penomoranSurat->penomoran_surat_id}}/reset">
									<button class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i class="fas fa-sync fa-sm text-white-50"></i> Reset</button>
								</a>
								@endif
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
	<!-- BAGIAN POPUP SWEET ALLERT -->
	<div class="modal fade" id="uploadDokumen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
		@php	
			echo form_open_multipart('penomoranSurat/uploadDokumen', array('class' => 'form', 'id' => 'uploadDokumen'));
		@endphp
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
		    <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLongTitle">Upload File Scan Surat</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		    </div>
		    <div class="modal-body">
			    <input type="hidden" id="penomoran_surat_id" name="penomoran_surat_id" value="">
			    <input type="hidden" id="jenis_surat" name="jenis_surat" value="">
			    <input type="hidden" id="nomor_surat_lengkap" name="nomor_surat_lengkap" value="">
			    <input class="form-control" type="file" name="file_scan_surat">
		    </div>
		    <div class="modal-footer">
			<button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" type="submit"><i class="fas fa-upload"></i> Upload</button>
		    </div>
		  </div>
		</div>
		@php
			echo form_close();
		@endphp
	</div>
@endsection

