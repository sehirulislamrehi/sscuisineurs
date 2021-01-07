</div>
<!-- body content end -->

	<!-- jquery lib file -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- jqeury ui js -->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<!-- the main bootstrap file -->
	<script type="text/javascript" src="{{ asset('backend/js/bootstrap.min.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('backend/js/rte.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('backend/js/all_plugins.js') }}" ></script>

	<!-- data table js -->
	<script type="text/javascript" src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
	<script>
	    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
	</script>

	<script src="{{asset('frontend/js/fencybox.min.js')}}"></script>
	<script src="{{asset('frontend/js/fency.js')}}"></script>

	
	<!-- the main js file -->
	<script type="text/javascript" src="{{ asset('backend/js/choosen.min.js') }}" ></script>
	<script type="text/javascript" src="{{ asset('backend/js/main.js') }}" ></script>
	
	<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>


    <script type="text/javascript">
        $(document).ready( function () {
			$('#myTable').DataTable({
			});
			$('#message_table').DataTable({
			    "order": [[ 3, "desc" ]]
			});
			
			$(".myTable").DataTable({
			});
			$(".food_table").DataTable({
				"bPaginate": false,
				"searching": true,
				
			});
			$('#myTable2').DataTable();
        });
        
         
	</script>



	
	@yield('js')


