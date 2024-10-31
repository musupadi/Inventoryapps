
<section class="content-header">
      <h1>
        My Profile
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">My Profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="well well-sm">
                <div class="row">
                  <?php foreach ( $user as $data ) : ?>
                    <div class="col-sm-6 col-md-4">
                        <img src="<?= base_url(); ?>img/profile/<?= $data->photo ?>" alt="" class="img-rounded img-responsive img-bordered" />
                    </div>
                    <div class="col-sm-6 col-md-8"> 
                        <h4>
                            <?= $data->name ?></h4>
                        <!-- <small><cite title="San Francisco, USA">San Francisco, USA <i class="glyphicon glyphicon-map-marker">
                        </i></cite></small> -->
                        <h4>
                        <hr class="divider">
                            <i class="glyphicon glyphicon-envelope"></i> <?= $data->email ?>
                            <hr class="divider">
                            <?php if ( $data->id_role == 3 ) : ?>
                            <i class="fa fa-user"></i> Admin Warehouse
                            <?php endif ;?>
                            <hr class="divider">
                          </h4>
                          <h5> Register Since <?=  date_format(date_create($data->created_at), 'd F Y') ?> </h5>
                        <!-- Split button -->
                        <div class="btn-group">
                        <a href="<?= base_url('Home/EditProfileAdminWarehouse/' . $data->id); ?>" class="btn btn-primary">
                          <i class="fa fa-fw fa-pencil"></i> Edit
                        </a> 
                        </div>
                    </div>
                </div>
                <?php endforeach ; ?>
            </div>
        </div>
    </div>
</div>

    </section>
    <!-- /.content -->

