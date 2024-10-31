<section class="content-header">
      <h1>
        Edit User
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-newspaper-o"></i>Edit</a></li>
        <li class="active">Edit User</li>
      </ol>
    </section>

    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <?php foreach ($users as $data) {

                ?>
                <?php echo form_open_multipart('Home/EditProfileAdminWarehouse/'.$data->id)?>
                <form role="form" action="<?php echo base_url('User/EditProfileAdminWarehouse/'.$data->id)?>" method="post" >
                  <div class="box-body">
                
                        <div class="form-group">
                      <label for="text"><span style="color: red; margin-right: 3px">*</span>Name</label>
                      <input type="text" class="form-control" name="name" placeholder="Nama" value = "<?php echo $data->name?>">
                      <p class="text-red"><?php echo form_error('name')?></p>
                    </div>
                    <div class="form-group">
                      <label for="text"><span style="color: red; margin-right: 3px">*</span>Username</label>
                      <input type="text" class="form-control" name="username" placeholder="Username" value = "<?php echo $data->username?>" readonly>
                      <p class="text-red"><?php echo form_error('username')?></p>
                    </div>
                    <div class="form-group">
                      <label for="text"><span style="color: red; margin-right: 3px">*</span>Password</label>
                      <input type="password" class="form-control" name="password" placeholder="Password">
                      <p class="text-red"><?php echo form_error('password')?></p>
                    </div>
                    <div class="form-group">
                      <label for="text"><span style="color: red; margin-right: 3px">*</span>Email</label>
                      <input type="text" class="form-control" name="email" placeholder="Email" value = "<?php echo $data->email?>">
                      <p class="text-red"><?php echo form_error('email')?></p>
                    </div>
                    <div class="form-group">
                        <label><span style="color: red; margin-right: 3px">*</span>Role Name</label>
                        <select class="form-control muted" name="id_role" >
                        <?php foreach ( $role as $datas ) : ?>
                          <?php if ( $datas->id == 3 ) { ?>
                        <option value="<?php echo $datas->id?>"><?php echo $datas->label ?></option>
                        <?php }?>
                        <?php endforeach ; ?>
                        </select>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                      <label for="text">Gambar</label>
                      <input type="file" name="gambar" size="20" />
                      <p class="text-red"><?php echo form_error('nama')?></p>
                    </div>
                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Edit Data</button>
                    <a href="<?php echo base_url('Home/MyProfileAdminWarehouse')?>">Batal</a>
                  </div>
                </form>
              </div>
              <!-- /.box -->
            </div>
            <!--/.col (right) -->
          </div>
          <!-- /.row -->
        </section>  