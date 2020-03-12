@extends('layouts/master')

@section('content')
	<div class="container-fluid">
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Users</h1>
			<a href="{{ base_url('user/add') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data Users</i></a>
		</div>
		<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list fa-sm"></i> Data User</h6>
		</div>
		<div class="card-body">
		<div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>NRP</th>
                      <th>Satuan</th>
                      <th>Group</th>
                      <th>Kode Satuan</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
						
					@php
						$no=0;
					@endphp
					@foreach ($users as $user) 
						<tr>
							<td>{{$user->name=="" ? $user->username : $user->name}}</td>
							<td>{{$user->nrp=="" ? $user->user_id : $user->nrp}}</td>
							<td>
								@if (!isset($user->satuan->satuan_name))
								    <b>Satuan tidak ada di database.</b>
								@else 
								    {{$user->satuan->satuan_name}}
								@endif
								
							</td>
							<td>{{$user->group->group_name}}</td>
							<td>{{$user->satuan->kode_satuan}}</td>
							<td>
							<a href="{{ base_url("")}}user/{{$user->user_id}}/edit"><button class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i> Edit Data</button></a>
							<button class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="confirmDelete('user',{{$user->user_id}})"><i class="fas fa-trash fa-sm text-white-50"></i> Hapus Data</button>
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
	<script>
	function confirmDelete(x){
       
		swal({
			title: "Are you sure?",
			text: "But you will still be able to retrieve this file.",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: '#2E59D9',
			cancelButtonColor: '#d33',
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "Cancel",
			closeOnConfirm: false,
			closeOnCancel: false
			},
			function(isConfirm){
			if (isConfirm) {
				window.location.href = "user/"+x+"/delete";
			} else {
				swal("Cancelled", "Data tidak terhapus", "error");
			}
			});
    }
	</script>
@endsection