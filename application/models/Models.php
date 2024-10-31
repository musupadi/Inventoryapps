<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Models extends CI_Model {
    public function GetTimestamp(){
        $tz = 'Asia/Jakarta';
        $dt = new DateTime("now", new DateTimeZone($tz));
        $timestamp = $dt->format('Y-m-d G:i:s');

        return $timestamp;
    }
    public function getAll($table){
        return $this->db->get($table)->result();
    }
    public function getID($table,$key,$id){
        return $this->db->get_where($table,array($key => $id))->result();
    }

    public function insert($table,$data){
        return $this->db->insert($table,$data);
    }

    public function edit($table,$key,$id,$data){
        return $this->db->update($table,$data,array($key => $id));
    }
    public function editAll($table, $data) {
        return $this->db->update($table, $data);
    }
    public function delete($table,$key,$id){
        return $this->db->delete($table,array($key => $id));
    }

    function getWhere($table,$where){
        return $this->db->get_where($table,$where)->result_array();
    }

    public function Count($table,$key,$id){
        $query = "SELECT Count(*) AS count FROM $table WHERE $key = '$id'";
        return $this->db->query($query)->result();
    }
    public function AllCount($table){
        $query = "SELECT COUNT (*) AS c FROM $table";
        return $this->db->query($query)->result();
    }
    public function RepairLogItem($id_item) {
        do{
            $ok = 1;
            $Log = $this->GetLogItem($id_item);
            // var_dump(count($Log));
            // die;
            foreach ($Log as $index => $repair) {
                $data = []; // Inisialisasi data kosong
                $id = $repair->id;
                $prev = $repair->qty1;
                $balance = $repair->balance;
                $after = $repair->qty2;
                $description = $repair->description;
        
                if ($index > 0) {
                    // Ambil qty2 dari transaksi sebelumnya sebagai AfterBefore
                    $AfterBefore = $Log[$index - 1]->qty2;
        
                    if ($description == "0") { // Item keluar
                        $expectedQty1 = $AfterBefore;
                        $expectedQty2 = $expectedQty1 - $balance;
        
                        // Perbaiki qty1 jika tidak sesuai
                        if ($prev != $expectedQty1) {
                            $data['qty1'] = $expectedQty1;
                        }
                        // Perbaiki qty2 jika tidak sesuai
                        if ($after != $expectedQty2) {
                            $data['qty2'] = $expectedQty2;
                        }
                    } else if ($description == "1") { // Item masuk
                        $expectedQty1 = $AfterBefore;
                        $expectedQty2 = $expectedQty1 + $balance;
        
                        // Perbaiki qty1 jika tidak sesuai
                        if ($prev != $expectedQty1) {
                            $data['qty1'] = $expectedQty1;
                        }
                        // Perbaiki qty2 jika tidak sesuai
                        if ($after != $expectedQty2) {
                            $data['qty2'] = $expectedQty2;
                        }
                    }
        
                    // Update jika ada perubahan pada qty1 atau qty2
                    if (!empty($data)) {
                        $this->edit('m_log', 'id', $id, $data);
                        $ok = 0;
                    }
                }
            }
        } while ($ok ==0);
        
    }
    public function itemOneMonth() {
        // Define start and end dates for one month time limit
        $startDate = date('Y-m-01'); // First day of current month
        $endDate = date('Y-m-t'); // Last day of previous month
        
        // Construct SQL query using CodeIgniter Query Builder
        $this->db->select('*');
        $this->db->from('m_item'); // Replace 'your_table' with your table name
        $this->db->where('created_at >=', $startDate);
        $this->db->where('created_at <=', $endDate);
        $query = $this->db->get();
        
        // Execute query and get result
        $result = $query->result();
        
        return $result;
    }

    public function transactionInOut() {
        // Define start and end dates for one month time limit
        $startDate = date('Y-m-01'); // First day of current month
        $endDate = date('Y-m-t'); // Last day of previous month
        
        // Construct SQL query using CodeIgniter Query Builder
        $this->db->select('*');
        $this->db->from('m_log'); // Replace 'your_table' with your table name
        $this->db->where('created_at >=', $startDate);
        $this->db->where('created_at <=', $endDate);
        $query = $this->db->get();
        
        // Execute query and get result
        $result = $query->result();
        
        return $result;
    }

    public function transactionIn() {
        // Define start and end dates for one month time limit
        $startDate = date('Y-m-01'); // First day of current month
        $endDate = date('Y-m-t'); // Last day of previous month
        
        // Construct SQL query using CodeIgniter Query Builder
        $this->db->select('*');
        $this->db->from('m_log'); // Replace 'your_table' with your table name
        $this->db->where('created_at >=', $startDate);
        $this->db->where('created_at <=', $endDate);
        $this->db->where('description', 1);
        $query = $this->db->get();
        
        // Execute query and get result
        $result = $query->result();
        
        return $result;
    }

    public function transactionOut() {
        // Define start and end dates for one month time limit
        $startDate = date('Y-m-01'); // First day of current month
        $endDate = date('Y-m-t'); // Last day of previous month
        
        // Construct SQL query using CodeIgniter Query Builder
        $this->db->select('*');
        $this->db->from('m_log'); // Replace 'your_table' with your table name
        $this->db->where('created_at >=', $startDate);
        $this->db->where('created_at <=', $endDate);
        $this->db->where('description', 0);
        $query = $this->db->get();
        
        // Execute query and get result
        $result = $query->result();
        
        return $result;
    }
    
    public function AllUser(){
        $this->db->select('a.id,a.name,a.username,a.email,b.label,a.photo,');
        $this->db->from('m_user as a');
        $this->db->order_by('id', 'desc');
        $this->db->join('m_role as b','a.id_role = b.id','left');
        $this->db->where('people', "1");
        $data = $this->db->get()->result();
        return $data;
    }

    public function GetQuantity($id_item,$id_warehouse){
        $this->db->select('id,qty');
        $this->db->from('m_stock');
        $this->db->where('id_item = '.$id_item);
        $this->db->where('id_warehouse = '.$id_warehouse);
        $data = $this->db->get()->result();
        return $data;
    }

    public function AllBrand(){
        $this->db->select('a.id, a.label as brand, b.label as origin, a.created_at, a.created_by, a.updated_at, a.updated_by');
        $this->db->from('m_brand as a');
        $this->db->join('m_origin as b','a.id_origin = b.id','left');
        $data = $this->db->get()->result();
        return $data;
    }
    public function GetLogItem($id_item){
        $this->db->select('*');
        $this->db->from('m_log');
        $this->db->where('id_item',$id_item);
        $this->db->order_by('back_date', 'asc');
        $this->db->order_by('created_at', 'asc');
        $data = $this->db->get()->result();
        return $data;
    }

    public function AssetSearch($name){
        $this->db->select('a.id,e.id as IdStock, a.name,g.label as status,f.name as allocation,f.people,f.id as id_allocation, b.label as type, a.asset_no, a.description, a.id_status, c.label as brand, d.label as vendor,a.warranty, a.serial_number, a.photo');
        $this->db->from('m_item as a'); 
        $this->db->join('m_category as b', 'a.id_category = b.id', 'left');
        $this->db->join('m_brand as c', 'a.id_brand = c.id', 'left'); // Corrected join condition
        $this->db->join('m_vendor as d', 'a.id_vendor = d.id', 'left');
        $this->db->join('m_stock as e','a.id = e.id_item');
        $this->db->join('m_user as f','e.allocation = f.id');
        $this->db->join('m_status as g','g.id = e.status');
        $this->db->where('a.name',$name);
        $this->db->order_by('a.id', 'asc');
        $data = $this->db->get()->result();
        return $data;
    }
    public function AllItem($asset = null) {
        $this->db->select('a.id, a.name, b.label as category, a.asset_no, a.description, a.id_status, c.label as brand, d.label as vendor, a.warranty, a.serial_number, a.photo');
        $this->db->from('m_item as a'); 
        $this->db->join('m_category as b', 'a.id_category = b.id', 'left');
        $this->db->join('m_brand as c', 'a.id_brand = c.id', 'left');
        $this->db->join('m_vendor as d', 'a.id_vendor = d.id', 'left');
        $this->db->where('a.id_status', 1); // Corrected where condition
        $this->db->group_by('a.name');
        $this->db->order_by('b.label', 'asc');
        $this->db->order_by('a.asset_no', 'asc');
        if ($asset === true) {
            $this->db->where('a.asset_no !=', 0);
        } elseif ($asset === false) {
            $this->db->where('a.asset_no', 0);
        }
    
        $data = $this->db->get()->result();
        return $data;
    }
    public function CountCheckerAsset2($id_warehouse,$category){
        $this->db->select('COUNT(*) as count');
        $this->db->from('m_item as a');
        $this->db->join('m_category as b', 'a.id_category = b.id', 'left');
        $this->db->join('m_brand as c', 'a.id_brand = c.id', 'left'); // Corrected join condition
        $this->db->join('m_vendor as d', 'a.id_vendor = d.id', 'left');
        $this->db->join('m_stock as e', 'a.id = e.id_item', 'left');
        $this->db->join('m_warehouse as f', 'e.id_warehouse = f.id', 'left');
        $this->db->join('m_user as g', 'e.allocation = g.id', 'left');
        $this->db->where('a.id_status = 1');
        $this->db->where('e.id_warehouse = '.$id_warehouse);
        $this->db->where('b.label =', $category);
        $data = $this->db->get()->result();
        return $data;
    }
    public function CountCheckerAsset($id_warehouse,$item_name){
        $this->db->select('COUNT(*) as count');
        $this->db->from('m_item as a');
        $this->db->join('m_category as b', 'a.id_category = b.id', 'left');
        $this->db->join('m_brand as c', 'a.id_brand = c.id', 'left'); // Corrected join condition
        $this->db->join('m_vendor as d', 'a.id_vendor = d.id', 'left');
        $this->db->join('m_stock as e', 'a.id = e.id_item', 'left');
        $this->db->join('m_warehouse as f', 'e.id_warehouse = f.id', 'left');
        $this->db->join('m_user as g', 'e.allocation = g.id', 'left');
        $this->db->where('a.id_status = 1');
        $this->db->where('e.id_warehouse = '.$id_warehouse);
        $this->db->where('a.name =', $item_name);
        $data = $this->db->get()->result();
        return $data;
    }
    public function CategoryData($id_warehouse,$asset = null,$category = null){
        $this->db->select('e.allocation,e.asset,e.id,a.id as ItemName,e.limits, a.name, b.label as type, a.asset_no, a.description, a.id_status, c.label as brand, d.label as vendor, a.warranty, a.serial_number, a.photo,e.qty,f.name as warehouse');
        $this->db->from('m_item as a');
        $this->db->join('m_category as b', 'a.id_category = b.id', 'left');
        $this->db->join('m_brand as c', 'a.id_brand = c.id', 'left'); // Corrected join condition
        $this->db->join('m_vendor as d', 'a.id_vendor = d.id', 'left');
        $this->db->join('m_stock as e', 'a.id = e.id_item', 'left');
        $this->db->join('m_warehouse as f', 'e.id_warehouse = f.id', 'left');
        $this->db->join('m_user as g', 'e.allocation = g.id', 'left');
        $this->db->where('a.id_status = 1');
        $this->db->where('e.id_warehouse = '.$id_warehouse);
        $this->db->order_by('b.label', 'asc');
        $this->db->order_by('a.asset_no', 'asc');
        $this->db->group_by('b.label');
        if ($asset === true) {
            $this->db->where('a.asset_no !=', "0");
            if($category === true){
                
            }
        } elseif ($asset === false) {
            $this->db->where('a.asset_no', "0");
        }
    
        $data = $this->db->get()->result();
        return $data;
    }
    public function ItemWarehouse($id_warehouse,$asset = null,$category = null){
        $this->db->select('e.allocation,e.asset,e.id,a.id as ItemName,e.limits, a.name, b.label as type, a.asset_no, a.description, a.id_status, c.label as brand, d.label as vendor, a.warranty, a.serial_number, a.photo,e.qty,f.name as warehouse');
        $this->db->from('m_item as a');
        $this->db->join('m_category as b', 'a.id_category = b.id', 'left');
        $this->db->join('m_brand as c', 'a.id_brand = c.id', 'left'); // Corrected join condition
        $this->db->join('m_vendor as d', 'a.id_vendor = d.id', 'left');
        $this->db->join('m_stock as e', 'a.id = e.id_item', 'left');
        $this->db->join('m_warehouse as f', 'e.id_warehouse = f.id', 'left');
        $this->db->join('m_user as g', 'e.allocation = g.id', 'left');
        $this->db->where('a.id_status = 1');
        $this->db->where('e.id_warehouse = '.$id_warehouse);
        $this->db->order_by('b.label', 'asc');
        $this->db->order_by('a.asset_no', 'asc');
        if($category != null){
            $this->db->group_by('b.label');
        }else{
            $this->db->group_by('a.name');  // Add GROUP BY clause
        }
        if ($asset === true) {
            $this->db->where('a.asset_no !=', "0");
            if($category === true){
                
            }
        } elseif ($asset === false) {
            $this->db->where('a.asset_no', "0");
        }
    
        $data = $this->db->get()->result();
        return $data;
    }
    public function importNewStock($data,$id_user,$id_warehouse,$filePath) {
        // Proses data yang diimpor, seperti validasi dan penyimpanan ke database
        // Anda perlu menyesuaikan kode ini sesuai dengan struktur data Anda dan aturan bisnis Anda
        $this->db->trans_begin();
        $error = 0;
		foreach ($data as $i => $row) {
            if(!empty($row[0])){
                if($i > 0){
                    $where = array(
                        'name' => $row[1],
                        'asset_no' => $row[3]
                    );
                    $item = $this->Models->data_login("m_item",$where)->result();
                    // $item = $this->getID('m_item','name',$row[1]);
                    if(!empty($item)){
                        if($row[3] == "0"){
                            $id_item = $item['id'];
                            $stock['qty'] = $row[8];   
                            $stock['id_item'] = $id_item;
                            $stock['id_warehouse'] = $id_warehouse;
                            $stock['limits'] = $row[9]; 
                            $stock['asset'] = "0"; 
                            if($row[3] != "0" || $row[3] != ""){
                                $stock['asset'] = "1";
                                $Allocation = $this->Models->getID("m_user","name",$row[12]);
                                if(!empty($Allocation)){
                                    $stock['allocation'] = $Allocation[0]->id;
                                }else{
                                    if(empty($row[12]) || $row[12] == ""){
                                        $stock['allocation'] = "";
                                    }else{
                                        if($row[13] != "1"){
                                            $user['people'] = "0";
                                        }else{
                                            $user['people'] = "1";
                                        }
                                     
                                        $user['name'] = $row[12];
                                        $user['username'] = $row[12];
                                        $user['password'] = MD5("Podomoro");
                                        $user['email'] = "";
                                        $user['department'] = "";
                                        $user['phone_number'] = "";
                                        $user['id_role '] = "4";
                                        $user['jabatan'] = $row[14];
                                        $user['photo'] = "logo.jpg";
                                        $user['created_by'] = $id_user;
                                        $user['updated_by'] = $id_user;
                                    
                                        $this->Models->insert('m_user',$user);
                                        $idUsers = $this->db->insert_id();
                                        $stock['allocation'] = $idUsers;
                                    }
                                }
                            }
                            $LocationData = $this->Models->getID("m_location","label",$row[15]);
                            if(!empty($LocationData)){
                                $stock['location'] = $row[15];
                            }else{
                                if($row[15] == "0" || $row[15] == ""){
                                    $stock['location'] = "-";
                                }else{
            
                                    $location['label'] = $row[15];
                                    $location['created_by'] = $id_user;
                                    $location['updated_by'] = $id_user;
                    
                                        
                                    $this->Models->insert('m_location',$location);
                                    $lastID = $this->db->insert_id();
                                    $stock['location'] = $lastID;
                                }
                            }
                            $StatusData = $this->Models->getID("m_status","label",$row[17]);
                            if(!empty($StatusData)){
                                $stock['status'] = $row[17];
                            }else{
                                if($row[17] == "0" || $row[17] == ""){
                                    $stock['status'] = "-";
                                }else{
            
                                    $location['label'] = $row[17];
                                    $location['created_by'] = $id_user;
                                    $location['updated_by'] = $id_user;
                    
                                        
                                    $this->Models->insert('m_status',$location);
                                    $lastID = $this->db->insert_id();
                                    $stock['status'] = $lastID;
                                }
                            }
                            $stock['created_by'] = $id_user;
                            $stock['created_at'] = $this->Models->GetTimestamp();
                            $stock['updated_by'] = $id_user;
                            $stock['updated_at'] = $this->Models->GetTimestamp();
                            $this->edit('m_stock','id_item', $id_item,$stock);
                            $where = array(
                                'id_item' => $id_item,
                                'id_warehouse' => $id_warehouse
                            );
                            $StockItem = $this->Models->data_login("m_stock",$where)->result();
                            //Logs
                            $logs['file'] = "";
                            $logs['id_item'] = $id_item;
                            $logs['id_warehouse'] = $id_warehouse;
                            if($StockItem){
                                $logs['qty1'] = $StockItem[0]->qty;
                            }else{
                                $logs['qty1'] = "0";
                            }
                            $logs['balance'] = $row[8];
                            $logs['qty2'] = $row[8];
                            $logs['description'] = 1;
                            $logs['reason'] = "Update new item from Excel";
                            $logs['back_date'] = $row[18]." 00:00:00";
                            $logs['created_by'] = $id_user;
                            $logs['updated_by'] = $id_user;
                            $this->insert('m_log',$logs);
                        }else{
                            $Allocation = $this->Models->getID("m_user","name",$row[12]);
                            if(!empty($Allocation)){
                                $stock['allocation'] = $Allocation[0]->id;
                            }else{
                                if(empty($row[12]) || $row[12] == ""){
                                    $stock['allocation'] = $Allocation[0]->id;
                                }else{
                                    if($row[13] != "1"){
                                        $user['people'] = "0";
                                    }else{
                                        $user['people'] = "1";
                                    }
                                 
                                    $user['name'] = $row[12];
                                    $user['username'] = $row[12];
                                    $user['password'] = MD5("Podomoro");
                                    $user['email'] = "";
                                    $user['department'] = "";
                                    $user['phone_number'] = "";
                                    $user['id_role '] = "4";
                                    $user['jabatan'] = $row[14];
                                    $user['photo'] = "logo.jpg";
                                    $user['created_by'] = $id_user;
                                    $user['updated_by'] = $id_user;
                                
                                    $this->Models->insert('m_user',$user);
                                    $idUsers = $this->db->insert_id();
                                    $stock['allocation'] = $idUsers;
                                }
                            }
                            $id_item = $item[0]->id;
                            $stock['qty'] = $row[8];   
                            $stock['id_item'] = $id_item;
                            $stock['id_warehouse'] = $id_warehouse;
                            $stock['limits'] = "0"; 
                            $stock['asset'] = "1";
                            $stock['remark'] = "1"; 
                            $LocationData = $this->Models->getID("m_location","label",$row[15]);
                           
                            if(!empty($LocationData)){
                                $stock['location'] = $LocationData[0]->id;
                            }else{
                                if($row[15] == "0" || $row[15] == ""){
                                    $location['label'] = "-";
                                    $location['created_by'] = $id_user;
                                    $location['updated_by'] = $id_user;
                    
                                        
                                    $this->Models->insert('m_location',$location);
                                    $lastID = $this->db->insert_id();
                                    $stock['location'] = $lastID;
                                }else{
                                    $location['label'] = $row[15];
                                    $location['created_by'] = $id_user;
                                    $location['updated_by'] = $id_user;
                    
                                        
                                    $this->Models->insert('m_location',$location);
                                    $lastID = $this->db->insert_id();
                                    $stock['location'] = $lastID;
                                }
                            }
                            $StatusData = $this->Models->getID("m_status","label",$row[17]);
                            
                            if(!empty($StatusData)){
                                $stock['status'] = $StatusData[0]->id;
                            }else{
                                if($row[17] == "0" || $row[17] == "" || empty($row[17])){
                                    $location['label'] = "-";
                                    $location['created_by'] = $id_user;
                                    $location['updated_by'] = $id_user;
                    
                                        
                                    $this->Models->insert('m_status',$location);
                                    $lastID = $this->db->insert_id();
                                    $stock['status'] = $lastID;
                                }else{
                                
                                    $location['label'] = $row[17];
                                    $location['created_by'] = $id_user;
                                    $location['updated_by'] = $id_user;
                    
                                        
                                    $this->Models->insert('m_status',$location);
                                    $lastID = $this->db->insert_id();
                                    $stock['status'] = $lastID;
                                }
                            }
                            if(empty($row[16])){
                                $stock['remark'] = "-";
                            }else{
                                $stock['remark'] = $row[16];
                            }
                            
                            $stock['created_by'] = $id_user;
                            $stock['created_at'] = $this->Models->GetTimestamp();
                            $stock['updated_by'] = $id_user;
                            $stock['updated_at'] = $this->Models->GetTimestamp();
                                 
                            $this->edit('m_stock','id_item', $id_item,$stock);
                            
                            //Logs
                            $where = array(
                                'id_item' => $id_item,
                                'id_warehouse' => $id_warehouse
                            );
                            $StockItems = $this->Models->data_login("m_stock",$where)->result();
                            if($StockItems){
                                $logs['qty1'] = $StockItems[0]->qty;
                            }else{
                                $logs['qty1'] = "0";
                            }
                            $logs['file'] = "";
                            $logs['id_item'] = $id_item;
                            $logs['id_warehouse'] = $id_warehouse;
        
                            $logs['balance'] = $row[8];
                            $logs['qty2'] = $row[8];
                            $logs['description'] = 1;
                            $logs['reason'] = "Update new item from Excel";
                            $logs['back_date'] = $row[18]." 00:00:00";
                            $logs['created_by'] = $id_user;
                            $logs['updated_by'] = $id_user;
                            $this->insert('m_log',$logs);
                        }
                    }else{
                        $category = $this->getID('m_category', 'label', $row[2]);
                        if(!empty($category)){
                            $id_category = $category[0]->id;
                        }else{
                            $insertCat = array(
                                'label' => $row[2],
                                'created_by' => $id_user,
                                'updated_by' => $id_user
                                // Lanjutkan untuk kolom-kolom lainnya
                            );
                            // Simpan data ke database
                            $this->db->insert('m_category', $insertCat);
                            // Mengambil ID terakhir yang diinsert
                            $id_category = $this->db->insert_id();
                        }
                        $brand = $this->getID('m_brand', 'label', $row[5]);
                        if(!empty($brand)){
                            $id_brand = $brand[0]->id;
                        }else{
                            $insertBrand = array(
                                'label' => $row[5],
                                'created_by' => $id_user,
                                'updated_by' => $id_user
                                // Lanjutkan untuk kolom-kolom lainnya
                            );
                            // Simpan data ke database
                            $this->db->insert('m_brand', $insertBrand);
                            // Mengambil ID terakhir yang diinsert
                            $id_brand = $this->db->insert_id();
                        }
                        $vendor = $this->getID('m_vendor', 'label', $row[6]);
                        if(!empty($vendor)){
                            $id_vendor = $vendor[0]->id;
                        }else{
                            $insertVendor = array(
                                'label' => $row[6],
                                'created_by' => $id_user,
                                'updated_by' => $id_user
                                // Lanjutkan untuk kolom-kolom lainnya
                            );
                            // Simpan data ke database
                            $this->db->insert('m_vendor', $insertVendor);
                            // Mengambil ID terakhir yang diinsert
                            $id_vendor = $this->db->insert_id();
                        }
                        $insertItem = array(
                            'name' => $row[1],
                            'id_category' => $id_category,
                            'asset_no' => $row[3],
                            'description' => $row[4],
                            'id_status ' => 1,
                            'id_brand ' => $id_brand,
                            'id_vendor ' => $id_vendor,
                            'warranty ' => "",
                            'serial_number ' => $row[7],
                            'photo ' => 'default.jpg',
                            'created_by' => $id_user,
                            'updated_by' => $id_user
                            // Lanjutkan untuk kolom-kolom lainnya
                        );
                        // Simpan data ke database
                        $this->db->insert('m_item', $insertItem);
                        // Mengambil ID terakhir yang diinsert
                        $id_item = $this->db->insert_id();
                       
                        //New Item
                        $stock['qty'] = $row[8];   
                        $stock['id_item'] = $id_item;
                        $stock['id_warehouse'] = $id_warehouse;
                        $stock['limits'] = $row[9];
                   
                        if($row[3] != "0" || $row[3] != ""){
                            $stock['asset'] = "1";
                            $Allocation = $this->Models->getID("m_user","name",$row[12]);
                            if(!empty($Allocation)){
                                $stock['allocation'] = $Allocation[0]->id;
                            }else{
                                if(empty($row[12]) || $row[12] == ""){
                                    $stock['allocation'] = "";
                                }else{
                                    if($row[13] != "1"){
                                        $user['people'] = "0";
                                    }else{
                                        $user['people'] = "1";
                                    }
                                 
                                    $user['name'] = $row[12];
                                    $user['username'] = $row[12];
                                    $user['password'] = MD5("Podomoro");
                                    $user['email'] = "";
                                    $user['department'] = "";
                                    $user['phone_number'] = "";
                                    $user['id_role '] = "4";
                                    $user['jabatan'] = $row[14];
                                    $user['photo'] = "logo.jpg";
                                    $user['created_by'] = $id_user;
                                    $user['updated_by'] = $id_user;
                                
                                    $this->Models->insert('m_user',$user);
                                    $idUsers = $this->db->insert_id();
                                    $stock['allocation'] = $idUsers;
                                }
                            }
                        }
                        $LocationData = $this->Models->getID("m_location","label",$row[15]);
                        if(!empty($LocationData)){
                            $stock['location'] = $LocationData[0]->id;
                        }else{
                            if($row[15] == "0" || $row[15] == ""){
                                $stock['location'] = $row[15];
                            }else{
        
                                $location['label'] = $row[15];
                                $location['created_by'] = $id_user;
                                $location['updated_by'] = $id_user;
                 
                                    
                                $this->Models->insert('m_location',$location);
                                $lastID = $this->db->insert_id();
                                $stock['location'] = $lastID;
                            }
                        }
                        $StatusData = $this->Models->getID("m_status","label",$row[17]);
                        if(!empty($StatusData)){
                            $stock['status'] = $StatusData[0]->id;
                        }else{
                            if($row[17] == "0" || $row[17] == ""){
                                $status['label'] = "-";
                                $status['created_by'] = $id_user;
                                $status['updated_by'] = $id_user;
                 
                                    
                                $this->Models->insert('m_status',$status);
                                $lastID = $this->db->insert_id();
                                $stock['status'] = $lastID;
                            }else{
        
                                $location['label'] = $row[17];
                                $location['created_by'] = $id_user;
                                $location['updated_by'] = $id_user;
                 
                                    
                                $this->Models->insert('m_status',$location);
                                $lastID = $this->db->insert_id();
                                $stock['status'] = $lastID;
                            }
                        }
                        if(empty($row[16])){
                            $stock['remark'] = "-";
                        }else{
                            $stock['remark'] = $row[16];
                        }
                        $stock['created_by'] = $id_user;
                        $stock['created_at'] = $this->Models->GetTimestamp();
                        $stock['updated_by'] = $id_user;
                        $stock['updated_at'] = $this->Models->GetTimestamp();
                        $this->insert('m_stock',$stock);   
        
                        //Logs
                        $logs['file'] = "";
                        $logs['id_item'] = $id_item;
                        $logs['id_warehouse'] = $id_warehouse;
                        $logs['qty1'] = "0";
                        $logs['balance'] = $row[8];
                        $logs['qty2'] = $row[8];
                        $logs['description'] = 1;
                        $logs['reason'] = "Input new item from Excel";
                        $logs['back_date'] = $row[18]." 00:00:00";
                        $logs['created_by'] = $id_user;
                        $logs['updated_by'] = $id_user;
                        $this->insert('m_log',$logs);
                    }    
                }
            }
        }		
		if ($this->db->trans_status() === FALSE || $error == 1)
		{
            unlink($filePath);
			$this->db->trans_rollback();
			return FALSE;
		}
		else
		{
            unlink($filePath);
			$this->db->trans_commit();
			return TRUE;
		}
    }
    public function ItemWarehouseSearch($id_item){
        $this->db->select('e.id,a.id as ItemName, a.name, b.label as type, a.asset_no, a.description, a.id_status, c.label as brand, d.label as vendor, a.warranty, a.serial_number, a.photo,e.qty, f.id as id_warehouse ,f.name as warehouse,f.description as warehouse_description');
        $this->db->from('m_item as a');
        $this->db->join('m_category as b', 'a.id_category = b.id');
        $this->db->join('m_brand as c', 'a.id_brand = c.id'); // Corrected join condition
        $this->db->join('m_vendor as d', 'a.id_vendor = d.id');
        $this->db->join('m_stock as e', 'a.id = e.id_item');
        $this->db->join('m_warehouse as f', 'e.id_warehouse = f.id');
        $this->db->where('a.id_status = 1');
        $this->db->where('a.id = '.$id_item);
        $data = $this->db->get()->result();
        return $data;
    }
    
    public function AllVendor(){
        $this->db->select('id, label, created_at, created_by, updated_at, updated_by');
        $this->db->from('m_vendor');
        $data = $this->db->get()->result();
        return $data;
    }

    public function AllAnnouncement($id){
        $this->db->select('a.id, a.title, a.description, a.receiver, a.author, a.date, a.created_at,b.name');
        $this->db->from('m_announcement a');
        $this->db->join('m_user b','a.created_by = b.id');
        $this->db->order_by('date', 'desc');
        $this->db->where('id_status = 1');
        if($id != null || $id != ""){
            $this->db->where('a.id',$id);
        }
        $data = $this->db->get()->result();
        return $data;
    }

    public function moreInfoAnnouncement($id){
        $this->db->select('id, title, description, receiver, author, date, created_at');
        $this->db->from('m_announcement');
        $this->db->where('id_status = 1');
        $this->db->where('id', $id);
        $data = $this->db->get()->result();
        return $data;
    }

    public function AllWarehouse(){
        $this->db->select('a.id, a.name, a.description, b.label as location, a.created_at, a.created_by, a.updated_at, a.updated_by');
        $this->db->from('m_warehouse as a');
        $this->db->join('m_location as b', 'a.id_location = b.id', 'left');
        $data = $this->db->get()->result();
        return $data;
    }

    public function RoleWarehouse($id_user){
        $this->db->select('a.id, a.id_user,a.id_warehouse, b.name, a.created_at, a.created_by, a.updated_at, a.updated_by');
        $this->db->from('role_warehouse as a');
        $this->db->join('m_warehouse as b', 'a.id_warehouse = b.id', 'left');
        $this->db->where('a.id_user', $id_user);
        $data = $this->db->get()->result();
        return $data;
    }

    public function AllType(){
        $this->db->select('id, label, created_at, created_by, updated_at, updated_by');
        $this->db->from('m_category');
        $data = $this->db->get()->result();
        return $data;
    }

    public function AllOrigin(){
        $this->db->select('id, label, created_at, created_by, updated_at, updated_by');
        $this->db->from('m_origin');
        $data = $this->db->get()->result();
        return $data;
    }

    public function AllTRItem(){
        $this->db->select('b.name as names, c.name, a.category, a.status_handover, a.handover_date, d.label, d.floor, a.image, a.created_at, a.created_by, a.updated_at, a.updated_by');
        $this->db->from('tr_item as a');
        $this->db->join('m_user as b', 'a.id_user = b.id', 'left');
        $this->db->join('m_item as c', 'a.id_item = c.id', 'left');
        $this->db->join('m_location as d', 'a.id_location = d.id', 'left');
        $data = $this->db->get()->result();
        return $data;
    }

    public function AllRole(){
        $this->db->select('id, label, level, created_at, created_by, updated_at, updated_by');
        $this->db->from('m_role');
        $data = $this->db->get()->result();
        return $data;
    }

    public function AllLocation(){
        $this->db->select('id, label, floor, created_at, created_by, updated_at, updated_by');
        $this->db->from('m_location');
        $data = $this->db->get()->result();
        return $data;
    }
    public function LoginData($username,$password){
        $this->db->select('a.id as id_user,a.name,a.email,a.photo,b.label as role,b.level');
        $this->db->from('m_user as a');
        $this->db->join('m_role as b', 'a.id_role = b.id', 'left');
        $this->db->where('a.username',$username);
        $this->db->where('a.password',$password);
        $data = $this->db->get()->result();
        return $data;
    }
    function data_login($table,$where){
        return $this->db->get_where($table,$where);
    }
    public function AllDetail($username){
        $this->db->select('name, username, email, department, phone_number');
        $this->db->from('tr_item');
        $this->db->order_by('id', 'desc');
        $this->db->where('username',$username);
        $data = $this->db->get()->result();
        return $data;
    }


   

    public function AllTransaction($id_warehouse = null){
        $this->db->select('a.reason,e.id as id_warehouse,c.id as id_item,b.id as id_user,b.name,c.name as item_name,
        d.label as category,c.asset_no,c.description,c.warranty,a.name,a.username,a.email,a.department,a.phone_number,
        c.serial_number,c.photo,a.handover_date,a.image,
        a.status,a.created_at,a.created_by,a.updated_at,a.updated_by,a.qty,a.id,a.handover_date,
        e.name as warehouse_name');
        $this->db->from('tr_item as a');
        $this->db->order_by('id', 'desc');
        $this->db->join('m_user as b', 'a.id_user = b.id', 'left');
        $this->db->join('m_item as c', 'a.id_item = c.id', 'left');
        $this->db->join('m_category as d', 'c.id_category = d.id', 'left');
        $this->db->join('m_warehouse as e', 'a.id_warehouse = e.id', 'left');
        if($id_warehouse != null){
            $this->db->where('e.id', $id_warehouse);
        }
        $data = $this->db->get()->result();
        return $data;
    }
    public function CountTransactions($id_warehouse = null, $id_user = null, $transaction = null){
        $this->db->select('COUNT(*) as count');
    
        $this->db->from('tr_item as a');
        $this->db->order_by('a.id', 'desc');
        $this->db->join('m_user as b', 'a.id_user = b.id', 'left');
        $this->db->join('m_item as c', 'a.id_item = c.id', 'left');
        $this->db->join('m_category as d', 'c.id_category = d.id', 'left');
        $this->db->join('m_warehouse as e', 'a.id_warehouse = e.id', 'left');
    
        if ($id_warehouse !== null) {
            $this->db->where('e.id', $id_warehouse);
        }
    
        if ($id_user !== null) {
            $this->db->where('b.id', $id_user);
        }
    
        if ($transaction !== null) {
            if($transaction == "Weekly"){
                $this->db->where('a.created_at >=', date('Y-m-d H:i:s', strtotime('-1 week')));
            } else if($transaction == "Monthly"){
                $this->db->where('a.created_at >=', date('Y-m-d H:i:s', strtotime('-1 month')));
            }
        }
    
        $query = $this->db->get();
        $result = $query->row();
        return $result->count;
    }
    public function Transaction($id_warehouse = null, $id_user = null, $transaction = null){
        $this->db->select('a.reason, e.id as id_warehouse, c.id as id_item, b.id as id_user, b.name, 
            c.name as item_name, d.label as category, c.asset_no, c.description, c.warranty, 
            a.name, a.username, a.email, a.department, a.phone_number, c.serial_number, c.photo, 
            a.handover_date, a.image, a.status, a.created_at, a.created_by, a.updated_at, a.updated_by, 
            a.qty, a.id, a.handover_date, e.name as warehouse_name');
        $this->db->from('tr_item as a');
        $this->db->order_by('a.id', 'desc');
        $this->db->join('m_user as b', 'a.id_user = b.id', 'left');
        $this->db->join('m_item as c', 'a.id_item = c.id', 'left');
        $this->db->join('m_category as d', 'c.id_category = d.id', 'left');
        $this->db->join('m_warehouse as e', 'a.id_warehouse = e.id', 'left');
    
        if ($id_warehouse !== null) {
            $this->db->where('e.id', $id_warehouse);
        }
    
        if ($id_user !== null) {
            $this->db->where('b.id', $id_user);
        }
    
        if ($transaction !== null) {
            if($transaction == "Weekly"){
                $this->db->where('a.created_at >=', date('Y-m-d H:i:s', strtotime('-1 week')));
            } else if($transaction == "Monthly"){
                $this->db->where('a.created_at >=', date('Y-m-d H:i:s', strtotime('-1 month')));
            }
        }
    
        $data = $this->db->get()->result();
        return $data; // You might want to return the data to use it later
    }
    public function CountTransactionUser($id_user,$status = null){
        $this->db->select('count(*) count');
        $this->db->from('tr_item as a');
        $this->db->join('m_user as b', 'a.id_user = b.id', 'left');
        $this->db->join('m_item as c', 'a.id_item = c.id', 'left');
        $this->db->join('m_category as d', 'c.id_category = d.id', 'left');
        $this->db->join('m_warehouse as e', 'a.id_warehouse = e.id', 'left');
        $this->db->where('b.id',$id_user);
        if($status){
            $this->db->where('a.status',$status);
        }
        $data = $this->db->get()->result();
        return $data;
    }
    public function Transactionuser($id_user){
        $this->db->select('e.id as id_warehouse,c.id as id_item,b.id as id_user,b.name,c.name as item_name,a.created_at,a.reason,
        d.label as category,c.asset_no,c.description,c.warranty,a.name,a.username,a.email,a.department,a.phone_number,
        c.serial_number,c.photo,a.handover_date,a.image,
        a.status,a.created_at,a.created_by,a.updated_at,a.updated_by,a.qty,a.id,a.handover_date,
        e.name as warehouse_name');
        $this->db->from('tr_item as a');
        $this->db->order_by('id', 'desc');
        $this->db->join('m_user as b', 'a.id_user = b.id', 'left');
        $this->db->join('m_item as c', 'a.id_item = c.id', 'left');
        $this->db->join('m_category as d', 'c.id_category = d.id', 'left');
        $this->db->join('m_warehouse as e', 'a.id_warehouse = e.id', 'left');
        $this->db->where('b.id',$id_user);
        $data = $this->db->get()->result();
        return $data;
    }

    public function AllHistoryTransaction(){
        $this->db->select('a.back_date,d.department,a.balance,a.reason,a.id,a.id_item,b.name as item_name ,c.name as warehouse,a.id_warehouse,a.description,a.qty1, a.qty2 ,a.created_at,a.created_by,a.updated_at,a.updated_by,d.name as user,e.name as receiver');
        $this->db->from('m_log as a');
        $this->db->join('m_item as b', 'a.id_item = b.id', 'left');
        $this->db->join('m_warehouse as c', 'a.id_warehouse = c.id', 'left'); // Corrected join condition
        $this->db->join('m_user as d', 'a.created_by = d.id', 'left'); // Corrected join condition
        $this->db->join('m_user as e', 'a.updated_by = e.id', 'left'); // Corrected join condition
        $this->db->order_by('a.back_date', 'desc');
        $data = $this->db->get()->result();
        return $data;
    }
    public function AllHistoryTransactionFilter($date1,$date2){
        $this->db->select('a.back_date,d.department,a.balance,a.reason,a.id,a.id_item,b.name as item_name ,c.name as warehouse,a.id_warehouse,a.description,a.qty1, a.qty2 ,a.created_at,a.created_by,a.updated_at,a.updated_by,d.name as user,e.name as receiver');
        $this->db->from('m_log as a');
        $this->db->join('m_item as b', 'a.id_item = b.id', 'left');
        $this->db->join('m_warehouse as c', 'a.id_warehouse = c.id', 'left'); // Corrected join condition
        $this->db->join('m_user as d', 'a.created_by = d.id', 'left'); // Corrected join condition
        $this->db->join('m_user as e', 'a.updated_by = e.id', 'left'); // Corrected join condition
        $this->db->where('a.created_at >=', $date1);
        $this->db->where('a.created_at <=', $date2);
        $this->db->order_by('a.back_date', 'desc');
        $this->db->order_by('a.created_at', 'desc'); // Order by created_at as second priority
        $data = $this->db->get()->result();
        return $data;
    }
    public function AllHistoryTransactionItem($id_item){
        $this->db->select('a.back_date,d.department,a.balance,a.reason,a.id,a.id_item,b.name as item_name ,c.name as warehouse,a.id_warehouse,a.description,a.qty1, a.qty2 ,a.created_at,a.created_by,a.updated_at,a.updated_by,d.name as user,e.name as receiver');
        $this->db->from('m_log as a');
        $this->db->join('m_item as b', 'a.id_item = b.id', 'left');
        $this->db->join('m_warehouse as c', 'a.id_warehouse = c.id', 'left'); // Corrected join condition
        $this->db->join('m_user as d', 'a.created_by = d.id', 'left'); // Corrected join condition
        $this->db->join('m_user as e', 'a.updated_by = e.id', 'left'); // Corrected join condition
        $this->db->where('a.id_item', $id_item);
        $this->db->order_by('a.back_date', 'desc');
        $this->db->order_by('a.created_at', 'desc'); // Order by created_at as second priority
        $data = $this->db->get()->result();
        return $data;
    }
    public function AllHistoryTransactionFilterItem($date1,$date2,$id_item){
        $this->db->select('a.back_date,d.department,a.balance,a.reason,a.id,a.id_item,b.name as item_name ,c.name as warehouse,a.id_warehouse,a.description,a.qty1, a.qty2 ,a.created_at,a.created_by,a.updated_at,a.updated_by,d.name as user,e.name as receiver');
        $this->db->from('m_log as a');
        $this->db->join('m_item as b', 'a.id_item = b.id', 'left');
        $this->db->join('m_warehouse as c', 'a.id_warehouse = c.id', 'left'); // Corrected join condition
        $this->db->join('m_user as d', 'a.created_by = d.id', 'left'); // Corrected join condition
        $this->db->join('m_user as e', 'a.updated_by = e.id', 'left'); // Corrected join condition
        $this->db->where('a.created_at >=', $date1);
        $this->db->where('a.created_at <=', $date2);
        $this->db->where('a.id_item', $id_item);
        $this->db->order_by('a.back_date', 'desc');
        $this->db->order_by('a.created_at', 'desc'); // Order by created_at as second priority
        $data = $this->db->get()->result();
        return $data;
    }

    //Models2
    public function AllHistoryTransactionAdmin($id_warehouse){
        $this->db->select('a.back_date,d.department,a.balance,a.reason,a.id,a.id_item,b.name as item_name ,c.name as warehouse,a.id_warehouse,a.description,a.qty1, a.qty2 ,a.created_at,a.created_by,a.updated_at,a.updated_by,d.name as user,e.name as receiver');
        $this->db->from('m_log as a');
        $this->db->join('m_item as b', 'a.id_item = b.id', 'left');
        $this->db->join('m_warehouse as c', 'a.id_warehouse = c.id', 'left'); // Corrected join condition
        $this->db->join('m_user as d', 'a.created_by = d.id', 'left'); // Corrected join condition
        $this->db->join('m_user as e', 'a.updated_by = e.id', 'left'); // Corrected join condition
        
        $this->db->where('a.id_warehouse', $id_warehouse);
        $this->db->order_by('a.back_date', 'desc');
        $this->db->order_by('a.created_at', 'desc'); // Order by created_at as second priority
        $data = $this->db->get()->result();
        return $data;
    }
    public function AllHistoryTransactionFilterAdmin($date1,$date2,$id_warehouse){
        $this->db->select('a.back_date,d.department,a.balance,a.reason,a.id,a.id_item,b.name as item_name ,c.name as warehouse,a.id_warehouse,a.description,a.qty1, a.qty2 ,a.created_at,a.created_by,a.updated_at,a.updated_by,d.name as user,e.name as receiver');
        $this->db->from('m_log as a');
        $this->db->join('m_item as b', 'a.id_item = b.id', 'left');
        $this->db->join('m_warehouse as c', 'a.id_warehouse = c.id', 'left'); // Corrected join condition
        $this->db->join('m_user as d', 'a.created_by = d.id', 'left'); // Corrected join condition
        $this->db->join('m_user as e', 'a.updated_by = e.id', 'left'); // Corrected join condition
        // $this->db->where("a.created_at BETWEEN '$date1' AND '$date2'");
        $this->db->where('a.created_at >=', $date1);
        $this->db->where('a.created_at <=', $date2);
        $this->db->where('a.id_warehouse', $id_warehouse);
        $this->db->order_by('a.back_date', 'desc');
        $this->db->order_by('a.created_at', 'desc'); // Order by created_at as second priority
        $data = $this->db->get()->result();
        return $data;
    }
    public function AllHistoryTransactionItemAdmin($id_item,$id_warehouse){
        $this->db->select('a.back_date,d.department,a.balance,a.reason,a.id,a.id_item,b.name as item_name ,c.name as warehouse,a.id_warehouse,a.description,a.qty1, a.qty2 ,a.created_at,a.created_by,a.updated_at,a.updated_by,d.name as user,e.name as receiver');
        $this->db->from('m_log as a');
        $this->db->join('m_item as b', 'a.id_item = b.id', 'left');
        $this->db->join('m_warehouse as c', 'a.id_warehouse = c.id', 'left'); // Corrected join condition
        $this->db->join('m_user as d', 'a.created_by = d.id', 'left'); // Corrected join condition
        $this->db->join('m_user as e', 'a.updated_by = e.id', 'left'); // Corrected join condition
        $this->db->where('a.id_item', $id_item);
        $this->db->where('a.id_warehouse', $id_warehouse);
        $this->db->order_by('a.back_date', 'desc');
        $this->db->order_by('a.created_at', 'desc'); // Order by created_at as second priority
        $data = $this->db->get()->result();
        return $data;
    }
    public function AllHistoryTransactionFilterItemAdmin($date1,$date2,$id_item,$id_warehouse){
        $this->db->select('a.back_date,d.department,a.balance,a.reason,a.id,a.id_item,b.name as item_name ,c.name as warehouse,a.id_warehouse,a.description,a.qty1, a.qty2 ,a.created_at,a.created_by,a.updated_at,a.updated_by,d.name as user,e.name as receiver');
        $this->db->from('m_log as a');
        $this->db->join('m_item as b', 'a.id_item = b.id', 'left');
        $this->db->join('m_warehouse as c', 'a.id_warehouse = c.id', 'left'); // Corrected join condition
        $this->db->join('m_user as d', 'a.created_by = d.id', 'left'); // Corrected join condition
        $this->db->join('m_user as e', 'a.updated_by = e.id', 'left'); // Corrected join condition
        $this->db->where('a.created_at >=', $date1);
        $this->db->where('a.created_at <=', $date2);
        $this->db->where('a.id_item', $id_item);
        $this->db->where('a.id_warehouse', $id_warehouse);
        $this->db->order_by('a.back_date', 'desc');
        $this->db->order_by('a.created_at', 'desc'); // Order by created_at as second priority
        $data = $this->db->get()->result();
        return $data;
    }

    // Model Lama
    public function BeritaLimit($limit){
        $query = "SELECT a.id_berita,a.judul_berita,a.berita,b.kategori,a.gambar FROM berita a JOIN kategori_berita b ON a.id_kategori=b.id_kategori ORDER BY a.id_berita DESC LIMIT $limit";
        return $this->db->query($query)->result();
    }
    public function PengumumanLimit($limit){
        $query = "SELECT * FROM pengumuman ORDER BY id_pengumuman DESC LIMIT $limit";
        return $this->db->query($query)->result();
    }
    public function Pengumuman(){
        $query = "SELECT * FROM pengumuman ORDER BY id_pengumuman DESC";
        return $this->db->query($query)->result();
    }
    public function getAllBerita(){
        $query = "SELECT a.id_berita,a.judul_berita,a.berita,b.kategori,a.gambar FROM berita a JOIN kategori_berita b ON a.id_kategori=b.id_kategori ORDER BY a.id_berita DESC";
        return $this->db->query($query)->result();
    }
    public function getAllKelas(){
        $query = "SELECT a.id_kelas,a.nama_kelas,a.class,a.program,b.nama_jurusan FROM kelas a JOIN jurusan b ON a.id_jurusan=b.id_jurusan";
        return $this->db->query($query)->result();
    }
    public function getAllUjian(){
        $query = "SELECT a.sks,a.id_ujian,a.tanggal,a.mulai,a.selesai,a.jenis_ujian,a.status,b.id_matkul,b.nama_matkul,c.id_jurusan,c.nama_jurusan,d.id_kelas,d.nama_kelas,d.program,d.class,e.id_ruang,e.nama_ruang,f.id_dosen,f.nama_dosen FROM jadwal_ujian a JOIN mata_kuliah b ON a.id_matkul=b.id_matkul JOIN jurusan c ON a.id_jurusan=c.id_jurusan JOIN kelas d ON a.id_kelas=d.id_kelas JOIN ruang e ON a.id_ruang = e.id_ruang JOIN dosen f ON a.id_dosen=f.id_dosen";
        return $this->db->query($query)->result();
    }
    public function getUjianTanggal($id_jurusan,$id_kelas,$tanggal){
        $query = "SELECT a.sks,a.id_ujian,a.tanggal,a.mulai,a.selesai,a.jenis_ujian,a.status,b.id_matkul,b.nama_matkul,c.id_jurusan,c.nama_jurusan,d.id_kelas,d.nama_kelas,d.program,d.class,e.id_ruang,e.nama_ruang,f.id_dosen,f.nama_dosen FROM jadwal_ujian a JOIN mata_kuliah b ON a.id_matkul=b.id_matkul JOIN jurusan c ON a.id_jurusan=c.id_jurusan JOIN kelas d ON a.id_kelas=d.id_kelas JOIN ruang e ON a.id_ruang = e.id_ruang JOIN dosen f ON a.id_dosen=f.id_dosen WHERE a.id_jurusan = '$id_jurusan' AND a.id_kelas = '$id_kelas' AND a.tanggal = '$tanggal'";
        return $this->db->query($query)->result();
    }
    public function getKelasUjian($kelas,$jurusan){
        $query = "SELECT a.sks,a.id_ujian,a.tanggal,a.mulai,a.selesai,a.jenis_ujian,a.status,b.id_matkul,b.nama_matkul,c.id_jurusan,c.nama_jurusan,d.id_kelas,d.nama_kelas,d.program,d.class,e.id_ruang,e.nama_ruang,f.id_dosen,f.nama_dosen FROM jadwal_ujian a JOIN mata_kuliah b ON a.id_matkul=b.id_matkul JOIN jurusan c ON a.id_jurusan=c.id_jurusan JOIN kelas d ON a.id_kelas=d.id_kelas JOIN ruang e ON a.id_ruang = e.id_ruang JOIN dosen f ON a.id_dosen=f.id_dosen WHERE a.id_jurusan = '$jurusan' AND a.id_kelas = '$kelas'";
        return $this->db->query($query)->result();
    }
    public function getUjian($id_jurusan,$id_kelas,$jenis_ujian){
        $query = "SELECT a.sks,a.id_ujian,a.tanggal,a.mulai,a.selesai,a.jenis_ujian,a.status,b.id_matkul,b.nama_matkul,c.id_jurusan,c.nama_jurusan,d.id_kelas,d.nama_kelas,d.program,d.class,e.id_ruang,e.nama_ruang,f.id_dosen,f.nama_dosen FROM jadwal_ujian a JOIN mata_kuliah b ON a.id_matkul=b.id_matkul JOIN jurusan c ON a.id_jurusan=c.id_jurusan JOIN kelas d ON a.id_kelas=d.id_kelas JOIN ruang e ON a.id_ruang = e.id_ruang JOIN dosen f ON a.id_dosen=f.id_dosen WHERE a.id_jurusan = '$id_jurusan' AND a.id_kelas = '$id_kelas' AND a.jenis_ujian = '$jenis_ujian'";
        return $this->db->query($query)->result();
    }
    public function getUjian2($id_jurusan,$id_kelas,$tanggal){
        $query = "SELECT a.sks,a.id_ujian,a.tanggal,a.mulai,a.selesai,a.jenis_ujian,a.status,b.id_matkul,b.nama_matkul,c.id_jurusan,c.nama_jurusan,d.id_kelas,d.nama_kelas,d.program,d.class,e.id_ruang,e.nama_ruang,f.id_dosen,f.nama_dosen FROM jadwal_ujian a JOIN mata_kuliah b ON a.id_matkul=b.id_matkul JOIN jurusan c ON a.id_jurusan=c.id_jurusan JOIN kelas d ON a.id_kelas=d.id_kelas JOIN ruang e ON a.id_ruang = e.id_ruang JOIN dosen f ON a.id_dosen=f.id_dosen WHERE a.id_jurusan = '$id_jurusan' AND a.id_kelas = '$id_kelas' AND a.tanggal = '$tanggal'";
        return $this->db->query($query)->result();
    }
    public function Jadwal($Jurusan,$Kelas,$hari){
        $query = "SELECT a.id_jadwal,a.hari,a.mulai,a.akhir,a.sks,b.id_matkul,b.nama_matkul,c.id_jurusan,c.nama_jurusan,d.id_kelas,d.nama_kelas,d.program,d.class,e.id_dosen,e.nama_dosen,f.nama_ruang FROM jadwal_pelajaran a JOIN mata_kuliah b ON a.id_matkul=b.id_matkul JOIN jurusan c ON a.id_jurusan=c.id_jurusan JOIN kelas d ON a.id_kelas=d.id_kelas JOIN dosen e ON a.id_dosen=e.id_dosen JOIN ruang f ON a.id_ruang = f.id_ruang WHERE a.id_jurusan = '$Jurusan' AND a.id_kelas = '$Kelas' AND a.hari = '$hari'";
        return $this->db->query($query)->result();
    }
    public function JadwalKelas($Jurusan,$Kelas){
        $query = "SELECT a.id_jadwal,a.hari,a.mulai,a.akhir,a.sks,b.id_matkul,b.nama_matkul,c.id_jurusan,c.nama_jurusan,d.id_kelas,d.nama_kelas,d.program,d.class,e.id_dosen,e.nama_dosen,f.nama_ruang FROM jadwal_pelajaran a JOIN mata_kuliah b ON a.id_matkul=b.id_matkul JOIN jurusan c ON a.id_jurusan=c.id_jurusan JOIN kelas d ON a.id_kelas=d.id_kelas JOIN dosen e ON a.id_dosen=e.id_dosen JOIN ruang f ON a.id_ruang = f.id_ruang WHERE a.id_jurusan = '$Jurusan' AND a.id_kelas = '$Kelas'";
        return $this->db->query($query)->result();
    }
    public function getAllJadwal(){
        $query = "SELECT a.id_jadwal,a.hari,a.mulai,a.akhir,a.sks,b.id_matkul,b.nama_matkul,c.id_jurusan,c.nama_jurusan,d.id_kelas,d.nama_kelas,d.program,d.class,e.id_dosen,e.nama_dosen,f.nama_ruang FROM jadwal_pelajaran a JOIN mata_kuliah b ON a.id_matkul=b.id_matkul JOIN jurusan c ON a.id_jurusan=c.id_jurusan JOIN kelas d ON a.id_kelas=d.id_kelas JOIN dosen e ON a.id_dosen=e.id_dosen JOIN ruang f ON a.id_ruang = f.id_ruang";
        return $this->db->query($query)->result();
    }
    public function getKelasJadwal($kelas,$jurusan){
        $query = "SELECT a.id_jadwal,a.hari,a.mulai,a.akhir,a.sks,b.id_matkul,b.nama_matkul,c.id_jurusan,c.nama_jurusan,d.id_kelas,d.nama_kelas,d.program,d.class,e.id_dosen,e.nama_dosen,f.nama_ruang FROM jadwal_pelajaran a JOIN mata_kuliah b ON a.id_matkul=b.id_matkul JOIN jurusan c ON a.id_jurusan=c.id_jurusan JOIN kelas d ON a.id_kelas=d.id_kelas JOIN dosen e ON a.id_dosen=e.id_dosen JOIN ruang f ON a.id_ruang = f.id_ruang WHERE a.id_jurusan = '$jurusan' AND a.id_kelas = '$kelas' ";
        return $this->db->query($query)->result();
    }
    public function getJadwalPelajaran($kelas,$jurusan,$hari){
        $query = "SELECT a.id_jadwal,a.hari,a.mulai,a.akhir,a.sks,b.id_matkul,b.nama_matkul,c.id_jurusan,c.nama_jurusan,d.id_kelas,d.nama_kelas,d.program,d.class,e.id_dosen,e.nama_dosen,f.nama_ruang FROM jadwal_pelajaran a JOIN mata_kuliah b ON a.id_matkul=b.id_matkul JOIN jurusan c ON a.id_jurusan=c.id_jurusan JOIN kelas d ON a.id_kelas=d.id_kelas JOIN dosen e ON a.id_dosen=e.id_dosen JOIN ruang f ON a.id_ruang = f.id_ruang WHERE a.id_jurusan = '$jurusan' AND a.id_kelas = '$kelas' AND a.hari = '$hari'";
        return $this->db->query($query)->result();
    }
    function getWhere2($table,$where){
        return $this->db->get_where($table,$where)->result();
    }
    public function getAllProduct($id){
        $query = "SELECT a.username,a.nama,a.email,b.nama_barang,b.harga,b.quantity,b.gambar,b.deskripsi,b.id FROM user a JOIN barang b ON a.username=b.id_penjual EXCEPT SELECT a.username,a.nama,a.email,b.nama_barang,b.harga,b.quantity,b.gambar,b.deskripsi,b.id FROM user a JOIN barang b ON a.username=b.id_penjual WHERE a.username='$id'";
        return $this->db->query($query)->result();
    }
    public function getMyProduct($id){
        $query = "SELECT a.username,a.nama,a.email,b.nama_barang,b.harga,b.quantity,b.gambar,b.deskripsi,b.id FROM user a JOIN barang b ON a.username=b.id_penjual WHERE a.username='$id'";
        return $this->db->query($query)->result();
    }

    public function getProduct($id){
        $query = "SELECT a.username,a.nama,a.email,b.nama_barang,b.harga,b.quantity,b.gambar,b.deskripsi,b.id FROM user a JOIN barang b ON a.username=b.id_penjual WHERE b.id = $id";
        return $this->db->query($query)->result();
    }

    public function getAllRequest(){
        $query = "SELECT a.nama,a.email,a.wallet,a.profile,a.level,b.id_transaksi,b.jumlah,b.bukti,b.peminta,b.pemberi,b.status FROM user a JOIN wallet b ON a.username = b.peminta";
        return $this->db->query($query)->result();
    }
    public function getRequest($id){
        $query = "SELECT a.nama,a.email,a.wallet,a.profile,a.level,b.id_transaksi,b.jumlah,b.bukti,b.peminta,b.pemberi,b.status FROM user a JOIN wallet b ON a.username = b.peminta WHERE b.id_transaksi = '$id'";
        return $this->db->query($query)->result();
    }
    public function getAllTransaction($user){
        $query = "SELECT a.id,a.id_barang,a.id_penjual,a.id_pembeli,a.quantity,a.total,b.nama_barang,b.harga,b.gambar,b.deskripsi,c.username,c.nama,c.email,c.wallet,c.profile,c.level FROM history a JOIN barang b ON a.id_barang=b.id JOIN user c ON a.id_penjual=c.username WHERE a.id_penjual = '$user' OR a.id_pembeli = '$user'";
        if($this->db->query($query)->num_rows() >0){
            return $this->db->query($query)->result();
        }else{
            return "Nothing";
        }
    }
    public function getJualTransaction($user){
        $query = "SELECT a.id,a.id_barang,a.id_penjual,a.id_pembeli,a.quantity,a.total,b.nama_barang,b.harga,b.gambar,b.deskripsi,c.username,c.nama,c.email,c.wallet,c.profile,c.level FROM history a JOIN barang b ON a.id_barang=b.id JOIN user c ON a.id_penjual=c.username WHERE a.id_penjual = '$user'";
        if($this->db->query($query)->num_rows() >0){
            return $this->db->query($query)->result();
        }else{
            return "Nothing";
        }
    }
    public function getBeliTransaction($user){
        $query = "SELECT a.id,a.id_barang,a.id_penjual,a.id_pembeli,a.quantity,a.total,b.nama_barang,b.harga,b.gambar,b.deskripsi,c.username,c.nama,c.email,c.wallet,c.profile,c.level FROM history a JOIN barang b ON a.id_barang=b.id JOIN user c ON a.id_penjual=c.username WHERE a.id_pembeli = '$user'";
        if($this->db->query($query)->num_rows() >0){
            return $this->db->query($query)->result();
        }else{
            return "Nothing";
        }
    }
 
    public function countAllTransaction($user){
        $query = "SELECT a.id,a.id_barang,a.id_penjual,a.id_pembeli,a.quantity,a.total,b.nama_barang,b.harga,b.gambar,b.deskripsi,c.username,c.nama,c.email,c.wallet,c.profile,c.level FROM history a JOIN barang b ON a.id_barang=b.id JOIN user c ON a.id_penjual=c.username WHERE a.id_penjual = '$user' OR a.id_pembeli = '$user'";
        return $this->db->query($query)->result();
    }
    public function countBeliTransaction($user){
        $query = "SELECT COUNT (*) AS c FROM history a JOIN barang b ON a.id_barang=b.id JOIN user c ON a.id_penjual=c.username WHERE a.id_penjual = '$user' OR a.id_pembeli = '$user'";
        return $this->db->query($query)->result();
    }
    public function countJualTransaction($user){
        $query = "SELECT a.id,a.id_barang,a.id_penjual,a.id_pembeli,a.quantity,a.total,b.nama_barang,b.harga,b.gambar,b.deskripsi,c.username,c.nama,c.email,c.wallet,c.profile,c.level FROM history a JOIN barang b ON a.id_barang=b.id JOIN user c ON a.id_penjual=c.username WHERE a.id_penjual = '$user' OR a.id_pembeli = '$user'";
        return $this->db->query($query)->result();
    }

    public function ChangeProfile($id,$profile){
        $query = "UPDATE user SET profile = '$profile' WHERE username = '$id'";
        return $this->db->query($query)->result();
    }
    public function ChangeDataProfile($id,$nama,$email,$alamat){
        $query = "UPDATE user SET nama = '$nama',email = '$email',alamat='$alamat' WHERE username = '$id'";
        return $this->db->query($query)->result();
    }
    public function uploadImage(){
    $config['upload_path']          = './img/product/';
    $config['allowed_types']        = 'gif|jpg|png|jpeg';
    $config['file_name']            = $this->id;
    $config['overwrite']			= true;
    $config['max_size']             = 4096; // 1MB
    // $config['max_width']            = 1024;
    // $config['max_height']           = 768;

    $this->load->library('upload', $config);

    if ($this->upload->do_upload('image')) {
        return $this->upload->data("file_name");
    }else{
        return "default.jpg";
    }   
}
}

/* End of file Models.php */
