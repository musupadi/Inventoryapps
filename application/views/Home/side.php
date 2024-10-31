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
          <p><?php echo  $data->nama?></p>
                <?php } ?>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li><a href="<?php echo base_url("Home")?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        <li class="treeview">
          <a href="#">
            <i class="fa  fa-newspaper-o"></i> <span>Berita</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('Berita')?>"><i class="fa fa-list"></i>List Berita</a></li>
            <li><a href="<?php echo base_url('Berita/Postberita')?>"><i class="fa fa-map-pin"></i>Post Berita</a></li>
            <li><a href="<?php echo base_url('Berita/Kategori')?>"><i class="fa fa-wrench"></i>Kategori</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bank"></i> <span>Data Kampus</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?php echo base_url('Matakuliah')?>"><i class="fa fa-book"></i>Mata Kuliah</a></li>
            <li><a href="<?php echo base_url('Jurusan')?>"><i class="fa fa-mortar-board"></i>Jurusan</a></li>
            <li><a href="<?php echo base_url('Kelas')?>"><i class="fa fa-users"></i>Kelas</a></li>
            <li><a href="<?php echo base_url('Ruang')?>"><i class="fa fa-users"></i>Ruang</a></li>
            <li><a href="<?php echo base_url('Dosen')?>"><i class="fa fa-users"></i>Dosen</a></li>
          </ul>
        </li>
        <li><a href="<?php echo base_url("Jadwal")?>"><i class="fa fa-clock-o"></i> <span>Jadwal Kuliah</span></a></li>
        <li><a href="<?php echo base_url("Ujian")?>"><i class="fa fa-calendar"></i> <span>Jadwal Ujian</span></a></li>
        <li><a href="<?php echo base_url("Feedback")?>"><i class="fa fa-envelope"></i> <span>Feedback</span></a></li>
        <li class="active"><a href="<?php echo base_url("About")?>"><i class="fa fa-user"></i> <span>About</span></a></li>
        <li><a href="<?php echo base_url("Login/logout")?>"><i class="fa fa-user-times"></i> <span>Sign Out</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->