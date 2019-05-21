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
            <h4 class="mt-2 mb-2">Add BillType</h4>
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

                        <form class="" method="post" action="<?=base_url('add-billgenerated'); ?>" enctype="multipart/form-data">

													<div class="row">
															<div class="form-group col">
																	 <label>Select User</label>
																	 <select onchange="getBillValue();" id="mySelectBill" class="form-control" name="client_id" required>
																	 	<option selected>Select User</option>
																		<?php foreach ($User as $client) { ?>
																			<option value="<?=$client->userId;?>"><?=$client->fname;?></option>
																		<?php } ?>
																	 </select>
															 </div>
															<div class="form-group col">
																	 <label>Bill Type</label>
																	 <div class="mybiltypeselect">
																		 <select class="form-control" name="bill_type" required>
																		 <option selected>Select Bill Type</option>
																		</select>

																	 </div>

															 </div>
															 <div class="form-group col">
																		<label>Bill Month</label>
																		<input type="text" class="form-control date-picker" id="startDate" name="bill_month" value="<?php echo set_value('bill_month'); ?>" required placeholder="bill month"  autocomplete="off"/>
																</div>
													 </div>

													 <div class="row">
                               <div class="form-group col">
                                    <label>Bill Amount</label>
                                    <input type="number" id="bill_amount" class="form-control" name="bill_amount" value="<?php echo set_value('bill_amount'); ?>" required placeholder="bill amount"/>
                                </div>
                               <div class="form-group col">
                                    <label>Bill Generated Date</label>
                                    <input type="text" class="form-control" id="bill_generated_date" name="bill_generated_date" value="<?php echo set_value('bill_generated_date'); ?>" required placeholder="bill generated date"  autocomplete="off"/>
                                </div>
                               <div class="form-group col">
                                    <label>Bill Due Date</label>
                                    <input type="text" class="form-control" id="due_date" name="due_date" value="<?php echo set_value('due_date'); ?>" required placeholder="due date"  autocomplete="off"/>
                                </div>
                            </div>

							 <div class="row">
                           <!--    <div class="form-group col">
                                    <label>Bill Rate</label>
                                    <input type="text" class="form-control" name="rate" value="<?php echo set_value('rate'); ?>" required placeholder="bill rate"/>
                                </div> 
							-->
                               <div class="form-group col">
                                    <label>Bill Unit</label>
                                    <input type="number" class="form-control" name="unit" value="<?php echo set_value('unit'); ?>" required placeholder="unit"/>
                                </div>
                            
                               <div class="form-group col">
                                    <label>Late Fee</label>
                                    <input type="number" class="form-control" id="late_fee" name="late_fee" value="<?php echo set_value('late_fee'); ?>" required placeholder="Late Fee"/>
                                </div>
                               <div class="form-group col">
                                    <label>Total Amount</label>
                                    <input type="number" class="form-control" id="total_amount" name="total_amount" value="<?php echo set_value('total_amount'); ?>" required placeholder="total amount"/>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <div>
                                    <button type="submit" class="btn btn-primary btn-rounded pull-right waves-effect waves-light">Submit</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('includes/footer') ;?>
</body>
</html>

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

$(document).ready(function(){
  $("#late_fee").keyup(function(){
		var bill_amount = $('#bill_amount').val();
		var late_fee = $('#late_fee').val();
		var total = parseInt(bill_amount) + parseInt(late_fee);
		$('#total_amount').val(total);
  });
});



function getBillValue(){
	var id = $("#mySelectBill").val();
  $.ajax({
      url: "<?=base_url('BillGenerated/getBillValue')?>",
      type: "POST",
      dataType: "text",
      data: {"id": id},
      success: function(data){
    	$(".mybiltypeselect").html(data);
      },
      error: function(error){
     console.log("Error:");
     console.log(error);
      }
  });
}





 jQuery( function() {
	 jQuery( "#bill_generated_date" ).datepicker({
		  dateFormat: 'yy-mm-dd'
		}).val();

	 jQuery( "#due_date" ).datepicker({
		 dateFormat: 'yy-mm-dd'
	 }).val();

 } );







 $(function() {
    $('.date-picker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd',
        onClose: function(dateText, inst) {
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });
});

</script>
