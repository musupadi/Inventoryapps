<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('Models');
        $this->load->library('form_validation');
    }

    private function rulesAnnouncement(){
        return [
            ['field' => 'title','label' => 'Title','rules' => 'required'],
            ['field' => 'description','label' => 'Description','rules' => 'required']
        ];
    }

    private function rulesCategory(){
        return [
            ['field' => 'label','label' => 'Label','rules' => 'required']
        ];
    }

    public function index()
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['title'] = 'Announcement';
        $data['announcement'] = $this->Models->AllAnnouncement("");
        $this->load->view('dashboard/header',$data);
        $this->load->view('Announcement/side',$data);
        $this->load->view('Announcement/main',$data);
        $this->load->view('dashboard/footer');
    }

    public function addAnnouncement()
    {
        $this->form_validation->set_rules($this->rulesAnnouncement());

        if($this->form_validation->run() === FALSE){
            $data['user'] =$this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $data['title'] = 'Add Announcement';
            $this->load->view('dashboard/header',$data);
            $this->load->view('Announcement/side',$data);
            $this->load->view('Announcement/input',$data);
            $this->load->view('dashboard/footer');
        }else{
            $id = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));            
            $data['title'] = $this->input->post('title');
            $data['receiver'] = "";
            $data['author'] = "";
            $data['date'] = $this->input->post('date');
            $data['description'] = $this->input->post('description');
            $data['id_status'] = 1;
            $data['created_by'] = $id[0]->id;
            $data['update_by'] = $id[0]->id;
            $this->Models->insert('m_announcement',$data);
            redirect(base_url('Announcement'));
        }    
    }

    public function updateAnnouncement($id){
        $this->form_validation->set_rules($this->rulesAnnouncement());
        if($this->form_validation->run() === false){
            $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $where = array(
                'id' => $id
            );
            $data['announcement'] = $this->Models->getWhere2("m_announcement",$where);
            $data['title'] = "Edit Announcement";
            $this->load->view('dashboard/header',$data);
            $this->load->view('Announcement/side',$data);
            $this->load->view('Announcement/edit',$data);
            $this->load->view('dashboard/footer');  
            $this->session->set_flashdata('pesan', '<script>alert("Data gagal diubah")</script>');
        }else{
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));
            $data['title'] = $this->input->post('title');
            $data['receiver'] = $this->input->post('receiver');
            $data['author'] = $this->input->post('author');
            $data['date'] = $this->input->post('date');
            $data['description'] = $this->input->post('description');
            $data['update_by'] = $ID[0]->id;
            $data['update_at'] = $this->Models->GetTimestamp();
            $this->Models->edit('m_announcement','id',$id,$data);
            redirect(base_url('Announcement'));
        }
    }
    
    public function deleteAnnouncement($id){
        $where = ['id' => $id];
        $data['id_status'] = 0;
        $this->Models->edit('m_announcement','id',$id, $data);
        $this->session->set_flashdata('pesan', '<script>alert("Data berhasil dihapus")</script>');
        redirect(base_url('Announcement'));
    }

    public function moreInfo($id)
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['title'] = 'Announcement';
        $data['announcement'] = $this->Models->AllAnnouncement($id);
        $this->load->view('dashboard/header',$data);
        $this->load->view('dashboard/side',$data);
        $this->load->view('Announcement/detail',$data);
        $this->load->view('dashboard/footer');
    }

}

/* End of file Controllername.php */
