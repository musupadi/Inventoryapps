<section class="content-header">
      <h1>
        Edit Warehouse
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-newspaper-o"></i>Edit Warehouse</a></li>
        <li class="active">Edit Warehouse</li>
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
                <?php foreach ($warehouse as $data){

                ?>    
                  <?php echo form_open_multipart('Inventory/Warehouseedit/'.$data->id)?>
                <form role="form" action="<?php echo base_url('Inventory/Warehouseedit/'.$data->id)?>" method="post" >
                  <div class="box-body">
                    <div class="form-group">
                      <label for="text">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $data->name ?>">
                     <p class="text-red"><?php echo form_error('name')?></p>
                    </div>
                    <div class="form-group">
                      <label for="text">Description</label>
                        <input type="text" class="form-control" name="description" placeholder="Description" value="<?php echo $data->description ?>">
                     <p class="text-red"><?php echo form_error('description')?></p>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <select class="form-control" name="id_location">
                        <?php foreach ($location as $datas){

                        ?>
                            <option value="<?php echo $datas->id?>"><?php echo $datas->label ?></option>
                        <?php }?>
                        </select>
                    </div>
                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Edit Data</button>
                    <a href="<?php echo base_url('Inventory/Warehouse')?>">Batal</a>
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