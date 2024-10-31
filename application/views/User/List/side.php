<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
      <?php
                foreach ($user as $data){

                ?>
        <div class="pull-left image">
          <img src="<?php echo base_url();?>img/profile/<?php echo $data->photo ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo  $data->name?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <!-- Super Admin & Admin -->
        <?php if ( $data->id_role == 1 || $data->id_role == 2) : ?>
          <li class=""><a href="<?php echo base_url("Home")?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
          <li class=""><a href="<?php echo base_url("Transaction")?>"><i class="fa fa-exchange"></i> <span>Transaction</span></a></li>
          <li class=""><a href="<?php echo base_url("Announcement")?>"><i class="fa fa-newspaper-o"></i> <span>Announcement</span></a></li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-database"></i> <span>Data Inventory</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class=""><a href="<?php echo base_url("Stock")?>"><i class="fa fa-list-alt"></i> <span>Item Stock</span></a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-briefcase"></i> <span>Master Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class=""><a href="<?php echo base_url('Inventory/item')?>"><i class="fa fa-cube"></i>Item</a></li>
            <li class=""><a href="<?php echo base_url('Inventory/Warehouse')?>"><i class="fa fa-home"></i>Warehouse</a></li>
            <li class=""><a href="<?php echo base_url('Inventory/Category')?>"><i class="fa fa-list"></i>Category</a></li>
            <li class=""><a href="<?php echo base_url('Vendor/List')?>"><i class="fa fa-briefcase"></i>Vendor</a></li>
            <li class=""><a href="<?php echo base_url('Vendor/Origin')?>"><i class="fa fa-archive"></i>Origin</a></li>
            <li class=""><a href="<?php echo base_url('Vendor/Brand')?>"><i class="fa fa-industry"></i>Brand</a></li>
            <li class=""><a href="<?php echo base_url("Home/Location")?>"><i class="fa fa-map"></i>Location</a></li>

          </ul>
        </li>
        <li class="treeview active">
          <?php if ( $data->id_role == 1) : ?>
          <a href="#">
            <i class="fa fa-users"></i> <span>User Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <?php endif ;?>
         <?php if ( $data->id_role == 2 ) : ?>
          <?php endif ;?>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('User/Role')?>"><i class="fa fa-unlock-alt"></i>Role</a></li>
            <li class="active"><a href="<?php echo base_url('User')?>"><i class="fa fa-user"></i>User</a></li>
          </ul>
        </li>
        <li><a href="<?php echo base_url("Home/HistoryTransaction")?>"><i class="fa fa-history"></i> <span>Transaction History</span></a></li>
        <li><a href="<?php echo base_url("Login/logout")?>"onclick="return confirm('are you going to logout?');"><i class="fa fa-user-times"></i> <span>Sign Out</span></a></li>
        <?php endif ?>

        <!-- Admin Warehouse -->
        <?php if ($data->id_role == 3) : ?>
          <li class="active"><a href="<?php echo base_url("Home")?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
          <li class=""><a href="<?php echo base_url("Transaction/trAdminWarehouse")?>"><i class="fa fa-exchange"></i> <span>Transaction</span></a></li>
          <li class=""><a href="<?php echo base_url("Stock/stockAdminWarehouse/" . $data->id)?>"><i class="fa fa-list-alt"></i> <span>Stock</span></a></li>
          <li><a href="<?php echo base_url("Login/logout")?>"onclick="return confirm('are you going to logout?');"><i class="fa fa-user-times"></i> <span>Sign Out</span></a></li>
        <?php endif ?>

        <!-- User -->
        <?php if ($data->id_role == 4) : ?>
          <li class="active"><a href="<?php echo base_url("Home")?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
          <li class=""><a href="<?php echo base_url("Transaction/userTransaction")?>"><i class="fa fa-exchange"></i> <span>Transaction</span></a></li>
          <li><a href="<?php echo base_url("Login/logout")?>"onclick="return confirm('are you going to logout?');"><i class="fa fa-user-times"></i> <span>Sign Out</span></a></li>
        <?php endif ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <?php } ?>
    <!-- Content Header (Page header) -->