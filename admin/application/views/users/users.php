<!-- START HEADER-->
<?php   $this->load->view('includes/headerpart') ;?>
<!-- END HEADER-->
<!-- DATATABLES-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/datatables-colvis/css/dataTables.colVis.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/datatables/media/css/dataTables.bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/dataTables.fontAwesome/index.css">
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
        <small>Add, Edit, Delete</small>
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

      <div class="container-fluid">

        <!-- START DATATABLE 1-->
        <div class="row">
           <div class="col-lg-12">
              <div class="panel panel-default">
                 <div class="panel-heading">Dashboard |
                    <small>Users</small>
                 </div>
                 <div class="panel-body">
                    <div class="table-responsive">
                       <table class="table table-striped table-hover" id="datatable1">
                          <thead>
                            <tr>
                              <th>Id</th>
                              <th>First Name</th>
                              <th>Last Name</th>
                              <th>Email</th>
                              <th>Mobile</th>

                              <th class="text-center">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                             <?php
                             if(!empty($userRecords))
                             {
                            foreach($userRecords as $record)
                            {
                             ?>
                             <tr class="gradeX">
                               <td><?php echo $record->userId ?></td>
                               <td><?php echo $record->fname ?></td>
                               <td><?php echo $record->lname ?></td>
                               <td><?php echo $record->email ?></td>
                               <td><?php echo $record->mobile ?></td>


                               		<input type="hidden" id="<?php echo "user1".$record->userId;  ?>" name="status" value="<?php echo $record->userId;  ?>">
                               		<input type="hidden" id="<?php echo "user2".$record->userId;  ?>" name="status" value="<?php echo $record->fname;  ?>">
                               		<input type="hidden" id="<?php echo "user3".$record->userId;  ?>" name="status" value="<?php echo $record->lname;  ?>">
                               		<input type="hidden" id="<?php echo "user4".$record->userId;  ?>" name="status" value="<?php echo $record->email;  ?>">
                               		<input type="hidden" id="<?php echo "user5".$record->userId;  ?>" name="status" value="<?php echo $record->mobile;  ?>">
                               		<input type="hidden" id="<?php echo "user6".$record->userId;  ?>" name="status" value="<?php echo $record->website;  ?>">
                               		<input type="hidden" id="<?php echo "user7".$record->userId;  ?>" name="status" value="<?php echo $record->address;  ?>">
                               		<input type="hidden" id="<?php echo "user8".$record->userId;  ?>" name="status" value="<?php echo $record->facebook_url;  ?>">
                               		<input type="hidden" id="<?php echo "user9".$record->userId;  ?>" name="status" value="<?php echo $record->twitter_url;  ?>">
                               		<input type="hidden" id="<?php echo "user10".$record->userId;  ?>" name="status" value="<?php echo $record->linkedin_url;  ?>">
                               		<input type="hidden" id="<?php echo "user11".$record->userId;  ?>" name="status" value="<?php echo $record->dribble_url;  ?>">
                               		<input type="hidden" id="<?php echo "user12".$record->userId;  ?>" name="status" value="<?php echo $record->instagram_url	;  ?>">
                               		<input type="hidden" id="<?php echo "user13".$record->userId;  ?>" name="status" value="<?php echo $record->profile_image;  ?>">
                               		<input type="hidden" id="<?php echo "user14".$record->userId;  ?>" name="status" value="<?php echo $record->role;  ?>">

                               <td class="text-center">
                                <a class="btn btn-sm btn-info" onclick="setvaluemodel(<?php echo $record->userId; ;  ?>)" title="View"><i class="fa fa-eye"></i></a>
                               </td>
                             </tr>
                             <?php  } }  ?>
                          </tbody>
                       </table>
                    </div>
                 </div>
              </div>
           </div>
        </div>
        <!-- END DATATABLE 1-->

      </div>
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
<?php   $this->load->view('includes/datatablescripts') ;?>

