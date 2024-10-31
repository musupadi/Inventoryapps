<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if($this->session->userdata('status') != "login"){
            redirect(base_url("login"));
        }
        $this->load->model("Models");
        $this->load->library('form_validation');
    }
    private function rulesCategory(){
        return [
            ['field' => 'label','label' => 'Label','rules' => 'required']
        ];
    }
    private function rulesUser(){
        return [
            ['field' => 'name','label' => 'Name','rules' => 'required'],
            ['field' => 'username','label' => 'Username ','rules' => 'required'],
            ['field' => 'id_role','label' => 'Id_role','rules' => 'required'],
            ['field' => 'email','label' => 'email','rules' => 'required']
        ];
    }
    private function rulesItem(){
        return [
            ['field' => 'name','label' => 'Name','rules' => 'required'],
            ['field' => 'id_category','label' => 'Id Category','rules' => 'required'],
            ['field' => 'asset_no','label' => 'Asset No','rules' => 'required']
        ];
    }
    private function rulesWarehouse(){
        return [
            ['field' => 'name','label' => 'Name','rules' => 'required']
        ];
    }

    public function index()
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['category'] = $this->Models->Allcategory();
        $this->load->view('dashboard/header',$data);
        $this->load->view('masterData/Item/side',$data);
        $this->load->view('masterData/Item/main',$data);
        $this->load->view('dashboard/footer');
    }

    // category
    public function category(){
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['category'] = $this->Models->getAll('m_category');
        $data['title'] = 'category';
        $this->load->view('dashboard/header',$data);
        $this->load->view('masterData/Category/side',$data);
        $this->load->view('masterData/Category/main',$data);
        $this->load->view('dashboard/footer');
    }
    public function Tambahcategory(){
        $this->form_validation->set_rules($this->rulescategory());
        $ID = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        if($this->form_validation->run() === FALSE){
            $data['user'] =$this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $this->load->view('dashboard/header',$data);
            $this->load->view('masterData/Category/side',$data);
            $this->load->view('masterData/Category/main',$data);
            $this->load->view('dashboard/footer');
        }else{
            $id = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));            
            $data['label'] = $this->input->post('label');
            $data['created_by'] = $id[0]->id;
            $data['updated_by'] = $id[0]->id;
            $this->Models->insert('m_category',$data);
            $last_id = $this->db->insert_id();

            $log['label'] = "insert";
            $log['description'] = "User ".$id[0]->name." Input New Category Named ".$this->input->post('label');
            $log['id_affected'] =  $last_id;
            $log['table'] = "m_category";
            $log['created_by'] = $id[0]->id;
            $this->Models->insert('log_user',$log);
            $this->session->set_flashdata('pesan','<script>alert("Data berhasil disimpan")</script>');
            redirect(base_url('Inventory/category'));
        }
    }
    public function Categoryedit($id){
        $this->form_validation->set_rules($this->rulescategory());
        if($this->form_validation->run() === false){
            $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $where = array(
                'id' => $id
            );
            $data['role'] = $this->Models->getWhere2("m_category",$where);
            $data['title'] = 'Edit category';
            $this->load->view('dashboard/header',$data);
            $this->load->view('masterData/Category/side',$data);
            $this->load->view('masterData/Category/edit',$data);
            $this->load->view('dashboard/footer');  
            $this->session->set_flashdata('Pesan', '<script>alert("Data gagal diubah")</script>');
        }else{
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama')); 
            $ids = $this->Models->getID('m_category','id',$id);
            
            // $last_id = $this->db->insert_id();
            $log['label'] = "update";
            $log['description'] = "User ".$ID[0]->name." Edit Category Name From ".$ids[0]->label." To ".$this->input->post('label');
            $log['id_affected'] =  $id;
            $log['table'] = "m_category";
            $log['created_by'] = $ID[0]->id;
            $this->Models->insert('log_user',$log);


            $data['label'] = $this->input->post('label');
            $data['updated_by'] = $ID[0]->id;
            $data['updated_at'] = $this->Models->GetTimestamp();
            $this->Models->edit('m_category','id',$id,$data);


   

            $this->session->set_flashdata('pesan', '<script>alert("Data berhasil diubah")</script>');
            redirect(base_url('Inventory/category'));
        }
    }
    public function Hapuscategory($id){
        $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama')); 
        $ids = $this->Models->getID('m_category','id',$id);
        $log['label'] = "delete";
        $log['description'] = "User ".$ID[0]->name." Delete Category Name ".$ids[0]->label;
        $log['id_affected'] =  $id;
        $log['table'] = "m_category";
        $log['created_by'] = $ID[0]->id;
        $this->Models->insert('log_user',$log);

        $this->Models->delete('m_category','id',$id);
        $this->session->set_flashdata('pesan', '<script>alert("Data berhasil dihapus")</script>');
        redirect(base_url('Inventory/category'));
    }

    // Inventory Item
    public function Item(){
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['item'] = $this->Models->AllItem();
        $data['warehouse'] = $this->Models->AllWarehouse();
        $data['category'] = $this->Models->getAll('m_category');
        $data['vendor'] = $this->Models->getAll('m_vendor');
        $data['brand'] = $this->Models->getAll('m_brand');
        $data['title'] = 'Item';
        $this->load->view('dashboard/header',$data);
        $this->load->view('masterData/Item/side',$data);
        $this->load->view('masterData/Item/main',$data);
        $this->load->view('dashboard/footer');
    }
    
    public function TambahItem(){
        $this->form_validation->set_rules($this->rulesItem());
        $ID = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['item'] = $this->Models->AllItem();
        $data['category'] = $this->Models->getAll('m_category');
        $data['vendor'] = $this->Models->getAll('m_vendor');
        $data['brand'] = $this->Models->getAll('m_brand');
        $data['title'] = 'Item';
        if(empty($this->input->post())){
            $data['user'] =$this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $this->load->view('dashboard/header',$data);
            $this->load->view('masterData/Item/side',$data);
            $this->load->view('masterData/Item/main',$data);
            $this->load->view('dashboard/footer');
        }else{
            $id = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));    
            $config['upload_path']          = './img/item/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['file_name']            = uniqid();
            // $config['overwrite']			= true;
            $config['max_size']             = 4096; // 1MB
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('photo')) {
                $insert['photo'] = $this->upload->data("file_name");
                $insert['name'] = $this->input->post('name');
                $insert['id_category'] = $this->input->post('id_category');
                $insert['description'] = $this->input->post('description');
                $insert['id_vendor'] = $this->input->post('id_vendor');
                $insert['id_brand'] = $this->input->post('id_brand');
                $insert['id_status'] = 1;
                $insert['warranty'] = $this->input->post('warranty');
                $insert['serial_number'] = $this->input->post('serial_number');
                $insert['created_by'] = $ID[0]->id;
                $insert['updated_by'] = $ID[0]->id;
            }else{
                $insert['photo'] = "default.jpg";
                $insert['name'] = $this->input->post('name');
                $insert['id_category'] = $this->input->post('id_category');
                $insert['description'] = $this->input->post('description');
                $insert['id_vendor'] = $this->input->post('id_vendor');
                $insert['id_brand'] = $this->input->post('id_brand');
                $insert['id_status'] = 1;
                $insert['warranty'] = $this->input->post('warranty');
                $insert['serial_number'] = $this->input->post('serial_number');
                $insert['created_by'] = $ID[0]->id;
                $insert['updated_by'] = $ID[0]->id;
            }
            $AssetType = $this->input->post('asset_type');
            if($AssetType == "asset"){
                $insert['asset_no'] = $this->input->post('asset_no');
            }else{
                $insert['asset_no'] = "0";
            }
            $this->Models->insert('m_item',$insert);


            $last_id = $this->db->insert_id();

            $log['label'] = "insert";
            $log['description'] = "User ".$id[0]->name." Input New Item Named ".$this->input->post('name');
            $log['id_affected'] =  $last_id;
            $log['table'] = "m_item";
            $log['created_by'] = $id[0]->id;
            $this->Models->insert('log_user',$log);
            // $id_item = $this->db->insert_id();

            // $data['id_item']

            // $this->session->set_flashdata('pesan','<script>alert("Data berhasil disimpan")</script>');
            redirect(base_url('Inventory/Item'));
        }
    }

    public function Itemedit($id){
        $this->form_validation->set_rules($this->rulesItem());
        if($this->form_validation->run() === false){
            $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $where = array(
                'id' => $id
            );
            $data['item'] = $this->Models->getWhere2("m_item",$where);
            $data['category'] = $this->Models->getAll('m_category');
            $data['vendor'] = $this->Models->getAll('m_vendor');
            $data['brand'] = $this->Models->getAll('m_brand');
            $data['title'] = "Edit Item";
            $this->load->view('dashboard/header',$data);
            $this->load->view('masterData/Item/side',$data);
            $this->load->view('masterData/Item/edit',$data);
            $this->load->view('dashboard/footer');  
            // $this->session->set_flashdata('pesan', '<script>alert("Data gagal diubah")</script>');
        }else{
            $config['upload_path']          = './img/item/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['file_name']            = uniqid();
            // $config['file_name']            = $this->id;
            // $config['overwrite']			= true;
            $config['max_size']             = 4096; // 1MB
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;

            $this->load->library('upload', $config);
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));
            
            if ($this->upload->do_upload('photo')) {
                $old_image = $data['m_item']['photo'];
                if ( $old_image != "default.jpg" ){
                    unlink(FCPATH . 'img/item/' . $old_image);
                }

                $new_image = $this->upload->data('file_name');
                $this->db->set('photo', $new_image);
            }else{
                $data['name'] = $this->input->post('name');
                $data['id_category'] = $this->input->post('id_category');
                $data['description'] = $this->input->post('description');
                $data['id_vendor'] = $this->input->post('id_vendor');
                $data['id_brand'] = $this->input->post('id_brand');
                $data['warranty'] = $this->input->post('warranty');
                $data['serial_number'] = $this->input->post('serial_number');
                $data['updated_by'] = $ID[0]->id;
                $data['updated_at'] = $this->Models->GetTimestamp();
            }

            $AssetType = $this->input->post('asset_type');
            if($AssetType == "asset"){
                $insert['asset_no'] = $this->input->post('asset_no');
            }else{
                $insert['asset_no'] = "0";
            }

            $log['label'] = "update";
            $log['description'] = "User ".$ID[0]->name." Input Edit Item Named ". $this->Models->getID('m_item', 'id',$id)[0]->label." To ".$this->input->post('name');
            $log['id_affected'] =  $id;
            $log['table'] = "m_item";
            $log['created_by'] = $ID[0]->id;
            $this->Models->insert('log_user',$log);
            $this->Models->edit('m_item','id',$id,$data);
            // $this->session->set_flashdata('pesan', '<script>alert("Data berhasil diubah")</script>');
            redirect(base_url('Inventory/Item'));
        }
    }
    
    public function HapusItem($id){
        $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));
        $where = ['id' => $id];
        $data['id_status'] = 0;
        $this->Models->edit('m_item','id',$id, $data);

        
        $last_id = $this->db->insert_id();

        $log['label'] = "delete";
        $log['description'] = "User ".$ID[0]->name." Deleted Item Named ". $this->Models->getID('m_item', 'id',$id)[0]->label;
        $log['id_affected'] =  $id;
        $log['table'] = "m_item";
        $log['created_by'] = $ID[0]->id;
        $this->Models->insert('log_user',$log);
        // $this->session->set_flashdata('pesan', '<script>alert("Data berhasil dihapus")</script>');
        redirect(base_url('Inventory/Item'));
    }

    // Warehouse
    public function Warehouse(){
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['warehouse'] = $this->Models->AllWarehouse();
        $data['category'] = $this->Models->getAll('m_category');
        $data['location'] = $this->Models->getAll('m_location');
        $data['title'] = 'Warehouse';
        $this->load->view('dashboard/header',$data);
        $this->load->view('masterData/Warehouse/side',$data);
        $this->load->view('masterData/Warehouse/main',$data);
        $this->load->view('dashboard/footer');
    }
    
    public function TambahWarehouse(){
        $this->form_validation->set_rules($this->rulesWarehouse());
        $ID = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        if($this->form_validation->run() === FALSE){
            $data['user'] =$this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $this->load->view('dashboard/header',$data);
            $this->load->view('masterData/Warehouse/side',$data);
            $this->load->view('masterData/Warehouse/main',$data);
            $this->load->view('dashboard/footer');
        }else{
            $id = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));            
            $data['name'] = $this->input->post('name');
            $data['description'] = $this->input->post('description');
            $data['id_location'] = $this->input->post('id_location');
            $data['created_by'] = $id[0]->id;
            $data['updated_by'] = $id[0]->id;
            $this->Models->insert('m_warehouse',$data);
            // $this->session->set_flashdata('pesan','<script>alert("Data berhasil disimpan")</script>');
            redirect(base_url('Inventory/Warehouse'));
        }
    }

    public function Warehouseedit($id){
        $this->form_validation->set_rules($this->rulesWarehouse());
        if($this->form_validation->run() === false){
            $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $where = array(
                'id' => $id
            );
            $data['warehouse'] = $this->Models->getWhere2("m_warehouse",$where);
            $data['title'] = 'Edit Warehouse';
            $data['location'] = $this->Models->getAll('m_location');
            $this->load->view('dashboard/header',$data);
            $this->load->view('masterData/Warehouse/side',$data);
            $this->load->view('masterData/Warehouse/edit',$data);
            $this->load->view('dashboard/footer');  
            // $this->session->set_flashdata('pesan', '<script>alert("Data gagal diubah")</script>');
        }else{
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));     
            $data['name'] = $this->input->post('name');
            $data['description'] = $this->input->post('description');
            $data['id_location'] = $this->input->post('id_location');
            $data['updated_by'] = $ID[0]->id;
            $data['updated_at'] = $this->Models->GetTimestamp();
            $this->Models->edit('m_warehouse','id',$id,$data);
            // $this->session->set_flashdata('pesan', '<script>alert("Data berhasil diubah")</script>');
            redirect(base_url('Inventory/Warehouse'));
        }
    }

    public function HapusWarehouse($id){
        $this->Models->delete('m_warehouse','id',$id);
        $this->session->set_flashdata('pesan', '<script>alert("Data berhasil dihapus")</script>');
        redirect(base_url('Inventory/Warehouse'));
    }
}

/* End of file Home.php */
