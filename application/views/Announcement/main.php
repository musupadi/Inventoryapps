
<section class="content-header">
      <h1>
        Announcement
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-newspaper-o"></i>Announcement
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
              <h3 class="box-title">Announcement</h3>
            </div>
            <!-- /.box-header -->
            <a href="<?= base_url('Announcement/addAnnouncement') ?>" class="btn btn-success btn-sm" style="margin-left: 10px"><i class="fa fa-fw fa-plus"></i>Add Announcement</a>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th style="width: 500px;">Description</th>
                  <th style="width: 50px;">Date</th>
                  <th style="width: 40px;">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $id = 1;
                foreach ($announcement as $data) {

                ?>
                <tr>
                  <td><?php echo $id++?></td>
                  <td><?php echo $data->title?></td>
                  <td><?php echo $data->name?></td>
                  <td><?php echo $data->description?></td>
                  <td><?= date_format(date_create($data->date),"d M Y")?></td>
                  <td style="text-align: center;">
                    <a href="<?= base_url('Announcement/updateAnnouncement/' . $data->id) ?>">
                      <i class="fa fa-fw fa-pencil"></i>
                    </a> 
                    <a href="<?= base_url('Announcement/deleteAnnouncement/' . $data->id) ?>" onclick="return confirm('Data akan dihapus')">
                      <i class="fa fa-fw fa-trash"></i>
                    </a>
                    </div>
                    </div>
                  </td>
                </tr>
                <?php  } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th style="width: 10px;">#</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th style="width: 500px;">Description</th>
                  <th style="width: 50px;">Date</th>
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



