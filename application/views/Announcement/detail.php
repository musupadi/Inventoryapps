
<section class="content-header">
      <h1>
        Announcement
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-newspaper-o"></i>dashboard
</a></li>
        <li class="active">Announcement</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <?php foreach($announcement as $data) : ?>
              <h3 class="box-title"><b><?= $data->title ?></b></h3>
              <hr style="margin-top: 10px">
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top: -25px">
              <p>Author : <span><?= $data->name ?></span> | Date : <span><?= date_format(date_create($data->created_at),"d M Y")?></span></p>
              <p style="margin-top: 20px"><?= $data->description ?></p>
            </div>
              <?php endforeach ?>
            <?php echo $this->session->flashdata('pesan');?>
            <!-- /.box-body -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->



