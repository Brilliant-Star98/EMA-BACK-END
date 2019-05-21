<?php
if ($this->session->userdata('role') != '1') {
	redirect('dashboard');
}
?>
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

                        <form class="" method="post" action="<?=base_url('edit-billtype/'); ?>?id=<?=$BillType[0]->id; ?>" enctype="multipart/form-data">

														<div class="row">
                                <div class="form-group col">
                                     <label>Bill Title</label>
                                     <input type="text" class="form-control" name="bill_title" value="<?=$BillType[0]->bill_title; ?>" required placeholder="bill title"/>
                                 </div>

 																<div class="form-group col">
 																			<label>Bill Logo</label>
 																			<div>
 																				<input type="file" name="image">
 																			</div>
																			<div class="form-group col">
																				<img src="<?=base_url('assets/uploads/');?><?=$BillType[0]->bill_logo; ?>" alt="" width="200">
																		 </div>
 																	</div>
                             </div>

														 <div class="row">
 																<div class="form-group col-md-2">
 																		 <label>Manual Bill
 																		 <input type="radio" name="ismanual" value="0" <?php if($BillType[0]->ismanual == '0'){ echo "checked"; } ?>/>
 																		 </label>
 																 </div>

 																<div class="form-group col-md-2">
 																		 <label>Fixed Bill
 																		 <input type="radio" name="ismanual" value="1" <?php if($BillType[0]->ismanual == '1'){ echo "checked"; } ?>/>
 																		 </label>
 																 </div>

 														 </div>

                             <div class="row">
                                 <div class="form-group col">
                                     <label>Description</label>
                                     <div>
                                         <textarea required class="form-control" name="bill_description" rows="5"><?=$BillType[0]->bill_description; ?></textarea>
                                     </div>
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB55Pqo39oh9l7IDU0-NIhS5RrLv-DJgKs&&libraries=places" type="text/javascript"></script>
        <script src="<?=base_url(); ?>assets/js/bootstrap-tagsinput.min.js"></script>
        <script src="<?=base_url(); ?>assets/js/locationpicker.jquery.min.js"></script>

<script>
$( document ).ready(function() {
$('#us2').locationpicker({
    location: {
        latitude: <?=$BillType[0]->latitude; ?>,
        longitude: <?=$BillType[0]->longitude; ?>
    },
    radius: 300,
    inputBinding: {
        latitudeInput: $('#us2-lat'),
        longitudeInput: $('#us2-lon'),
        radiusInput: $('#us2-radius'),
        locationNameInput: $('#us2-address')
    },
    enableAutocomplete: true,
    zoomControl: true,
  scaleControl: true
});
});
</script>
</body>
</html>
