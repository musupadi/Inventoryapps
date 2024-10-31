<section class="content-header">
  <h1>Inventory</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-newspaper-o"></i>Transaction</a></li>
    <li class="active">Transaction</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Transaction</h3>
        </div>
        <a data-toggle="modal" data-target="#modal-success2" class="btn btn-success btn-sm" style="width: 150px; margin-left: 10px"><i class="fa fa-fw fa-search"></i>Filter Warehouse</a>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="width: 10px;">#</th>
                <th>User</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Asset No</th>
                <th>Description</th>
                <th>Warehouse</th>
                <th>Qty</th>
                <th>Requested Date</th>
                <th>Handover Date</th>
                <th>Reason</th>
                <th style="width: 40px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $id = 1;
              foreach ($transaction as $data) {
              ?>
                <tr>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $id++?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->name?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->item_name?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->category?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->asset_no?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->description?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->warehouse_name?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->qty?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->created_at?></td>
                  <td style="height: 50px; vertical-align: middle;">
                    <?php if ($data->status == 0): ?>
                      <button type="button" class="btn btn-block btn-warning" style="cursor: text" disabled>Requested</button>
                    <?php elseif ($data->status == 1): ?>
                      <?= date_format(date_create($data->handover_date),"d M Y") ?>
                    <?php elseif ($data->status == 2): ?>
                      <button type="button" class="btn btn-block btn-danger" style="cursor: text" disabled>Rejected</button>
                    <?php endif ?>
                  </td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->reason?></td>
                  <td style="text-align: center; vertical-align: middle;">
                    <?php if ($data->status == 0): ?>
                      <a data-toggle="modal" data-target="#modal-accept" onclick='accept_data("<?=$data->id?>","<?=$data->qty?>","<?=$data->id_item?>","<?=$data->id_warehouse?>")'>
                        <button type="button" class="btn btn-block btn-success">Accept</button>
                      </a>
                      <br>
                      <a href="<?php echo base_url('Transaction/EditStatusRejected/'.$data->id);?>" onclick="return confirm('yakin?');">
                        <button type="button" class="btn btn-block btn-danger">Reject</button>
                      </a>
                    <?php else: ?>
                      <?php if ($data->status == 1): ?>
                        <button type="button" class="btn btn-block btn-success" disabled>Delivered</button>
                      <?php elseif ($data->status == 2): ?>
                        <button type="button" class="btn btn-block btn-danger" disabled>Rejected</button>
                      <?php endif ?>
                    <?php endif ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <th style="width: 10px;">#</th>
                <th>User</th>
                <th>Item Name</th>
                <th>Category</th>
                <th>Asset No</th>
                <th>Description</th>
                <th>Warehouse</th>
                <th>Qty</th>
                <th>Requested Date</th>
                <th>Handover Date</th>
                <th>Reason</th>
                <th style="width: 40px;">Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <?php echo $this->session->flashdata('pesan');?>
        <!-- /.box-body -->

        <!-- INPUT -->
        <div class="modal modal-success fade" id="modal-accept">
          <?php echo form_open_multipart('Transaction/EditStatusAcceptAdmin/')?>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title">Delivery Date</h4>
                </div>
                <div class="modal-body">
                  <input type="hidden" id='id_item' name='id_item' value="" style="color: black;">
                  <input type="hidden" id='id_warehouse' name='id_warehouse' value="" style="color: black;">
                  <input type="hidden" id='qty' name='qty' value="" style="color: black;">
                  <input type="hidden" id='id_edit' name='id_edit' value="" style="color: black;">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="datepicker">Delivery Date: </label>
                      <input type="date" id="handover_date" name="handover_date" style="color: black;">
                    </div>
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

        <div class="modal modal-success fade" id="modal-success2">
          <?php echo form_open_multipart('Transaction/Filter')?>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <h4 class="modal-title">Filter Warehouse</h4>
                </div>
                <div class="modal-body">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="text"><span style="color: red; margin-right: 3px">*</span>Name</label>
                      <select id="warehouse_id" name="warehouse_id" class="select2" style="width: 100%;" >
                        <option value="">Semua</option>
                        <?php foreach ($warehouse as $data): ?>
                          <option value="<?= $data->id ?>"><?= $data->name ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-outline">Filter</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
</section>
<!-- /.content -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Select2 JS -->
<script src="vendor/select2/select2/dist/js/select2.min.js"></script>

<script>
  function reject_data(id) {
    console.log(id);
    document.getElementById('id_edit').value = id;
  }

  function accept_data(id, qty, id_item, id_warehouse) {
    console.log(id);
    document.getElementById('id_edit').value = id;
    document.getElementById('qty').value = qty;
    document.getElementById('id_item').value = id_item;
    document.getElementById('id_warehouse').value = id_warehouse;
  }
</script>
<script>
        $(document).ready(function() {
            $('#warehouse_id').select2();
        });
</script>