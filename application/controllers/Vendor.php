<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if($this->session->userdata('status') != "login"){
            redirect(base_url("login"));
        }
        $this->load->model("Models");
        $this->load->library('form_validation');
    }
    private function rulesOrigin(){
        return [
            ['field' => 'label','label' => 'Label','rules' => 'required']
        ];
    }
    private function rulesUser(){
        return [
            ['field' => 'name','label' => 'Name','rules' => 'required'],
            ['field' => 'username','label' => 'Username ','rules' => 'required'],
            ['field' => 'id_role','label' => 'Id_role','rules' => 'required'],
            ['field' => 'email','label' => 'email','rules' => 'required'],
        ];
    }


    public function index()
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['Data'] = $this->Models->AllUser();
        $this->load->view('dashboard/header',$data);
        $this->load->view('User/List/side',$data);
        $this->load->view('User/List/main',$data);
        $this->load->view('dashboard/footer');
    }
    public function Postuser(){
        $this->form_validation->set_rules($this->rulesUser());
        $username = $this->session->userdata('nama');
        if($this->form_validation->run() === FALSE){
            $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $data['role'] =$this->Models->getAll('m_role');
            $this->load->view('dashboard/header',$data);
            $this->load->view('User/List/side',$data);
            $this->load->view('User/List/input',$data);
            $this->load->view('dashboard/footer');
        }else{
            $config['upload_path']          = './img/profile/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            // $config['file_name']            = $this->id;
            // $config['overwrite']			= true;
            $config['max_size']             = 4096; // 1MB
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;

            $this->load->library('upload', $config);
            $id = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));
            if ($this->upload->do_upload('gambar')) {
                $data['name'] = $this->input->post('name');
                $data['username'] = $this->input->post('username');
                $data['password'] = MD5($this->input->post('password'));
                $data['email'] = $this->input->post('email');
                $data['id_role '] = $this->input->post('id_role');
                $data['photo'] = $this->upload->data("file_name");
                $data['created_by'] = $id[0]->id;
                $data['updated_by'] = $id[0]->id;
            }else{
                $data['name'] = $this->input->post('name');
                $data['username'] = $this->input->post('username');
                $data['password'] = MD5($this->input->post('password'));
                $data['email'] = $this->input->post('email');
                $data['id_role '] = $this->input->post('id_role');
                $data['photo'] = "logo.jpg";
                $data['created_by'] = $id[0]->id;
                $data['updated_by'] = $id[0]->id;
            }
            $this->Models->insert('m_user',$data);
            $this->session->set_flashdata('pesan','<script>alert("Data berhasil disimpan")</script>');
            redirect(base_url('User'));
        }
    }
    public function Edit($id){
        $this->form_validation->set_rules($this->rulesUser());
        $username = $this->session->userdata('nama');
        if($this->form_validation->run() === FALSE){
            $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $data['role'] =$this->Models->getAll('m_role');
            $data['users'] =$this->Models->getID('m_user','id',$id);
            $this->load->view('dashboard/header',$data);
            $this->load->view('User/List/side',$data);
            $this->load->view('User/List/edit',$data);
            $this->load->view('dashboard/footer');
        }else{
            $config['upload_path']          = './img/profile/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config[''];
            // $config['file_name']            = $this->id;
            // $config['overwrite']			= true;
            $config['max_size']             = 4096; // 1MB
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;

            $this->load->library('upload', $config);
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));
            if ($this->upload->do_upload('gambar')) {
                $data['name'] = $this->input->post('name');
                $data['username'] = $this->input->post('username');
                $data['password'] = MD5($this->input->post('password'));
                $data['email'] = $this->input->post('email');
                $data['id_role '] = $this->input->post('id_role');
                $data['photo'] = $this->upload->data("file_name");
                $data['updated_by'] = $ID[0]->id;
                $data['updated_at'] = $this->Models->GetTimestamp();
            }else{
                $data['name'] = $this->input->post('name');
                $data['username'] = $this->input->post('username');
                $data['password'] = MD5($this->input->post('password'));
                $data['email'] = $this->input->post('email');
                $data['id_role '] = $this->input->post('id_role');
                $data['photo'] = "logo.jpg";
                $data['updated_by'] = $ID[0]->id;
                $data['updated_at'] = $this->Models->GetTimestamp();
            }
            $this->Models->edit('m_user','id',$id,$data);
            $this->session->set_flashdata('pesan','<script>alert("Data berhasil disimpan")</script>');
            redirect(base_url('User'));
        }
    }
    public function Delete($id){
        $this->Models->delete('m_user','id',$id);
        $this->session->set_flashdata('Pesan', '<script>alert("Data berhasil dihapus")</script>');
        redirect(base_url('User'));
    }


    // Origin
    public function Origin(){
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['origin'] = $this->Models->getAll('m_origin');
        $data['title'] = 'Origin';
        $this->load->view('dashboard/header',$data);
        $this->load->view('masterData/Origin/side',$data);
        $this->load->view('masterData/Origin/main',$data);
        $this->load->view('dashboard/footer');
    }
    public function List(){
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['vendor'] = $this->Models->getAll('m_vendor');
        $data['title'] = 'Vendor';
        $this->load->view('dashboard/header',$data);
        $this->load->view('masterData/List/side',$data);
        $this->load->view('masterData/List/main',$data);
        $this->load->view('dashboard/footer');
    }

    public function Brand(){
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['brand'] = $this->Models->AllBrand('m_brand');
        $data['origin'] = $this->Models->AllOrigin('m_origin');
        $data['title'] = 'Brand';
        $this->load->view('dashboard/header',$data);
        $this->load->view('masterData/Brand/side',$data);
        $this->load->view('masterData/Brand/main',$data);
        $this->load->view('dashboard/footer');
    }

    public function TambahOrigin(){
        $this->form_validation->set_rules($this->rulesOrigin());
        $ID = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        if($this->form_validation->run() === FALSE){
            $data['user'] =$this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $this->load->view('dashboard/header',$data);
            $this->load->view('masterData/Origin/side',$data);
            $this->load->view('masterData/Origin/main',$data);
            $this->load->view('dashboard/footer');
        }else{
            $id = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));            
            $data['label'] = $this->input->post('label');
            $data['created_by'] = $id[0]->id;;
            $data['updated_by'] = $id[0]->id;;
            $this->Models->insert('m_origin',$data);
            $this->session->set_flashdata('pesan','<script>alert("Data berhasil disimpan")</script>');
            redirect(base_url('Vendor/Origin'));
        }
    }

    public function TambahVendor(){
        $this->form_validation->set_rules($this->rulesOrigin());
        $ID = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        if($this->form_validation->run() === FALSE){
            $data['user'] =$this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $this->load->view('dashboard/header',$data);
            $this->load->view('masterData/List/side',$data);
            $this->load->view('masterData/List/main',$data);
            $this->load->view('dashboard/footer');
        }else{
            $id = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));            
            $data['label'] = $this->input->post('label');
            $data['created_by'] = $id[0]->id;;
            $data['updated_by'] = $id[0]->id;;
            $this->Models->insert('m_vendor',$data);
            $this->session->set_flashdata('pesan','<script>alert("Data berhasil disimpan")</script>');
            redirect(base_url('Vendor/List'));
        }
    }

    public function TambahBrand(){
        $this->form_validation->set_rules($this->rulesOrigin());
        $ID = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        if($this->form_validation->run() === FALSE){
            $data['user'] =$this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $this->load->view('dashboard/header',$data);
            $this->load->view('masterData/Brand/side',$data);
            $this->load->view('masterData/Brand/main',$data);
            $this->load->view('dashboard/footer');
        }else{
            $id = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));            
            $data['label'] = $this->input->post('label');
            $data['id_origin'] = $this->input->post('id_origin');
            $data['created_by'] = $id[0]->id;;
            $data['updated_by'] = $id[0]->id;;
            $this->Models->insert('m_brand',$data);
            $this->session->set_flashdata('pesan','<script>alert("Data berhasil disimpan")</script>');
            redirect(base_url('Vendor/Brand'));
        }
    }

    public function EditOrigin($id){
        $this->form_validation->set_rules($this->rulesOrigin());
        if($this->form_validation->run() === false){
            $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $where = array(
                'id' => $id
            );
            $data['origin'] = $this->Models->getWhere2("m_origin",$where);
            $data['title'] = 'Edit Origin';
            $this->load->view('dashboard/header',$data);
            $this->load->view('masterData/Origin/side',$data);
            $this->load->view('masterData/Origin/edit',$data);
            $this->load->view('dashboard/footer');  
            $this->session->set_flashdata('Pesan', '<script>alert("Data gagal diubah")</script>');
        }else{
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));     
            $data['label'] = $this->input->post('label');
            $data['updated_by'] = $ID[0]->id;
            $data['updated_at'] = $this->Models->GetTimestamp();
            $this->Models->edit('m_origin','id',$id,$data);
            $this->session->set_flashdata('Pesan', '<script>alert("Data berhasil diubah")</script>');
            redirect(base_url('Vendor/Origin'));
        }
    }
    public function EditVendor($id){
        $this->form_validation->set_rules($this->rulesOrigin());
        if($this->form_validation->run() === false){
            $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $where = array(
                'id' => $id
            );
            $data['vendor'] = $this->Models->getWhere2("m_vendor",$where);
            $data['title'] = 'Edit Vendor';
            $this->load->view('dashboard/header',$data);
            $this->load->view('masterData/List/side',$data);
            $this->load->view('masterData/List/edit',$data);
            $this->load->view('dashboard/footer');  
            $this->session->set_flashdata('Pesan', '<script>alert("Data gagal diubah")</script>');
        }else{
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));     
            $data['label'] = $this->input->post('label');
            $data['updated_by'] = $ID[0]->id;
            $data['updated_at'] = $this->Models->GetTimestamp();
            $this->Models->edit('m_vendor','id',$id,$data);
            $this->session->set_flashdata('Pesan', '<script>alert("Data berhasil diubah")</script>');
            redirect(base_url('Vendor/List'));
        }
    }

    public function EditBrand($id){
        $this->form_validation->set_rules($this->rulesOrigin());
        if($this->form_validation->run() === false){
            $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $where = array(
                'id' => $id
            );
            $data['brand'] = $this->Models->getWhere2("m_brand",$where);
            $data['title'] = 'Edit Brand';
            $data['origin'] =$this->Models->getAll('m_origin');
            $this->load->view('dashboard/header',$data);
            $this->load->view('masterData/Brand/side',$data);
            $this->load->view('masterData/Brand/edit',$data);
            $this->load->view('dashboard/footer');  
            $this->session->set_flashdata('Pesan', '<script>alert("Data gagal diubah")</script>');
        }else{
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));     
            $data['label'] = $this->input->post('label');
            $data['id_origin'] = $this->input->post('id_origin');
            $data['updated_by'] = $ID[0]->id;
            $data['updated_at'] = $this->Models->GetTimestamp();
            $this->Models->edit('m_brand','id',$id,$data);
            $this->session->set_flashdata('Pesan', '<script>alert("Data berhasil diubah")</script>');
            redirect(base_url('Vendor/Brand'));
        }
    }
    public function Hapusrole($id){
        $this->Models->delete('m_role','id',$id);
        $this->session->set_flashdata('Pesan', '<script>alert("Data berhasil dihapus")</script>');
        redirect(base_url('User/Role'));
    }
    public function HapusOrigin($id){
        $this->Models->delete('m_origin','id',$id);
        $this->session->set_flashdata('Pesan', '<script>alert("Data berhasil dihapus")</script>');
        redirect(base_url('Vendor/Origin'));
    }
    public function HapusVendor($id){
        $this->Models->delete('m_vendor','id',$id);
        $this->session->set_flashdata('Pesan', '<script>alert("Data berhasil dihapus")</script>');
        redirect(base_url('Vendor/List'));
    }
    public function HapusBrand($id){
        $this->Models->delete('m_brand','id',$id);
        $this->session->set_flashdata('Pesan', '<script>alert("Data berhasil dihapus")</script>');
        redirect(base_url('Vendor/Brand'));
    }

    
}

/* End of file Home.php */
