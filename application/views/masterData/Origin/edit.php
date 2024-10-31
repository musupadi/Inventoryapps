<section class="content-header">
      <h1>
        Edit Origin
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-newspaper-o"></i>Edit Origin</a></li>
        <li class="active">Edit Origin</li>
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
                <?php foreach ($origin as $data){

                ?>    
                  <?php echo form_open_multipart('Vendor/EditOrigin/'.$data->id)?>
                <form role="form" action="<?php echo base_url('Vendor/EditOrigin/'.$data->id)?>" method="post" >
                  <div class="box-body">
                  <div class="form-group">
                      <label for="text">Nama Origin</label>
                      <input type="text" class="form-control" name="label" placeholder="Nama Role" value="<?php echo $data->label ?>">
                     <p class="text-red"><?php echo form_error('label')?></p>
                    </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Edit Data</button>
                    <a href="<?php echo base_url('Vendor/Origin')?>">Batal</a>
                  </div>
                  <?php } ?>
                </form>
              </div>
              <!-- /.box -->
            </div>
            <!--/.col (right) -->
          </div>
          <!-- /.row -->
        </section>  