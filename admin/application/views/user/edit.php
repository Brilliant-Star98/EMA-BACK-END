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

                        <form class="" method="post" action="<?=base_url('edit-user/'); ?>?id=<?=$AddUser[0]->userId; ?>" enctype="multipart/form-data">
                           <div class="row">
                               <div class="form-group col">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="fname" value="<?=$AddUser[0]->fname; ?>" required placeholder="First Name"/>
                                </div>

                                <div class="form-group col">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="lname" value="<?=$AddUser[0]->lname; ?>" required placeholder="Last Name"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col">
                                    <label>E-Mail</label>
                                    <div>
                                        <input type="email" name="email" class="form-control" value="<?=$AddUser[0]->email; ?>" required parsley-type="email" placeholder="Enter e-mail"/>
                                    </div>
                               </div>
                                <div class="form-group col">
                                    <label>Alternate E-Mmail</label>
                                    <div>
                                        <input type="email" name="contact_email" class="form-control" value="<?=$AddUser[0]->contact_email; ?>" parsley-type="email" placeholder="Enter e-mail"/>
                                    </div>
                                </div>
                            </div>

														<?php
														$bit = $getBillType[0]->billtype;
														$exp =  explode(',',$bit);
														?>

														<div class="row">
															<div class="form-group col">
															 <label>Bill Type</label>
																<div>
															<?php foreach ($BillType as $Bill): ?>
																	<input <?php if(in_array($Bill->id,$exp)){echo "Checked";} ?> type="checkbox" name="billtype[]" value="<?= $Bill->id; ?>"> <?= $Bill->bill_title; ?>
															<?php endforeach; ?>
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
                                        <input parsley-type="text" name="mobile" type="text" value="<?=$AddUser[0]->mobile; ?>" class="form-control" required placeholder="Mobile Number"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>House Number</label>
                                    <div>
                                        <input parsley-type="text" name="house_number" type="text" value="<?=$AddUser[0]->house_number; ?>" class="form-control" placeholder="House Number"/>
                                    </div>
                                </div>
                            </div>

														<div class="row">
															<div class="form-group col">
																		<label>Street</label>
																		<div>
																				<input parsley-type="text" name="street" type="text" value="<?=$AddUser[0]->street; ?>" class="form-control" required placeholder="Street"/>
																		</div>
																</div>
																<div class="form-group col">
																		<label>Court</label>
																		<div>
																				<input parsley-type="text" name="court" type="text" value="<?=$AddUser[0]->court; ?>" class="form-control" required placeholder="Court"/>
																		</div>
																</div>
														</div>


                            <div class="row">
                                <div class="form-group col">
                                    <label>Password</label>
                                    <div>
                                        <input parsley-type="password" name="password" type="password" value="<?php echo set_value('password'); ?>" class="form-control" placeholder="Password"/>
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <label>Confirm Password</label>
                                    <div>
                                        <input parsley-type="password" name="confirm_password" value="<?php echo set_value('confirm_password'); ?>" type="password" class="form-control" placeholder="Confirm Password"/>
                                    </div>
                                </div>
                            </div>


									<div class="row">
										 <div class="col-md-12">
												 <div class="form-group">
														 <label for="address" class="control-label">Address*</label>
														 <input type="text" class="form-control" value="<?=$AddUser[0]->full_address; ?>" id="us2-address" name="address" required>
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
																				<img src="<?=base_url('assets/uploads/');?><?=$AddUser[0]->profile_picture; ?>" alt="" width="200">
																		 </div>
																		 </div>

                            </div>


														<div class="row">
														 <div class="col-md-12">
														 <h4>Residents Details</h4>

															<a href="javascript:void(0)" class="btn btn-success addMore"><span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> +Add New</a>
															<br><br>

															<div class="form-group fieldGroup" style="display: none;">

															</div>

															<?php
														if($AddUser[0]->residents != ''){
														$jdecod = json_decode($AddUser[0]->residents);

														foreach ($jdecod as $resident): ?>
															 <div class="form-group fieldGroup">
															 <div class="input-group">
																<input type="text" name="name[]" class="form-control" value="<?php echo $resident->name; ?>" placeholder="Enter Name" required/>

																<select class="form-control" name="gender[]" required>
																<option>Select Gender</option>
																<option <?php if($resident->gender == 'Male'){echo "Selected";} ?> value="Male">Male</option>
																<option <?php if($resident->gender == 'Female'){echo "Selected";} ?> value="Female">Female</option>
																</select>

																<input type="number" name="pcontact[]" class="form-control" value="<?php echo $resident->pcontact; ?>" placeholder="Primary Contact" required/>

																<input type="number" name="scontact[]" class="form-control" value="<?php echo $resident->scontact; ?>" placeholder="Secondry Contact"/>

															 <div class="input-group-addon">
															 <a href="javascript:void(0)" class="btn btn-danger remove"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a>
															 </div>
															 </div>
															 </div>
														<?php endforeach; }?>

														</div>
													 </div>



                            <div class="form-group mb-0">
                                <div>
                                    <button type="submit" class="btn btn-primary btn-rounded pull-right waves-effect waves-light">Update</button>
                                </div>
                            </div>
                        </form>

												<div class="form-group fieldGroupCopy" style="display: none;">
												<div class="input-group">
												<input type="text" name="name[]" class="form-control" placeholder="Enter Name" required/>
												<select class="form-control" name="gender[]" required>
												<option selected>Select Gender</option>
												<option value="Male">Male</option>
												<option value="Female">Female</option>
												</select>

												<input type="number" name="pcontact[]" class="form-control" placeholder="Primary Contact" required/>
												<input type="number" name="scontact[]" class="form-control" placeholder="Secondry Contact"/>

												<div class="input-group-addon">
												<a href="javascript:void(0)" class="btn btn-danger remove"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a>
												</div>
												</div>
												</div>

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
		$("#demo").intlTelInput("setCountry", "<?= $AddUser[0]->short_code != ''? $AddUser[0]->short_code : "gb" ?>");
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
        latitude: <?=$AddUser[0]->latitude != '' ? $AddUser[0]->latitude : '-0.371266'; ?>,
        longitude: <?=$AddUser[0]->longitude != '' ? $AddUser[0]->longitude : '39.273938'; ?>
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


<script type="text/javascript">
$(document).ready(function(){

    var maxGroup = 10;

    $(".addMore").click(function(){
        if($('body').find('.fieldGroup').length < maxGroup){
            var fieldHTML = '<div class="form-group fieldGroup">'+$(".fieldGroupCopy").html()+'</div>';
            $('body').find('.fieldGroup:last').after(fieldHTML);
        }else{
            alert('Maximum '+maxGroup+' groups are allowed.');
        }
    });

    //remove fields group
    $("body").on("click",".remove",function(){
        $(this).parents(".fieldGroup").remove();
    });
});
</script>

</body>
</html>
