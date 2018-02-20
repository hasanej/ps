	<script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/bower_components/raphael/raphael.min.js') }}"></script>
	<script src="{{ asset('assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
	<script src="{{ asset('assets/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
	<script src="{{ asset('assets/bower_components/moment/min/moment.min.js') }}"></script>
	<script src="{{ asset('assets/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
	<script src="{{ asset('assets/bower_components/ckeditor/ckeditor.js') }}"></script>
	<script src="{{ asset('assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset('assets/bower_components/fastclick/lib/fastclick.js') }}"></script>
	<script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
	<script src="{{ asset('assets/dist/js/pages/dashboard.js') }}"></script>
	<script src="{{ asset('assets/dist/js/demo.js') }}"></script>
	<script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>
	<script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
	<script>
	  	$.widget.bridge('uibutton', $.ui.button);
	</script>
	<script>
	  	$(function () {
		    $('#example1').DataTable()
		    $('#example2').DataTable({
		      'paging'      : true,
		      'lengthChange': false,
		      'searching'   : false,
		      'ordering'    : true,
		      'info'        : true,
		      'autoWidth'   : false
	    	})
	  	})
	</script>
	<script>
		$(document).on('click', ':not(form)[data-confirm]', function(e){
	    	if(!confirm($(this).data('confirm')))
	    	{
		        e.stopImmediatePropagation();
		        e.preventDefault();
	    	}
		});
	</script>
	<script>
	  	$(function () {
	    	$('input').iCheck({
		    checkboxClass: 'icheckbox_square-blue',
		    radioClass: 'iradio_square-blue',
		    increaseArea: '20%'
	    	});
	  	});
	</script>
	<script>
	  	$(function () {
	    CKEDITOR.replace('ckeditor')
	    $('.textarea').wysihtml5()
	  })
	</script>