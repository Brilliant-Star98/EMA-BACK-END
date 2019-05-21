
          <div class="sidebar-left">
                <div class="sidebar-left-info">
                    <ul class="side-navigation">
                        <li class="active">
                            <a href="index.php"><i class="mdi mdi-google-maps"></i> <span>Heat Map</span></a>
                        </li>

                        <?php if ($this->session->userdata('role') == '2') {
    ?>

                        <li class="menu-list"><a href="#"><i class="mdi mdi-account"></i> <span>Add User</span></a>
                            <ul class="child-list">
                                <li><a href="<?=base_url('add-user'); ?>"> Add User</a></li>
                            </ul>
                        </li>
                        <li class="menu-list"><a href="#"><i class="mdi mdi-account"></i> <span>Add Guard</span></a>
                            <ul class="child-list">
                                <li><a href="<?=base_url('add-guard'); ?>"> Add Guard</a></li>
                                <li><a href="<?=base_url('list-guard'); ?>">List Guard</a></li>
                            </ul>
                        </li>
                        <li class="menu-list"><a href="#"><i class="mdi mdi-account"></i> <span>List User</span></a>
                            <ul class="child-list">
                              <li><a href="<?=base_url('approve-users'); ?>">List</a></li>
                            </ul>
                        </li>
                        <li class="menu-list"><a href="#"><i class="mdi mdi-account"></i> <span>Notification</span></a>
                            <ul class="child-list">
                                <li><a href="<?=base_url('add-notification-set'); ?>"> Add Notification</a></li>
                                <li><a href="<?=base_url('list-notification-set'); ?>">List Notification</a></li>
                            </ul>
                        </li>
                        <li class="menu-list"><a href="#"><i class="mdi mdi-account"></i> <span>Bill</span></a>
                            <ul class="child-list">
                                <li><a href="<?=base_url('add-billgenerated'); ?>"> Add Bill</a></li>
                                <li><a href="<?=base_url('list-billgenerated'); ?>">List Bill</a></li>
                            </ul>
                        </li>

                        <li class="menu-list"><a href="#"><i class="mdi mdi-account"></i> <span>Payment</span></a>
                            <ul class="child-list">
                                <li><a href="<?=base_url('list-payment'); ?>">List Payment</a></li>
                            </ul>
                        </li>
                        <li>
                          <a href="<?=base_url('bill-settings'); ?>"><i class="fa fa-fire-extinguisher"></i> <span>Bill Settings</span> </a>
                        </li>
                        <li>
                          <a href="<?=base_url('distress-requests'); ?>"><i class="fa fa-fire-extinguisher"></i> <span>Distress Notification</span> </a>
                        </li>
                        <li>
                          <a href="<?=base_url('logout'); ?>"><i class="fa fa-sign-out"></i> <span>Logout</span> </a>
                        </li>
                      <?php
} ?>


<?php if ($this->session->userdata('role') == '4') {
        ?>

<li class="menu-list"><a href="#"><i class="mdi mdi-account"></i> <span>Add Visitor</span></a>
    <ul class="child-list">
        <li><a href="<?=base_url('add-visitors'); ?>"> Add Visitor</a></li>
        <li><a href="<?=base_url('list-visitors'); ?>"> List Visitor</a></li>
    </ul>
</li>
<li>
  <a href="<?=base_url('logout'); ?>"><i class="fa fa-sign-out"></i> <span>Logout</span> </a>
</li>
<?php
    } ?>

                      <?php if ($this->session->userdata('role') == '1') {
        ?>

                        <li class="menu-list"><a href="#"><i class="mdi mdi-appnet"></i> <span>Agent</span></a>
                            <ul class="child-list">
                                <li><a href="<?=base_url('add-agent'); ?>"> Add Agent</a></li>
                                <li><a href="<?=base_url('list-agent'); ?>">Agent List</a></li>
                            </ul>
                        </li>

                        <li class="menu-list"><a href="#"><i class="mdi mdi-appnet"></i> <span>BillType</span></a>
                            <ul class="child-list">
                                <li><a href="<?=base_url('add-billtype'); ?>"> Add BillType</a></li>
                                <li><a href="<?=base_url('list-billtype'); ?>">List BillType</a></li>
                            </ul>
                        </li>

                        <li class="menu-list"><a href="#"><i class="mdi mdi-appnet"></i> <span>Notification Type</span></a>
                            <ul class="child-list">
                                <li><a href="<?=base_url('add-notification'); ?>"> Add NotificationType</a></li>
                                <li><a href="<?=base_url('list-notification'); ?>">List NotificationType</a></li>
                            </ul>
                        </li>

                         <li class="menu-list"><a href="#"><i class=" mdi mdi-car"></i> <span>Vehicle Entry </span></a>
                            <ul class="child-list">
                                <li><a href="add_vehicle.php"> Add Vehicle</a></li>
                                <li><a href="vehicle_list.php">Vehicle List</a></li>
                            </ul>
                        </li>
                        <li class="menu-list">
                        	<a href="#"><i class="mdi mdi-google-physical-web"></i> <span>Report</span> </a>
                        </li>
                         <li class="menu-list"><a href="#"><i class=" fa fa-money"></i> <span>Payment</span></a>
                            <ul class="child-list">
                                <li><a href="add_user.php"> Add Payment</a></li>
                                <li><a href="eddit_user.php">  Payment List</a></li>
                            </ul>
                        </li>
                        <li>
                          <a href="<?=base_url('logout'); ?>"><i class="fa fa-sign-out"></i> <span>Logout</span> </a>
                        </li>
                          <?php
    } ?>

                    </ul>
                </div>
        </div>
