
<section class="content-header">
      <h1>
        Inventory
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-newspaper-o"></i>Inventory</a></li>
        <li class="active">Item</li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Item</h3>
              <div class="lg-5">
                  <h4><a href="<?= base_url('Stock') ?>"> <i class="fa fa-arrow-circle-o-left" style="font-size:18px;"></i> Back</a></h4>
              </div>
            </div>
            <!-- /.box-header -->
            <!-- <a data-toggle="modal" data-target="#modal-success" class="btn btn-success btn-sm" style="width: 100px; margin-left: 10px"><i class="fa fa-fw fa-plus"></i>Add Item</a> -->
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Photo</th>
                  <th>Item Name</th>
                  <th>Category</th>
                  <th>Asset No</th>
                  <th>Description</th>
                  <th>Warranty</th>
                  <th>Serial Number</th>
                  <th style="width: 40px;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $id = 1;
                foreach ($item as $data) {

                ?>
                <tr>
                  <td><?php echo $id++?></td>
                  <td><img class="profile-user-img img-responsive" src="<?php echo base_url()?>img/item/<?php echo $data->photo?>" alt="Image Item"></td>
                  <td><?php echo $data->name?></td>
                  <td><?php echo $data->category?></td>
                  <td><?php echo $data->asset_no?></td>
                  <td><?php echo $data->description?></td>
                  <td><?php echo $data->warranty?></td>
                  <td><?php echo $data->serial_number?></td>
                  <td style="vertical-align: middle;"><a data-toggle="modal" data-target="#modal-success" class="btn btn-success btn-sm" style="width: 100px;" onclick="accept_data('<?=$data->id ?>','<?=$data->name ?>')"><i class="fa fa-fw fa-plus"></i>Add Item</a></td>  
                </tr>
                <?php  } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Photo</th>
                  <th>Item Name</th>
                  <th>Category</th>
                  <th>Asset No</th> 
                  <th>Description</th>
                  <th>Warranty</th>
                  <th>Serial Number</th>
                  <th style="width: 40px;">Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <?php echo $this->session->flashdata('pesan');?>
            <!-- /.box-body -->

            <!-- INPUT -->
            <div class="modal modal-success fade" id="modal-success">
            <?php echo form_open_multipart('Stock/AddEditItemStock/'.$id_warehouse . '/' . $warehouse_name)?>
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Input Item</h4>
                    </div>
                    <div class="modal-body">
                      <div class="box-body">
                        <div class="form-group">
                          <label for="text">Item Name</label>
                            <input type="text" disabled class="form-control"  id="name" name="name" placeholder="Name" required>
                            <p class="text-red"><?php echo form_error('name')?></p>
                        </div>
                        <input type="hidden" id="id" name="id" value="" style="color:black">
                        <div class="form-group">
                          <label for="text"><span style="color: red; margin-right: 3px">*</span>Qty</label>
                            <input type="number" class="form-control" name="qty" min="1" placeholder="Qty" required>
                    
                          <p class="text-red"><?php echo form_error('qty')?></p>
                        </div>
                        <div class="form-group">
                          <label for="text">Reason</label>
                            <input type="text" class="form-control" name="reason" placeholder="Reason">
                    
                          <p class="text-red"><?php echo form_error('reason')?></p>
                        </div>
                        <div class="form-group">
                              <label for="text"><span style="color: red; margin-right: 3px"></span>Date</label>
                              <input type="date" class="form-control" id="date" name="date" style="color: black;">
                              <p class="text-red"><?php echo form_error('date')?></p>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline">Save changes</button>
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
  function accept_data(id, name)
  {
    console.log(id, name);
    document.getElementById('id').value = id;
    document.getElementById('name').value = name;
  }
</script>

