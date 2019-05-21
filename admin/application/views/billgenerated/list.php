<?php
if ($this->session->userdata('role') != '2') {
	redirect('dashboard');
}
?>
<?php $this->load->view('includes/header') ;?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url();?>assets/plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet" type="text/css" />

<body class="sticky-header">
<?php $this->load->view('includes/nav') ;?>
<?php $this->load->view('includes/sidebar') ;?>

<div class="body-content">
	<div class="container-fluid">
    	<div class="page-head">
            <h4 class="mt-2 mb-2">BillGenerated List</h4>
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

														 <ul id="agentbutonUl">
																 <li>
																		 <input type="text" onchange="GetMonthDetails();" id="billMonth" name="billMonth" placeholder="Bill Month" value="">
																 </li>
																 <li>
																			 <button type="button" onclick="GetMonthPaidDetails();" id="Paid" name="button">Paid</button>
																 </li>
																	<li>
																		   <button type="button" onclick="GetMonthPendingDetails();" id="Pending" name="button">Pending</button>
																 </li>
													 	 </ul>

														<table id="datatable" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Bill User</th>
                                    <th>Bill Month</th>
                                    <th>Bill Amount</th>
                                    <th>Bill Date</th>
                                    <th>Bill Due Date</th>
                                <!--    <th>Bill Rate</th>  -->
                                    <th>Bill Unit</th>
                                    <th>Action</th>
                                </tr>
                                </thead>


                                <tbody id="generatedTable">
																	<?php foreach ($BillGeneratedData as $BillType) { ?>
                                <tr>
                                    <td><?php echo $BillType->id; ?> </td>
                                    <td><?php echo $BillType->fname; ?> <?php echo $BillType->lname; ?></td>
                                    <td><?php echo $BillType->bill_month; ?> </td>
                                    <td><?php echo $BillType->bill_amount; ?> </td>
                                    <td><?php echo $BillType->bill_generated_date; ?> </td>
                                    <td><?php echo $BillType->due_date; ?> </td>
                                 <!--   <td><?php echo $BillType->rate; ?> </td> -->
                                    <td><?php echo $BillType->unit; ?> </td>
                                    <td>
                                        <a class=" btn btn-sm btn-dark" style="float: none; padding:5px; margin: 0px;" href="<?=base_url();?>edit-billgenerated?id=<?=$BillType->id; ?>"><span class="ti-pencil"></span></a>
                                        <a class="btn btn-danger btn-animation"  onclick="deleteRow(<?=$BillType->id; ?>)"  style="float: none; padding:5px; margin: 0px;"><span class="fa fa-trash"></span> </a>
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

<script src="<?php echo base_url();?>assets/plugins/sweet-alert/sweetalert2.min.js"></script>
<script src="<?php echo base_url();?>assets/pages/jquery.sweet-alert.init.js"></script>

<script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/responsive.bootstrap4.min.js"></script>


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
 jQuery( function() {
	 jQuery( "#billMonth" ).datepicker({
		  dateFormat: 'yy-mm'
		}).val();
} );
</script>


<script type="text/javascript">

function GetMonthDetails()
{
	 var bilmonth = $("#billMonth").val();
		$.ajax({
		    url: "<?=base_url('BillGenerated/MonthFilter')?>",
		    type: "POST",
		    dataType: "html",
		    data: {"month": bilmonth},
		    success: function(data){
					 $("#generatedTable").empty();
					 $("#generatedTable").append(data);
		  },
		    error: function(error){
		         console.log("Error:");
		         console.log(error);
		    }
		});
}


function GetMonthPendingDetails()
{
	 var bilmonth = $("#billMonth").val();
		$.ajax({
		    url: "<?=base_url('BillGenerated/MonthPendingFilter')?>",
		    type: "POST",
		    dataType: "html",
		    data: {"month": bilmonth},
		    success: function(data){
					 $("#generatedTable").empty();
					 $("#generatedTable").append(data);
		  },
		    error: function(error){
		         console.log("Error:");
		         console.log(error);
		    }
		});
}


function GetMonthPaidDetails()
{
	 var bilmonth = $("#billMonth").val();
		$.ajax({
		    url: "<?=base_url('BillGenerated/MonthPaidFilter')?>",
		    type: "POST",
		    dataType: "html",
		    data: {"month": bilmonth},
		    success: function(data){
					 $("#generatedTable").empty();
					 $("#generatedTable").append(data);
		  },
		    error: function(error){
		         console.log("Error:");
		         console.log(error);
		    }
		});
}







	 jQuery(document).ready(function() {
			 jQuery('#datatable').DataTable(),
			 jQuery('#datatable2').DataTable();
	 } );
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
					url: '<?=base_url();?>delete-billgenerated?id='+orderid,
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
<style media="screen">
ul#agentbutonUl {
	list-style: none;
}

ul#agentbutonUl li {
    float: left;
    padding: 5px;
    left: -27px;
    position: relative;
}

</style>
</body>
</html>
