<section class="content-header">
      <h1>
        Pengisian Saldo Wlalet
      </h1>
      <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-book"></i>Permintaan Pengisian Wallet</a></li>
        <li class="active"><a href="#">Input</a></li>
      </ol>
    </section>

    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Silahkan Masukan Jumlahnya disini</h3>
                </div>
                <div class="col-md-12">
                <p>Ini adalah rekening milik kami<br>5860377707 BCA a/n Muhammad Supriyadi<br>jika sudah di kirimkan harap difoto untuk <br>dijadikan bukti pembayaran dan isi <br>jumlah Pengisian&nbsp;berdasarkan uang yang dikirimkan<br></p>
                </div>
                
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo form_open_multipart('Wallet/input')?>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="text">Jumlah Pengisian</label>
                      <input type="number" class="form-control" name="jumlah" placeholder="Jumlah Pengisian">
                      <p class="text-red"><?php echo form_error('jumlah')?></p>
                    </div>      
                    <div class="form-group">
                      <label for="text">Gambar Barang</label>
                      <input type="file" name="gambar" size="20" />
                      <p class="text-red"><?php echo form_error('nama')?></p>
                    </div>
                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Kirim permintaan</button>
                    <a href="<?php echo base_url()?>">Batal</a>
                  </div>
                </form>
              </div>
              <!-- /.box -->
            </div>
            <!--/.col (right) -->
          </div>
          <!-- /.row -->
        </section>  