<section class="content-header">
  <h1>Inventory</h1>
  <div class="lg-5">
    <h4><a href="<?= base_url('Stock') ?>"> <i class="fa fa-arrow-circle-o-left" style="font-size:18px;"></i> Back</a></h4>
  </div>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-newspaper-o"></i>Stock</a></li>
    <li class="active">Stock Item in <strong><?= preg_replace('/%20/', ' ', $warehouse_name) ?></strong></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Stock Item in <strong><?= preg_replace('/%20/', ' ', $warehouse_name) ?></strong></h3>
        </div>
        <a href="<?php echo base_url();?>Stock/AddItemStock/<?=$id_warehouse ?>/<?= $warehouse_name ?>" class="btn btn-success btn-sm" style="width: 130px; margin-left: 10px"><i class="fa fa-fw fa-plus"></i>Add Item</a>
        <a data-toggle="modal" data-target="#modal-excel" class="btn btn-success btn-sm" style="width: 150px; margin-left: 10px"><i class="fa fa-fw fa-plus"></i>Input New Item PDF</a>
        <!-- /.box-header -->

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
                <th>Allocation</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $id = 1;
              foreach ($item as $data) {
              ?>
                <tr>
                  <td><?php echo $id++?></td>
                  <td style="height: 50px; vertical-align: middle;"><img class="profile-user-img img-responsive" src="<?php echo base_url()?>img/item/<?php echo $data->photo?>" alt="Image Item"></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->name?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->type?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->asset_no; ?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->description?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->allocation?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->status?></td>
                  <td style="height: 50px; vertical-align: middle;">
                    <a data-toggle="modal" data-target="#modal-allocation" class="btn btn-warning btn-sm" style="width: 150px; margin-left: 10px" onclick="allocation('<?=$data->id ?>', '<?=$data->name ?>', '<?=$data->IdStock ?>')"><i class="fa fa-fw fa-tag"></i>Allocation</a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <th style="width: 10px;">#</th>
                <th>Photo</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Asset No</th>
                <th>Description</th>
                <th>Allocation</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <?php echo $this->session->flashdata('pesan');?>
        <!-- box-body -->
        <div class="modal modal-success fade" id="modal-allocation">
          <?php echo form_open_multipart('Stock/ChangeAllocation/' . $id_warehouse . '/' . $warehouse_name)?>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Allocation Item</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="text">Item Name</label>
                  <!-- <input type="text" id="allocation_id" name="allocation_id"class="form-control" placeholder="Name"> -->
                  <input type="text" id="allocation_name" class="form-control" name="allocation_name" readonly>
                  <p class="text-red"><?php echo form_error('allocation_name')?></p>
                </div>
               
                <input type="hidden" id="allocation_id" name="allocation_id" style="color:black">
                <input type="text" id="stock_id" name="stock_id" style="color:black">
                <div class="form-group">
                  <label for="text"><span style="color: red; margin-right: 3px">*</span>Type</label>
                  <select id="allocation_type" class="form-control" onchange="updateDropdown()">
                    <option value="1">People</option>
                    <option value="0">Environment</option>
                  </select>
                  <p class="text-red"><?php echo form_error('allocation_type')?></p>
                </div>
              <div class="form-group">
                    <label>Pick User</label>
                    <select id="id_user" name="id_user" class="select2" style="width: 100%;">
                      <?php foreach ($people as $data) : ?>
                        <option value="<?= $data->id ?>"><?= $data->name ?></option>
                      <?php endforeach ?>
                      <!-- Add more options as needed -->
                    </select>
                  </div>
                <div class="form-group">
                  <label for="text"><span style="color: red; margin-right: 3px">*</span>Remarks</label>
                  <input type="text" id="remarks" class="form-control" name="remarks" placeholder="Remarks">
                  <p class="text-red"><?php echo form_error('remarks')?></p>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Save changes</button>
              </div>
            </div>
          </div>
          </form>
        </div>
        <!-- INPUT -->

        <!-- Import Excel Modal -->
        <div class="modal modal-success fade" id="modal-excel">
          <?php echo form_open_multipart('Stock/ImportExcel/' . $id_warehouse . '/' . $warehouse_name); ?>
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Import Excel</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
                  <div class="form-group">
                    <label><span style="color: red; margin-right: 3px">*</span>Download Template Excel</label>
                    <br>
                    <a href="<?php echo base_url('file/template_item.xlsx'); ?>" download="Input Template.xlsx">
                      <i class="fa fa-cloud-download"></i> Download Excel
                    </a>
                  </div>
                  <div class="form-group">
                    <label><span style="color: red; margin-right: 3px">*</span>Import Excel</label>
                    <br>
                    <label for="file-uploada" class="custom-file-upload">
                      <i class="fa fa-cloud-upload"></i> Upload Excel
                    </label>
                    <input type="file" class="form-control" name="excel_file" size="20" id="file-uploada">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Save changes</button>
              </div>
            </div>
          </div>
          <?php echo form_close(); ?>
        </div>

        <!-- /.modal -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->

<script>
  function allocation(id, name,stock_id) {
    document.getElementById('allocation_id').value = id;
    document.getElementById('allocation_name').value = name;
    document.getElementById('stock_id').value = stock_id;
  }

  function updateDropdown() {
    var type = document.getElementById('allocation_type').value;
    var userDropdown = document.getElementById('id_user');
    var peopleOptions = <?= json_encode($people) ?>;
    var environmentOptions = <?= json_encode($environment) ?>;
    var options = type == 1 ? peopleOptions : environmentOptions;

    // Clear existing options
    userDropdown.innerHTML = '';

    // Populate dropdown with new options
    options.forEach(function(option) {
      var opt = document.createElement('option');
      opt.value = option.id;
      opt.innerHTML = option.name;
      userDropdown.appendChild(opt);
    });
  }

  $(document).ready(function() {
    $('#id_user').select2();
  });
</script>
