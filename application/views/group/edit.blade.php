@extends('layouts/master')

@section('content')
<div class="container-fluid" >
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
			<h1 class="h3 mb-0 text-gray-800">Ubah User</h1>
		</div>
		@if(isset($alertStatus))
		<div class="card mb-3 border-bottom-danger alert-box">
	      <div class="card-body">
	        {{$alertMessage}}
	      </div>
	    </div>
	    @endif
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list fa-sm"></i> Data Ubah User</h6>
			</div>
			<div class="card-body">
				<div class="table-responsive">
						
					@php			
					echo form_open('group/'.$group->group_id.'/edit', array('class' => 'form', 'id' => 'add'));
					@endphp
						<table class="table">
							<tr>
								<td style="width:200px;">Name</td>
								<td>
									<input type="text" value="{{$group->group_name}}"  class="form-control" name="group_name" id="group_name">
									
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