<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Home extends CI_Controller {

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

    private function rulesLocation(){
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
        // $data['barang'] = $this->Models->getMyProduct($this->session->userdata('nama'));
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        // $data['count_wallet'] = $this->Models->Count('wallet','status','Belum Diverifikasi');
        $data['title'] = 'Dashboard';
        $data['item'] = $this->Models->itemOneMonth();
        $data['transactionInOut'] = $this->Models->transactionInOut();
        $data['transactionIn'] = $this->Models->transactionIn();
        $data['transactionOut'] = $this->Models->transactionOut();
        $data['announcement'] = $this->Models->AllAnnouncement("");
        $this->load->view('dashboard/header',$data);
        $this->load->view('dashboard/side',$data);
        $this->load->view('dashboard/main',$data);
        $this->load->view('dashboard/footer');
    }
    public function profile(){
        $data['barang'] = $this->Models->getMyProduct($this->session->userdata('nama'));
        $data['user'] = $this->Models->getID('user','username',$this->session->userdata('nama'));
        $data['count_wallet'] = $this->Models->Count('wallet','status','Belum Diverifikasi');
        $this->load->view('dashboard/header',$data);
        $this->load->view('dashboard/side',$data);
        $this->load->view('dashboard/profile',$data);
        $this->load->view('dashboard/footer');
    }
    public function changeimage(){
        $userData = $this->Models->getID('user','username',$this->session->userdata('nama'));
        foreach($userData as $datas){
            if($datas->profile != "default.jpg"){
                $config['upload_path']          = './img/profile/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                // $config['file_name']            = $data->profile;
                // $config['overwrite']			= true;
                $config['max_size']             = 4096; // 1MB
                    // $config['max_width']            = 1024;
                    // $config['max_height']           = 768;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('gambar')) {
                    // $data['password'] = $datas->password;
                    $data['nama'] = $datas->nama;
                    $data['email'] = $datas->email;
                    $data['wallet'] = $datas->wallet;
                    $data['profile'] = $this->upload->data("file_name");
                    $data['alamat'] = $datas->alamat;
                    $data['level'] = $datas->level;
                }else{
                    // $data['password'] = $datas->password;
                    $data['nama'] = $datas->nama;
                    $data['email'] = $datas->email;
                    $data['wallet'] = $datas->wallet;
                    $data['profile'] = "default.jpg";
                    $data['alamat'] = $datas->alamat;
                    $data['level'] = $datas->level;
                }
            }else{
                $config['upload_path']          = './img/profile/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                // $config['file_name']            = $this->id;
                // $config['overwrite']			= true;
                $config['max_size']             = 4096; // 1MB
                // $config['max_width']            = 1024;
                // $config['max_height']           = 768;
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('gambar')) {
                    // $data['password'] = $datas->password;
                    $data['nama'] = $datas->nama;
                    $data['email'] = $datas->email;
                    $data['wallet'] = $datas->wallet;
                    $data['profile'] = $this->upload->data("file_name");
                    $data['alamat'] = $datas->alamat;
                    $data['level'] = $datas->level;
                }else{
                    // $data['password'] = $datas->password;
                    $data['nama'] = $datas->nama;
                    $data['email'] = $datas->email;
                    $data['wallet'] = $datas->wallet;
                    $data['profile'] = "default.jpg";
                    $data['alamat'] = $datas->alamat;
                    $data['level'] = $datas->level;
                }
            }
            $this->Models->edit('user','username',$this->session->userdata('nama'),$data);
            $this->session->set_flashdata('Pesan', '<script>alert("Gambar Berhasil diubah")</script>');
            redirect(base_url('Home/profile'));
        }
    }
    public function changeProfileData(){
        $userData = $this->Models->getID('user','username',$this->session->userdata('nama'));
        foreach($userData as $user){
            // $data['password'] = $user->password;
            $data['nama'] = $this->input->post('nama');
            $data['email'] = $this->input->post('email');
            $data['wallet'] = $user->wallet;
            $data['profile'] = $user->profile;
            $data['alamat'] = $this->input->post('alamat');
            $data['level'] = $user->level;

            $this->Models->edit('user','username',$this->session->userdata('nama'),$data);
            $this->session->set_flashdata('pesan','<script>alert("Data berhasil diubah")</script>');
            redirect(base_url('home/profile'));
        }
    }

    public function MyProfile()
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['Data'] = $this->Models->AllUser();
        $data['role'] =$this->Models->getAll('m_role');
        $roles = $this->Models->RoleWarehouse($data['user'][0]->id);
        $data['transaction'] = $this->Models->TransactionUser($data['user'][0]->id);
        $data['request'] = $this->Models->CountTransactionUser($data['user'][0]->id,"0");
        $data['accept'] = $this->Models->CountTransactionUser($data['user'][0]->id,"1");
        $data['reject'] = $this->Models->CountTransactionUser($data['user'][0]->id,"2");
        // $data['count'] = $this->Models->CountTransactionUser($data['user'][0]->id);
        $data['title'] = 'My Profile';
        // var_dump($data['request']);
        // die;
        
        $this->load->view('dashboard/header',$data);
        $this->load->view('dashboard/side',$data);
        $this->load->view('Profile/MyProfileUser/main',$data);
        $this->load->view('dashboard/footer');
    }
    public function MyProfileAdmin()
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['Data'] = $this->Models->AllUser();
        $data['role'] =$this->Models->getAll('m_role');
        $roles = $this->Models->RoleWarehouse($data['user'][0]->id);
        $data['transaction'] = $this->Models->TransactionUser($data['user'][0]->id);
        $data['request'] = $this->Models->CountTransactionUser($data['user'][0]->id,"0");
        $data['accept'] = $this->Models->CountTransactionUser($data['user'][0]->id,"1");
        $data['reject'] = $this->Models->CountTransactionUser($data['user'][0]->id,"2");
        // $data['count'] = $this->Models->CountTransactionUser($data['user'][0]->id);
        $data['title'] = 'My Profile';
        // var_dump($data['request']);
        // die;
        
        $this->load->view('dashboard/header',$data);
        $this->load->view('dashboard/side',$data);
        $this->load->view('Profile/MyProfileUser/main',$data);
        $this->load->view('dashboard/footer');
    }

    public function MyProfileUser()
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['Data'] = $this->Models->AllUser();
        $data['role'] =$this->Models->getAll('m_role');
        $roles = $this->Models->RoleWarehouse($data['user'][0]->id);
        $data['transaction'] = $this->Models->TransactionUser($data['user'][0]->id);
        $data['request'] = $this->Models->CountTransactionUser($data['user'][0]->id,"0");
        $data['accept'] = $this->Models->CountTransactionUser($data['user'][0]->id,"1");
        $data['reject'] = $this->Models->CountTransactionUser($data['user'][0]->id,"2");
        // $data['count'] = $this->Models->CountTransactionUser($data['user'][0]->id);
        $data['title'] = 'My Profile';
        // var_dump($data['request']);
        // die;
        
        $this->load->view('dashboard/header',$data);
        $this->load->view('dashboard/side',$data);
        $this->load->view('Profile/MyProfileUser/main',$data);
        $this->load->view('dashboard/footer');
    }
    public function MyProfileAdminWarehouse()
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['Data'] = $this->Models->AllUser();
        $data['role'] =$this->Models->getAll('m_role');
        $roles = $this->Models->RoleWarehouse($data['user'][0]->id);
        $data['transaction'] = $this->Models->TransactionUser($data['user'][0]->id);
        $data['request'] = $this->Models->CountTransactionUser($data['user'][0]->id,"0");
        $data['accept'] = $this->Models->CountTransactionUser($data['user'][0]->id,"1");
        $data['reject'] = $this->Models->CountTransactionUser($data['user'][0]->id,"2");
        // $data['count'] = $this->Models->CountTransactionUser($data['user'][0]->id);
        $data['title'] = 'My Profile';
        // var_dump($data['request']);
        // die;
        
        $this->load->view('dashboard/header',$data);
        $this->load->view('dashboard/side',$data);
        $this->load->view('Profile/MyProfileUser/main',$data);
        $this->load->view('dashboard/footer');
    }

    public function EditProfileUser($id){
        $this->form_validation->set_rules($this->rulesUser());
        $username = $this->session->userdata('nama');
        if($this->form_validation->run() === FALSE){
            $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $data['role'] =$this->Models->getAll('m_role');
            $data['users'] =$this->Models->getID('m_user','id',$id);
            $data['title'] = 'Edit';
            $this->load->view('dashboard/header',$data);
            $this->load->view('dashboard/side',$data);
            $this->load->view('Profile/MyProfileUser/edit',$data);
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
                // $data['password'] = MD5($this->input->post('password'));
                $data['email'] = $this->input->post('email');
                $data['id_role '] = $this->input->post('id_role');
                $data['photo'] = $this->upload->data("file_name");
                $data['updated_by'] = $ID[0]->id;
                $data['updated_at'] = $this->Models->GetTimestamp();
            }else{
                $data['name'] = $this->input->post('name');
                $data['username'] = $this->input->post('username');
                // $data['password'] = MD5($this->input->post('password')); 
                $data['email'] = $this->input->post('email');
                $data['id_role '] = $this->input->post('id_role');
                $data['photo'] = "logo.jpg";
                $data['updated_by'] = $ID[0]->id;
                $data['updated_at'] = $this->Models->GetTimestamp();
            }
            $this->Models->edit('m_user','id',$id,$data);
            $this->session->set_flashdata('pesan','<script>alert("Data berhasil disimpan")</script>');
            redirect(base_url('Home/MyProfileUser'));
        }

    }
    public function EditProfileAdminWarehouse($id){
        $this->form_validation->set_rules($this->rulesUser());
        $username = $this->session->userdata('nama');
        if($this->form_validation->run() === FALSE){
            $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $data['role'] =$this->Models->getAll('m_role');
            $data['users'] =$this->Models->getID('m_user','id',$id);
            $data['title'] = 'Edit';
            $this->load->view('dashboard/header',$data);
            $this->load->view('dashboard/side',$data);
            $this->load->view('Profile/MyProfileAdminWarehouse/edit',$data);
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
                // $data['password'] = MD5($this->input->post('password'));
                $data['email'] = $this->input->post('email');
                $data['id_role '] = $this->input->post('id_role');
                $data['photo'] = $this->upload->data("file_name");
                $data['updated_by'] = $ID[0]->id;
                $data['updated_at'] = $this->Models->GetTimestamp();
            }else{
                $data['name'] = $this->input->post('name');
                $data['username'] = $this->input->post('username');
                // $data['password'] = MD5($this->input->post('password')); 
                $data['email'] = $this->input->post('email');
                $data['id_role '] = $this->input->post('id_role');
                $data['photo'] = "logo.jpg";
                $data['updated_by'] = $ID[0]->id;
                $data['updated_at'] = $this->Models->GetTimestamp();
            }
            $this->Models->edit('m_user','id',$id,$data);
            $this->session->set_flashdata('pesan','<script>alert("Data berhasil disimpan")</script>');
            redirect(base_url('Home/MyProfileAdminWarehouse'));
        }
    }

   
    public function Location(){
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['location'] = $this->Models->getAll('m_location');
        $data['title'] = 'Location';
        $this->load->view('dashboard/header',$data);
        $this->load->view('masterData/Location/side',$data);
        $this->load->view('masterData/Location/main',$data);
        $this->load->view('dashboard/footer');
    }

    public function TambahLocation(){
        $this->form_validation->set_rules($this->rulesLocation());
        $ID = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        if($this->form_validation->run() === FALSE){
            $data['user'] =$this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $this->load->view('dashboard/header',$data);
            $this->load->view('masterData/Location/side',$data);
            $this->load->view('masterData/Location/main',$data);
            $this->load->view('dashboard/footer');
        }else{
            $id = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));            
            $data['label'] = $this->input->post('label');
            $data['floor'] = $this->input->post('floor');
            $data['created_by'] = $id[0]->id;;
            $data['updated_by'] = $id[0]->id;;
            $this->Models->insert('m_location',$data);
            $this->session->set_flashdata('pesan','<script>alert("Data berhasil disimpan")</script>');
            redirect(base_url('Home/Location'));
        }
    }

    public function EditLocation($id){
        $this->form_validation->set_rules($this->rulesLocation());
        if($this->form_validation->run() === false){
            $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $where = array(
                'id' => $id
            );
            $data['location'] = $this->Models->getWhere2("m_location",$where);
            $this->load->view('dashboard/header',$data);
            $this->load->view('User/Role/side',$data);
            $this->load->view('masterData/Location/edit',$data);
            $this->load->view('dashboard/footer');  
            $this->session->set_flashdata('pesan', '<script>alert("Data gagal diubah")</script>');
        }else{
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));     
            $data['label'] = $this->input->post('label');
            $data['floor'] = $this->input->post('floor');
            $data['updated_by'] = $ID[0]->id;
            $data['updated_at'] = $this->Models->GetTimestamp();
            $this->Models->edit('m_location','id',$id,$data);
            $this->session->set_flashdata('pesan', '<script>alert("Data berhasil diubah")</script>');
            redirect(base_url('Home/Location'));
        }
    }

    public function HapusLocation($id){
        $this->Models->delete('m_location','id',$id);
        $this->session->set_flashdata('pesan', '<script>alert("Data berhasil dihapus")</script>');
        redirect(base_url('Home/Location'));
    }
    public function EditHistory(){
        $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));  
        $id = $this->input->post('id');
        $data['back_date'] = $this->input->post('backdate');
        $data['updated_at'] = $this->Models->GetTimestamp();
        $data['updated_by'] = $ID[0]->id;
        $this->Models->edit('m_log','id',$id,$data);
        redirect(base_url('Home/HistoryTransaction'));
    }
    public function HistoryTransaction()
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['title'] = 'History Transaction';
        if($data['user'][0]->id_role == 3){
            $getRolesID = $this->Models->getID('role_warehouse','id_user',$data['user'][0]->id);
            $data['history'] = $this->Models->AllHistoryTransactionAdmin($getRolesID[0]->id_warehouse);
        }else{
            $data['history'] = $this->Models->AllHistoryTransaction();
        }
        
   
        $data['item'] = $this->Models->AllItem();
        $data['warehouse'] = $this->Models->AllWarehouse();
        $this->load->view('dashboard/header',$data);
        $this->load->view('History/side',$data);
        $this->load->view('History/main',$data);
        $this->load->view('dashboard/footer');
    }
    public function PDFCard(){
        $product_name = $this->input->post('product_name');
        $max_stock = $this->input->post('max_stock');
        $min_stock = $this->input->post('min_stock');

        
    }
    public function RepairLogItem($id_item) {
        $this->Models->RepairLogItem($id_item);
        // $Log = $this->Models->GetLogItem($id_item);
       
        // foreach ($Log as $index => $repair) {
        //     $id = $repair->id;
        //     $prev = $repair->qty1;
        //     $balance = $repair->balance;
        //     $after = $repair->qty2;
        //     $description = $repair->description;
    
        //     if ($index != 0) {
        //         // Ambil qty2 dari transaksi sebelumnya sebagai AfterBefore
        //         $AfterBefore = $Log[$index - 1]->qty2;
    
        //         if ($description == "0") { // Item keluar
        //             $expectedQty1 = $AfterBefore;
        //             $expectedQty2 = $expectedQty1 - $balance;
    
        //             // Perbaiki qty1 jika tidak sesuai
        //             if ($prev != $expectedQty1) {
        //                 $data['qty1'] = $expectedQty1;
        //             }
        //             // Perbaiki qty2 jika tidak sesuai
        //             if ($after != $expectedQty2) {
        //                 $data['qty2'] = $expectedQty2;
        //             }
        //         } else if ($description == "1") { // Item masuk
        //             $expectedQty1 = $AfterBefore;
        //             $expectedQty2 = $expectedQty1 + $balance;
    
        //             // Perbaiki qty1 jika tidak sesuai
        //             if ($prev != $expectedQty1) {
        //                 $data['qty1'] = $expectedQty1;
        //             }
        //             // Perbaiki qty2 jika tidak sesuai
        //             if ($after != $expectedQty2) {
        //                 $data['qty2'] = $expectedQty2;
        //             }
        //         }
    
        //         // Update jika ada perubahan pada qty1 atau qty2
        //         if (!empty($data)) {
        //             $this->Models->edit('m_log', 'id', $id, $data);
        //             var_dump($this->db->last_query());
        //         }
        //     }
        // }
    }
    
    
    public function RepairLOG(){
        $Log = $this->Models->getAll('m_log');
        foreach($Log as $index => $repair){
            $id = $repairs->id;

            if($repairs->description = "0"){
                $prev = $repairs->qty1;
                $in = $repairs->balance;
                $after = $repairs->qty2;
                $RepairsData = $prev - $in;
                if($after != $RepairsData){
                    $data['qty2'] = $RepairsData;
                    $this->Models->edit('m_log','id',$id,$data);
                }
               
            }else if($repairs->description = "1"){
                $prev = $repairs->qty1;
                $in = $repairs->balance;
                $after = $repairs->qty2;
                $RepairsData = $prev + $in;
                if($after != $RepairsData){
                    $data['qty2'] = $RepairsData;
                    $this->Models->edit('m_log','id',$id,$data);
                }
            }
        }
    }
    public function PdfTransaction() {
        // Retrieve POST data
        $start_date = $this->input->post('start_date');
        $end_dates = $this->input->post('end_date');
        $responsible = $this->input->post('responsible');
        $name = $this->input->post('name');
        $department = $this->input->post('department');
        $id_item = $this->input->post('id_item');
        $pdf_editor = $this->input->post('pdf');
        // var_dump($responsible);
        // die;
        // Adjust end date
        $end_date = null;
        if ($end_dates != null) {
            $end_date = date('Y-m-d', strtotime($end_dates . ' +1 day'));
        }
    
        // Get user data
        $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));
    
        
    
        if($pdf_editor=="2"){
            // Initialize TCPDF
            $pdf = new TCPDF('P', 'mm', 'A4');
            $pdf->SetMargins(5, 15, 5);
            $pdf->SetAutoPageBreak(true, 10);
            $pdf->AddPage();
        
            // Add logo image to PDF
            $imageUrl = 'https://portal.podomorouniversity.ac.id/assets/icon/logo_pu.png';
            $pdf->Image($imageUrl, 158, 15, 50, 0, '', '', '', false, 300, '', false, false, 0, false, false, false);
        
            // Add user details with HTML
            $pdf->SetFont('helvetica', '', 12);
            $html = '<b>Name:</b> ' . $name  . '<br>';
            $html .= '<b>Department:</b> ' . $department . '<br>';
            $html .= '<b>Date:</b> ' . ($start_date != "" || $start_date != null && $end_date != "" || $end_date != null ? $start_date . ' - ' . $end_date : 'All') . '<br>';
            $pdf->writeHTML($html, true, false, true, false, '');
        
            // Add header for transaction list with HTML
            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->Cell(0, 10, 'Transaction List', 0, 1, 'C');
            $pdf->SetFont('helvetica', '', 6);
            // Table headers with HTML
            $html = '<table border="1" cellpadding="4">
                        <tr>
                            <th style="width:20px;">No</th>
                            <th style="width:50px;">Name</th>
                            <th style="width:50px;">Tanggal</th>
                            <th style="width:50px;">Masuk</th>
                            <th style="width:50px;">Keluar</th>
                            <th style="width:50px;">Sisa</th>
                            <th style="width:75px;">Pengambil</th>
                            <th style="width:150px;">Keterangan</th>
                            <th style="width:75px;">PIC WH</th>
                        </tr>';
        
            // Retrieve transaction data
            if ($start_date != null || $end_date != null) {
                if ($id_item != "" || $id_item != null) {
                    $this->Models->RepairLogItem($id_item);
                    if ($data['user'][0]->id_role == 3) {
                        $getRolesID = $this->Models->getID('role_warehouse', 'id_user', $data['user'][0]->id);
                        $data = $this->Models->AllHistoryTransactionFilterItemAdmin($start_date, $end_date, $id_item, $getRolesID[0]->id_warehouse);
                    } else {
                        $data = $this->Models->AllHistoryTransactionFilterItem($start_date, $end_date, $id_item);
                    }
                } else {
                    if ($data['user'][0]->id_role == 3) {
                        $getRolesID = $this->Models->getID('role_warehouse', 'id_user', $data['user'][0]->id);
                        $data = $this->Models->AllHistoryTransactionFilterAdmin($start_date, $end_date, $getRolesID[0]->id_warehouse);
                    
                    } else {
                        $data = $this->Models->AllHistoryTransactionFilter($start_date, $end_date);
                       
                    }
                }
            } else {
                if ($id_item != "" || $id_item != null) {
                    $this->Models->RepairLogItem($id_item);
                    if ($data['user'][0]->id_role == 3) {
                        $getRolesID = $this->Models->getID('role_warehouse', 'id_user', $data['user'][0]->id);
                        $data = $this->Models->AllHistoryTransactionItemAdmin($id_item, $getRolesID[0]->id_warehouse);
                    } else {
                        $data = $this->Models->AllHistoryTransactionItem($id_item);
                    }
                } else {
                    if ($data['user'][0]->id_role == 3) {
                        $getRolesID = $this->Models->getID('role_warehouse', 'id_user', $data['user'][0]->id);
                        $data = $this->Models->AllHistoryTransactionAdmin($getRolesID[0]->id_warehouse);
                        
                    } else {
                        $data = $this->Models->AllHistoryTransaction();
                    }
                }
            }
            // var_dump($this->db->last_query());
            // die;
            // Populate transaction data in table
            $counter = 1;
            foreach ($data as $transaction) {
                $description = $transaction->description == 0 ? "Out" : ($transaction->description == 2 ? "Ex" : "In");
                $receive = (!empty($transaction->receiver)) ? $transaction->receiver : "Not Found";
                if($transaction->description == 0){
                    $html .= '<tr>
                        <td>' . $counter . '</td>
                        <td>' . $transaction->item_name . '</td>
                        <td>' . date_format(date_create($transaction->back_date), "d M Y") . '</td>
                        <td></td>
                        <td>' . $transaction->balance . '</td>
                        <td>' . $transaction->qty2 . '</td>
                        <td>' . $transaction->user . '</td>
                        <td>' . $transaction->reason . '</td>
                        <td>' . $receive . '</td>
                    </tr>';
                }else if($transaction->description == 1){
                    $html .= '<tr>
                        <td>' . $counter . '</td>
                        <td>' . $transaction->item_name . '</td>
                        <td>' . date_format(date_create($transaction->back_date), "d M Y") . '</td>
                        <td>' . $transaction->balance . '</td>
                        <td></td>
                        <td>' . $transaction->qty2 . '</td>
                        <td>' . $transaction->user . '</td>
                        <td>' . $transaction->reason . '</td>
                        <td>' . $receive . '</td>
                    </tr>';
                }else{
                    $html .= '<tr>
                        <td>' . $counter . '</td>
                        <td>' . $transaction->item_name . '</td>
                        <td>' . date_format(date_create($transaction->back_date), "d M Y") . '</td>
                        <td></td>
                        <td></td>
                        <td>' . $transaction->qty2 . '</td>
                        <td>' . $transaction->user . '</td>
                        <td>' . $transaction->reason . '</td>
                        <td>' . $receive . '</td>
                    </tr>';
                }
                $counter ++;  
            }
            
            $html .= '</table>'; 
               // Output table with HTML
            $pdf->writeHTML($html, true, false, true, false, '');
        
            // Check if there's enough space for the footer, if not, add a new page
            if($pdf->getY() > 280) {
                $pdf->AddPage();
            }
        
            // Move to the last page
            $pdf->lastPage();
            $pdf->SetAutoPageBreak(false);
            // Add footer content to the last page only
      
            $pdf->SetFont('helvetica', '', 7);
        
            // Menambahkan bagian "Dibuat Oleh" di sebelah kiri

        
            // Memeriksa panjang string untuk penambahan baris baru
             // Mengatur posisi X ke margin kiri
             $pdf->SetY(-30); // Mengatur posisi lebih rendah untuk mendekati bagian bawah halaman

             // Gabungkan dua sel dalam satu baris
             $pdf->SetX(15);
             $pdf->Cell(30, 10, 'Dibuat Oleh', 0, 0, 'C');
             
             $pdf->SetX(170);
             $pdf->Cell(30, 10, 'Diketahui Oleh', 0, 0, 'C');


             $pdf->SetY(-10); // Mengatur posisi lebih rendah untuk mendekati bagian bawah halaman

             // Gabungkan dua sel dalam satu baris
             $pdf->SetX(0);
             $pdf->Cell(60, 10, $name, 0, 0, 'C');
             
             $pdf->SetX(155);
             $pdf->Cell(60, 10, $responsible, 0, 0, 'C');
            // if(strlen($name) > 10){ // Asumsikan 30 karakter adalah batas panjang yang ditentukan
            //     $pdf->MultiCell(0, 10, "       Dibuat Oleh\n\n\n\n\n\n\n" . $name, 0, 'L', 0, 0);
            // } else {
            //     $pdf->MultiCell(0, 10, "       Dibuat Oleh\n\n\n\n\n\n\n               " . $name, 0, 'L', 0, 0);
            // }
        
            
            // Menambahkan bagian "Diketahui Oleh" di sebelah kanan
            // $pdf->SetX(-100); // Mengatur posisi X ke margin kanan
            // if(strlen($responsible) > 10){ // Asumsikan 30 karakter adalah batas panjang yang ditentukan
            //     $pdf->MultiCell(0, 10, "Diketahui Oleh       \n\n\n\n\n\n\n" . $responsible, 0, 'R', 0, 0);
            // } else {
            //     $pdf->MultiCell(0, 10, "Diketahui Oleh       \n\n\n\n\n\n\n" . $responsible."                ", 0, 'R', 0, 0);
            // }
        
            $pdf->Output('TRANSACTION_REPORT.PDF', 'I'); // Untuk menampilkan di browser
        }else{
            // Initialize TCPDF
            $pdf = new TCPDF('L', 'mm', 'A4');
            $pdf->SetMargins(15, 15, 15);
            $pdf->SetAutoPageBreak(true, 10);
            $pdf->AddPage();
        
            // Add logo image to PDF
            $imageUrl = 'https://portal.podomorouniversity.ac.id/assets/icon/logo_pu.png';
            $pdf->Image($imageUrl, 235, 15, 50, 0, '', '', '', false, 300, '', false, false, 0, false, false, false);
        
            // Add user details with HTML
            $pdf->SetFont('helvetica', '', 12);
            $html = '<b>Name:</b> ' . $name  . '<br>';
            $html .= '<b>Department:</b> ' . $department . '<br>';
            $html .= '<b>Date:</b> ' . ($start_date != "" || $start_date != null && $end_date != "" || $end_date != null ? $start_date . ' - ' . $end_date : 'All') . '<br>';
            $pdf->writeHTML($html, true, false, true, false, '');
        
            // Add header for transaction list with HTML
            $pdf->SetFont('helvetica', 'B', 16);
            $pdf->Cell(0, 10, 'Transaction List', 0, 1, 'C');
            $pdf->SetFont('helvetica', '', 7);
            // Table headers with HTML
            $html = '<table border="1" cellpadding="4">
                        <tr>
                            <th style="width:100px;">Item Name</th>
                            <th style="width:50px;">Warehouse</th>
                            <th style="width:50px;">In</th>
                            <th style="width:50px;">Out</th>
                            <th style="width:50px;">Balance</th>
                            <th>Desc</th>
                            <th style="width:100px;">User</th>
                            <th style="width:100px;">Transaction Date</th>
                            <th style="width:175px;">Reason</th>
                        </tr>';
        
            // Retrieve transaction data
            if ($start_date != null || $end_date != null) {
                if ($id_item != "" || $id_item != null) {
                    if ($data['user'][0]->id_role == 3) {
                        $getRolesID = $this->Models->getID('role_warehouse', 'id_user', $data['user'][0]->id);
                        $data = $this->Models->AllHistoryTransactionFilterItemAdmin($start_date, $end_date, $id_item, $getRolesID[0]->id_warehouse);
                    } else {
                        $data = $this->Models->AllHistoryTransactionFilterItem($start_date, $end_date, $id_item);
                    }
                } else {
                    if ($data['user'][0]->id_role == 3) {
                        $getRolesID = $this->Models->getID('role_warehouse', 'id_user', $data['user'][0]->id);
                        $data = $this->Models->AllHistoryTransactionFilterAdmin($start_date, $end_date, $getRolesID[0]->id_warehouse);
                    } else {
                        $data = $this->Models->AllHistoryTransactionFilter($start_date, $end_date);
                    }
                }
            } else {
                if ($id_item != "" || $id_item != null) {
                    if ($data['user'][0]->id_role == 3) {
                        $getRolesID = $this->Models->getID('role_warehouse', 'id_user', $data['user'][0]->id);
                        $data = $this->Models->AllHistoryTransactionItemAdmin($id_item, $getRolesID[0]->id_warehouse);
                    } else {
                        $data = $this->Models->AllHistoryTransactionItem($id_item);
                    }
                } else {
                    if ($data['user'][0]->id_role == 3) {
                        $getRolesID = $this->Models->getID('role_warehouse', 'id_user', $data['user'][0]->id);
                        $data = $this->Models->AllHistoryTransactionAdmin($getRolesID[0]->id_warehouse);
                    } else {
                        $data = $this->Models->AllHistoryTransaction();
                    }
                }
            }
        
            // Populate transaction data in table
            foreach ($data as $transaction) {
                $description = $transaction->description == 0 ? "Out" : ($transaction->description == 2 ? "Ex" : "In");
                if($transaction->description == 0){
                    $html .= '<tr>
                    <td>' . $transaction->item_name . '</td>
                    <td>' . $transaction->warehouse . '</td>
                    <td></td>
                    <td>' . $transaction->balance . '</td>
                    <td>' . $transaction->qty2 . '</td>
                    <td>' . $description . '</td>
                    <td>' . $transaction->user . '</td>
                    <td>' . date_format(date_create($transaction->back_date), "d M Y") . '</td>
                    <td>' . $transaction->reason . '</td>
                </tr>';
                }else if($transaction->description == 1){
                    $html .= '<tr>
                    <td>' . $transaction->item_name . '</td>
                    <td>' . $transaction->warehouse . '</td>
                    <td>' . $transaction->balance . '</td>
                    <td></td>
                    <td>' . $transaction->qty2 . '</td>
                    <td>' . $description . '</td>
                    <td>' . $transaction->user . '</td>
                    <td>' . date_format(date_create($transaction->back_date), "d M Y") . '</td>
                    <td>' . $transaction->reason . '</td>
                </tr>';
                }else{
                    $html .= '<tr>
                    <td>' . $transaction->item_name . '</td>
                    <td>' . $transaction->warehouse . '</td>
                    <td></td>
                    <td></td>
                    <td>' . $transaction->qty2 . '</td>
                    <td>' . $description . '</td>
                    <td>' . $transaction->user . '</td>
                    <td>' . date_format(date_create($transaction->back_date), "d M Y") . '</td>
                    <td>' . $transaction->reason . '</td>
                </tr>';
                }
            }
        
            $html .= '</table>';
              // Output table with HTML
            $pdf->writeHTML($html, true, false, true, false, '');
        
            // Check if there's enough space for the footer, if not, add a new page
            if($pdf->getY() > 180) {
                $pdf->AddPage();
            }
        
            // Move to the last page
            $pdf->lastPage();
            $pdf->SetAutoPageBreak(false);
            // Add footer content to the last page only
            $pdf->SetY(-30); // Mengatur posisi lebih rendah untuk mendekati bagian bawah halaman
            $pdf->SetFont('helvetica', '', 7);
        
            // Menambahkan bagian "Dibuat Oleh" di sebelah kiri
            $pdf->SetX(15); // Mengatur posisi X ke margin kiri
        
            // Memeriksa panjang string untuk penambahan baris baru
            if(strlen($name) > 10){ // Asumsikan 30 karakter adalah batas panjang yang ditentukan
                $pdf->MultiCell(0, 10, "       Dibuat Oleh\n\n\n\n\n\n\n" . $name, 0, 'L', 0, 0);
            } else {
                $pdf->MultiCell(0, 10, "       Dibuat Oleh\n\n\n\n\n\n\n       " . $name, 0, 'L', 0, 0);
            }
        
            // Menambahkan bagian "Diketahui Oleh" di sebelah kanan
            $pdf->SetX(-100); // Mengatur posisi X ke margin kanan
            if(strlen($responsible) > 10){ // Asumsikan 30 karakter adalah batas panjang yang ditentukan
                $pdf->MultiCell(0, 10, "Diketahui Oleh       \n\n\n\n\n\n\n" . $responsible, 0, 'R', 0, 0);
            } else {
                $pdf->MultiCell(0, 10, "Diketahui Oleh       \n\n\n\n\n\n\n" . $responsible."         ", 0, 'R', 0, 0);
            }
        
            $pdf->Output('TRANSACTION_REPORT.PDF', 'I'); // Untuk menampilkan di browser
            }

    
      
        // Atau
        // $pdf->Output('path/to/save/TRANSACTION_REPORT.PDF', 'F'); // Untuk menyimpan di file
    }
    
    
    
    

    
    public function HistoryTransactionFilter()
    {
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $end_dates = date('Y-m-d', strtotime($end_date . ' +1 day'));
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['title'] = 'History Transaction';
        if($data['user'][0]->id_role == 3){
            $data['history'] = $this->Models->AllHistoryTransactionFilterAdmin($start_date,$end_dates,$getRolesID[0]->id_warehouse);
        }else{
            $data['history'] = $this->Models->AllHistoryTransactionFilter($start_date,$end_dates);
        }
        $data['item'] = $this->Models->AllItem();
        $data['warehouse'] = $this->Models->AllWarehouse();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $this->load->view('dashboard/header',$data);
        $this->load->view('History/side',$data);
        $this->load->view('History/main2',$data);
        $this->load->view('dashboard/footer');
    }

    public function UserPage() 
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        // $data['history'] = $this->Models->AllHistoryTr();
        $data['title'] = 'User Page';
        $this->load->view('dashboard/header',$data);
        $this->load->view('dashboard/side',$data);
        $this->load->view('dashboard/main',$data);
        $this->load->view('dashboard/footer');
    }

    public function AdminWarehouse() 
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        // $data['history'] = $this->Models->AllHistoryTr();
        $data['title'] = 'Admin Warehouse Page';
        $this->load->view('dashboard/header',$data);
        $this->load->view('dashboard/side',$data);
        $this->load->view('dashboard/main',$data);
        $this->load->view('dashboard/footer');
    }


    


}

/* End of file Home.php */
