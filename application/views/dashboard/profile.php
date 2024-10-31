
    <section class="content-header">
      <h1>
        Data Profile
        <h3 class="box-title">
        </h3>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-balance-scale"></i>Online Shop</a></li>
        <li class="active">Profile</li>
      </ol>
    </section>

    <section class="content">
    <?php
                foreach ($user as $data){

                ?>
      <div class="row">
      <div class="col-md-12">

<!-- Profile Image -->
<div class="box box-primary">
  <div class="box-body box-profile">
    <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url()?>img/profile/<?php echo $data->profile?>" data-toggle="modal" data-target="#modal-warning" alt="User profile picture">
    
    
    <h3 class="profile-username text-center"><?php echo $data->nama ?></h3>
    <p class="text-muted text-center"><?php echo $data->username ?></p>

    <ul class="list-group list-group-unbordered">
      <li class="list-group-item">
        <b>Email</b> <a class="pull-right"><?php echo $data->email?></a>
      </li>
      <li class="list-group-item">
        <b>Wallet</b> <a class="pull-right"><?php echo number_format($data->wallet) ?></a>
      </li>
      <li class="list-group-item">
        <b>User</b> <a class="pull-right">
          <?php if($data->level >1){?>
            User
          <?php }else{ ?>
            Admin
          <?php } ?>
        </a>
      </li>
    </ul>           
    <a href="#" input type ="file" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-primary"><b>Ubah Data</b></a>
    <div class="modal modal-primary fade" id="modal-primary">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ubah Foto</h4>
              </div>
              <div class="modal-body">
              <form role="form" action="<?php echo base_url('Home/changeProfileData/')?>" method="post" >
                  <div class="box-body">
                    <div class="form-group">
                      <label for="text">Nama</label>
                      <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?php echo $data->nama ?>">
                      <p class="text-red"><?php echo form_error('nama')?></p>
                    </div>
                    <div class="form-group">
                      <label for="text">Email</label>
                      <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $data->email ?>">
                      <p class="text-red"><?php echo form_error('nama')?></p>
                    </div>
                    <div class="form-group">
                      <label>Alamat</label>
                       <textarea class="form-control" rows="3" input type="text" name="alamat" placeholder="Alamat"><?php echo $data->alamat ?></textarea>
                       <p class="text-red"><?php echo form_error('deskripsi')?></p>
                    </div>
                  </div>
                  <!-- /.box-body -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Ubah Data</button>
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->

<!-- About Me Box -->
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Tentang Saya</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <strong><i class="fa fa-map-marker margin-r-5"></i>Alamat</strong>

    <p class="text-muted"><?php echo $data->alamat?></p>

    <hr>

    <!-- <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

    <p>
      <span class="label label-danger">UI Design</span>
      <span class="label label-success">Coding</span>
      <span class="label label-info">Javascript</span>
      <span class="label label-warning">PHP</span>
      <span class="label label-primary">Node.js</span>
    </p>

    <hr>

    <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p> -->
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
</div>
      </div>
      <!-- /.row -->

      <div class="modal modal-warning fade" id="modal-warning">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Primary Modal</h4>
              </div>
              <div class="modal-body">
              <?php echo form_open_multipart('Home/changeimage/')?>
              <form role="form" action="<?php echo base_url('Home/changeimage/')?>" method="post" >
                  <div class="box-body">
                  <div class="form-group">
                    <label for="text">Gambar Barang</label>
                      <input type="file" name="gambar" size="20" />
                      <p class="text-red"><?php echo form_error('nama')?></p>
                    </div>
                  </div>
                  <!-- /.box-body -->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Ubah Data</button>
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
        <!-- /.modal-dialog -->
                <?php } ?>        
    </section>

