@extends('layouts/master')

@section('content')

	<div class="container-fluid" >
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Tambah Ruang Rapat</h1>
		</div>
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list fa-sm"></i> Data Tambah Ruang Rapat</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					{{-- {{$group[0]['group_id']}} --}}
					@php
					
					echo form_open('ruangRapat', array('class' => 'form', 'id' => 'add'));
					@endphp
						<input type="hidden" value="0" name="ruang_rapat_id" id="ruang_rapat_id" readonly class="form-control">
						<table class="table">
							<tr>
								<td>Ruang Rapat</td>
								<td>
									<input type="text" value="" name="ruang_rapat_name" id="jenis_surat" placeholder="Masukkan Ruang Rapat" class="form-control" required>
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