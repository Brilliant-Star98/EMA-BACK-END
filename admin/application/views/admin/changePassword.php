<?php $this->load->view('includes/header') ;?>
<body class="sticky-header">
<?php $this->load->view('includes/nav') ;?>
<?php $this->load->view('includes/sidebar') ;?>

<section class="bg-login">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="wrapper-page">
                    <div class="account-pages">
                        <div class="account-box">
                            <div class="card m-b-30">
                                <div class="card-body">

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

                                  <?php
                                      $noMatch = $this->session->flashdata('nomatch');
                                      if($noMatch)
                                      {
                                  ?>
                                  <div class="alert alert-warning alert-dismissable">
                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                      <?php echo $this->session->flashdata('nomatch'); ?>
                                  </div>
                                  <?php } ?>
                                  <div class="card-title text-center">
                                      <h5 class="mt-3"><b>Change Password</b></h5>
                                  </div>

          <form class="form mt-5 contact-form" action="<?php echo base_url() ?>changePassword" method="post">
          <div class="form-group ">
              <div class="col-sm-12">
                <input type="password" class="form-control" id="inputOldPassword" placeholder="Old password" name="oldPassword" maxlength="20" required>
              </div>
          </div>
          <div class="form-group ">
              <div class="col-sm-12">
                <input type="password" class="form-control" id="inputPassword1" placeholder="New password" name="newPassword" maxlength="20" required>
              </div>
          </div>
          <div class="form-group ">
              <div class="col-sm-12">
                <input type="password" class="form-control" id="inputPassword2" placeholder="Confirm new password" name="cNewPassword" maxlength="20" required>
              </div>
          </div>
          <div class="form-group">
              <div class="row  mt-4">
                  <div class="col-md-6">
                <input type="submit" class="btn btn-primary btn-block btn-rounded btn-lg" value="Submit" />
              </div>
              <div class="col-md-6">
                <input type="reset" class="btn btn-default btn-block btn-rounded btn-lg" value="Reset" />
                </div>
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

<?php $this->load->view('includes/footer') ;?>
</body>
</html>
