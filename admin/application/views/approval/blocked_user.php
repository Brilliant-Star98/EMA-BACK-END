<?php
if ($this->session->userdata('role') != '2') {
	redirect('dashboard');
}
?>
<?php $this->load->view('includes/header') ;?>
<link href="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/plugins/sweet-alert/sweetalert2.min.css" rel="stylesheet" type="text/css" />

<body class="sticky-header">
<?php $this->load->view('includes/nav') ;?>
<?php $this->load->view('includes/sidebar') ;?>

<div class="body-content">


	           <?php
	               $this->load->helper('form');
	               $error = $this->session->flashdata('error');
	               if($error)
	               {
	           ?>
	           <div class="alert alert-danger alert-dismissable">
	               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	               <?php echo $this->session->flashdata('error'); ?>
	           </div>
	           <?php } ?>
	           <?php
	               $success = $this->session->flashdata('success');
	               if($success)
	               {
	           ?>
	           <div class="alert alert-success alert-dismissable">
	               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	               <?php echo $this->session->flashdata('success'); ?>
	           </div>
	           <?php } ?>

	           <div class="row">
	               <div class="col-md-12">
	                   <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
	               </div>
	           </div>


	<div class="container-fluid">
    	<div class="page-head">
            <h4 class="mt-2 mb-2">Pending User List</h4>
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
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
																	<?php foreach ($PendingUserData as $UserData) { ?>
                                <tr>
                                    <td><?php echo $UserData->fname; ?> </td>
                                    <td><?php echo $UserData->lname; ?> </td>
                                    <td><?php echo $UserData->email; ?> </td>
                                    <td><?php echo $UserData->full_address; ?> </td>
                                    <td>
                                        <a class=" btn btn-sm btn-success" onclick="return confirm('Are you sure approve this? #<?= $UserData->fname;?>')"  style="float: none; padding:5px; margin: 0px;" href="<?=base_url();?>approve-user-now?id=<?=$UserData->userId; ?>"><span class="ti-check"></span></a>
                                        <a class=" btn btn-sm btn-dark" style="float: none; padding:5px; margin: 0px;" href="<?=base_url();?>edit-user?id=<?=$UserData->userId; ?>"><span class="ti-pencil"></span></a>
                                        <a class="btn btn-danger btn-animation"  onclick="deleteRow(<?=$UserData->userId; ?>)"  style="float: none; padding:5px; margin: 0px;">
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
					url: '<?=base_url();?>delete-user?id='+orderid,
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