</html>



<script>
function setvaluemodel(id)
{
  var td1 = "#user1"+id ;
  var td2 = "#user2"+id ;
  var td3 = "#user3"+id ;
  var td4 = "#user4"+id ;
  var td5 = "#user5"+id ;
  var td6 = "#user6"+id ;
  var td7 = "#user7"+id ;
  var td8 = "#user8"+id ;
  var td9 = "#user9"+id ;
  var td10 = "#user10"+id ;
  var td11 = "#user11"+id ;
  var td12 = "#user12"+id ;
  var td13 = "#user13"+id ;
  var td14 = "#user14"+id ;



  $("#userid").text($(td1).val()) ;
  $("#fname").text($(td2).val()) ;
  $("#lname").text($(td3).val()) ;
  $("#email").text($(td4).val()) ;
  $("#mobile").text($(td5).val()) ;
  $("#website").attr("href",$(td6).val()) ;
  $("#address").text($(td7).val()) ;
  $("#facebook_url").attr("href", $(td8).val()) ;
  $("#twitter_url").attr("href", $(td9).val()) ;
  $("#linkedin_url").attr("href", $(td10).val()) ;
  $("#dribble_url").attr("href", $(td11).val()) ;
  $("#instagram_url").attr("href", $(td12).val()) ;
  $("#role").val($(td14).val()) ;


$('#myModal').modal('show');

}
</script>




<!-- Modal -->
	<div class="modal left fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">App User Details</h4>
				</div>

				<div class="modal-body">
          <p><strong>Name : </strong> <span id="fname"></span> <span id="lname"></span></p>
          <p><strong>Email : </strong> <span id="email"></span></p>
          <p><strong>Mobile : </strong> <span id="mobile"></span></p>
          <p><strong>Address : </strong> <span id="address"></span></p>
          <ul style="list-style:none;">
            <li> <a target="_blank" href="#" id="website">Website</a></li>
            <li> <a target="_blank" href="#" id="facebook_url">Facebook</a></li>
            <li> <a target="_blank" href="#" id="twitter_url">Twitter</a></li>
            <li> <a target="_blank" href="#" id="linkedin_url">LinkedIN</a></li>
            <li> <a target="_blank" href="#" id="dribble_url">Dribble</a></li>
            <li> <a target="_blank" href="#" id="instagram_url">Instagram</a></li>
          </ul>

				</div>

			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div><!-- modal -->























  <style media="screen">
  .modal.left .modal-dialog,
.modal.right .modal-dialog {
  position: fixed;
  margin: auto;
  width: 320px;
  height: 100%;
  -webkit-transform: translate3d(0%, 0, 0);
      -ms-transform: translate3d(0%, 0, 0);
       -o-transform: translate3d(0%, 0, 0);
          transform: translate3d(0%, 0, 0);
}

.modal.left .modal-content,
.modal.right .modal-content {
  height: 100%;
  overflow-y: auto;
}

.modal.left .modal-body,
.modal.right .modal-body {
  padding: 15px 15px 80px;
}

/*Left*/
.modal.left.fade .modal-dialog{
  left: -320px;
  -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
     -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
       -o-transition: opacity 0.3s linear, left 0.3s ease-out;
          transition: opacity 0.3s linear, left 0.3s ease-out;
}

.modal.left.fade.in .modal-dialog{
  left: 0;
}

/*Right*/
.modal.right.fade .modal-dialog {
  right: -320px;
  -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
     -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
       -o-transition: opacity 0.3s linear, right 0.3s ease-out;
          transition: opacity 0.3s linear, right 0.3s ease-out;
}

.modal.right.fade.in .modal-dialog {
  right: 0;
}

/* ----- MODAL STYLE ----- */
.modal-content {
  border-radius: 0;
  border: none;
}

.modal-header {
  border-bottom-color: #EEEEEE;
  background-color: #FAFAFA;
}
  </style>
