<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>eMeeting (Jadwal Rapat Terpadu)</title>

  <!-- Custom fonts for this template-->
  <link href="{{assets_url('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{ assets_url('css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">
		<h1 class="h1 text-white mb-1" style="text-align:center; margin-top:40px; font-weight:bold;">eMeeting <br> (Jadwal Rapat Terpadu)</h1>
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back, Please Login</h1>
                  </div>
                  	@php
						$attributes = array('class' => 'login-form', 'id' => 'login-form');
						echo form_open('login', $attributes);
					@endphp
                    <div class="form-group">
                      <input type="text" name="username" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password">
                    </div>
                    <button class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                    @php 
						echo form_close(); 
            @endphp
                  <p style="color:red; padding:10px; text-align:center;">
                    {{$auth}}
                  </p>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{assets_url('vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{assets_url('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{assets_url('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{assets_url('js/sb-admin-2.min.js')}}"></script>

</body>

</html>
