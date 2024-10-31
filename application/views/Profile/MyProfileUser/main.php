<section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?= base_url(); ?>img/profile/<?= $user[0]->photo ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $user[0]->name ?></h3>

              <p class="text-muted text-center"><?php echo $user[0]->department ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Requested Transaction</b> <a class="pull-right"><?php echo $request[0]->count?></a>
                </li>
                <li class="list-group-item">
                  <b>Accepted Transaction</b> <a class="pull-right"><?php echo $accept[0]->count?></a>
                </li>
                <li class="list-group-item">
                  <b>Rejected Transaction</b> <a class="pull-right"><?php echo $reject[0]->count?></a>
                </li>                             
              </ul>
              <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i>Departement</strong>

              <p class="text-muted">
                <?php echo $user[0]->department ?>
              </p>

              <hr>
<!-- 
              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted">Malibu, California</p>

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              </p>

              <hr> -->

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Phone Number</strong>

              <p><?php echo $user[0]->phone_number ?></p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Activity</a></li>
              <li><a href="#settings" data-toggle="tab">Settings</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
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
                    <th>Reason</th>
                    <th>Handover Date</th>
                    <th>Request Date</th>
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
                    <td style="height: 50px; vertical-align: middle;"><?php echo $data->reason?></td>
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
                    <td style="height: 50px; vertical-align: middle;"><?php echo $data->created_at?></td>
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
                    <th>Reason</th>
                    <th>Handover Date</th>
                    <th>Request Date</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                      <div class="timeline-body">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                        quora plaxo ideeli hulu weebly balihoo...
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs">Read more</a>
                        <a class="btn btn-danger btn-xs">Delete</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-user bg-aqua"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                      <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                      </h3>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-comments bg-yellow"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                      <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                      <div class="timeline-body">
                        Take me to your leader!
                        Switzerland is small and neutral!
                        We are more like Germany, ambitious and misunderstood!
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-camera bg-purple"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                      <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                      <div class="timeline-body">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
                <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <?php foreach ($user as $data) {

                ?>
                <?php echo form_open_multipart('Home/EditProfileUser/'.$data->id)?>
                <form role="form" action="<?php echo base_url('User/EditProfileUser/'.$data->id)?>" method="post" >
                  <div class="box-body">
                
                    <div class="form-group">
                      <label for="text"><span style="color: red; margin-right: 3px">*</span>Name</label>
                      <input type="text" class="form-control" name="name" placeholder="Nama" value = "<?php echo $data->name?>">
                      <p class="text-red"><?php echo form_error('name')?></p>
                    </div>
                    <div class="form-group">
                      <label for="text"><span style="color: red; margin-right: 3px">*</span>Username</label>
                      <input type="text" class="form-control" name="username" placeholder="Username" value = "<?php echo $data->username?>" readonly>
                      <p class="text-red"><?php echo form_error('username')?></p>
                    </div>
                    <div class="form-group">
                      <label for="text"><span style="color: red; margin-right: 3px">*</span>Password</label>
                      <input type="password" class="form-control" name="password" placeholder="Password">
                      <p class="text-red"><?php echo form_error('password')?></p>
                    </div>
                    <div class="form-group">
                      <label for="text"><span style="color: red; margin-right: 3px">*</span>Email</label>
                      <input type="text" class="form-control" name="email" placeholder="Email" value = "<?php echo $data->email?>">
                      <p class="text-red"><?php echo form_error('email')?></p>
                    </div>
                    <div class="form-group">
                        <label><span style="color: red; margin-right: 3px">*</span>Role Name</label>
                        <select class="form-control muted" name="id_role" >
                        <?php foreach ( $role as $datas ) : ?>
                          <?php if ( $datas->id == 4 ) { ?>
                        <option value="<?php echo $datas->id?>"><?php echo $datas->label ?></option>
                        <?php }?>
                        <?php endforeach ; ?>
                        </select>
                        <?php } ?>
                    </div>
                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Edit Data</button>
                    <a href="<?php echo base_url('Home/MyProfileUser')?>">Batal</a>
                  </div>
                </form>
              </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>