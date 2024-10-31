<section class="content-header">
      <h1>
        History Transaction
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">History Transaction</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">History</h3>
              
            </div>
            <a data-toggle="modal" data-target="#modal-success" class="btn btn-success btn-sm" style="width: 130px; margin-left: 10px"><i class="fa fa-fw fa-calendar"></i>Filter Date</a>
            <a data-toggle="modal" data-target="#modal-success2" class="btn btn-success btn-sm" style="width: 130px; margin-left: 10px"><i class="fa fa-fw  fa-file-pdf-o"></i>Save PDF</a>
            
            
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Name</th>
                  <th>Warehouse</th>
                  <th>Balance Prev</th>
                  <th>Balance</th>
                  <th>Balance Now</th>
                  <th>Reason</th>
                  <th>Description</th>
                  <th>User</th>
                  <th>Departement</th>
                  <th>Requested Date</th>
                  <th>Transaction Date</th>
                 
                  <?php if($user[0]->id_role == 1 || $user[0]->id_role == 2){?>
                    <th>Action</th>
                  <?php  }?>
                  
                </tr>
                </thead>
                <tbody>
                <?php
                $id = 1;
                foreach ($history as $data) {

                ?>
                <tr style="text-align: center">
                  <td style="text-align: left"><?php echo $id++?></td>
                  <td style="text-align: left"><?php echo $data->item_name?></td>
                  <td style="text-align: left"><?php echo $data->warehouse?></td>
                  <td style="text-align: left"><?php echo $data->qty1 ?></td>
                  <td style="text-align: left"><?php echo $data->balance ?></td>
                  <td style="text-align: left"><?php echo $data->qty2?></td>
                  <td style="text-align: left"><?php echo $data->reason?></td>
                  <?php if ( $data->description == 1 ) : ?>
                      <td class="btn btn-success" style="font-size: 1.2rem; padding: 7px; margin-top: 3px; padding: 7px 11.5px"><i class="fa fa-fw fa-sign-in"></i></td>
                    <?php endif ;?>
                    <?php if ( $data->description == 2 ) : ?>
                      <td class="btn btn-info" style="font-size: 1.2rem; padding: 7px; margin-top: 3px; padding: 7px 11.5px"><i class="fa fa-fw fa-exchange"></td>
                    <?php endif ;?>
                    <?php if ( $data->description == 0 ) : ?>
                      <td class="btn btn-danger" style="font-size: 1.2rem; padding: 7px; margin-top: 3px; padding: 7px 11.5px"><i class="fa fa-fw fa-sign-out"></i></td>
                    <?php endif ;?>
                  <td style="text-align: left"><?php echo $data->user?></td>
                  <td style="text-align: left"><?php echo $data->department?></td>
                  <td style="text-align: left"><?= date_format(date_create($data->back_date),"d M Y")?></td>
                  <td style="text-align: left"><?= date_format(date_create($data->created_at),"d M Y - H:i:s")?></td>
                  <?php if($user[0]->id_role == 1 || $user[0]->id_role == 2){?>
                    <td style="text-align: center;">
                      <a data-toggle="modal" data-target="#modal-edit" class="btn btn-success btn-sm" style="width: 150px; margin-left: 10px" onclick="accept_data('<?=$data->id ?>', '<?= date_format(date_create($data->back_date),'Y-m-d')?>', '<?=$data->item_name ?>')"><i class="fa fa-fw fa-pencil"></i>Update Transaction</a>
                    </div>
                    </div>
                  </td>
                  
                  <?php  }?>
                  </td>
                </tr>
                <?php  } ?>
                      
                </tbody>
                <tfoot>
                  <tr>
                    <th style="width: 10px;">#</th>
                    <th>Name</th>
                    <th>Warehouse</th>
                    <th>Balance Prev</th>
                    <th>Balance</th>
                    <th>Balance Now</th>
                    <th>Reason</th>
                    <th>Description</th>
                    <th>User</th>
                    <th>Departement</th>
                    <th>Requested Date</th>
                    <th>Transaction Date</th>
                    <?php if($user[0]->id_role == 1 || $user[0]->id_role == 2){?>
                      <th>Action</th>
                    <?php  }?>
                  </tr>
                </tfoot>
              </table>
            </div>
            <?php echo $this->session->flashdata('pesan');?>
            <div class="modal modal-info fade" id="modal-edit">
                    <?php echo form_open_multipart('Home/EditHistory')?>
                        <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">Update Transaction</h4>
                              </div>
                              <div class="modal-body">
                              <div class="form-group">
                                  <label for="text">Item name</label>
                                    
                                  <p class="text-red"><?php echo form_error('id')?></p>
                                </div>
                                <div class="form-group">
                                  <label for="text">Item name</label>
                                    <input type="hidden" class="form-control" name="id"  id="id" placeholder="Item Name" required>
                                    <input type="text" class="form-control" name="name" id="name"disabled value="<?php echo $data->item_name?>" placeholder="Item Name" required>
                                  <p class="text-red"><?php echo form_error('names')?></p>
                                </div>
                                <div class="form-group">
                                  <label for="text">Transaction Date</label>
                                  <input type="date" class="form-control" name="backdate" id="backdate" placeholder="Item Name" required>
                                  <p class="text-red"><?php echo form_error('backdate')?></p>
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
            <?php echo $this->session->flashdata('pesan');?>
            <div class="modal modal-success fade" id="modal-success">
              <?php echo form_open_multipart('Home/HistoryTransactionFilter')?>
                  <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Add Stock</h4>
                        </div>
                        <div class="modal-body">
                            <div class="box-body">
                              <div class="form-group">
                                  <label for="datepicker" style="width: 100px;">Start Date : </label>
                                  <input type="date" id="start_date" name="start_date" value ="<?php echo $start_date ?>" style="color: black;">
                              </div>
                            </div>
                            <div class="box-body">
                            <div class="form-group">
                                <label for="datepicker" style="width: 100px;">End Date Date : </label>
                                <input type="date" id="end_date" name="end_date" value ="<?php echo $end_date ?>"style="color: black;">
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
              <?php echo form_open_multipart('Home/PdfTransaction')?>
                  <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Save PDF</h4>
                        </div>
                        <div class="modal-body">
                        <?php foreach ($user as $data) : ?>
                          <input type="hidden" class="form-control" name="name" value="<?= $data->name ?>">
                          <input type="hidden" class="form-control" name="username" value="<?= $data->username ?>">
                          <input type="hidden" class="form-control" name="email" value="<?= $data->email ?>">
                          <input type="hidden" class="form-control" name="department" value="<?= $data->department ?>">
                          <input type="hidden" class="form-control" name="phone_number" value="<?= $data->phone_number ?>">
                          <input type="hidden" class="form-control" name="start_date" value="<?= $start_date?>">
                          <input type="hidden" class="form-control" name="end_date" value="<?= $end_date ?>">

                        <?php endforeach ?>
                            <div class="box-body">
                              <div class="form-group">
                                <label for="text"><span style="color: red; margin-right: 3px">*</span>Name</label>
                                <select id="id_item" name="id_item" class="select2" style="width: 100%;" >
                                  <option value="">Semua</option>
                                  <?php foreach ($item as $data) : ?>
                                    <option value="<?= $data->id ?>"><?= $data->name ?></option>
                                  <?php endforeach ?>
                                  
                                    <!-- Add more options as needed -->
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="text"><span style="color: red; margin-right: 3px">*</span>Person Responsible</label>
                                <input type="text"  class="form-control" name="name" placeholder="Nama" style="width: 100%;" value="<?php echo $user[0]->name ?>" hint="Person Responsible">
                                <p class="text-red"><?php echo form_error('name')?></p>
                              </div>
                              <div class="form-group">
                                <label for="pdf"><span style="color: red; margin-right: 3px">*</span>PDF Type</label>
                                <select class="form-control" name="pdf" style="width: 100%;" hint="PDF Type">
                                    <option value="" disabled selected>Pick PDF Type</option>
                                    <!-- Opsi-opsi yang tersedia -->
                                    <option value="1">Report</option>
                                    <option value="2">Stock Card</option>
                                    <!-- Tambahkan opsi lainnya sesuai kebutuhan -->
                                </select>
                                <p class="text-red"><?php echo form_error('pdf')?></p>
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
            <!-- /.box-body -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Select2 JS -->
    <script src="vendor/select2/select2/dist/js/select2.min.js"></script>
    <script>
  function accept_data(id,backdate,name)
  {
    console.log(id);  
    document.getElementById('id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('backdate').value = backdate;
  }
</script>
    <script>
        $(document).ready(function() {
            $('#id_item').select2();
        });
    </script>
    