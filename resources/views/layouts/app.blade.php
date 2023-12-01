<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios@0.24.0/dist/axios.min.js"></script>
  <title> {{ $title }} </title>
  <style type="text/css">
		.flex {
			display:flex;
		}
		.dataTables_filter {
			float: left !important;
		}
		.nav-pills .nav-link.active, .nav-pills .show>.nav-link{
			background-color: #3d9970!important;
			color: #fff!important;
			border-radius:0px;
		}
		.nav-link:hover, .nav-link:focus{
			background-color: #4ec891!important;
			color: #fff!important;
			border-radius:0px;

		}
		/* .buttons-print, .buttons-html5{
			display:none!important;
		} */
		.page-item.active .page-link
		{
			background-color: #3d9970!important;
			border-color: #3d9970!important;
		}
		.dataTables_filter{
			float:right!important;
		}
	</style>
  @include('includes.styles')

</head>
<body class="hold-transition sidebar-mini text-sm">
<!-- Site wrapper -->
@auth
<div class="wrapper">

@include('includes.topbar')

@include('includes.sidebar')
@endauth


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->

<!-- modal create/edit account -->
<div class="modal" id="modal-global">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@include('includes.scripts')
@yield('footer-scripts')
</body>
<script>



	function mytime()
	{
		var d=new Date();
		ap="am";
		h=d.getHours();
		m=d.getMinutes();
		s=d.getSeconds();
		if (h>11) { ap = "pm"; }
		if (h>12) { h = h-12; }
		if (h==0) { h = 12; }
		if (m<10) { m = "0" + m; }
		if (s<10) { s = "0" + s; }
		document.getElementById('currentTime').innerHTML=h + ":" + m + ":" + s + " " + ap;

		t=setTimeout('mytime()',500);
		document.getElementById('currentDate').innerHTML =  new Date().toLocaleDateString('en-us', { weekday:"long", year:"numeric", month:"short", day:"numeric"})
	}
</script>
</html>
