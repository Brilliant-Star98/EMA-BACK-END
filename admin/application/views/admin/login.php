<?php $this->load->view('includes/header'); ?>
<body class="sticky-header">
<body class="sticky-header">
        <section class="bg-login">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="wrapper-page">
                            <div class="account-pages">
                                <div class="account-box">
                                <div class="card-title text-center" style=" background: #2e61f2; padding-top: 13px; margin-bottom: 0px;"  >
                                                <img src="<?= base_url();?>assets/images/logo_sm.png" alt="" class="">
                                            </div>
                                    <div class="card m-b-30">
                                        <div class="card-body">

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
                                          <?php echo $error; ?>
                                          </div>
                                          <?php }
                                          $success = $this->session->flashdata('success');
                                          if($success)
                                          {
                                          ?>
                                          <div class="alert alert-success alert-dismissable">
                                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                          <?php echo $success; ?>
                                          </div>
                                          <?php } ?>

                                            <div class="card-title pl-3">
                                                <h5 class="mt-3"><b>Welcome to Ema</b></h5>
                                            </div>
                                            <form class="form mt-5 contact-form" method="post" action="<?php echo base_url(); ?>loginMe">
                                                <div class="form-group ">
                                                    <div class="col-sm-12">
                                                      <input class="form-control form-control-line" name="email" id="exampleInputEmail1" type="email" placeholder="Email Address" autocomplete="off" required="@.com">
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="col-sm-12">
                                                      <input name="password" class="form-control form-control-line" id="exampleInputPassword1" type="password" placeholder="Password" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12 mt-4">
                                                        <button class="btn btn-primary btn-block" type="submit">Log In</button>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12 mt-4 text-center">
                                                      <a href="<?php echo base_url(); ?>forgotPassword">Forgot password?</a> <br>
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
