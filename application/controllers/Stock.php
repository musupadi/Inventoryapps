<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if($this->session->userdata('status') != "login"){
            redirect(base_url("login"));
        }
        $this->load->model("Models");
        $this->load->library('form_validation');
    }
    private function rulesTransaction(){
        return [
            ['field' => 'handover_date','label' => 'Handover Date','rules' => 'required'],
            ['field' => 'id','label' => 'Id','rules' => 'required'],
        ];
    }
    private function rulesEditStock(){
        return [
            ['field' => 'qty','label' => 'qty','rules' => 'required'],
            ['field' => 'id','label' => 'id','rules' => 'required']
        ];
    }
    private function rulesEditStocks(){
        return [
            ['field' => 'qtys','label' => 'qtys','rules' => 'required'],
            ['field' => 'ids','label' => 'ids','rules' => 'required']
        ];
    }
    private function rulesStock(){
        return [
            ['field' => 'qty','label' => 'qty','rules' => 'required'],
            ['field' => 'id','label' => 'id','rules' => 'required']
        ];
    }
    public function index()
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['warehouse'] = $this->Models->AllWarehouse();
        $data['type'] = $this->Models->getAll('m_category');
        $data['title'] = 'Warehouse';
        $this->load->view('dashboard/header',$data);
        $this->load->view('Inventory/Stock/side',$data);
        $this->load->view('Inventory/Stock/main',$data);
        $this->load->view('dashboard/footer');
    }
    public function StockData($id){
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['warehouse'] = $this->Models->AllWarehouse();
        $data['type'] = $this->Models->getAll('m_category');
        $data['title'] = 'Warehouse';
        $this->load->view('dashboard/header',$data);
        $this->load->view('Inventory/Stock/side',$data);
        $this->load->view('Inventory/Stock/main',$data);
        $this->load->view('dashboard/footer');
    }
    public function EditStatusAccept(){
        $this->form_validation->set_rules($this->rulesTransaction());
        if($this->form_validation->run() === false){
            $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $data['transaction'] = $this->Models->AllTransaction();
            $data['title'] = 'Transaction';
            $this->load->view('dashboard/header',$data);
            $this->load->view('Transaction/side',$data);
            $this->load->view('Transaction/main',$data);
            $this->load->view('dashboard/footer');  
        }else{
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $data['handover_date'] = $this->input->post('handover_date');   
            $data['status'] = 1;
            $data['updated_by'] = $ID[0]->id;
            $data['updated_at'] = $this->Models->GetTimestamp();
            $this->Models->edit('tr_item','id',$this->input->post('id'),$data);
            redirect(base_url('Transaction'));
        }
    }
    public function EditStatusRejected($id){
        $this->form_validation->set_rules($this->rulesTransaction());
        if($this->form_validation->run() === false){
            $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $where = array(
                'id' => $id
            );
            $data['transaction'] = $this->Models->AllTransaction();
            $data['title'] = 'Transaction';
            $this->load->view('dashboard/header',$data);
            $this->load->view('Transaction/side',$data);
            $this->load->view('Transaction/main',$data);
            $this->load->view('dashboard/footer');  
        }else{
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $data['handover_date'] = $this->input->post('handover_date');   
            $data['status'] = 2;
            $data['updated_by'] = $ID[0]->id;
            $data['updated_at'] = $this->Models->GetTimestamp();
            $this->Models->edit('tr_item','id',$this->input->post('id'),$data);
            redirect(base_url('Transaction'));
        }
    }

    public function StockItem($id_warehouse, $warehouse_name) 
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        // $data['item'] = $this->Models->ItemWarehouse($id_warehouse);
        $data['id_warehouse'] = $id_warehouse;
        $data['warehouse_name'] = $warehouse_name;
        $data['type'] = $this->Models->getAll('m_category');
        $data['title'] = "Stock Item";
        $data['asset'] = $this->Models->CategoryData($id_warehouse,true);

        
        // $data['category'] = $this->Models->ItemWarehouse($id_warehouse,true,true);
        // foreach($data['asset'] as $index -> $asset){

        // }
        foreach($data['asset'] as $index => $asset) {
            $data['count_asset'][$index] = $this->Models->CountCheckerAsset($id_warehouse, $asset->name);
        }     
        $data['nonasset'] = $this->Models->ItemWarehouse($id_warehouse,false);
        $this->load->view('dashboard/header',$data);
        $this->load->view('Inventory/Stock/side',$data);
        $this->load->view('Inventory/Stock/stockitem',$data);
        $this->load->view('dashboard/footer');
    }

    public function stockAdminWarehouse($id_user)
    {
        $roles = $this->Models->RoleWarehouse($id_user);
       
       
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        // $data['item'] = $this->Models->ItemWarehouse($id_warehouse);
        $data['id_warehouse'] = $roles[0]->id_warehouse;
        $data['warehouse_name'] = $roles[0]->name;
        $data['type'] = $this->Models->getAll('m_category');
        $data['title'] = "Stock Item";
        $data['asset'] = $this->Models->CategoryData($roles[0]->id_warehouse,true);

        
        // $data['category'] = $this->Models->ItemWarehouse($id_warehouse,true,true);
        // foreach($data['asset'] as $index -> $asset){

        // }
        foreach($data['asset'] as $index => $asset) {
            $data['count_asset'][$index] = $this->Models->CountCheckerAsset($roles[0]->id_warehouse, $asset->name);
        }     
        $data['nonasset'] = $this->Models->ItemWarehouse($roles[0]->id_warehouse,false);
        // $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        // $data['item'] = $this->Models->ItemWarehouse();
        // $data['asset'] = $this->Models->ItemWarehouse($roles[0]->id_warehouse,true);
        // $data['nonasset'] = $this->Models->ItemWarehouse($roles[0]->id_warehouse,false);
        // $data['id_warehouse'] = $roles[0]->id_warehouse;
        // $data['warehouse_name'] = $roles[0]->name;
        // $data['type'] = $this->Models->getAll('m_category');
        // $data['title'] = "Stock Item";
        $this->load->view('dashboard/header',$data);
        $this->load->view('Inventory/Stockadmin/side',$data);
        $this->load->view('Inventory/Stock/stockitem2',$data);
        $this->load->view('dashboard/footer');
    }

    public function AddItemStock($id_warehouse, $warehouse_name){
        $data['id_warehouse'] = $id_warehouse;
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['item'] = $this->Models->AllItem();
        $data['warehouse'] = $this->Models->AllWarehouse();
        $data['warehouse_name'] = $warehouse_name;
        $data['type'] = $this->Models->getAll('m_category');
        $data['title'] = 'Item';
        $this->load->view('dashboard/header',$data);
        $this->load->view('Inventory/Stock/side',$data);
        $this->load->view('Inventory/Stock/addItem',$data);
        $this->load->view('dashboard/footer');
    }

    public function AddEditItemStock($id_warehouse, $warehouse_name){
        $this->form_validation->set_rules($this->rulesStock());
        if($this->form_validation->run() === false){
            $data['id_warehouse'] = $id_warehouse;
            $data['warehouse_name'] = $warehouse_name;
            $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $data['item'] = $this->Models->AllItem();
            $data['warehouse'] = $this->Models->AllWarehouse();
            $data['type'] = $this->Models->getAll('m_category');
            $data['title'] = 'Item';
            $this->load->view('dashboard/header',$data);
            $this->load->view('Inventory/Stock/side',$data);
            $this->load->view('Inventory/Stock/addItem',$data);
            $this->load->view('dashboard/footer');
        }else{
            $CheckerQTY = $this->input->post('qty');
            if($CheckerQTY <0){
                $data['id_warehouse'] = $id_warehouse;
                $data['warehouse_name'] = $warehouse_name;
                $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
                $data['item'] = $this->Models->AllItem();
                $data['warehouse'] = $this->Models->AllWarehouse();
                $data['type'] = $this->Models->getAll('m_category');
                $data['title'] = 'Item';
                $this->load->view('dashboard/header',$data);
                $this->load->view('Inventory/Stock/side',$data);
                $this->load->view('Inventory/Stock/addItem',$data);
                $this->load->view('dashboard/footer');
            }
            $Checker = $this->Models->GetQuantity($this->input->post('id'),$id_warehouse);
            $dates = $this->input->post('date');
            if($Checker){
                $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
                $data['qty'] = $Checker[0]->qty + $this->input->post('qty');   
                $data['updated_by'] = $ID[0]->id;
                $data['updated_at'] = $this->Models->GetTimestamp();
                $this->Models->edit('m_stock','id_item',$this->input->post('id'),$data);

                $data2['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
                $data2['item'] = $this->Models->ItemWarehouse($id_warehouse);
                $data2['id_warehouse'] = $id_warehouse;
                $data2['type'] = $this->Models->getAll('m_category');
                $data2['title'] = "Stock Item";


 
                $config['upload_path']          = './file/log/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
                $config['file_name']            = uniqid();
                // $config['overwrite']			= true;
                $config['max_size']             = 4096; // 1MB
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;
    
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('photo')) {
                    $data3['file'] = "/file/log/".$config['file_name'];
                }else{
                    $data3['file'] = "";
                }    
                $data3['id_item'] = $this->input->post('id');
                $data3['id_warehouse'] = $id_warehouse;
                $data3['qty1'] = $Checker[0]->qty;
                $data3['balance'] = $this->input->post('qty');
                $data3['qty2'] = $data['qty'];
                $data3['description'] = 1;
                $data3['reason'] = $this->input->post('reason'); 
                $data3['back_date'] = $dates." 00:00:00";
                $data3['created_by'] = $ID[0]->id;
                $data3['updated_by'] = $ID[0]->id;
                $this->Models->insert('m_log',$data3);
                $this->Models->RepairLogItem($data3['id_item']);
                $this->load->view('dashboard/header',$data2);
                $this->load->view('Inventory/Stock/side',$data2);
                $this->load->view('Inventory/Stock/stockitem',$data2);
                $this->load->view('dashboard/footer');
            }else{
                $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
                
                $data['qty'] = $this->input->post('qty');   
                $data['id_item'] = $this->input->post('id');
                $data['id_warehouse'] = $id_warehouse;
                $GetItem = $this->Models->getID('m_item','id',$data['id_item']);
                if($GetItem[0]->asset_no != "" || $GetItem[0]->asset_no != "0"){
                    $data['location'] = '10';
                    $data['allocation'] = '87';
                    $data['status'] = '3';
                    $data['asset'] = '1';
                }
                $data['created_by'] = $ID[0]->id;
                $data['created_at'] = $this->Models->GetTimestamp();
                $data['updated_by'] = $ID[0]->id;
                $data['updated_at'] = $this->Models->GetTimestamp();
                $this->Models->insert('m_stock',$data);
                
                $data2['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
                $data2['item'] = $this->Models->ItemWarehouse($id_warehouse);
                $data2['id_warehouse'] = $id_warehouse;
                $data2['warehouse_name'] = $warehouse_name;
                $data2['type'] = $this->Models->getAll('m_category');
                $data2['title'] = "Stock Item";


                $config['upload_path']          = './file/log/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
                $config['file_name']            = uniqid();
                // $config['overwrite']			= true;
                $config['max_size']             = 4096; // 1MB
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;
    
                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('photo')) {
                    $data3['file'] = "/file/log/".$config['file_name'];
                }else{
                    $data3['file'] = "";
                }    
                $data3['id_item'] = $this->input->post('id');
                $data3['id_warehouse'] = $id_warehouse;
                $data3['qty1'] = "0";
                $data3['balance'] = $this->input->post('qty');
                $data3['qty2'] = $data['qty'];
                $data3['description'] = 1;
                $data3['reason'] = $this->input->post('reason'); 
                $data3['back_date'] = $dates." 00:00:00";
                $data3['created_by'] = $ID[0]->id;
                $data3['updated_by'] = $ID[0]->id;
                $this->Models->insert('m_log',$data3);
                $this->Models->RepairLogItem($data3['id_item']);
                    
                $this->load->view('dashboard/header',$data2);
                $this->load->view('Inventory/Stock/side',$data2);
                $this->load->view('Inventory/Stock/stockitem',$data2);
                $this->load->view('dashboard/footer');
   
            }
        }
        redirect(base_url('Stock/StockItem/'. $id_warehouse . '/' . $warehouse_name));
    }



    public function AddStockItem($id_warehouse, $warehouse_name){
        $this->form_validation->set_rules($this->rulesEditStock());
        if($this->form_validation->run() === false){
            $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $data['item'] = $this->Models->ItemWarehouse($id_warehouse);
            $data['id_warehouse'] = $id_warehouse;
            $data['warehouse_name'] = $warehouse_name;
            $data['type'] = $this->Models->getAll('m_category');
            $data['title'] = "Stock Item";
            $this->load->view('dashboard/header',$data);
            $this->load->view('Inventory/Stock/side',$data);
            $this->load->view('Inventory/Stock/stockitem',$data);
            $this->load->view('dashboard/footer');
        }else{
            $qty1 = $this->input->post('qty');  
            $dates = $this->input->post('date');
            $qty2 = $this->input->post('qty2');
            if($qty2 < 0){
                $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
                $data['item'] = $this->Models->ItemWarehouse($id_warehouse);
                $data['id_warehouse'] = $id_warehouse;
                $data['warehouse_name'] = $warehouse_name;
                $data['type'] = $this->Models->getAll('m_category');
                $data['title'] = "Stock Item";
                $this->load->view('dashboard/header',$data);
                $this->load->view('Inventory/Stock/side',$data);
                $this->load->view('Inventory/Stock/stockitem',$data);
                $this->load->view('dashboard/footer');
            }else{
                $qty = $qty1+$qty2;
                $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
                $data['qty'] = $qty;  
                $data['updated_by'] = $ID[0]->id;
                $data['updated_at'] = $this->Models->GetTimestamp();
                $this->Models->edit('m_stock','id',$this->input->post('id'),$data);


                $data2['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
                $data2['item'] = $this->Models->ItemWarehouse($id_warehouse);
                $data2['id_warehouse'] = $id_warehouse;
                $data2['type'] = $this->Models->getAll('m_category');
                $data2['title'] = "Stock Item";


                $config['upload_path']          = './file/log/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
                $config['file_name']            = uniqid();
                // $config['overwrite']			= true;
                $config['max_size']             = 4096; // 1MB
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;

                $this->load->library('upload', $config);
                
                if ($this->upload->do_upload('photo')) {
                    $data3['file'] = "/file/log/".$config['file_name'];
                }else{
                    $data3['file'] = "";
                }       
                $data3['id_item'] = $this->input->post('ItemName');
                $data3['id_warehouse'] = $id_warehouse;
                $data3['qty1'] = $qty1;
                $data3['balance'] = $qty2;
                $data3['qty2'] = $qty;
                $data3['description'] = 1;
                $data3['reason'] = $this->input->post('reason');
                $data3['back_date'] = $dates." 00:00:00";
                $data3['created_by'] = $ID[0]->id;
                $data3['updated_by'] = $ID[0]->id;
                $this->Models->insert('m_log',$data3);
                $this->Models->RepairLogItem($data3['id_item']);
                $this->load->view('dashboard/header',$data2);
                $this->load->view('Inventory/Stock/side',$data2);
                $this->load->view('Inventory/Stock/stockitem',$data2);
                $this->load->view('dashboard/footer');
                redirect(base_url('Stock/StockItem/'. $id_warehouse . '/' . $warehouse_name));   
            }
        }
    }
    public function AdjustStockItem($id_warehouse, $warehouse_name){
        $qty1 = $this->input->post('qtys');
        $qty2 = $this->input->post('qty2s');
        $dates = $this->input->post('date');
        $qty = $qty1-$qty2;
        if($qty2<0){
            $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $data['item'] = $this->Models->ItemWarehouse($id_warehouse);
            $data['id_warehouse'] = $id_warehouse;
            $data['warehouse_name'] = $warehouse_name;
            $data['type'] = $this->Models->getAll('m_category');
            $data['title'] = "Stock Item";
            $this->load->view('dashboard/header',$data);
            $this->load->view('Inventory/Stock/side',$data);
            $this->load->view('Inventory/Stock/stockitem',$data);
            $this->load->view('dashboard/footer');
        }else if($qty<0){
            $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $data['item'] = $this->Models->ItemWarehouse($id_warehouse);
            $data['id_warehouse'] = $id_warehouse;
            $data['warehouse_name'] = $warehouse_name;
            $data['type'] = $this->Models->getAll('m_category');
            $data['title'] = "Stock Item";
            $this->session->set_flashdata('pesan', '<script>alert("Total Barang Tidak Boleh Minus")</script>');
            $this->load->view('dashboard/header',$data);
            $this->load->view('Inventory/Stock/side',$data);
            $this->load->view('Inventory/Stock/stockitem',$data);
            $this->load->view('dashboard/footer');
        }else{
            
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $data['qty'] = $qty;  
            $data['updated_by'] = $ID[0]->id;
            $data['updated_at'] = $this->Models->GetTimestamp();
            $this->Models->edit('m_stock','id',$this->input->post('ids'),$data);
            

            $data2['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $data2['item'] = $this->Models->ItemWarehouse($id_warehouse);
            $data2['id_warehouse'] = $id_warehouse;
            $data2['type'] = $this->Models->getAll('m_category');
            $data2['title'] = "Stock Item";

            $config['upload_path']          = './file/log/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
            $config['file_name']            = uniqid();
            // $config['overwrite']			= true;
            $config['max_size']             = 4096; // 1MB
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;

            $this->load->library('upload', $config);
            
            if ($this->upload->do_upload('photos')) {
                $data3['file'] = "/file/log/".$config['file_name'];
            }else{
                $data3['file'] = "";
            }    
            $data3['id_item'] = $this->input->post('ItemNames');
            $data3['id_warehouse'] = $id_warehouse;
            $data3['qty1'] = $qty1;
            $data3['balance'] = $qty2;
            $data3['qty2'] = $qty;
            $data3['description'] = 0;
            $data3['reason'] = $this->input->post('reasons');
            $data3['created_by'] = $ID[0]->id;
            $data3['back_date'] = $dates." 00:00:00";
            $data3['updated_by'] = $ID[0]->id;
            $this->Models->insert('m_log',$data3);
            $this->Models->RepairLogItem($this->input->post('ItemNames'));
            $this->load->view('dashboard/header',$data2);
            $this->load->view('Inventory/Stock/side',$data2);
            $this->load->view('Inventory/Stock/stockitem',$data2);
            $this->load->view('dashboard/footer');
            redirect(base_url('Stock/StockItem/'. $id_warehouse . '/' . $warehouse_name));
        }
        
    }
    public function Allocation($name, $id_warehouse, $warehouse_name) {
        $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));  
        $name = urldecode($name); // Mengubah %20 menjadi spasi

        $Items = $this->Models->getID('m_item','id',$name);
    
        // var_dump($name);
        // die;
        // $data['limits'] = $limit;  
        // $data['updated_by'] = $ID[0]->id;
        // $data['updated_at'] = $this->Models->GetTimestamp();
        // $this->Models->edit('m_stock','id',$this->input->post('limit_id'),$data);

        $data['id_warehouse'] = $id_warehouse;
        $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));
        $data['item'] = $this->Models->AssetSearch($Items[0]->name);
        $data['warehouse'] = $this->Models->AllWarehouse();
        $data['warehouse_name'] = $warehouse_name;
        $data['type'] = $this->Models->getAll('m_category');
        $data['people'] = $this->Models->getID('m_user', 'people', "1");
        $data['environment'] = $this->Models->getID('m_user', 'people', "0");
        $data['title'] = 'Item';
    
        $this->load->view('dashboard/header', $data);
        $this->load->view('Inventory/Stock/side', $data);
        $this->load->view('Inventory/Stock/allocation', $data);
        $this->load->view('dashboard/footer');
    }
    public function ChangeAllocation($id_warehouse, $warehouse_name) {
        $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
        $name = $this->input->post('allocation_name');
        $IdStock = $this->input->post('stock_id');
        $user_allocation = $this->input->post('id_user');
        $remarks = $this->input->post('remarks');
        $ids = $this->input->post('allocation_id');
        
        


        $DataStock = $this->Models->getID('m_stock','id',$IdStock);
        $PrevUser = $this->Models->getID('m_user','id',$DataStock[0]->allocation);
        $NowUser = $this->Models->getID('m_user','id',$user_allocation);
        $Reasons = "Allocation Item ".$name." From ".$PrevUser[0]->name." To ".$NowUser[0]->name;

        $update['allocation'] = $user_allocation;  
        $update['remark'] = $remarks;  
        $update['updated_by'] = $ID[0]->id;
        $update['updated_at'] = $this->Models->GetTimestamp();
        $this->Models->edit('m_stock','id',$IdStock,$update);


        $id_item = $this->Models->getID('m_stock','id_item',$ids);
        $data3['id_item'] = $id_item[0]->id_item;   
        $data3['id_warehouse'] = $id_warehouse;   
        $data3['description'] = 2;
        $data3['reason'] = $Reasons;
        $data3['qty1'] = "1";
        $data3['balance'] = "1";
        $data3['qty2'] =  "1";
        $data3['back_date'] =  $this->Models->GetTimestamp();
        $data3['updated_at'] = $this->Models->GetTimestamp();
        $data3['updated_by'] = $ID[0]->id;
        $data3['created_at'] = $this->Models->GetTimestamp();
        $data3['created_by'] = $ID[0]->id;
        $this->Models->insert('m_log',$data3);
        $this->Models->RepairLogItem($data3['id_item']);
        $this->session->set_flashdata('pesan', '<script>alert("Data berhasil diubah")</script>');
        redirect(base_url("Stock"));

    
        $data['id_warehouse'] = $id_warehouse;
        $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));
        $data['item'] = $this->Models->AssetSearch($name);
        $data['warehouse'] = $this->Models->AllWarehouse();
        $data['warehouse_name'] = $warehouse_name;
        $data['type'] = $this->Models->getAll('m_category');
        $data['people'] = $this->Models->getID('m_user', 'people', "1");
        $data['environment'] = $this->Models->getID('m_user', 'people', "0");
        $data['title'] = 'Item';
    
        $this->load->view('dashboard/header', $data);
        $this->load->view('Inventory/Stock/side', $data);
        $this->load->view('Inventory/Stock/allocation', $data);
        $this->load->view('dashboard/footer');
    }
    public function LimitStockItem($id_warehouse, $warehouse_name){
        $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
        $limit = $this->input->post('limit');
        $data['limits'] = $limit;  
        $data['updated_by'] = $ID[0]->id;
        $data['updated_at'] = $this->Models->GetTimestamp();
        $this->Models->edit('m_stock','id',$this->input->post('limit_id'),$data);
        redirect(base_url('Stock/StockItem/'. $id_warehouse . '/' . $warehouse_name));
    }
    public function ImportExcel($id_warehouse,$warehouse_name) {
        // Mengunggah file
        $config['upload_path'] = './file/excel/';
        $config['allowed_types'] = 'xls|xlsx|csv';
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('excel_file')) {
            // Gagal mengunggah file
            $error = array('error' => $this->upload->display_errors());
            print_r($error);
        } else {
            // File berhasil diunggah
            $fileData = $this->upload->data();
            $filePath = './file/excel/' . $fileData['file_name'];

            // Menggunakan PhpSpreadsheet untuk membaca file Excel
            // $this->load->library('PhpSpreadsheet');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $ID = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
            // Proses data yang diimpor
            $db = $this->Models->importNewStock($sheetData,$ID[0]->id,$id_warehouse,$filePath);
            unlink($filePath);
            if($db==true){
                unlink($filePath);
                $this->session->set_flashdata('pesan','<script>alert("Data berhasil disimpan")</script>');
                redirect(base_url('Stock/StockItem/'. $id_warehouse . '/' . $warehouse_name));
            }else{
                // unlink($filePath);
                // var_dump($sheetData);
                // die;
                $this->session->set_flashdata('pesan','<script>alert("Data Gagal disimpan karena Kesalahan Format")</script>');
                redirect(base_url('Stock/StockItem/'. $id_warehouse . '/' . $warehouse_name));
            }
            // Hapus file setelah diimpor
            
          
        }
    }
}