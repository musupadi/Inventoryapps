<section class="content-header">
      <h1>
        Edit Location
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-newspaper-o"></i>Edit Location</a></li>
        <li class="active">Edit Location</li>
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
                <?php foreach ($location as $data){

                ?>    
                  <?php echo form_open_multipart('Home/EditLocation/'.$data->id)?>
                <form role="form" action="<?php echo base_url('Home/EditLocation/'.$data->id)?>" method="post" >
                  <div class="box-body">
                    <div class="form-group">
                        <label for="text">Label</label>
                        <input type="text" class="form-control" name="label" placeholder="Label" value="<?php echo $data->label ?>">
                      <p class="text-red"><?php echo form_error('label')?></p>
                    </div>
                    <div class="form-group">
                        <label for="floor">Floor</label>
                        <input type="text" class="form-control" name="floor" placeholder="Floor" value="<?php echo $data->floor ?>">
                      <p class="text-red"><?php echo form_error('floor')?></p>
                    </div>
                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Edit Data</button>
                    <a href="<?php echo base_url('Location')?>">Batal</a>
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