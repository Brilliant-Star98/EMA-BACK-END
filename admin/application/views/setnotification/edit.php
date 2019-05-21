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
            <h4 class="mt-2 mb-2">Edit Notification</h4>
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

                        <form class="" method="post" action="<?=base_url('edit-notification-set/'); ?>?id=<?=$SetNotification[0]->id; ?>" enctype="multipart/form-data">

													<div class="row">

														<div class="form-group col">
																 <label>Notification To</label>
																 <select id="mySelectBill" class="form-control" name="to" required>
																	<option>Select Notification To</option>
																	<?php foreach ($getUserData as $UserData) { ?>
																		<option <?php if($UserData->userId == $SetNotification[0]->to){echo "Selected";} ?> value="<?=$UserData->userId;?>"><?=$UserData->fname;?> <?=$UserData->lname;?></option>
																	<?php } ?>
																 </select>
														 </div>

															<div class="form-group col">
																	 <label>Select Notification Type</label>
																	 <select id="mySelectBill" class="form-control" name="type" required>
																	 	<option>Select Notification Type</option>
																		<?php foreach ($NotificationType as $Notification) { ?>
																			<option  <?php if($Notification->id == $SetNotification[0]->type){echo "Selected";} ?> value="<?=$Notification->id;?>"><?=$Notification->title;?></option>
																		<?php } ?>
																	 </select>
															 </div>

													 </div>

													 <div class="row">
                               <div class="form-group col">
                                    <label>Notification Title</label>
                                    <input type="text" class="form-control" name="title" value="<?=$SetNotification[0]->title; ?>" required placeholder="Notification Title"/>
                                </div>
																<div class="form-group col">
                                     <label>Notification Message</label>
																		 <textarea class="form-control" name="message" placeholder="Notification Message"><?=$SetNotification[0]->message; ?></textarea>
                                 </div>
                            </div>
                            <div class="form-group mb-0">
                                <div>
                                    <button type="submit" class="btn btn-primary btn-rounded pull-right waves-effect waves-light">Update</button>
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
