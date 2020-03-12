@extends('layouts/master')

@section('content')

	<div class="container-fluid" >
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Tambah User</h1>
		</div>
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list fa-sm"></i> Data Tambah User</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">
						{{-- {{$group[0]['group_id']}} --}}
					@php
					
					echo form_open('user', array('class' => 'form', 'id' => 'add'));
					@endphp
						<input type="hidden" value="0" name="personel_id" id="personel_id" placeholder="Masukkan Nama" readonly class="form-control">
						<table class="table">
							<tr>
								<td style="width:200px;">NRP</td>
								<td>
									<div class="form-inline" style="width:100%;">
										<input type="number" value=""  class="form-control" name="nrp" id="nrp" placeholder="Masukkan NRP Anda" min='0' required>
										<a href="#" onclick="getPersonelByNRPForAddUser()" id="loading" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" style="margin:0px 10px;"><i class="fas fa-check fa-sm text-white-50"></i> Cek Data NRP</i></a>

										<div class="toast" data-autohide="true" data-delay="4000" data-animation="true" style="position:relative; padding:0px; margin:0px;">
											<div class="toast-body" style="padding:7px 10px; margin:0px;">
												<strong class="mr-auto text-danger"><i class="fas fa-times" ></i> Gagal</strong> Data <b>NRP</b> tidak ditemukan
											</div>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td>Nama</td>
								<td>
									<input type="text" value="" name="name" id="name" placeholder="Masukkan Nama" class="form-control"  readonly>
								</td>
							</tr>
							
							<tr>
								<td>Satuan</td>
								<td>
									<input type="text" value="" name="" id="satuan" placeholder="Masukkan Satuan" readonly class="form-control">
								</td>
							</tr>
							
							<tr>
								<td>Kode Satuan</td>
								<td>
									<input type="text" value="" name="kode_satuan" id="kode_satuan" placeholder="Masukkan Kode satuan" readonly class="form-control">
								</td>
							</tr>
							
							<tr>
								<td>Group</td>
								<td>
									<select class="form-control" name="group_id" id="user-groups"> 
										@foreach ($groups as $group)
											<option value="{{$group->group_id}}">{{$group->group_name}}</option>
										@endforeach
									</select>
								</td>	
							</tr>
							
							<tr>
								<td>Username</td>
								<td>
									<input type="text" value="" name="username" id="username" placeholder="Masukkan Username" class="form-control" required>
								</td>	
							</tr>
							
							<tr>
								<td>Password</td>
								<td>
									<input type="password" value="" name="password" id="password" placeholder="Masukkan Password" class="form-control" required>
								</td>	
							</tr>
							
							<tr>
								<td></td>
								<td><button  class=" d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" style="margin:0px 10px; float:right;"><i class="fas fa-save fa-sm text-white-50"></i> Simpan Data</i></button></td>
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