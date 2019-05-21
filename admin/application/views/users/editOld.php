<?php

$userId = '';
$fname = '';
$email = '';
$mobile = '';
$roleId = '';
$contact_email = '';
$website = '';
$address = '';
$image = '';
$facebook_url = '';
$twitter_url = '';
$linkedin_url = '';
$dribble_url = '';
$instagram_url = '';

if(!empty($userInfo))
{
    foreach ($userInfo as $uf)
    {
        $userId = $uf->userId;
        $fname = $uf->fname;
        $lname = $uf->lname;
        $email = $uf->email;
        $address = $uf->address;
        $contact_email = $uf->contact_email;
        $website = $uf->website;
        $image = $uf->profile_image;
        $facebook_url = $uf->facebook_url;
        $twitter_url = $uf->twitter_url;
        $linkedin_url = $uf->linkedin_url;
        $dribble_url = $uf->dribble_url;
        $instagram_url = $uf->instagram_url;
        $mobile = $uf->mobile;
        $roleId = $uf->roleId;
    }
}


?>


<!-- START HEADER-->
<?php   $this->load->view('includes/headerpart') ;?>
<!-- END HEADER-->
</head>
<body>
<div class="wrapper">
<!-- START NAVBAR-->
<?php   $this->load->view('includes/topnav') ;?>
<!-- END NAVBAR-->
<!-- START SIDEBAR-->
<?php   $this->load->view('includes/sidebar') ;?>
<!-- END SIDEBAR-->
<!-- STRAT OFFSIDEBAR-->
<?php   $this->load->view('includes/offsidebar') ;?>
<!-- END OFFSIDEBAR-->
<!-- START MAIN SECTION-->
<section>
   <!-- Page content-->
   <div class="content-wrapper">
      <h3>User Management
         <small>Add / Edit User</small>
      </h3>

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

      <!-- START row-->
      <div class="row">
         <div class="col-lg-12">
           <?php $this->load->helper("form"); ?>
            <form method="post" action="<?php echo base_url() ?>editUser" data-parsley-validate="" novalidate=""  enctype="multipart/form-data">
               <!-- START panel-->
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <div class="panel-title">Enter User Details</div>
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="fname" class="control-label">First Name</label>
                              <input type="text" class="form-control" value="<?php echo $fname; ?>" id="fname" name="fname" maxlength="128" required>
                              <input type="hidden" value="<?php echo $userId; ?>" name="userId" id="userId" />
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="lname" class="control-label">Last Name</label>
                              <input type="text" class="form-control" value="<?php echo $lname; ?>" id="lname" name="lname" maxlength="128" required>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="email" class="control-label">Email address</label>
                              <input type="email" class="form-control" id="email" value="<?php echo $email; ?>" name="email" maxlength="128" required readonly>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="role" class="control-label">Role</label>
                              <select class="form-control" id="role" name="role" required>
                                  <option value="">Select Role</option>
                                  <?php
                                    if(!empty($roles))
                                    {
                                        foreach ($roles as $rl)
                                        {
                                            ?>
                                            <option value="<?php echo $rl->roleId; ?>" <?php if($rl->roleId == $roleId) {echo "selected=selected";} ?>><?php echo $rl->role ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                              </select>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="control-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" maxlength="20" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cpassword" class="control-label">Confirm Password</label>
                                <input type="password" class="form-control" id="cpassword" name="cpassword" maxlength="20" data-parsley-equalto="#password" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile" class="control-label">Mobile Number</label>
                                <input type="number" class="form-control digits" id="mobile" value="<?php echo $mobile; ?>" name="mobile" maxlength="10" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_email" class="control-label">Contact Email</label>
                                <input type="email" class="form-control digits" id="contact_email" value="<?php echo $contact_email; ?>" name="contact_email" maxlength="128" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="website" class="control-label">Website</label>
                                <input type="text" class="form-control digits" id="website" value="<?php echo $website; ?>" name="website" maxlength="128" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <div class="col-md-2">
                                  <img src="<?php echo base_url()."assets/uploads/profile/".$image; ?>" height="50" width="50" alt="Profile Image">
                              </div>
                              <div class="col-md-10">
                                <label for="image" class="control-label">Profile Picture</label>
                                <input type="file" class="form-control digits" id="image" name="image" required accept="image/*">
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="address" class="control-label">Address</label>
                              <textarea class="form-control" id="address" name="address" required><?php echo $address; ?></textarea>
                          </div>
                      </div>
                    </div>

                    <hr>

                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="facebook_url" class="control-label">Facebook URL</label>
                              <input type="text" class="form-control" value="<?php echo $facebook_url; ?>" id="facebook_url" name="facebook_url">
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="twitter_url" class="control-label">Twitter URL</label>
                              <input type="text" class="form-control" value="<?php echo $twitter_url; ?>" id="twitter_url" name="twitter_url">
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="linkedin_url" class="control-label">Linkedin URL</label>
                              <input type="text" class="form-control" value="<?php echo $linkedin_url; ?>" id="linkedin_url" name="linkedin_url">
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="dribble_url" class="control-label">Dribble URL</label>
                              <input type="text" class="form-control" value="<?php echo $dribble_url; ?>" id="dribble_url" name="dribble_url">
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="instagram_url" class="control-label">Instagram URL</label>
                              <input type="text" class="form-control" value="<?php echo $instagram_url; ?>" id="instagram_url" name="instagram_url">
                          </div>
                      </div>
                    </div>


                  </div>
                  <div class="panel-footer">
                     <div class="clearfix">

                       <div class="pull-left">

                       </div>

                        <div class="pull-right">
                           <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- END panel-->
            </form>



         </div>
      </div>
      <!-- END row-->
   </div>
</section>
<!-- END MAIN SECTION-->
<!-- START FOOTER-->
<?php   $this->load->view('includes/footer') ;?>
<!-- END FOOTER-->
</div>
</body>
<!-- START FOOTER SCRIPT-->
<?php   $this->load->view('includes/footerscript') ;?>
<!-- END FOOTER SCRIPT-->
</html>
