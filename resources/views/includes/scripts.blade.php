<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- bootbox -->
<script src="{{ asset('plugins/bootbox/bootbox.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{  asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{  asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{  asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{  asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{  asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{  asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{  asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{  asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{  asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- x editable -->
<script src="{{ asset('plugins/bootstrap3-editable-1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte/adminlte.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<!-- custom js -->
<script src="{{ asset('js/custom.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{ asset('js/adminlte/demo.js') }}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.0/jquery.bootstrap-growl.min.js"></script>

<script>
	jQuery(document).ready(function() {  
		@if(Session::has('success'))
			$.bootstrapGrowl("{{Session::get('success')}}", {type:'success'});
		@endif
	});
</script>

@yield('js')