<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct(){
        parent::__construct();
        if($this->session->userdata('status') != "login"){
            redirect(base_url("login"));
        }
        $this->load->model("Models");
        $this->load->library('form_validation');
    }
    private function rulesRoles(){
        return [
            ['field' => 'label','label' => 'Label','rules' => 'required'],
            ['field' => 'level','label' => 'Level','rules' => 'required']
        ];
    }
    private function rulesUser(){
        return [
            ['field' => 'username','label' => 'Username ','rules' => 'required'],
            ['field' => 'id_role','label' => 'Id_role','rules' => 'required'],
            ['field' => 'email','label' => 'email','rules' => 'required'],
        ];
    }
    private function rulesUpdateUser(){
        return [
            ['field' => 'username','label' => 'Username ','rules' => 'required'],
            ['field' => 'email','label' => 'email','rules' => 'required'],
        ];
    }


    public function index()
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['Data'] = $this->Models->AllUser();
        $data['title'] = 'User';
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
            $data['role'] = $this->Models->getAll('m_role');
            $data['warehouse'] =$this->Models->AllWarehouse();
            $data['title'] = 'New User';
            $this->load->view('dashboard/header',$data);
            $this->load->view('User/List/side',$data);
            $this->load->view('User/List/input',$data);
            $this->load->view('dashboard/footer');
        }else{
            $config['upload_path']          = './img/profile/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['file_name']            = uniqid();
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
                $data['department'] = $this->input->post('department');
                $data['phone_number'] = $this->input->post('phone_number');
                $data['id_role '] = $this->input->post('id_role');
                $data['photo'] = $this->upload->data("file_name");
                $data['created_by'] = $id[0]->id;
                $data['updated_by'] = $id[0]->id;
            }else{
                $data['name'] = $this->input->post('name');
                $data['username'] = $this->input->post('username');
                $data['password'] = MD5($this->input->post('password'));
                $data['email'] = $this->input->post('email');
                $data['department'] = $this->input->post('department');
                $data['phone_number'] = $this->input->post('phone_number');
                $data['id_role '] = $this->input->post('id_role');
                $data['photo'] = "logo.jpg";
                $data['created_by'] = $id[0]->id;
                $data['updated_by'] = $id[0]->id;
            }

            $this->db->where('username', $this->input->post('username'));
            $query = $this->db->get('m_user');

            if ($query->num_rows() > 0) {
                $this->session->set_flashdata('pesan','<script>alert("Username already exists..")</script>');
            } else {
                $this->Models->insert('m_user',$data);
                $this->session->set_flashdata('pesan','<script>alert("New user added successfully")</script>');
            }

            $id_user = $this->db->insert_id();

            if ( !empty($this->input->post('id_warehouse')) ){
                $data2['id_user'] = $id_user;
                $data2['id_warehouse'] = $this->input->post('id_warehouse');
                $data2['created_by'] = $id[0]->id;
                $data2['updated_by'] = $id[0]->id;
                $this->Models->insert('role_warehouse',$data2);
            }
            redirect(base_url('User'));
        }
    }
    public function Edit($id){
        $this->form_validation->set_rules($this->rulesUser());
        $username = $this->session->userdata('nama');
        if($this->form_validation->run() === FALSE){
            $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $data['role'] =$this->Models->getAll('m_role');
            $data['warehouse'] =$this->Models->AllWarehouse();
            $data['rolewarehouse'] = $this->Models->getID('role_warehouse','id_user',$id);
            $data['users'] =$this->Models->getID('m_user','id',$id);
            $data['title'] = 'Edit';
            $this->load->view('dashboard/header',$data);
            $this->load->view('User/List/side',$data);
            $this->load->view('User/List/edit',$data);
            $this->load->view('dashboard/footer');
        }else{
            $config['upload_path']          = './img/profile/';
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
                $old_image = $data['m_user']['photo'];
                if ( $old_image != "logo.jpg" ){
                    unlink(FCPATH . 'img/profile/' . $old_image);
                }

                $new_image = $this->upload->data('file_name');
                $this->db->set('photo', $new_image);
            }else{
                $data['name'] = $this->input->post('name');
                $data['username'] = $this->input->post('username');
                $data['email'] = $this->input->post('email');
                $data['department'] = $this->input->post('department');
                $data['phone_number'] = $this->input->post('phone_number');
                $data['id_role'] = $this->input->post('id_role');
                $data['updated_by'] = $ID[0]->id;
                $data['updated_at'] = $this->Models->GetTimestamp();
            }
            
            $this->Models->edit('m_user','id',$id,$data);

                if ( !empty($this->input->post('id_user')) ){

                    $this->db->where('id_user', $id);
                    $query = $this->db->get('role_warehouse');

                    if ($query->num_rows() > 0) {
                        $data2['id_user'] = $this->input->post('id_user');
                        $data2['id_warehouse'] = $this->input->post('id_warehouse');
                        $data2['updated_by'] = $ID[0]->id;
                        $data2['updated_at'] = $this->Models->GetTimestamp();
                        $this->Models->edit('role_warehouse','id_user' , $this->input->post('id_user'), $data2);
                    } else {
                        $data2['id_user'] = $this->input->post('id_user');
                        $data2['id_warehouse'] = $this->input->post('id_warehouse');
                        $data2['updated_by'] = $ID[0]->id;
                        $data2['updated_at'] = $this->Models->GetTimestamp();
                        $this->Models->insert('role_warehouse', $data2);
                    }

                } else if (empty($this->input->post('id_user'))) {
                    $this->Models->delete('role_warehouse','id_user', $id);
                }
            redirect(base_url('User'));
        }
    }
    public function EditAdmin($id){
        $this->form_validation->set_rules($this->rulesUpdateUser());
        $username = $this->session->userdata('nama');
        if($this->form_validation->run() === FALSE){
            $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $data['role'] =$this->Models->getAll('m_role');
            $data['warehouse'] =$this->Models->AllWarehouse();
            $data['rolewarehouse'] = $this->Models->getID('role_warehouse','id_user',$id);
            $data['users'] =$this->Models->getID('m_user','id',$id);
            $data['title'] = 'Edit';
            $this->load->view('dashboard/header',$data);
            $this->load->view('User/List/side',$data);
            $this->load->view('User/List/update',$data);
            $this->load->view('dashboard/footer');
        }else{
            $config['upload_path']          = './img/profile/';
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
                $old_image = $data['m_user']['photo'];
                if ( $old_image != "logo.jpg" ){
                    unlink(FCPATH . 'img/profile/' . $old_image);
                }

                $new_image = $this->upload->data('file_name');
                $this->db->set('photo', $new_image);
            }else{
                $data['name'] = $this->input->post('name');
                $data['username'] = $this->input->post('username');
                $data['email'] = $this->input->post('email');
                $data['department'] = $this->input->post('department');
                $data['phone_number'] = $this->input->post('phone_number');
                $data['updated_by'] = $ID[0]->id;
                $data['updated_at'] = $this->Models->GetTimestamp();
            }
            
            $this->Models->edit('m_user','id',$id,$data);

                if ( !empty($this->input->post('id_user')) ){

                    $this->db->where('id_user', $id);
                    $query = $this->db->get('role_warehouse');

                    if ($query->num_rows() > 0) {
                        $data2['id_user'] = $this->input->post('id_user');
                        $data2['id_warehouse'] = $this->input->post('id_warehouse');
                        $data2['updated_by'] = $ID[0]->id;
                        $data2['updated_at'] = $this->Models->GetTimestamp();
                        $this->Models->edit('role_warehouse','id_user' , $this->input->post('id_user'), $data2);
                    } else {
                        $data2['id_user'] = $this->input->post('id_user');
                        $data2['id_warehouse'] = $this->input->post('id_warehouse');
                        $data2['updated_by'] = $ID[0]->id;
                        $data2['updated_at'] = $this->Models->GetTimestamp();
                        $this->Models->insert('role_warehouse', $data2);
                    }

                } else if (empty($this->input->post('id_user'))) {
                    $this->Models->delete('role_warehouse','id_user', $id);
                }
            redirect(base_url('Home'));
        }
    }
    public function Delete($id){
        $this->Models->delete('m_user','id',$id);
        $this->session->set_flashdata('Pesan', '<script>alert("Data berhasil dihapus")</script>');
        redirect(base_url('User'));
    }


    // Role
    public function Role(){
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['role'] = $this->Models->getAll('m_role');
        $data['title'] = 'Role';
        $this->load->view('dashboard/header',$data);
        $this->load->view('User/Role/side',$data);
        $this->load->view('User/Role/main',$data);
        $this->load->view('dashboard/footer');
    }
    public function TambahRole(){
        $this->form_validation->set_rules($this->rulesRoles());
        $ID = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        if($this->form_validation->run() === FALSE){
            $data['user'] =$this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $this->load->view('dashboard/header',$data);
            $this->load->view('User/Role/side',$data);
            $this->load->view('User/Role/main',$data);
            $this->load->view('dashboard/footer');
        }else{
            $id = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));            
            $data['label'] = $this->input->post('label');
            $data['level'] = $this->input->post('level');
            $data['created_by'] = $id[0]->id;;
            $data['updated_by'] = $id[0]->id;;
            $this->Models->insert('m_role',$data);
            $this->session->set_flashdata('pesan','<script>alert("Data berhasil disimpan")</script>');
            redirect(base_url('User/Role'));
        }
    }
    public function EditRole($id){
        $this->form_validation->set_rules($this->rulesRoles());
        if($this->form_validation->run() === false){
            $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $where = array(
                'id' => $id
            );
            $data['role'] = $this->Models->getWhere2("m_role",$where);
            $data['title'] = 'Edit Role';
            $this->load->view('dashboard/header',$data);
            $this->load->view('User/Role/side',$data);
            $this->load->view('User/Role/edit',$data);
            $this->load->view('dashboard/footer');  
            $this->session->set_flashdata('Pesan', '<script>alert("Data gagal diubah")</script>');
        }else{
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));     
            $data['label'] = $this->input->post('label');
            $data['level'] = $this->input->post('level');
            $data['updated_by'] = $ID[0]->id;
            $data['updated_at'] = $this->Models->GetTimestamp();
            $this->Models->edit('m_role','id',$id,$data);
            $this->session->set_flashdata('Pesan', '<script>alert("Data berhasil diubah")</script>');
            redirect(base_url('User/Role'));
        }
    }
    public function Hapusrole($id){
        $this->Models->delete('m_role','id',$id);
        $this->session->set_flashdata('Pesan', '<script>alert("Data berhasil dihapus")</script>');
        redirect(base_url('User/Role'));
    }
}

/* End of file Home.php */
