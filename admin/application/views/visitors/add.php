<?php
if ($this->session->userdata('role') != '4') {
    redirect('dashboard');
}
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/bootstrap-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/github.min.css">


<?php $this->load->view('includes/header') ;?>
<body class="sticky-header">
<?php $this->load->view('includes/nav') ;?>
<?php $this->load->view('includes/sidebar') ;?>
<div class="body-content">
	<div class="container-fluid">
    	<div class="page-head">
            <h4 class="mt-2 mb-2">Add Visitors</h4>
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




                        <form class="" method="post" action="<?=base_url('add-visitors'); ?>" enctype="multipart/form-data">

							<div class="row">
                               <div class="form-group col">
                                    <label>Visitor Name</label>
                                    <input type="text" class="form-control" name="visitor_name" value="<?php echo set_value('visitor_name'); ?>" required placeholder="visitor name"/>
                                </div>

                               <div class="form-group col">
                                    <label>Visit To</label>
									<select class="form-control" name="visit_to" required>
										<option value="">Select One</option>
										<?php foreach($usersData as $user){
											echo '<option value="'.$user->userId.'">'.$user->fname.' '.$user->lname.'</option>';
										}?>
									  </select>

                                </div>
                            </div>

                            <div class="row">
							                <div class="form-group col">
                                  <label>Gender</label>
                                  <select class="form-control" name="gender" required>
                                    <option  value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                  </select>
                            </div>
                            </div>

                            <div class="row">
                              <div class="form-group col">
                                 <label>Entry Date</label>
                                 <input type="text" id="date_in" class="form-control" name="date_in" value="<?php echo set_value('date_in'); ?>" required placeholder="Date Entry"  autocomplete="off"/>
                             </div>
                              <div class="form-group col">
                                 <label>Exit Date</label>
                                 <input type="text" id="date_out" class="form-control" name="date_out" value="<?php echo set_value('date_out'); ?>" required placeholder="Date Exit"  autocomplete="off"/>
                             </div>
                            </div>

                            <div class="row">
							 <div class="form-group col">
                                  <label>Time In</label>
								  <div class="input-group " data-placement="left" data-align="top" data-autoclose="true">
										<input id="single-input" type="text" name="time_in" class="form-control" value="" placeholder="Now" autocomplete="off">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-time"></span>
										</span>
									</div>
                            </div>
                           <div class="form-group col">
                                  <label>Time Out</label>
								    <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
										<input  type="text" name="time_out" class="form-control" value="" placeholder="Now"  autocomplete="off">
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-time"></span>
										</span>
									</div>

                            </div>
                            </div>

                            <div class="row">
                            <div class="form-group col">
                                   <label>Mobile</label>
                                   <input type="number" class="form-control" name="mobile" value="<?php echo set_value('mobile'); ?>" required placeholder="mobile"/>
                               </div>
                            <div class="form-group col">
                                   <label>Vical Number</label>
                                   <input type="text" class="form-control" name="vical_no" value="<?php echo set_value('vical_no'); ?>" required placeholder="Vical Number"/>
                               </div>
                            </div>



                            <div class="form-group mb-0">
                                <div>
                                    <button type="submit" class="btn btn-primary btn-rounded pull-right waves-effect waves-light">Submit</button>
                                </div>
                            </div>

                        </form>




<script type="text/javascript">
var input = $('#single-input').clockpicker({
    placement: 'bottom',
    align: 'left',
    autoclose: true,
    'default': 'now'
});

$('.clockpicker').clockpicker();
</script>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>
<?php $this->load->view('includes/footer') ;?>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $( function() {
    $( "#date_out" ).datepicker({dateFormat: 'dd-mm-yy'});
  } );
  $( function() {
    $( "#date_in" ).datepicker({dateFormat: 'dd-mm-yy'});
  } );
</script>


<script type="text/javascript" src="<?=base_url();?>assets/js/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker()
	.find('input').change(function(){
		console.log(this.value);
	});
var input = $('#single-input').clockpicker({
	placement: 'bottom',
	align: 'left',
	autoclose: true,
	'default': 'now'
});

$('.clockpicker-with-callbacks').clockpicker({
		donetext: 'Done',
		init: function() {
			console.log("colorpicker initiated");
		},
		beforeShow: function() {
			console.log("before show");
		},
		afterShow: function() {
			console.log("after show");
		},
		beforeHide: function() {
			console.log("before hide");
		},
		afterHide: function() {
			console.log("after hide");
		},
		beforeHourSelect: function() {
			console.log("before hour selected");
		},
		afterHourSelect: function() {
			console.log("after hour selected");
		},
		beforeDone: function() {
			console.log("before done");
		},
		afterDone: function() {
			console.log("after done");
		}
	})
	.find('input').change(function(){
		console.log(this.value);
	});

// Manually toggle to the minutes view
$('#check-minutes').click(function(e){
	// Have to stop propagation here
	e.stopPropagation();
	input.clockpicker('show')
			.clockpicker('toggleView', 'minutes');
});
if (/mobile/i.test(navigator.userAgent)) {
	$('input').prop('readOnly', true);
}
</script>
<script type="text/javascript" src="<?=base_url();?>assets/js/highlight.min.js"></script>
<script type="text/javascript">
hljs.configure({tabReplace: '    '});
hljs.initHighlightingOnLoad();
</script>


</body>
</html>
