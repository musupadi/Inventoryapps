<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('Models');
        $this->load->library('form_validation');
    }
    private function rules(){
        return [
            ['field' => 'username','label' => 'Username','rules' => 'required'],
            ['field' => 'password','label' => 'Password','rules' => 'required'],
            ['field' => 'email','label' => 'Email','rules' => 'required'],
        ];
    }
    public function index()
    {
        $this->load->view('form_login');
    }
    function check_login(){
        $this->form_validation->set_rules('username','username','required');
        $this->form_validation->set_rules('password','password','required');

        if($this->form_validation->run() == FALSE){
            $this->load->view('form_login');
        }else{
            var_dump($this->session->userdata());
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $where = array(
                'username' => $username,
                'password' => MD5($password)
            );
            $cek = $this->Models->data_login("m_user",$where)->row_array();
            if($cek >0){
                $data_session = array(
                    'nama' => $username,
                    'id_role' => $cek['id_role'],
                    'status' => "login"
                );
                $this->session->set_userdata($data_session);
                    redirect('Home');
            }else{
                $this->session->set_flashdata('pesan','Incorrect Email or Password');
                redirect(base_url("Login"));
            }
        }
    }
    function logout(){
        $this->session->sess_destroy();
        redirect(base_url("Login"));
    }
    public function register(){
        $this->form_validation->set_rules($this->rules());
        if($this->form_validation->run() === FALSE){
            $this->load->view('register');
        }else{
            $config['upload_path']          = './img/profile/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            // $config['file_name']            = $this->id;
            // $config['overwrite']			= true;
            //$config['max_size']             = 4096; // 1MB
            // $config['max_width']            = 1024;
            // $config['max_height']           = 768;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('gambar')) {
                $data['name'] = $this->input->post('name');
                $data['username'] = $this->input->post('username');
                $data['password'] = MD5($this->input->post('password'));
                $data['email'] = $this->input->post('email');
                $data['department'] = $this->input->post('department');
                $data['phone_number'] = $this->input->post('phone_number');
                $data['id_role'] = 4;
                $data['photo'] = $this->upload->data('file_name');
            }else{
                $data['name'] = $this->input->post('name');
                $data['username'] = $this->input->post('username');
                $data['password'] = MD5($this->input->post('password'));
                $data['email'] = $this->input->post('email');
                $data['department'] = $this->input->post('department');
                $data['phone_number'] = $this->input->post('phone_number');
                $data['id_role'] = 4;
                $data['photo'] = 'logo.jpg';
            }

            $this->db->where('username', $this->input->post('username'));
            $query = $this->db->get('m_user');

            if ($query->num_rows() > 0) {
                $this->session->set_flashdata('pesan','<script>alert("Username already exists..")</script>');
            } else {
                $this->Models->insert('m_user',$data);
                $this->session->set_flashdata('pesan','<script>alert("New user added successfully")</script>');
            }
            redirect(base_url('Login'));
        }
    }
}

/* End of file Controllername.php */
