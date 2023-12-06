<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MAC-AMS | Login</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte/adminlte.min.css') }}">

  <style type="text/css">

    .login-page {
      background-color: #ffffff;
      height: 75vh;
    }

  </style>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline">
    <div class="card-header text-center">
	  <div class="col-md-12">
	  	<img src="{{ asset('img/mac_logo.fw.png') }}" alt="mac_logo" class="img img-responsive">
	  </div>
    </div>
    <div class="card-body">
      <p class="login-box-msg" style="font-size: 1.5rem;"><b>Login</b></p>

      <form method="POST" id="handlelogin" action="{{route('login.user')}}" >
        @csrf
        @if (Session::has('success'))
        <div class="callout callout-success">
          <!-- <h5>Something Went Wrong!</h5> -->

          <p>{{ Session::get('success') }}</p>
        </div>
        @endif

        <div class="form-group">
          <label for="username" style="font-weight: normal;">Username</label>
          <input type="text" id="username" class="form-control" id="username" name="username" required autofocus>
          @if ($errors->has('username'))
            <span class="text-danger">{{ $errors->first('username') }}</span>

          @endif
        </div>
        <div class="form-group">
          <label for="password" style="font-weight: normal;">Password</label>
          <input type="password" id="password" class="form-control" id="password" name="password" required>
          @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
          @endif
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember" style="font-weight: normal;">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn bg-gradient-primary btn-flat btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->


<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>




<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte/adminlte.min.js') }}"></script>

{{-- <script>

    $(document).on('submit','#handlelogin',function(e) {
        e.preventDefault();
        var data = $("#handlelogin :input").serializeArray();
        $.ajax({
            type: "POST",
            url: '{{route('login.user')}}',
            data:data,
            dataType: "json",
            success: function (response) {
                console.log(response.data)

            }
         })
    })

</script> --}}


</body>
</html>
