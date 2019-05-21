<!DOCTYPE html>
<html>
  <!-- Mirrored from themicon.co/theme/angle/v3.8.3/backend-jquery/app/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 Jan 2018 07:53:25 GMT -->
  <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
     <meta name="description" content="Bootstrap Admin App + jQuery">
     <meta name="keywords" content="app, responsive, jquery, bootstrap, dashboard, admin">
     <title>ETHA - New Password</title>
     <!-- =============== VENDOR STYLES ===============-->
     <!-- FONT AWESOME-->
     <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/font-awesome.min.css">
     <!-- SIMPLE LINE ICONS-->
     <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/simple-line-icons/css/simple-line-icons.css">
     <!-- =============== BOOTSTRAP STYLES ===============-->
     <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css" id="bscss">
     <!-- =============== APP STYLES ===============-->
     <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.css" id="maincss">
  </head>
  <body>
    <div class="wrapper">
       <div class="block-center mt-xl wd-xl">
          <!-- START panel-->
          <div class="panel panel-dark panel-flat">
             <div class="panel-heading text-center">
                <a href="#">
                   <img style="width:100%" class="block-center img-rounded" src="<?php echo base_url(); ?>assets/img/logo.png" alt="Image">
                </a>
             </div>

             <div class="panel-body">
                <p class="text-center pv">SIGN IN TO CONTINUE.</p>

                <?php $this->load->helper('form'); ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
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
                <form action="<?php echo base_url(); ?>createPasswordUser" method="post" class="mb-lg" role="form" data-parsley-validate="" novalidate="">
                   <div class="form-group has-feedback">
                      <input class="form-control" name="email" id="exampleInputEmail1" type="email" placeholder="Enter email" autocomplete="off" value="<?php echo $email; ?>" readonly required>
                      <span class="fa fa-envelope form-control-feedback text-muted"></span>
                      <input name="activation_code" type="hidden" value="<?php echo $activation_code; ?>" required>
                   </div>

                   <div class="form-group has-feedback">
                      <input class="form-control" name="password" id="exampleInputPassword1" type="password" placeholder="Password" required>
                      <span class="fa fa-lock form-control-feedback text-muted"></span>
                   </div>

                   <div class="form-group has-feedback">
                      <input class="form-control" name="cpassword" id="exampleInputPassword1" type="password" placeholder="Password" required>
                      <span class="fa fa-lock form-control-feedback text-muted"></span>
                   </div>

                   <button class="btn btn-block btn-primary mt-lg" type="submit">Submit</button>
                </form>
             </div>
          </div>
          <!-- END panel-->
          <div class="p-lg text-center">
             <span>&copy;</span>
             <span>2017</span>
             <span>-</span>
             <span>ETHA</span>
             <br>
             <span>Admin Dashboard</span>
          </div>
       </div>
    </div>

    <!-- =============== VENDOR SCRIPTS ===============-->
    <!-- MODERNIZR-->
    <script src="<?php echo base_url(); ?>assets/vendor/modernizr/modernizr.custom.js"></script>
    <!-- JQUERY-->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/dist/jquery.js"></script>
    <!-- BOOTSTRAP-->
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/dist/js/bootstrap.js"></script>
    <!-- STORAGE API-->
    <script src="<?php echo base_url(); ?>assets/vendor/jQuery-Storage-API/jquery.storageapi.js"></script>
    <!-- PARSLEY-->
    <script src="<?php echo base_url(); ?>assets/vendor/parsleyjs/dist/parsley.min.js"></script>
    <!-- =============== APP SCRIPTS ===============-->
    <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
  </body>
</html>
