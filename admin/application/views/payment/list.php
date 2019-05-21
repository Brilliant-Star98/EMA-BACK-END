<?php
if ($this->session->userdata('role') != '2') {
	redirect('dashboard');
}
?>
<?php $this->load->view('includes/header') ;?>

<link href="<?php echo base_url();?>assets/plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet" type="text/css" />

		 <link href="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
		 <link href="<?php echo base_url();?>assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
		 <link href="<?php echo base_url();?>assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<body class="sticky-header">
<?php $this->load->view('includes/nav') ;?>
<?php $this->load->view('includes/sidebar') ;?>

<div class="body-content">
	<div class="container-fluid">
    	<div class="page-head">
            <h4 class="mt-2 mb-2">Payment List</h4>
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
																					 <table id="datatable" class="table table-bordered">
						                                <thead>
						                                <tr>
						                                    <th>Id</th>
						                                    <th>User</th>
						                                    <th>Bill Id</th>
						                                    <th>Amount</th>
						                                    <th>Note</th>
						                                    <th>Transection Id</th>
						                                    <th>Transection Date</th>
						                                    <th>Action</th>
						                                </tr>
						                                </thead>
						                                <tbody>
																							<?php foreach ($PaymentData as $Payment) { ?>
						                                <tr>
						                                    <td><?php echo $Payment->id; ?> </td>
						                                    <td><?php echo $Payment->fname; ?> <?php echo $Payment->lname; ?></td>
																								<td><?php echo $Payment->bill_id; ?> </td>
																								<td><?php echo $Payment->amount; ?> </td>
																								<td><?php echo $Payment->note; ?> </td>
																								<td><?php echo $Payment->transaction_id; ?> </td>
																								<td><?php echo $Payment->transaction_date; ?> </td>
						                                    <td>
						                                        <a class="btn btn-danger btn-animation"  onclick="deleteRow(<?=$Payment->id; ?>)"  style="float: none; padding:5px; margin: 0px;">
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
											</div>
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

<?php $this->load->view('includes/footer');?>

<script src="<?php echo base_url();?>assets/plugins/sweet-alert/sweetalert2.min.js"></script>
<script src="<?php echo base_url();?>assets/pages/jquery.sweet-alert.init.js"></script>

		<script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.responsive.min.js"></script>
		<script src="<?php echo base_url();?>assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

		<script type="text/javascript">
			 $(document).ready(function() {
					 $('#datatable').DataTable(),
					 $('#datatable2').DataTable();
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
					url: '<?=base_url();?>delete-payment?id='+orderid,
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



</body>
</html>
