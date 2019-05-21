<?php
if ($this->session->userdata('role') != '2') {
	redirect('dashboard');
}
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php $this->load->view('includes/header') ;?>
<body class="sticky-header">
<?php $this->load->view('includes/nav') ;?>
<?php $this->load->view('includes/sidebar') ;?>
<div class="body-content">
	<div class="container-fluid">
    	<div class="page-head">
            <h4 class="mt-2 mb-2">Add BillGenerated</h4>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">



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

                        <form class="" method="post" action="<?=base_url('edit-billgenerated/'); ?>?id=<?=$BillGenerated[0]->id; ?>" enctype="multipart/form-data">

													<div class="row">
															<div class="form-group col">
																	<label>Bill Amount</label>
																	<input type="text" class="form-control" value="<?=$BillGenerated[0]->fname." ".$BillGenerated[0]->lname; ?>" placeholder="bill amount" readonly/>
															 </div>
															<div class="form-group col">
																	 <label>Bill Type</label>
																		 <input type="text" class="form-control" value="<?=$BillGenerated[0]->bill_title; ?>" placeholder="Bill Type" readonly/>
															 </div>
															 <div class="form-group col">
																		<label>Bill Month</label>
																		<input type="text" class="form-control" name="bill_month" value="<?=$BillGenerated[0]->bill_month; ?>" readonly placeholder="bill month"  autocomplete="off"/>
																</div>
													 </div>

													 <div class="row">
															 <div class="form-group col">
																		<label>Bill Amount</label>
																		<input type="number" class="form-control" name="bill_amount" value="<?=$BillGenerated[0]->bill_amount; ?>" required placeholder="bill amount"/>
																</div>
															 <div class="form-group col">
																		<label>Bill Generated Date</label>
																		<input type="text" class="form-control" name="bill_generated_date" value="<?=$BillGenerated[0]->bill_generated_date; ?>" readonly placeholder="bill generated date"  autocomplete="off"/>
																</div>
															 <div class="form-group col">
																		<label>Bill Due Date</label>
																		<input type="text" class="form-control" name="due_date" value="<?=$BillGenerated[0]->due_date; ?>" readonly placeholder="due date"  autocomplete="off"/>
																</div>
														</div>

													 <div class="row">
													 <!--
															 <div class="form-group col">
																		<label>Bill Rate</label>
																		<input type="text" class="form-control" name="rate" value="<?=$BillGenerated[0]->rate; ?>" required placeholder="bill rate"/>
																</div>
														-->
															 <div class="form-group col">
																		<label>Bill Unit</label>
																		<input type="number" class="form-control" name="unit" value="<?=$BillGenerated[0]->unit; ?>" required placeholder="unit"/>
																</div>

															 <div class="form-group col">
																		<label>Late Fee</label>
																		<input type="number" class="form-control" name="late_fee" value="<?=$BillGenerated[0]->late_fee; ?>" required placeholder="Late Fee"/>
																</div>
															 <div class="form-group col">
																		<label>Total Amount</label>
																		<input type="number" class="form-control" name="total_amount" value="<?=$BillGenerated[0]->total_amount; ?>" required placeholder="total amount"/>
																</div>
														</div>




                            <div class="form-group mb-0">
                                <div>
																	<?php if ($BillGenerated[0]->status == '0'): ?>
																		<button type="submit" class="btn btn-primary btn-rounded pull-right waves-effect waves-light">Update</button>
																	<?php endif; ?>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>
<?php $this->load->view('includes/footer') ;?>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<style media="screen">
/* #startDate .ui-datepicker-calendar {
display: none;
} */
</style>
<script>
jQuery( function() {
 jQuery( "#bill_generated_date" ).datepicker();
 jQuery( "#due_date" ).datepicker();
} );


$(function() {
	$('.date-picker').datepicker( {
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat: 'MM yy',
			onClose: function(dateText, inst) {
					$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
			}
	});
});

</script>
</body>
</html>
