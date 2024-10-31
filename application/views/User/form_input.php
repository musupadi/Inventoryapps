<section class="content-header">
      <h1>
        Input Product Baru
      </h1>
      <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-book"></i>Jual Product</a></li>
        <li class="active"><a href="#">Input</a></li>
      </ol>
    </section>

    <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo form_open_multipart('Berita/TambahKategori/')?>
                <form role="form" action="<?php echo base_url('Berita/TambahKategori/')?>" method="post" >
                  <div class="box-body">
                    <div class="form-group">
                      <label for="text">Nama Kategori</label>
                      <input type="text" class="form-control" name="kategori" placeholder="Kategori">
                      <p class="text-red"><?php echo form_error('kategori')?></p>
                    </div>
                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                    <a href="<?php echo base_url('Berita/Kategori')?>">Batal</a>
                  </div>
                </form>
              </div>
              <!-- /.box -->
            </div>
            <!--/.col (right) -->
          </div>
          <!-- /.row -->
        </section>  