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




                        <form class="" method="post" action="<?=base_url('add-billtype'); ?>" enctype="multipart/form-data">
													 <div class="row">
                               <div class="form-group col">
                                    <label>Bill Title</label>
                                    <input type="text" class="form-control" name="bill_title" value="<?php echo set_value('bill_title'); ?>" required placeholder="bill title"/>
                                </div>

																<div class="form-group col">
																			<label>Bill Logo</label>
																			<div>
																				<input type="file" name="image" required="required">
																			</div>
																	</div>
                            </div>

														<div class="row">
																<div class="form-group col-md-2">
																		 <label>Manual Bill
																		 <input type="radio" name="ismanual" value="0" required/>
																		 </label>
																 </div>

																<div class="form-group col-md-2">
																		 <label>Fixed Bill
																		 <input type="radio" name="ismanual" value="1" required/>
																		 </label>
																 </div>

														 </div>


                            <div class="row">
                                <div class="form-group col">
                                    <label>Description</label>
                                    <div>
                                        <textarea required class="form-control" name="bill_description" rows="5"><?php echo set_value('bill_description'); ?></textarea>
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
            </div> <!-- end col -->
        </div>
    </div>
</div>
<?php $this->load->view('includes/footer') ;?>


</body>
</html>
