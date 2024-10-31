<section class="content-header">
    <h1>Master Data</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-newspaper-o"></i>Master Data</a></li>
        <li class="active">Item</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Item</h3>
                </div>
                <!-- /.box-header -->
                <a data-toggle="modal" data-target="#modal-success" class="btn btn-success btn-sm" style="width: 100px; margin-left: 10px"><i class="fa fa-fw fa-plus"></i>Add Item</a>
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
                            <th>Vendor</th>
                            <th>Brand</th>
                            <th>Warranty/Expired</th>
                            <th>Serial Number</th>
                            <th style="width: 40px;">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $id = 1;
                        foreach ($item as $data) {
                        ?>
                        <tr>
                            <td style="height: 50px; vertical-align: middle;"><?php echo $id++?></td>
                            <td><img class="profile-user-img img-responsive" src="<?php echo base_url()?>img/item/<?php echo $data->photo?>" alt="Image Item"></td>
                            <td style="height: 50px; vertical-align: middle;"><?php echo $data->name?></td>
                            <td style="height: 50px; vertical-align: middle;"><?php echo $data->category?></td>
                            <td style="height: 50px; vertical-align: middle;"><?php echo $data->asset_no?></td>
                            <td style="height: 50px; vertical-align: middle;"><?php echo $data->description?></td>
                            <td style="height: 50px; vertical-align: middle;"><?php echo $data->vendor?></td>
                            <td style="height: 50px; vertical-align: middle;"><?php echo $data->brand?></td>
                            <td style="height: 50px; vertical-align: middle;"><?php echo $data->warranty?></td>
                            <td style="height: 50px; vertical-align: middle;"><?php echo $data->serial_number?></td>
                            <td style="height: 50px; vertical-align: middle;">
                                <a href="<?php echo base_url('Inventory/Itemedit/'.$data->id);?>">
                                    <i class="fa fa-fw fa-pencil"></i>
                                </a> 
                                <a href="<?php echo base_url('Inventory/HapusItem/'.$data->id);?>" onclick="return confirm('Data akan dihapus')">
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
                            <th>Photo</th>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Asset No</th> 
                            <th>Description</th>
                            <th>Vendor</th>
                            <th>Brand</th>
                            <th>Warranty/Expired</th>
                            <th>Serial Number</th>
                            <th style="width: 40px;">Action</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <?php echo $this->session->flashdata('pesan');?>
                <!-- /.box-body -->

                <!-- INPUT -->
                <div class="modal modal-success fade" id="modal-success">
                <?php echo form_open_multipart('Inventory/TambahItem/')?>
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Input Item</h4>
                        </div>
                        <div class="modal-body">
                          <div class="box-body">
                            <div class="form-group">
                              <label for="text"><span style="color: red; margin-right: 3px">*</span>Item Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Item Name" required>
                                <p class="text-red"><?php echo form_error('name')?></p>
                            </div>
                            <div class="form-group">
                              <label for="text"><span style="color: red; margin-right: 3px">*</span>Select Category</label>
                              <select class="form-control" name="id_category">
                                <?php foreach ($category as $dataCategory){ ?>
                                    <option value="<?php echo $dataCategory->id?>"><?php echo $dataCategory->label ?></option>
                                <?php }?>
                              </select>
                            </div>
                            <div class="form-group">
                                <label for="asset_type"><span style="color: red; margin-right: 3px">*</span>Asset Type</label>
                                <select class="form-control" id="asset_type" name="asset_type">
                                  <option value="non_asset">Non Asset</option>    
                                  <option value="asset">Asset</option>  
                                </select>
                            </div>
                            <div class="form-group" id="asset_no_group">
                                <label for="text"><span style="color: red; margin-right: 3px">*</span>Asset No</label>
                                <input type="text" class="form-control" id="asset_no" name="asset_no" placeholder="Asset No" required>
                                <p class="text-red"><?php echo form_error('asset_no')?></p>
                            </div>
                            <div class="form-group">
                              <label for="description"></span>Description</label>
                                <textarea class="form-control" id="description" rows="2" name="description" placeholder="Type a description"></textarea>
                                <p style="text-align: right; margin-top: 5px"><span id="result"></span></p>
                            </div>
                            <div class="form-group" style="margin-top: -30px">
                                <label for="text"><span style="color: red; margin-right: 3px">*</span>Select Vendor</label>
                                <select class="form-control" name="id_vendor">
                                  <?php foreach ($vendor as $dataVendor){ ?>
                                      <option value="<?php echo $dataVendor->id?>"><?php echo $dataVendor->label ?></option>
                                  <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="text"><span style="color: red; margin-right: 3px">*</span>Select Brand</label>
                                <select class="form-control" name="id_brand">
                                  <?php foreach ($brand as $dataBrand){ ?>
                                      <option value="<?php echo $dataBrand->id?>"><?php echo $dataBrand->label ?></option>
                                  <?php }?>
                                </select>
                              </div>
                            <div class="form-group">
                              <label for="text"></span>Warranty/Expired</label>
                                <input type="text" class="form-control" name="warranty" placeholder="Warranty">
                              <p class="text-red"><?php echo form_error('warranty')?></p>
                            </div>
                          <div class="form-group">
                            <label for="text"></span>Serial Number</label>
                              <input type="text" class="form-control" name="serial_number" placeholder="Serial Number">
                            <p class="text-red"><?php echo form_error('serial_number')?></p>
                          </div>
                          <div class="form-group">
                            <label for="file-upload" class="custom-file-upload">
                              <i class="fa fa-cloud-upload"></i> Upload Photo</label>
                            <input type="file" class="form-control" name="photo" size="20" id="file-upload">
                          </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-outline">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var assetTypeSelect = document.getElementById('asset_type');
                var assetNoGroup = document.getElementById('asset_no_group');
                var assetNoInput = document.getElementById('asset_no');

                function toggleAssetNo() {
                    if (assetTypeSelect.value === 'asset') {
                        assetNoGroup.style.display = 'block';
                        assetNoInput.required = true;
                    } else {
                        assetNoGroup.style.display = 'none';
                        assetNoInput.required = false;
                        assetNoInput.value = '0';
                    }
                }

                // Initial toggle based on the default value
                toggleAssetNo();

                // Add event listener for change event
                assetTypeSelect.addEventListener('change', toggleAssetNo);
            });

            let description = document.getElementById('description');
            let result = document.getElementById('result');
            let limit = 255;
            result.textContent = 0 + "/" + limit;

            description.addEventListener('input', function(){
                var textLength = description.value.length;
                result.textContent = textLength + '/' + limit;

                if (textLength > limit){
                    result.style.color = 'red';
                } else {
                    result.style.color = 'white';
                }
            });
        </script>
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
