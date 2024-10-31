
    <section class="content-header">
      <h1>
        Data Tables
        
        <h3 class="box-title">
        </h3>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-balance-scale"></i>Online Shop</a></li>
        <li class="active">Pengisian Wallet</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <?php
                foreach ($wallet as $data){

                ?>
        <div class="col-md-4">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <a href="<?php echo base_url()?>img/bukti/<?php echo $data->bukti?>"><img class="profile-user-img img-responsive" src="<?php echo base_url()?>img/bukti/<?php echo $data->bukti?>" alt="User profile picture"></a>
              <h3 class="profile-username text-center"><?php echo $data->nama ?></h3>
              <h6 class="profile-username text-center"><?php echo $data->peminta ?></h6>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Jumlah</b> <a class="pull-right">Rp.<?php echo number_format($data->jumlah)?></a>
                </li>
                <li class="list-group-item">
                  <b>Pemberi</b> <a class="pull-right"><?php echo $data->pemberi?></a>
                </li>
                <li class="list-group-item">
                  <b>Status</b> <a class="pull-right"><?php echo $data->status?></a>
                </li>
              </ul>
              
              <?php if($data->status === 'Belum Diverifikasi'){
                  ?>
                <button type="button" data-toggle="modal" data-target="#modal-success" class="btn btn-success btn-block"><b>Terima</b></button>
                <button type="button" data-toggle="modal" data-target="#modal-danger" class="btn btn-danger btn-block"><b>Tolak</b></button>
                <div class="modal modal-primary fade" id="modal-primary">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Primary Modal</h4>
              </div>
              <div class="modal-body">
                <p>One fine body&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal modal-info fade" id="modal-info">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Info Modal</h4>
              </div>
              <div class="modal-body">
                <p>One fine body&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Save changes</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal modal-warning fade" id="modal-warning">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Warning Modal</h4>
              </div>
              <div class="modal-body">
                <p>One fine body&hellip;</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline">Save Change</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal modal-success fade" id="modal-success">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Menerima Permintaan</h4>
              </div>
              <div class="modal-body">
                <p>Check lagi dengan seksama apkah Bukti Transaksi benar ?</p>
                <a href="<?php echo base_url()?>img/bukti/<?php echo $data->bukti?>"><img class="profile-user-img img-responsive" src="<?php echo base_url()?>img/bukti/<?php echo $data->bukti?>" alt="User profile picture"></a>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a href="<?php echo base_url('Wallet/terima/'.$data->id_transaksi);?>" class="btn btn-outline"><b>Terima</b></a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal modal-danger fade" id="modal-danger">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Hapus Data</h4>
              </div>
              <div class="modal-body">
                <p>Anda yakin ingin Menolak permintaan <b><?php echo $data->peminta ?></b> ?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a href="<?php echo base_url('Wallet/tolak/'.$data->id_transaksi);?>" class="btn btn-outline"><b>Hapus</b></a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
                
                <?php }?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <?php } ?>
                    
        <!-- /.col -->
      <!-- /.row -->
    </section>

