
<section class="content-header">
      <h1>
        Inventory
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-newspaper-o"></i>Inventory</a></li>
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
            <!-- <a data-toggle="modal" data-target="#modal-add" class="btn btn-success btn-sm" style="width: 100px; margin-left: 10px"><i class="fa fa-fw fa-plus"></i>Request Item</a> -->
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
                  <th>Category</th>
                  <th style="width: 40px;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $id = 1;
                foreach ($transaction as $data) {

                ?>
                <tr>
                  <td><?php echo $id++?>
                  <td style="height: 50px; vertical-align: middle;"><img class="profile-user-img img-responsive" src="<?php echo base_url()?>img/item/<?php echo $data->photo?>" alt="Image Item"></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->name?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->category?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->asset_no?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->description?></td>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $data->category?></td>
                  <td style="height: 50px; vertical-align: middle;"><a href="<?= base_url('Transaction/userTransactionWarehouse/' . $data->id); ?>" class="btn btn-success btn-sm" style="width: 130px; margin-left: 10px">Request</a></td>
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
                  <th>Category</th>
                  <th style="width: 40px;">Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <?php echo $this->session->flashdata('pesan');?>
            <!-- /.box-body -->
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
  function accept_data(id)
  {
    console.log(id);
    document.getElementById('id_edit').value = id;
  }
</script>