
    <section class="content-header">
      <h1>
        User Management
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-newspaper-o"></i>User Management</a></li>
        <li class="active">User</li>
      </ol>
    </section>
  <?php  ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">New User</h3>
            </div>
            <!-- /.box-header -->
            <a href="<?php echo base_url('User/Postuser/')?>" data-target="#modal-success" class="btn btn-success btn-sm" style="width: 100px; margin-left: 10px"><i class="fa fa-fw fa-plus" ></i>New User</a>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Photo</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($Data as $data){

                ?>
                <tr>
                  <td><img class="profile-user-img img-responsive" src="<?php echo base_url()?>img/profile/<?=$data->photo?>" alt="User profile picture"></td>
                  <td style="vertical-align: middle;"><?php echo $data->name?></td>
                  <td style="vertical-align: middle;"><?php echo $data->username?></td>
                  <td style="vertical-align: middle;"><?php echo $data->label?></td>
                  <td style="text-align: center; vertical-align: middle;">
                    <a href="<?php echo base_url('User/Edit/'.$data->id);?>">
                      <i class="fa fa-fw fa-pencil"></i>
                    </a> 
                    <a href="<?php echo base_url('User/Delete/'.$data->id);?>"onclick="return confirm('yakin?');">
                      <i class="fa fa-fw fa-trash"></i>
                    </a>
                    <a href="<?php echo base_url('User/ResetPassword/'.$data->id);?>"onclick="return confirm('yakin ingin mengubah Mereset Password menjadi 123 User ini?');">
                      <i class="fa fa-fw fa-lock"></i>
                    </a>
                    </div>
                    </div>
                  </td>
                </tr>
                <?php  } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Photo</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <?php echo $this->session->flashdata('pesan');?>
            <!-- /.box-body -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

