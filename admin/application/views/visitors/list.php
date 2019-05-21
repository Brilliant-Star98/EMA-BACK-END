<?php
if ($this->session->userdata('role') != '4') {
	redirect('dashboard');
}
?>
<?php $this->load->view('includes/header') ;?>

<link href="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>assets/plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/bootstrap-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/github.min.css">


<body class="sticky-header">
<?php $this->load->view('includes/nav') ;?>
<?php $this->load->view('includes/sidebar') ;?>

<div class="body-content">
	<div class="container-fluid">
    	<div class="page-head">
            <h4 class="mt-2 mb-2">Visitors List</h4>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card m-b-30">
                    <div class="card-body table-responsive">
                        <div class="">
											<div class="data-table">
											 <div class="row">
													 <div class="col-lg-12 col-sm-12">
															 <div class="card m-b-30">
																	 <div class="card-body table-responsive">
																			 <div class="table-odd">
	<table border="0" cellspacing="5" cellpadding="5">
    <tbody>
		<tr>
           <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Filter</button>
        </tr>
    </tbody>
	</table>
							<table id="datatable" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Visitor Name</th>
                                    <th>Meet to</th>
                                    <th>Entry Date</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Mobile</th>
                                    <th>Vical Number</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                                <tbody>
								<?php foreach ($VisitorsData as $Visitors) { ?>
                                <tr>
                                    <td><?php echo $Visitors->visitor_name; ?> </td>
                                    <td><?php echo $Visitors->visit_to; ?> </td>
                                    <td><?php echo $Visitors->date_in; ?> </td>
                                    <td><?php echo $Visitors->time_in; ?> </td>
                                    <td><?php echo $Visitors->time_out; ?> </td>
                                    <td><?php echo $Visitors->mobile; ?> </td>
                                    <td><?php echo $Visitors->vical_no; ?> </td>
                                    <td>
									<?php
										if($Visitors->status == 0){
											echo '<button type="button" class="btn btn-warning">PENDDING</button>';
										}else if($Visitors->status == 1){
											echo '<button type="button" class="btn btn-success">ALLOWED</button>';
										}else{
											echo '<button type="button" class="btn btn-danger">REJECTED</button>';
										}
									?>
									</td>
                                    <td>
                                        <a class=" btn btn-sm btn-dark" style="float: none; padding:5px; margin: 0px;" href="<?=base_url();?>edit-visitors?id=<?=$Visitors->id; ?>"><span class="ti-pencil"></span></a>
                                        <a class="btn btn-danger btn-animation"  onclick="deleteRow(<?=$Visitors->id; ?>)"  style="float: none; padding:5px; margin: 0px;">
                                        <span class="fa fa-trash"></span>
                                        </a>
                                    </td>
                                </tr>
								<?php } ?>

                                </tbody>
                            </table>



																			</div>
																	</div>
															</div>
													</div>
											</div><!--end row-->
									</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

                            <div class="row">
							<div class="form-group col">
                                 <label>Date</label>
                                 <input type="text" id="datepicker" class="form-control dateRange" name="date" value="<?php echo set_value('date'); ?>" required placeholder="Date"/>
                             </div>
                            </div>
                            <div class="row">
							<div class="form-group col">
                                  <label>Time In</label>
									<div class="input-group " data-placement="left" data-align="top" data-autoclose="true">
										<input id="single-input" type="text" name="time_in" class="form-control startTime" value="" placeholder="Now">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-time"></span>
										</span>
									</div>
                            </div>
                            <div class="form-group col">
                                  <label>Time Out</label>
								    <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
										<input  type="text" name="time_out" class="form-control endTime" value="" placeholder="Now" >
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-time"></span>
										</span>
									</div>

                            </div>
                            </div>
                            <div class="row">
								<div class="form-group col">
                                   <label>Vical Number</label>
                                   <input type="text" class="form-control vicalNo" name="vical_no" value="<?php echo set_value('vical_no'); ?>" required placeholder="Vical Number"/>
								</div>
                            </div>

        </div>


        <div class="modal-footer">
		<div class="form-group mb-0">
			<div>
				<button type="button" onclick="ajaxRequest();" class="btn btn-primary btn-rounded waves-effect waves-light reserve-button">Filter</button>
			</div>
		</div>
        </div>

      </div>

    </div>
  </div>








