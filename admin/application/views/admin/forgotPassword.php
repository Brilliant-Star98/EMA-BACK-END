<?php $this->load->view('includes/header'); ?>
<body class="sticky-header">
        <section class="bg-login">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="wrapper-page">
                            <div class="account-pages">
                                <div class="account-box">
                                <div class="card-title text-center"  style=" background: #2e61f2; padding-top: 13px; margin-bottom: 0px;">
                                                <img src="assets/images/logo_sm.png" alt="" class="">
                                            </div>
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <div class="card-title  text-center">
                                                <h5 class="mt-3"><b>Reset Password</b></h5>
                                            </div>

                                            <?php $this->load->helper('form'); ?>
                               <div class="row">
                                   <div class="col-md-12">
                                       <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                                   </div>
                               </div>
                               <?php
                               $this->load->helper('form');
                               $error = $this->session->flashdata('error');
                               $send = $this->session->flashdata('send');
                               $notsend = $this->session->flashdata('notsend');
                               $unable = $this->session->flashdata('unable');
                               $invalid = $this->session->flashdata('invalid');
                               if($error)
                               {
                                   ?>
                                   <div class="alert alert-danger alert-dismissable">
                                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                       <?php echo $this->session->flashdata('error'); ?>
                                   </div>
                               <?php }

                               if($send)
                               {
                                   ?>
                                   <div class="alert alert-success alert-dismissable">
                                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                       <?php echo $send; ?>
                                   </div>
                               <?php }

                               if($notsend)
                               {
                                   ?>
                                   <div class="alert alert-danger alert-dismissable">
                                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                       <?php echo $notsend; ?>
                                   </div>
                               <?php }

                               if($unable)
                               {
                                   ?>
                                   <div class="alert alert-danger alert-dismissable">
                                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                       <?php echo $unable; ?>
                                   </div>
                               <?php }

                               if($invalid)
                               {
                                   ?>
                                   <div class="alert alert-warning alert-dismissable">
                                       <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                       <?php echo $invalid; ?>
                                   </div>
                               <?php } ?>


                                              <form class="form mt-5 contact-form" action="<?php echo base_url(); ?>resetPasswordUser" method="post">
                                                <?php echo $this->session->flashdata('send'); ?>
                                                <div class="form-group ">
                                                    <div class="col-sm-12">
                                                      <input class="form-control form-control-line" name="login_email" id="resetInputEmail1" placeholder="Enter Emil Address" type="email" autocomplete="off" required="@.com">
                                                      <?=form_error('login_email', '<div class="error">', '</div>');?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12 mt-4">
                                                        <button class="btn btn-primary btn-block" type="submit">Reset</button>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-sm-12 mt-4 text-center">
                                                      <a href="<?php echo base_url('login'); ?>">Login</a> <br>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="<?= base_url();?>assets/js/jquery-3.2.1.min.js"></script>
        <script src="<?= base_url();?>assets/js/popper.min.js"></script>
        <script src="<?= base_url();?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url();?>assets/js/jquery-migrate.js"></script>
        <script src="<?= base_url();?>assets/js/modernizr.min.js"></script>
        <script src="<?= base_url();?>assets/js/jquery.slimscroll.min.js"></script>
        <script src="<?= base_url();?>assets/js/slidebars.min.js"></script>
        <script src="<?= base_url();?>assets/js/jquery.app.js"></script>
    </body>
</html>
