<?php
if ($this->session->userdata('role') != '1') {
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
	<div class="container-fluid">
    	<div class="page-head">
            <h4 class="mt-2 mb-2">Agent List</h4>
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
            <button type="button" id="allAgent" name="button">All</button>
        </li>
				<li>
            <button type="button" id="approvedAgent" name="button">Approved Agent</button>
        </li>
				<li>
            <button type="button" id="pendingAgent" name="button">Pending Agent</button>
        </li>
				<li>
            <button type="button" id="blockedAgent" name="button">Blocked Agent</button>
        </li>
  </ul>



												<div id="Al_agent">
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
																<?php foreach ($AgentData as $agent) { ?>
                                <tr>
                                    <td><?php echo $agent->fname; ?> </td>
                                    <td><?php echo $agent->lname; ?> </td>
                                    <td><?php echo $agent->email; ?> </td>
                                    <td><?php echo $agent->full_address; ?> </td>
                                    <td>
                                        <a class=" btn btn-sm btn-dark" style="float: none; padding:5px; margin: 0px;" href="<?=base_url();?>edit-agent?id=<?=$agent->userId; ?>"><span class="ti-pencil"></span></a>
                                        <a class="btn btn-danger btn-animation"  onclick="deleteRow(<?=$agent->userId; ?>)"  style="float: none; padding:5px; margin: 0px;"><span class="fa fa-trash"></span></a>
                                    </td>
                                </tr>
																<?php } ?>
                                </tbody>
                        </table>
												</div>


												<div id="Ap_agent" style="display:none">
												<table id="datatable2" class="table table-bordered">
																<thead>
																<tr>
																		<th>First Name</th>
																		<th>Last Name</th>
																		<th>Email</th>
																		<th>Address</th>
																		<th>Action</th>
																</tr>
																</thead>
																<tbody >
																<?php foreach ($ApprovedAgentData as $agent) { ?>
																<tr>
																		<td><?php echo $agent->fname; ?> </td>
																		<td><?php echo $agent->lname; ?> </td>
																		<td><?php echo $agent->email; ?> </td>
																		<td><?php echo $agent->full_address; ?> </td>
																		<td>
																				<a class=" btn btn-sm btn-danger" onclick="return confirm('Are you sure block this? #<?= $agent->fname;?>')"  style="float: none; padding:5px; margin: 0px;" href="<?=base_url();?>block-now?id=<?=$agent->userId; ?>"><span class="ti-lock"></span></a>
																				<a class=" btn btn-sm btn-dark" style="float: none; padding:5px; margin: 0px;" href="<?=base_url();?>edit-agent?id=<?=$agent->userId; ?>"><span class="ti-pencil"></span></a>
																				<a class="btn btn-danger btn-animation"  onclick="deleteRow(<?=$agent->userId; ?>)"  style="float: none; padding:5px; margin: 0px;">
																				<span class="fa fa-trash"></span>
																				</a>
																		</td>
																</tr>
																<?php } ?>
																</tbody>
												</table>
												</div>


												<div id="Pe_agent" style="display:none">
												<table id="datatable3" class="table table-bordered">
																<thead>
																<tr>
																		<th>First Name</th>
																		<th>Last Name</th>
																		<th>Email</th>
																		<th>Address</th>
																		<th>Action</th>
																</tr>
																</thead>

																<tbody >
																<?php foreach ($PendingAgentData as $agent) { ?>
																<tr>
																		<td><?php echo $agent->fname; ?> </td>
																		<td><?php echo $agent->lname; ?> </td>
																		<td><?php echo $agent->email; ?> </td>
																		<td><?php echo $agent->full_address; ?> </td>
																		<td>
																			<a class=" btn btn-sm btn-success" onclick="return confirm('Are you sure approve this? #<?= $agent->fname;?>')"  style="float: none; padding:5px; margin: 0px;" href="<?=base_url();?>approve-user-now?id=<?=$agent->userId; ?>"><span class="ti-check"></span></a>
																			<a class=" btn btn-sm btn-danger" onclick="return confirm('Are you sure block this? #<?= $agent->fname;?>')"  style="float: none; padding:5px; margin: 0px;" href="<?=base_url();?>block-now?id=<?=$agent->userId; ?>"><span class="ti-lock"></span></a>
																				<a class=" btn btn-sm btn-dark" style="float: none; padding:5px; margin: 0px;" href="<?=base_url();?>edit-agent?id=<?=$agent->userId; ?>"><span class="ti-pencil"></span></a>
																				<a class="btn btn-danger btn-animation"  onclick="deleteRow(<?=$agent->userId; ?>)"  style="float: none; padding:5px; margin: 0px;">
																				<span class="fa fa-trash"></span>
																				</a>
																		</td>
																</tr>
																<?php } ?>
																</tbody>
															</table>
															</div>


															<div id="Bl_agent" style="display:none">
															<table id="datatable4" class="table table-bordered">
																			<thead>
																			<tr>
																					<th>First Name</th>
																					<th>Last Name</th>
																					<th>Email</th>
																					<th>Address</th>
																					<th>Action</th>
																			</tr>
																			</thead>
																			<tbody >
																			<?php foreach ($BlockedAgentData as $agent) { ?>
																			<tr>
																					<td><?php echo $agent->fname; ?> </td>
																					<td><?php echo $agent->lname; ?> </td>
																					<td><?php echo $agent->email; ?> </td>
																					<td><?php echo $agent->full_address; ?> </td>
																					<td>
																						<a class=" btn btn-sm btn-success" onclick="return confirm('Are you sure approve this? #<?= $agent->fname;?>')"  style="float: none; padding:5px; margin: 0px;" href="<?=base_url();?>approve-user-now?id=<?=$agent->userId; ?>"><span class="ti-check"></span></a>
																							<a class=" btn btn-sm btn-dark" style="float: none; padding:5px; margin: 0px;" href="<?=base_url();?>edit-agent?id=<?=$agent->userId; ?>"><span class="ti-pencil"></span></a>
																							<a class="btn btn-danger btn-animation"  onclick="deleteRow(<?=$agent->userId; ?>)"  style="float: none; padding:5px; margin: 0px;">
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
<div class="right sb-slidebar sb-right sb-style-overlay">
<div class="right-bar slimscroll">
    <span class="r-close-btn sb-close"><i class="fa fa-times"></i></span>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="chat">
            <div class="online-chat">
                <div class="online-chat-container">
                    <div class="side-title-alt">
                        <h2>User List</h2>
                    </div>

                    <div class="team-list chat-list-side">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group col">
                                    <label>First Name</label>
																		<p><strong><span id="p_fname"></span></strong></p>
                                </div>
                                <div class="form-group col">
                                    <label>Last Name</label>
                                    <p><strong><span id="p_lname"></span></strong></p>
                                </div>
                                <div class="form-group col">
                                    <label>E-Mail</label>
                                    <p><strong><span id="p_email"></span></strong></p>
                                </div>
                                <div class="form-group col">
                                    <label>Alternate E-Mmail</label>
                                   <p><strong><span id="p_altemail"></span></strong></p>
                                </div>
                                <div class="form-group col">
                                    <label>Mobile Number</label>
                                    <p><strong><span id="p_mobile"></span></strong></p>
                                </div>
                                <div class="form-group col">
                                    <label>Alternate Mobile Number</label>
                                    <p><strong><span id="p_altmobile"></span></strong></p>
                                </div>
                                <div class="form-group col">
                                    <label>Map Location</label>
                                    <div>
                                        <p><strong><span id="p_location"></span></strong></p>
                                    </div>
                                </div>
								 <div class="form-group col">
                                    <label>Extra Text</label>
																		<p><strong><span id="p_content"></span></strong></p>
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
			 $('#datatable3').DataTable();
			 $('#datatable4').DataTable();
	 } );

$(document).ready(function(){
    $("#allAgent").click(function(){
        $("#Al_agent").show();
        $("#Pe_agent").hide();
        $("#Bl_agent").hide();
				$("#Ap_agent").hide();
    });

		$("#approvedAgent").click(function(){
				$("#Ap_agent").show();
				$("#Al_agent").hide();
				$("#Pe_agent").hide();
				$("#Bl_agent").hide();
		});

		$("#pendingAgent").click(function(){
				$("#Al_agent").hide();
				$("#Pe_agent").show();
				$("#Bl_agent").hide();
				$("#Ap_agent").hide();
		});

		$("#blockedAgent").click(function(){
				$("#Al_agent").hide();
				$("#Pe_agent").hide();
				$("#Bl_agent").show();
				$("#Ap_agent").hide();
		});

});

$(document).ready(function() {
    var table = $('#example').DataTable();

    // Event listener to the two range filtering inputs to redraw on input
    $('#min, #max').keyup( function() {
        table.draw();
    } );
} );


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
					url: '<?=base_url();?>delete-agent?id='+orderid,
					type: 'POST',
					data: 'delete='+orderid,
					dataType: 'json'
			 })
			 .done(function(response){
					location.reload();
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
