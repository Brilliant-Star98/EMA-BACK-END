<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Vault</title>
<link href="<?=base_url()?>assets/styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php $this->load->helper("form"); ?>
<form method="post" action="<?php echo base_url() ?>addNewUser" data-parsley-validate="" novalidate="" enctype="multipart/form-data">
<div class="login">
<?php $this->load->helper('form'); ?>
<div class="logo">Register</div>
<div class="field">
<label>First Name:</label><br>
<input type="text" class="form-control" value="<?php echo set_value('fname'); ?>" id="fname" name="fname" maxlength="128" required>
<?=form_error('fname', '<div class="error">', '</div>');?>
</div>
<div class="field">
<label>Last Name:</label><br>
<input type="text" class="form-control" value="<?php echo set_value('lname'); ?>" id="lname" name="lname" maxlength="128" required>
<?=form_error('lname', '<div class="error">', '</div>');?>
</div>
<div class="field">
<label>Your Email address:</label><br>
<input type="email" class="form-control" id="email" value="<?php echo set_value('email'); ?>" name="email" maxlength="128" required>
<?=form_error('email', '<div class="error">', '</div>');?>
</div>
<div class="field">
<label>Password:</label><br>
<input type="password" class="form-control" id="password" name="password" maxlength="20" required>
<?=form_error('password', '<div class="error">', '</div>');?>
</div>
<div class="field">
<label>Repeat Password:</label><br>
<input type="password" class="form-control" id="cpassword" name="cpassword" maxlength="20" data-parsley-equalto="#password" required>
<?=form_error('cpassword', '<div class="error">', '</div>');?>
</div>
<div class="button">
<button class="btn btn-primary" type="submit">Register</button>
</div>
<div class=""><a href="<?php echo base_url('login'); ?>">Have an account? Login</a></div>
</div>
</form>
<?php $this->load->view('includes/footer') ;?>
