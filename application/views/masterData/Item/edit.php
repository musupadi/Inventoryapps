<section class="content-header">
    <h1>Edit Item</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-newspaper-o"></i>Edit Item</a></li>
        <li class="active">Edit Item</li>
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
                <?php foreach ($item as $data){ ?>    
                <?php echo form_open_multipart('Inventory/Itemedit/'.$data->id)?>
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">Item Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Item Name" value="<?php echo $data->name ?>">
                        <p class="text-red"><?php echo form_error('name')?></p>
                    </div>
                    <div class="form-group">
                        <label for="id_category">Category</label>
                        <select class="form-control" name="id_category">
                            <?php foreach ($category as $dataCategory){ ?>
                                <option value="<?php echo $dataCategory->id?>"><?php echo $dataCategory->label ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="asset_type">Asset Type</label>
                        <select class="form-control" id="asset_type" name="asset_type">
                            <option value="asset" <?php echo $data->asset_no != '0' ? 'selected' : ''; ?>>Asset</option>
                            <option value="non_asset" <?php echo $data->asset_no == '0' ? 'selected' : ''; ?>>Non Asset</option>
                        </select>
                    </div>
                    <div class="form-group" id="asset_no_group">
                        <label for="asset_no">Asset No</label>
                        <input type="text" class="form-control" id="asset_no" name="asset_no" placeholder="Asset No" value="<?php echo $data->asset_no ?>">
                        <p class="text-red"><?php echo form_error('asset_no')?></p>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" name="description" placeholder="Description" value="<?php echo $data->description ?>">
                        <p class="text-red"><?php echo form_error('description')?></p>
                    </div>
                    <div class="form-group">
                        <label for="id_vendor">Vendor</label>
                        <select class="form-control" name="id_vendor">
                            <?php foreach ($vendor as $dataVendor){ ?>
                                <option value="<?php echo $dataVendor->id?>"><?php echo $dataVendor->label ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_brand">Brand</label>
                        <select class="form-control" name="id_brand">
                            <?php foreach ($brand as $dataBrand){ ?>
                                <option value="<?php echo $dataBrand->id?>"><?php echo $dataBrand->label ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="warranty">Warranty</label>
                        <input type="text" class="form-control" name="warranty" placeholder="Warranty" value="<?php echo $data->warranty ?>">
                        <p class="text-red"><?php echo form_error('warranty')?></p>
                    </div>
                    <div class="form-group">
                        <label for="serial_number">Serial Number</label>
                        <input type="text" class="form-control" name="serial_number" placeholder="Serial Number" value="<?php echo $data->serial_number ?>">
                        <p class="text-red"><?php echo form_error('serial_number')?></p>
                    </div>
                    <div class="form-group">
                        <label for="file-upload" class="custom-file-upload">
                            <i class="fa fa-cloud-upload"></i> Upload Photo
                        </label>
                        <input type="file" class="form-control" name="photo" size="20" id="file-upload">
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Edit Data</button>
                    <a href="<?php echo base_url('Inventory/Item')?>">Cancel</a>
                </div>
                <?php } ?>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <!--/.col (right) -->
    </div>
    <!-- /.row -->
</section>  

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
</script>
