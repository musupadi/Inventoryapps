
    <section class="content-header">
      <h1>
        Master Data
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-newspaper-o"></i>Master Data</a></li>
        <li class="active">Warehouse</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Warehouse</h3>
            </div>
            <!-- /.box-header -->
            <a data-toggle="modal" data-target="#modal-success" class="btn btn-success btn-sm" style="width: 130px; margin-left: 10px"><i class="fa fa-fw fa-plus"></i>Add Warehouse</a>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Warehouse Name</th>
                  <th>Description</th>
                  <th>Location</th>
                  <th style="width: 40px;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $id = 1;
                foreach ($warehouse as $data) {

                ?>
                <tr>
                  <td><?php echo $id++?></td>
                  <td><?php echo $data->name?></td>
                  <td><?php echo $data->description?></td>
                  <td><?php echo $data->location?></td>
                  <td style="text-align: center;">
                    <a href="<?php echo base_url('Inventory/WarehouseEdit/'.$data->id);?>">
                      <i class="fa fa-fw fa-pencil"></i>
                    </a> 
                    <a href="<?php echo base_url('Inventory/HapusWarehouse/'.$data->id);?>" onclick="return confirm('Data akan dihapus')">
                      <i class="fa fa-fw fa-trash"></i>
                    </a>
                    </div>
                    </div>
                  </td>
                </tr>
                <?php  } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Warehouse Name</th>
                  <th>Description</th>
                  <th>Location</th>
                  <th style="width: 40px;">Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <?php echo $this->session->flashdata('pesan');?>
            <!-- /.box-body -->

            <!-- INPUT -->
            <div class="modal modal-success fade" id="modal-success">
            <?php echo form_open_multipart('Inventory/TambahWarehouse')?>
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Input Warehouse</h4>
                    </div>
                    <div class="modal-body">
                      <div class="box-body">
                        <div class="form-group">
                          <label for="text"><span style="color: red; margin-right: 3px">*</span>Warehouse Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Warehouse Name" required>
                          <p class="text-red"><?php echo form_error('name')?></p>
                        </div>
                        <div class="form-group">
                          <label for="text">Description</label>
                            <textarea class="form-control" id="description" rows="2" name="description" placeholder="Type a description"></textarea>
                        </div>
                        <div class="form-group">
                          <label for="text">Location</label>
                          <select class="form-control" name="id_location">
                            <?php foreach ($location as $datas){ ?>
                                <option value="<?php echo $datas->id?>"><?php echo $datas->label ?></option>
                            <?php }?>
                          </select>
                        </div>
                        
                    <div lass="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline pull-right">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

    <script>
      let description = document.getElementById('description');
      let result = document.getElementById('result');
      let limit = 255;
      result.textContent = 0 + "/" + limit;
 
      description.addEventListener('input', function(){
        var textLength = description.value.length;
        result.textContent = textLength + '/' + limit;

        if ( textLength > limit ){
          result.style.color = 'red';
        } else {
          result.style.color = 'white';
        }

      })

    </script>

