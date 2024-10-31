
<section class="content-header">
      <h1>
        Inventory
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-newspaper-o"></i>Transaction</a></li>
        <li class="active">Borrower's Details</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header" style="margin-bottom: -40px">
              <h3 class="box-title">Borrower's Details</h3>
              <hr style="padding-bottom: 20px">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Username</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Department</th>
                  <th>Phone Number</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                    $id = 1;
                    foreach ($detail as $data) :
                  ?>
                <tr>
                  <td style="height: 50px; vertical-align: middle;"><?php echo $id++?></td>
                  <td style="height: 50px; vertical-align: middle;"><?= $data->username ?></td>
                  <td style="height: 50px; vertical-align: middle;"><?= $data->name ?></td>
                  <td style="height: 50px; vertical-align: middle;"><?= $data->email ?></td>
                  <td style="height: 50px; vertical-align: middle;"><?= $data->department ?></td>
                  <td style="height: 50px; vertical-align: middle;"><?= $data->phone_number ?></td>
                </tr>
                <?php endforeach ?>
                </tbody>
                <tfoot>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Username</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Department</th>
                  <th>Phone Number</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
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