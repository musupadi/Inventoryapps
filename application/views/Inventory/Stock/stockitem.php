<section class="content-header">
  <h1>Inventory</h1>
  <div class="lg-5">
    <h4><a href="<?= base_url('Stock') ?>"><i class="fa fa-arrow-circle-o-left" style="font-size:18px;"></i> Back</a></h4>
  </div>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-newspaper-o"></i>Stock</a></li>
    <li class="active">Stock Item in <strong><?= preg_replace('/%20/', ' ', $warehouse_name) ?></strong></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="nav-tabs-custom">
        <div class="box-header">
          <h3 class="box-title">Stock Item in <strong><?= preg_replace('/%20/', ' ', $warehouse_name) ?></strong></h3>
        </div>
        <a href="<?= base_url('Stock/AddItemStock/'.$id_warehouse.'/'.$warehouse_name) ?>" class="btn btn-success btn-sm" style="width: 130px; margin-left: 10px">
          <i class="fa fa-fw fa-plus"></i>Add Item
        </a>
        <a data-toggle="modal" data-target="#modal-excel" class="btn btn-success btn-sm" style="width: 180px; margin-left: 10px">
          <i class="fa fa-fw fa-plus"></i>Input New Item From Excel
        </a>
        <br>
        <br>
        <ul class="nav nav-tabs">
          <li class="active"><a href="#asset" data-toggle="tab">Asset</a></li>
          <li><a href="#nonasset" data-toggle="tab">Non Asset</a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="asset">
            <div class="box">
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px;">#</th>
                      <th>Item Name</th>       
                      <th>Qty</th>
                      <th style="width: 100px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $id = 1; foreach ($asset as $data): ?>
                    <tr>
                      <td style="height: 20px; vertical-align: middle;"><?= $id++ ?></td>
                      <td style="height: 20px; vertical-align: middle;"><?= $data->type ?></td>
                      <td style="height: 20px; vertical-align: middle;"><?= $count_asset[$id-2][0]->count ?></td>
                      <td style="height: 20px; vertical-align: middle;">
                        <?php if ($data->asset_no == "0"): ?>
                          <a data-toggle="modal" data-target="#modal-stock" class="btn btn-success btn-sm" style="width: 150px; margin-left: 10px" onclick="accept_data('<?= $data->id ?>', '<?= $data->name ?>', '<?= $data->qty ?>', '<?= $data->ItemName ?>')"><i class="fa fa-fw fa-plus"></i>Add Quantity Stock</a>
                          <br><br>
                          <a data-toggle="modal" data-target="#modal-adjust" class="btn btn-danger btn-sm" style="width: 150px; margin-left: 10px" onclick="adjust_data('<?= $data->id ?>', '<?= $data->name ?>', '<?= $data->qty ?>', '<?= $data->ItemName ?>')"><i class="fa fa-fw fa-minus"></i>Adjust Quantity Stock</a>
                          <br><br>
                          <a data-toggle="modal" data-target="#modal-limit" class="btn btn-warning btn-sm" style="width: 150px; margin-left: 10px" onclick="limit_data('<?= $data->id ?>', '<?= $data->name ?>', '<?= $data->limits ?>')"><i class="fa fa-fw fa-tag"></i>Change Limit</a>
                        <?php else: ?>
                          <a href="<?= base_url('Stock/Allocation/' . $data->ItemName . '/' . $id_warehouse . '/' . $warehouse_name); ?>" class="btn btn-info btn-sm" style="width: 150px; margin-left: 10px"><i class="fa fa-fw fa-tag"></i>Detail</a>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th style="width: 10px;">#</th>
                      <th>Category Name</th>       
                      <th>Qty</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="nonasset">
            <div class="box">
              <div class="box-body">
                <table id="example11" class="table table-bordered table-striped">
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
                      <th>Qty</th>
                      <th style="width: 100px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $id = 1; foreach ($nonasset as $data): ?>
                    <tr>
                      <td style="height: 50px; vertical-align: middle;"><?= $id++ ?></td>
                      <td style="height: 50px; vertical-align: middle;">
                        <img class="profile-user-img img-responsive" src="<?= base_url('img/item/' . $data->photo) ?>" alt="Image Item">
                      </td>
                      <td style="height: 50px; vertical-align: middle;"><?= $data->name ?></td>
                      <td style="height: 50px; vertical-align: middle;"><?= $data->type ?></td>
                      <td style="height: 50px; vertical-align: middle;"><?= $data->asset_no == "0" ? 'Non Asset' : $data->asset_no; ?></td>
                      <td style="height: 50px; vertical-align: middle;"><?= $data->description ?></td>
                      <td style="height: 50px; vertical-align: middle;"><?= $data->warranty ?></td>
                      <td style="height: 50px; vertical-align: middle;"><?= $data->serial_number ?></td>
                      <td style="height: 50px; vertical-align: middle;"><?= $data->qty ?></td>
                      <td style="height: 50px; vertical-align: middle;">
                        <?php if ($data->asset_no == "0"): ?>
                          <a data-toggle="modal" data-target="#modal-stock" class="btn btn-success btn-sm" style="width: 150px; margin-left: 10px" onclick="accept_data('<?= $data->id ?>', '<?= $data->name ?>', '<?= $data->qty ?>', '<?= $data->ItemName ?>')"><i class="fa fa-fw fa-plus"></i>Add Quantity Stock</a>
                          <br><br>
                          <a data-toggle="modal" data-target="#modal-adjust" class="btn btn-danger btn-sm" style="width: 150px; margin-left: 10px" onclick="adjust_data('<?= $data->id ?>', '<?= $data->name ?>', '<?= $data->qty ?>', '<?= $data->ItemName ?>')"><i class="fa fa-fw fa-minus"></i>Adjust Quantity Stock</a>
                          <br><br>
                          <a data-toggle="modal" data-target="#modal-limit" class="btn btn-warning btn-sm" style="width: 150px; margin-left: 10px" onclick="limit_data('<?= $data->id ?>', '<?= $data->name ?>', '<?= $data->limits ?>')"><i class="fa fa-fw fa-tag"></i>Change Limit</a>
                        <?php else: ?>
                          <a href="<?= base_url('Stock/Allocation/' . $data->ItemName . '/' . $id_warehouse . '/' . $warehouse_name); ?>" class="btn btn-warning btn-sm" style="width: 150px; margin-left: 10px"><i class="fa fa-fw fa-tag"></i>Allocation</a>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
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
                      <th>Qty</th>
                      <th style="width: 100px;">Action</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
    <?= $this->session->flashdata('pesan'); ?>
    <div class="modal modal-success fade" id="modal-stock">
              <?php echo form_open_multipart('Stock/AddStockItem/' . $id_warehouse . '/' . $warehouse_name)?>
                  <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Add Stock</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                              <label for="text">Item Name</label>
                                <input type="text" id="name" class="form-control" name="name" placeholder="Name" disabled>
                                <p class="text-red"><?php echo form_error('name')?></p>
                            </div>
                            <div class="form-group">
                              <label for="text"><span style="color: red; margin-right: 3px">*</span>Qty</label>
                                <input type="hidden" id="qty" class="form-control" name="qty" required>
                                <input type="number" id="qty2" class="form-control" name="qty2" min="1" placeholder="Qty" required>
                                <input type="hidden" id="id" name="id" value="" style="color:black">
                                <input type="hidden" id="ItemName" name="ItemName" value="" style="color:black">
                              <p class="text-red"><?php echo form_error('qty')?></p>
                            </div>
                            <div class="form-group">
                              <label for="text"><span style="color: red; margin-right: 3px">*</span>Reason</label>
                              <textarea class="form-control" rows="5" id="reason"  name="reason" placeholder="Reason" required></textarea>
                                <!-- <input type="text" class="form-control" name="reason" placeholder="Reason" required> -->
                              <p class="text-red"><?php echo form_error('qty')?></p>
                            </div>
                            <div class="form-group">
                              <label for="text"><span style="color: red; margin-right: 3px"></span>Date</label>
                              <input type="date" class="form-control" id="date" name="date" style="color: black;">
                              <p class="text-red"><?php echo form_error('date')?></p>
                            </div>
                            <div class="form-group">
                              <label for="file-uploads" class="custom-file-upload">
                                <i class="fa fa-cloud-upload"></i> Upload Photo</label>
                              <input type="file" class="form-control" name="photo" size="20" id="file-uploads">
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
            <div class="modal modal-danger fade" id="modal-adjust">
              <?php echo form_open_multipart('Stock/AdjustStockItem/' . $id_warehouse . '/' . $warehouse_name)?>
                  <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Adjust Stock</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                              <label for="text">Item Name</label>
                                <input type="text" id="names" class="form-control" name="names" placeholder="Name" disabled>
                                <p class="text-red"><?php echo form_error('name')?></p>
                            </div>
                            <div class="form-group">
                              <label for="text"><span style="color: red; margin-right: 3px">*</span>Qty</label>
                                <input type="hidden" id="qtys" class="form-control" name="qtys" required>
                                <input type="number" id="qty2s" class="form-control" name="qty2s" min="1" placeholder="Qty" required>
                                <input type="hidden" id="ids" name="ids" value="" style="color:black">
                                <input type="hidden" id="ItemNames" name="ItemNames" value="" style="color:black">
                              <p class="text-red"><?php echo form_error('qty2s')?></p>
                            </div>
                            <div class="form-group">
                              <label for="text"><span style="color: red; margin-right: 3px">*</span>Reason</label>
                              <textarea class="form-control" rows="5" id="reasons"  name="reasons" placeholder="Reason" required></textarea>
                              <p class="text-red"><?php echo form_error('reasons')?></p>
                            </div>
                            <div class="form-group">
                              <label for="text"><span style="color: red; margin-right: 3px"></span>Date</label>
                              <input type="date" class="form-control" id="date" name="date" style="color: black;">
                              <p class="text-red"><?php echo form_error('date')?></p>
                            </div>
                            <div class="form-group">
                              <label for="file-upload" class="custom-file-upload">
                                <i class="fa fa-cloud-upload"></i> Upload Photo</label>
                              <input type="file" class="form-control" name="photos" size="20" id="file-upload">
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
            <div class="modal modal-warning fade" id="modal-limit">
              <?php echo form_open_multipart('Stock/LimitStockItem/' . $id_warehouse . '/' . $warehouse_name)?>
                  <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Adjust Stock</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                              <label for="text">Item Name</label>
                                <input type="text" id="limit_name" class="form-control" name="limit_name" placeholder="Name" disabled>
                                <p class="text-red"><?php echo form_error('name')?></p>
                            </div>
                            <input type="hidden" id="limit_id" name="limit_id" value="" style="color:black">
                            <div class="form-group">
                              <label for="text"><span style="color: red; margin-right: 3px">*</span>Limit</label>
                              <input type="number" id="limit" class="form-control" name="limit" placeholder="Limit">
                              <p class="text-red"><?php echo form_error('limit')?></p>
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
              <!-- Modals -->
              <!-- Import Excel Modal -->
              <div class="modal modal-success fade" id="modal-excel">
                <?= form_open_multipart('Stock/ImportExcel/' . $id_warehouse . '/' . $warehouse_name); ?>
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
                          <a href="<?= base_url('file/template_item.xlsx'); ?>" download="Input Template.xlsx">
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
                <?= form_close(); ?>
              </div>

              
              <!-- End Modals -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->

<script>
  function accept_data(id, name, qty,ItemName)
  {
    console.log(id);
    document.getElementById('id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('qty').value = qty;
    document.getElementById('ItemName').value = ItemName;
  }
  function adjust_data(id, name, qty,ItemName)
  {
    console.log(id);
    document.getElementById('ids').value = id;
    document.getElementById('names').value = name;
    document.getElementById('qtys').value = qty;
    document.getElementById('ItemNames').value = ItemName;
  }
  function limit_data(id, name, limit)
  {
    document.getElementById('limit_id').value = id;
    document.getElementById('limit_name').value = name;
    document.getElementById('limit').value = limit;
  }
</script>
