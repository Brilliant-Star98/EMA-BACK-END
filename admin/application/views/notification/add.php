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
            <h4 class="mt-2 mb-2">Add Notification Type</h4>
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

		 									<form class="" method="post" action="<?=base_url('add-notification'); ?>" enctype="multipart/form-data">
													 <div class="row">
                               <div class="form-group col">
                                    <label>Notification Title</label>
                                    <input type="text" class="form-control" name="title" value="<?php echo set_value('title'); ?>" required placeholder="Notification title"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label>Description</label>
                                    <div>
                                        <textarea required class="form-control" placeholder="Notification Description" name="description" rows="5"><?php echo set_value('description'); ?></textarea>
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


</body>
</html>
