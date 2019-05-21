<?php
if ($this->session->userdata('role') != '1') {
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
            <h4 class="mt-2 mb-2">Add Agent</h4>
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

                        <form class="" method="post" action="<?=base_url('edit-agent/'); ?>?id=<?=$Agent[0]->userId; ?>" enctype="multipart/form-data">
                           <div class="row">
                               <div class="form-group col">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="fname" value="<?=$Agent[0]->fname; ?>" required placeholder="First Name"/>
                                </div>

                                <div class="form-group col">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="lname" value="<?=$Agent[0]->lname; ?>" required placeholder="Last Name"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col">
                                    <label>E-Mail</label>
                                    <div>
                                        <input type="email" name="email" class="form-control" value="<?=$Agent[0]->email; ?>" required parsley-type="email" placeholder="Enter e-mail"/>
                                    </div>
                               </div>
                                <div class="form-group col">
                                    <label>Alternate E-Mmail</label>
                                    <div>
                                        <input type="email" name="contact_email" class="form-control" value="<?=$Agent[0]->contact_email; ?>" required parsley-type="email" placeholder="Enter e-mail"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
															<div class="form-group col-md-2">
                                  <label>Select Country Code</label>
                                  <div>
                                      <input id="demo" parsley-type="text" name="demo" type="text" value="" class="form-control" required placeholder="Select Country"/>
																			<input type="hidden" id="country_code" name="country_code"/>
																			<input type="hidden" id="country" name="country"/>
																			<input type="hidden" id="short_code" name="short_code"/>
																	</div>
                              </div>
                            	<div class="form-group col-md-4">
                                    <label>Mobile Number</label>
                                    <div>
                                        <input parsley-type="text" name="mobile" type="text" value="<?=$Agent[0]->mobile; ?>" class="form-control" required placeholder="Mobile Number"/>
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <label>Alternate Mobile Number</label>
                                    <div>
                                        <input parsley-type="text" name="alt_mobile" type="text" value="<?=$Agent[0]->alt_mobile; ?>" class="form-control" required placeholder="Alternate Mobile Number"/>
                                    </div>
                                </div>
                            </div>


									<div class="row">
										 <div class="col-md-12">
												 <div class="form-group">
														 <label for="address" class="control-label">Address*</label>
														 <input type="text" class="form-control" value="<?=$Agent[0]->full_address; ?>" id="us2-address" name="address" required>
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
														 <input type="text" class="form-control" value="" id="us2-lat" name="latitude" maxlength="128" required>
												 </div>
										 </div>
										 <div class="col-md-6">
												 <div class="form-group">
														 <label for="longitude" class="control-label">Longitude</label>
														 <input type="text" class="form-control" value="" id="us2-lon" name="longitude" maxlength="128" required>
												 </div>
										 </div>
									 </div>
                            <div class="row">
														<div class="col-md-6">
																<div class="form-group col">
                                  <label>Profile Picture</label>
                                  <div>
																		<input type="file" name="image" >
                                  </div>
	                                </div>
	                                </div>

																	<div class="col-md-6">
																			<div class="form-group col">
																				<img src="<?=base_url('assets/uploads/');?><?=$Agent[0]->profile_picture; ?>" alt="" width="200">
																		 </div>
																		 </div>

                            </div>

                            <div class="row">
                                <div class="form-group col">
                                    <label>Extra Text</label>
                                    <div>
                                        <textarea required class="form-control" name="content" rows="5"><?=$Agent[0]->content; ?></textarea>
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
				<script src="<?=base_url(); ?>assets/js/intlTelInput.js"></script>

				<script>
				$( document ).ready(function() {
				$("#demo").intlTelInput();
				$("#demo").intlTelInput("setCountry", "<?= $Agent[0]->short_code != ''? $Agent[0]->short_code : "gb" ?>");
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
        latitude: <?=$Agent[0]->latitude; ?>,
        longitude: <?=$Agent[0]->longitude; ?>
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