<div class="modal fade show" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" >
    <div class="modal-dialog  zoomIn  animated" role="document">
        <div class="modal-content">
            <div class="modal-body">
               <div class="swal2-icon swal2-warning">
               	<i class="mdi mdi-information-variant"></i>
               </div>
               <div class="text-center">
               <h4><strong>Are You Sure !</strong></h4>
               <p class="text-muted">You Want To Delete</p></div>
            </div>
            <div class="modal-footer " style="justify-content:center;">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button type="button" id="delete_yes" class="btn btn-success">Delete</button>
            </div>
        </div>
    </div>
</div>





<?php $this->load->view('includes/footer') ;?>


<script>
  jQuery( function() {
    jQuery( "#datepicker" ).datepicker();
  } );
</script>


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<script type="text/javascript">
	 $(document).ready(function() {
			 $('#datatable').DataTable(),
			 $('#datatable2').DataTable();
	 } );

	 $(document).ready(function() {
		setTimeout(function() {
			window.location.reload();
		}, 5000);
	 } );
</script>



<script>

$('.reserve-button').click(function(){


	var dateRange = $('.dateRange').val();
	var startTime = $('.startTime').val();
	var endTime = $('.endTime').val();
	var vicalNo = $('.vicalNo').val();

	//alert(dateRange);

    $.ajax
    ({
        url: '<?=base_url('AddVisitor/visitorFilter') ?>',
        data: {"dateRange": dateRange,"startTime": startTime,"endTime": endTime,"vicalNo": vicalNo},
        type: 'post',
        success: function(result)
        {
			$('#myModal').modal('hide');
        }
    });
});
</script>




<script>
function deleteRow(orderid) {


				swal({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!',
				showLoaderOnConfirm: true,
				preConfirm: function() {
					 return new Promise(function(resolve) {
			 $.ajax({
					url: '<?=base_url();?>delete-visitors?id='+orderid,
					type: 'POST',
					data: 'delete='+orderid,
					dataType: 'json'
			 })
			 .done(function(response){
					swal('Deleted!', response.message, response.status);
					readProducts();
							})
			 .fail(function(){
					swal('Oops...', 'Something went wrong with ajax !', 'error');
			 });
					 });
				},
				allowOutsideClick: false
				});


				 }

</script>








<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap-clockpicker.min.js"></script>

<script type="text/javascript">
$('.clockpicker').clockpicker()
	.find('input').change(function(){
		console.log(this.value);
	});
var input = $('#single-input').clockpicker({
	placement: 'bottom',
	align: 'left',
	autoclose: true,
	'default': 'now'
});

$('.clockpicker-with-callbacks').clockpicker({
		donetext: 'Done',
		init: function() {
			console.log("colorpicker initiated");
		},
		beforeShow: function() {
			console.log("before show");
		},
		afterShow: function() {
			console.log("after show");
		},
		beforeHide: function() {
			console.log("before hide");
		},
		afterHide: function() {
			console.log("after hide");
		},
		beforeHourSelect: function() {
			console.log("before hour selected");
		},
		afterHourSelect: function() {
			console.log("after hour selected");
		},
		beforeDone: function() {
			console.log("before done");
		},
		afterDone: function() {
			console.log("after done");
		}
	})
	.find('input').change(function(){
		console.log(this.value);
	});

// Manually toggle to the minutes view
$('#check-minutes').click(function(e){
	// Have to stop propagation here
	e.stopPropagation();
	input.clockpicker('show')
			.clockpicker('toggleView', 'minutes');
});
if (/mobile/i.test(navigator.userAgent)) {
	$('input').prop('readOnly', true);
}
</script>
<script type="text/javascript" src="<?=base_url();?>assets/js/highlight.min.js"></script>
<script type="text/javascript">
hljs.configure({tabReplace: '    '});
hljs.initHighlightingOnLoad();
</script>



<script src="<?php echo base_url();?>assets/plugins/sweet-alert/sweetalert2.min.js"></script>
<script src="<?php echo base_url();?>assets/pages/jquery.sweet-alert.init.js"></script>

<script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/responsive.bootstrap4.min.js"></script>


</body>
</html>
