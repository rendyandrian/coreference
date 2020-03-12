@extends('layouts/master')

@section('content')

	<div class="container-fluid" >
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Ubah User</h1>
		</div>
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list fa-sm"></i> Data Ubah User</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					@php			
					echo form_open('user/'.$user->user_id.'/edit', array('class' => 'form', 'id' => 'add'));
					@endphp
						<table class="table">
							<tr>
								<td style="width:200px;">NRP</td>
								<td>
									<div class="form-inline" style="width:100%;">
									<input type="text" value="{{$user->nrp}}"  class="form-control" name="" id="nrp" placeholder="Masukkan NRP Anda" required readonly>
									</div>
								</td>
							</tr>
							<tr>
								<td>Nama</td>
								<td>
									<input type="text" value="{{$user->name}}" name="" id="name" placeholder="Masukkan Nama" readonly class="form-control">
								</td>
							</tr>
							
							<tr>
								<td>Satuan</td>
								<td>
									<input type="text" value="{{$user->satuan->satuan_name}}" name="" id="satuan" placeholder="Masukkan Satuan" readonly class="form-control">
								</td>
							</tr>
							
							<tr>
								<td>Kode Satuan</td>
								<td>
									<input type="text" value="{{$user->satuan->kode_satuan}}" name="kode_satuan" id="kode_satuan" placeholder="Masukkan Kode satuan" readonly class="form-control">
								</td>
							</tr>
							<tr>
								<td>Group</td>
								<td>
									<select class="form-control" name="group_id">
										@foreach ($groups as $group)
											<option  @if($group->group_id==$user->group->group_id) selected @endif value="{{$group->group_id}}">{{$group->group_name}}</option>
										@endforeach
									</select>
								</td>	
							</tr>
							
							<tr>
								<td>Username</td>
								<td>
									<input type="text" value="{{$user->username}}" name="username" id="username" placeholder="Masukkan Username" class="form-control">
								</td>	
							</tr>
							
							<tr>
								<td>Password</td>
								<td>
									<input type="password"  name="password" id="password" placeholder="Masukkan Password (kosongkan jika tidak ingin merubah password)" class="form-control">
								</td>	
							</tr>
							
							<tr>
								<td></td>
								<td><button class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" style="margin:0px 10px; float:right;"><i class="fas fa-save fa-sm text-white-50"></i> Ubah Data</i></button></td>
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