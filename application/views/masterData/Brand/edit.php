<section class="content-header">
      <h1>
        Edit Brand
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-newspaper-o"></i>Edit Brand</a></li>
        <li class="active">Edit Brand</li>
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
                <?php foreach ($brand as $data){

                ?>    
                  <?php echo form_open_multipart('Vendor/EditBrand/'.$data->id)?>
                <form role="form" action="<?php echo base_url('Vendor/EditBrand/'.$data->id)?>" method="post" >
                  <div class="box-body">
                  <div class="form-group">
                      <label for="text">Nama Brand</label>
                      <input type="text" class="form-control" name="label" placeholder="Nama Role" value="<?php echo $data->label ?>">
                     <p class="text-red"><?php echo form_error('label')?></p>
                    </div>
                    <div class="form-group">
                        <label>Select Origin</label>
                        <select class="form-control" name="id_origin">
                        <?php foreach ($origin as $datas ){

                        ?>
                            <option value="<?php echo $datas->id?>"><?php echo $datas->label ?></option>
                        <?php }?>
                        </select>
                    </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Edit Data</button>
                    <a href="<?php echo base_url('Vendor/Brand')?>">Batal</a>
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