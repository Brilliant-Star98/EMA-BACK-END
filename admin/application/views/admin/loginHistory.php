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
     <h3>Login History
        <small>Track login history</small>
     </h3>

     <div class="row col-lg-12">
       <form action="<?php echo base_url() ?>login-history" method="POST" id="searchList">
         <div class="col-md-2 col-md-offset-4 form-group">
           <input for="fromDate" type="text" name="fromDate" value="<?php echo $fromDate; ?>" class="form-control datepicker" placeholder="From Date"/>
         </div>
         <div class="col-md-2 form-group">
           <input id="toDate" type="text" name="toDate" value="<?php echo $toDate; ?>" class="form-control datepicker" placeholder="To Date"/>
         </div>
         <div class="col-md-3 form-group">
           <input id="searchText" type="text" name="searchText" value="<?php echo $searchText; ?>" class="form-control" placeholder="Search Text"/>
         </div>
         <div class="col-md-1 form-group">
           <button type="submit" class="btn btn-md btn-default btn-block searchList pull-right"><i class="fa fa-search"></i></button>
         </div>
       </form>
     </div>
      <div class="container-fluid">

        <!-- START DATATABLE 1-->
        <div class="row">
           <div class="col-lg-12">
              <div class="panel panel-default">
                 <div class="panel-heading"><?= $userInfo->fname ?> |
                    <small><?= $userInfo->email ?></small>
                 </div>
                 <div class="panel-body">
                    <div class="table-responsive">
                       <table class="table table-striped table-hover" id="datatable1">
                          <thead>
                            <tr>
                              <th>Session Data</th>
                              <th>IP Address</th>
                              <th>User Agent</th>
                              <th>Agent Full String</th>
                              <th>Platform</th>
                              <th>Date-Time</th>
                            </tr>
                          </thead>
                          <tbody>
                              <?php
                              if(!empty($userRecords))
                              {
                                  foreach($userRecords as $record)
                                  {
                              ?>
                              <tr>
                                <td><?php echo $record->sessionData ?></td>
                                <td><?php echo $record->machineIp ?></td>
                                <td><?php echo $record->userAgent ?></td>
                                <td><?php echo $record->agentString ?></td>
                                <td><?php echo $record->platform ?></td>
                                <td><?php echo $record->createdDtm ?></td>
                              </tr>
                              <?php
                                  }
                              }
                              ?>
                          </tbody>
                       </table>

                         <?php //echo $this->pagination->create_links(); ?>
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
