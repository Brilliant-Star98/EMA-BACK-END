<?php
if ($this->session->userdata('role') != '2') {
    redirect('dashboard');
}
?>
<?php $this->load->view('includes/header') ;?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/intlTelInput.css">
<body class="sticky-header">
<?php $this->load->view('includes/nav') ;?>
<?php $this->load->view('includes/sidebar') ;?>
<div class="body-content">
	<div class="container-fluid">
    	<div class="page-head">
            <h4 class="mt-2 mb-2">Add Guard</h4>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">



											<?php
                 $this->load->helper('form');
                 $error = $this->session->flashdata('error');
                 if ($error) {
                     ?>
		 <div class="alert alert-danger alert-dismissable">
				 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				 <?php echo $this->session->flashdata('error'); ?>
		 </div>
		 <?php
                 } ?>
		 <?php
                 $success = $this->session->flashdata('success');
                 if ($success) {
                     ?>
		 <div class="alert alert-success alert-dismissable">
				 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				 <?php echo $this->session->flashdata('success'); ?>
		 </div>
		 <?php
                 } ?>

		 <div class="row">
				 <div class="col-md-12">
						 <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
				 </div>
		 </div>


                      <form class="" method="post" action="<?=base_url('add-guard'); ?>" enctype="multipart/form-data">
                           <div class="row">
                               <div class="form-group col">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="fname" value="<?php echo set_value('fname'); ?>" required placeholder="First Name"/>
                                </div>

                                <div class="form-group col">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="lname" value="<?php echo set_value('lname'); ?>" required placeholder="Last Name"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col">
                                    <label>E-Mail</label>
                                    <div>
                                        <input type="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>" required parsley-type="email" placeholder="Enter e-mail"/>
                                    </div>
                               </div>
                                <div class="form-group col">
                                    <label>Alternate E-Mail</label>
                                    <div>
                                        <input type="email" name="contact_email" class="form-control" value="<?php echo set_value('contact_email'); ?>" parsley-type="email" placeholder="Enter e-mail"/>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                              <div class="form-group col-md-2">
                                    <label>Select Country Code</label>
                                    <div>
                                        <input id="demo" parsley-type="text" name="demo" type="text" value="<?php echo set_value('demo'); ?>" class="form-control" required placeholder="Select Country"/>
																				<input type="hidden" id="country_code" name="country_code"/>
																				<input type="hidden" id="country" name="country"/>
																				<input type="hidden" id="short_code" name="short_code"/>
																		</div>
                                </div>
																<div class="form-group col-md-4">
	                                    <label>Mobile Number</label>
	                                    <div>
	                                        <input id="mobile" parsley-type="number" name="mobile" type="text" value="<?php echo set_value('mobile'); ?>" class="form-control" required placeholder="Mobile Number"/>
																			</div>
	                                </div>
																<div class="form-group col">
                                    <label>Alternate Mobile Number</label>
                                    <div>
                                        <input parsley-type="text" name="alt_mobile" type="text" value="<?php echo set_value('alt_mobile'); ?>" class="form-control" placeholder="Alternate Mobile Number"/>
                                    </div>
                                </div>
                            </div>

														<!-- <div class="row">
															<div class="form-group col">
																		<label>Street</label>
																		<div>
																				<input parsley-type="text" name="street" type="text" value="<?php echo set_value('street'); ?>" class="form-control" required placeholder="Street"/>
																		</div>
																</div>
																<div class="form-group col">
																		<label>Court</label>
																		<div>
																				<input parsley-type="text" name="court" type="text" value="<?php echo set_value('court'); ?>" class="form-control" required placeholder="Court"/>
																		</div>
																</div>
														</div> -->


                            <div class="row">
                                <div class="form-group col">
                                    <label>Password</label>
                                    <div>
                                        <input parsley-type="password" name="password" type="password" value="<?php echo set_value('password'); ?>" class="form-control" required placeholder="Password"/>
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <label>Confirm Password</label>
                                    <div>
                                        <input parsley-type="password" name="confirm_password" value="<?php echo set_value('confirm_password'); ?>" type="password" class="form-control" required placeholder="Confirm Password"/>
                                    </div>
                                </div>
                            </div>


									<div class="row">
										 <div class="col-md-12">
												 <div class="form-group">
														 <label for="address" class="control-label">Address*</label>
														 <input type="text" class="form-control" value="<?php echo set_value('address'); ?>" id="us2-address" name="address" required>
												 </div>
										 </div>
									 </div>

									 <div class="row">
										 <div class="col-md-12">
												 <div id="us2" style="width: 100%; height: 400px;"></div>
										 </div>
									 </div>

									 <div class="row">
										 <div class="col-md-6">
												 <div class="form-group">
														 <label for="latitude" class="control-label">Latitude</label>
														 <input type="text" class="form-control" value="<?php echo set_value('latitude'); ?>" id="us2-lat" name="latitude" maxlength="128" required>
												 </div>
										 </div>
										 <div class="col-md-6">
												 <div class="form-group">
														 <label for="longitude" class="control-label">Longitude</label>
														 <input type="text" class="form-control" value="<?php echo set_value('longitude'); ?>" id="us2-lon" name="longitude" maxlength="128" required>
												 </div>
										 </div>
									 </div>
                            <div class="row">
																<div class="form-group col">
	                                    <label>Profile Picture</label>
	                                    <div>
																				<input type="file" name="image" required="required">
	                                    </div>
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB55Pqo39oh9l7IDU0-NIhS5RrLv-DJgKs&&libraries=places" type="text/javascript"></script>
<script src="<?=base_url(); ?>assets/js/bootstrap-tagsinput.min.js"></script>
<script src="<?=base_url(); ?>assets/js/locationpicker.jquery.min.js"></script>

<script src="<?=base_url(); ?>assets/js/intlTelInput.js"></script>

<script>
$( document ).ready(function() {
$("#demo").intlTelInput();
$("#demo").intlTelInput("setCountry", "gb");
});

$("#demo").on("countrychange", function(e, countryData) {
console.log(countryData);
$('#demo').val(countryData.name);
$('#country_code').val(countryData.dialCode);
$('#country').val(countryData.name);
$('#short_code').val(countryData.iso2.toUpperCase());
});


</script>

<script>
$( document ).ready(function() {
$('#us2').locationpicker({
    location: {
			latitude:<?php if (set_value('latitude')) {
                     echo set_value('latitude');
                 } else {
                     echo "46.15242437752303";
                 } ?>,
			longitude:<?php if (set_value('longitude')) {
                     echo set_value('longitude');
                 } else {
                     echo "2.7470703125";
                 } ?>
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
