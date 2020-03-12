@extends('layouts/master')

@section('content')
	<div class="container-fluid">
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Group</h1>
			<a href="{{ base_url('group/add') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data Group</i></a>
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
			<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list fa-sm"></i> Data Group</h6>
		</div>
		<div class="card-body">
		<div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>#</th>
                <th>Name Group</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @php
                $no=1;
              @endphp
              @foreach ($groups as $group) 
                <tr>
                  <td>{{$no}}</td>
                  <td>{{$group->group_name}}</td>
                  <td>
                  <a href="{{ base_url("")}}group/{{$group->group_id}}/edit"><button class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-edit fa-sm text-white-50"></i> Edit Data</button></a>
                  <button class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" 
                  onclick="confirmDelete('{{base_url('group/'.$group->group_id.'/delete')}}')">
                    <i class="fas fa-trash fa-sm text-white-50"></i> Hapus Data
                  </button>
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
@endsection