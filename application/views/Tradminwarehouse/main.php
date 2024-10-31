
<section class="content-header">
      <h1>
        Inventory
      </h1>
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
                  <th>Warehouse</th>
                  <th>Qty</th>
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
                  <td  style="height: 50px; vertical-align: middle;"><?php echo $id++?></td>
                  <td style="height: 50px; vertical-align: middle;"><img class="profile-user-img img-responsive" src="<?php echo base_url()?>img/item/<?php echo $data->photo?>" alt="Image Item"></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->item_name?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->category?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->asset_no?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->description?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->warehouse_name?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->qty?></td>
                  <td style="height: 50px; vertical-align: middle;">
                    <?php if ($data->status==0): ?>
                      <button type="button" class="btn btn-block btn-warning" style="cursor: text">Requested</button>
                    <?php endif ?>
                    <?php if ($data->status==1): ?>
                      <?= date_format(date_create($data->handover_date),"d M Y") ?>
                    <?php endif ?>
                    <?php if ($data->status==2): ?>
                      <button type="button" class="btn btn-block btn-danger" style="cursor: text">Rejected</button>
                    <?php endif ?>
                  </td>  
        
                  <!-- <td style="height: 50px; vertical-align: middle;">
                    <?php if ($data->status==0): ?>
                      <button type="button" class="btn btn-block btn-warning">Requested</button>
                    <?php endif ?>
                    <?php if ($data->status==1): ?>
                      <button type="button" class="btn btn-block btn-success">Deliverd</button>
                    <?php endif ?>
                    <?php if ($data->status==2): ?>
                      <button type="button" class="btn btn-block btn-danger">Rejected</button>
                    <?php endif ?>
                  </td> -->
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->reason?></td>
                  <td style="text-align: center; vertical-align: middle;" >
                    <?php if ($data->status==0): ?>
                    <a data-toggle="modal" data-target="#modal-accept" onclick='accept_data("<?=$data->id?>","<?=$data->qty?>","<?=$data->id_item?>","<?=$data->id_warehouse?>")'>
                      <button type="button" class="btn btn-block btn-success">Accept</button>
                    </a>
                    <br> 
                    <a href="<?php echo base_url('Transaction/EditStatusRejected/'.$data->id);?>" onclick="return confirm('yakin?');")>
                      <button type="button" class="btn btn-block btn-danger">Rejected</button>
                    </a>
                    <?php endif ?>
                    <?php if ($data->status!=0): ?>
                      <?php if ($data->status==1): ?>
                        <button type="button" class="btn btn-block btn-success">Delivered</button>
                      <?php endif ?>
                      <?php if ($data->status==2): ?>
                        <button type="button" class="btn btn-block btn-danger">Rejected</button>
                      <?php endif ?>
                    <?php endif ?>
                   
                    </div>
                    </div>
                  </td>
                  
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
                  <th>Warehouse</th>
                  <th>Qty</th>
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
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Delivery Date</h4>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" id='id_item' name='id_item' value="" style="color: black;">
                      <input type="hidden" id='id_warehouse' name='id_warehouse' value="" style="color: black;">
                      <input type="hidden" id='qty' name='qty' value="" style="color: black;">
                      <input type="hidden" id='id_edit' name='id_edit' value="" style="color: black;">
                      <div class="box-body">
                        <div class="form-group">
                            <label for="datepicker">Delivery Date : </label>
                            <input type="date" id="handover_date" name="handover_date" style="color: black;">
                        </div>
                      </div>
                      <div class="box-body">
                        <div class="form-group">
                            <label for="datepicker">Backdate Date : </label>
                            <input type="date" id="handover_date" name="back_date" style="color: black;">
                        </div>
                      </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline">Save changes</button>
                    </div>
                </form>
            </div>


            <div class="modal modal-danger fade" id="modal-reject">
            <?php echo form_open_multipart('Transaction/EditStatusRejectedAdmin/')?>
                <form role="form" action="<?php echo base_url('Transaction/EditStatusRejected/')?>" method="post" >
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Delivery Date</h4>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" id='id_edit' name='id' value="" style="color: black;">
                      <div class="box-body">
                        <div class="form-group">
                            <label for="datepicker">Delivery Date : </label>
                            <input type="date" id="handover_date" name="handover_date" style="color: black;">
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
  function reject_data(id)
  {
    console.log(id);
    document.getElementById('id_edit').value = id;
  }
</script>
<script>
  function accept_data(id,qty,id_item,id_warehouse)
  {
    console.log(id);
    document.getElementById('id_edit').value = id;
    document.getElementById('qty').value = qty;
    document.getElementById('id_item').value = id_item;
    document.getElementById('id_warehouse').value = id_warehouse;
  }
</script>