<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

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
            ['field' => 'handover_date','label' => 'Handover Date','rules' => 'required']
        ];
    }
    private function rulesTransaction2(){
        return [
            ['field' => 'id','label' => 'Id','rules' => 'required'],
        ];
    }
    public function index()
    {
        // $data['barang'] = $this->Models->getMyProduct($this->session->userdata('nama'));
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['transaction'] = $this->Models->AllTransaction();
        $data['warehouse'] = $this->Models->getAll('m_warehouse');
        $data['title'] = 'Transaction';
        $data['category'] = $this->Models->getAll('m_category');
        $this->load->view('dashboard/header',$data);
        $this->load->view('Transaction/side',$data);
        $this->load->view('Transaction/main',$data);
        $this->load->view('dashboard/footer');
    }
    public function Filter()
    {
        $ID_Warehouse = $this->input->post('warehouse_id');   
        // $data['barang'] = $this->Models->getMyProduct($this->session->userdata('nama'));
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['transaction'] = $this->Models->AllTransaction($ID_Warehouse);
        $data['warehouse'] = $this->Models->getAll('m_warehouse');
        $data['title'] = 'Transaction';
        $data['category'] = $this->Models->getAll('m_category');
        $this->load->view('dashboard/header',$data);
        $this->load->view('Transaction/side',$data);
        $this->load->view('Transaction/main',$data);
        $this->load->view('dashboard/footer');
    }
    public function CheckReject(){
        $transaction = $this->Models->AllTransaction();
        $today = new DateTime();
        
        foreach($transaction as $row){
            $created_at = $row->created_at;
            $strdate = "+ 3 hours";
		    $expired_date = date('Y-m-d h:m:s', strtotime($strdate, strtotime(date('Y-m-d h:m:s'))));
            // var_dump($expired_date);
            // die;
            if($created_at < $expired_date){
                if($row->status == 0){
                    $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));  
                    // $last_id = $this->db->insert_id();

                    $log['label'] = "edit";
                    $log['description'] = "User ".$ID[0]->name." Reject Item Named ".$this->Models->getID('tr_item', 'id', $row->id);
                    $log['id_affected'] =  $row->id;
                    $log['table'] = "m_item";
                    $log['created_by'] = $id[0]->id;
                    $this->Models->insert('log_user',$log);

                    $data['status'] = 2;
                    $data['updated_by'] = $ID[0]->id;
                    $data['updated_at'] = $this->Models->GetTimestamp();
                    $result = $this->Models->edit('tr_item','id',$row->id,$data);
                } 
            }
        }
    }
    public function PICMaker($ID){
        //7 Rachel
        //2 Pak Ridwan
        // $ID= $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $getRolesID = $this->Models->getID('role_warehouse','id_user',$ID);      
        $DataWarehouse = $this->Models->getID('m_log','id_warehouse',$getRolesID[0]->id_warehouse);
        foreach($DataWarehouse as $Warehouse){
            $data['pic'] = $ID;
            $this->Models->edit('m_log','id_warehouse',$getRolesID[0]->id_warehouse,$data);
        }
    }
    public function Category()
    {
        // $data['barang'] = $this->Models->getMyProduct($this->session->userdata('nama'));
        $category = $this->input->post('id_category');  
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['transaction'] = $this->Models->AllTransactionCat($category);
        $data['count'] = $this->Models->AllTransactionCount();
        $data['title'] = 'Transaction';
        $data['category'] = $this->Models->getAll('m_category');
        $this->load->view('dashboard/header',$data);
        $this->load->view('Transaction/side',$data);
        $this->load->view('Transaction/main',$data);
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
            $this->session->set_flashdata('pesan', '<script>alert("Data gagal diubah")</script>');
        }else{
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));  
            $qty = $this->Models->GetQuantity($this->input->post('id_item'),$this->input->post('id_warehouse'));
            if($qty){
                if($qty[0]->qty < $this->input->post('qty')){
                    $this->session->set_flashdata('pesan', '<script>alert("Stock barang Tidak Cukup")</script>');
                    redirect(base_url('Transaction'));
                }else{
                    $DataID = $this->Models->getID('tr_item','id',$this->input->post('id_edit'));
                    $UserID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama')); 
                    $data['handover_date'] = $this->input->post('handover_date');   
                    $data['status'] = 1;
                    $data['updated_by'] = $ID[0]->id;
                    $data['updated_at'] = $this->Models->GetTimestamp();
                    $this->Models->edit('tr_item','id',$this->input->post('id_edit'),$data);

                    $data2['qty'] = $qty[0]->qty - $this->input->post('qty');
                    $data2['updated_by'] = $ID[0]->id;
                    $data2['updated_at'] = $this->Models->GetTimestamp();
                    $this->Models->edit('m_stock','id',$qty[0]->id,$data2);
                    
                    $data3['id_item'] = $this->input->post('id_item');   
                    $data3['id_warehouse'] = $this->input->post('id_warehouse');   
                    $data3['description'] = 0;
                    $data3['reason'] = $DataID[0]->reason;
                    $data3['qty1'] = $qty[0]->qty;
                    $data3['balance'] = $this->input->post('qty');
                    $data3['qty2'] = $qty[0]->qty - $this->input->post('qty');
                    $data3['back_date'] = $this->input->post('handover_date')." 00:00:00";
                    $data3['updated_at'] = $this->Models->GetTimestamp();
                    $data3['updated_by'] = $UserID[0]->id;
                    $data3['created_at'] = $this->Models->GetTimestamp();
                    $data3['created_by'] = $DataID[0]->created_by;
    
                   // Penerima email
                   $recipients = [$DataID[0]->email];
                    
                   $subject = "Inventory Request Item Notification";
                   $message = '<div style="margin:0;padding:10px 0;background-color:#ebebeb;font-size:14px;line-height:20px;font-family:Helvetica,sans-serif;width:100%;text-align:center">
                   <div class="adM">
                   <br>
                   </div>
                   <table style="width:600px;margin:0 auto;background-color:#ebebeb" border="0" cellpadding="0" cellspacing="0">
                       <tbody>
                           <tr>
                               <td></td>
                               <td style="background-color:#fff;padding:0 30px;color:#333;vertical-align:top;border:1px solid #cccccc;">
                                   <br>
                                   <div style="text-align: center;">
                                       <img src="https://pcam.podomorouniversity.ac.id/images/ic_.jpg" style="max-width: 250px;">
                                       <hr style="border-top: 1px solid #cccccc;"/>
                                       <div style="font-family:Proxima Nova Semi-bold,Helvetica,sans-serif;font-weight:bold;font-size:24px;line-height:24px;color:#607D8B">Inventory Notification</div>
                                   </div>
                                   <br/>
                                   <div style="font-family:Proxima Nova Reg,Helvetica,sans-serif">
                                       <div style="max-width:600px;margin:30px 0;display:block;font-size:14px;text-align:left!important">  
                                           You are receiving this email because we accept request from '.$DataID[0]->name.' 
                   
                                           Please login to system for approve.
                                       </div>
                                   </div>
                               </td>
                           </tr>
                       </tbody>
                   </table>
                   </div>';
                   
       
                   
                   $mail = new PHPMailer();
                   
                   // SMTP configuration
                   $mail->isSMTP();
                   $mail->Host = 'ssl://smtp.gmail.com';
                   $mail->SMTPAuth = true;
                   $mail->Username = 'ithelpdesk.notif@podomorouniversity.ac.id'; // SMTP username
                   $mail->Password = 'Podomoro2018'; // SMTP password
                   $mail->SMTPSecure = 'ssl';
                   $mail->Port = 465;
                   
                   $mail->setFrom('ithelpdesk.notif@podomorouniversity.ac.id', 'Inventory Podomoro University');
                   $mail->addReplyTo('ithelpdesk.notif@podomorouniversity.ac.id', 'Iventory Podomoro University');
                   $AdminWarehouse = $this->Models->GetWarehouse($this->input->post('id_warehouse'));
                   // Add recipients
               
                   foreach ($recipients as $recipient) {
                       $mail->addAddress($recipient);
                   }
                   
                   // Email subject
                   $mail->Subject = $subject;
                   
                   // Set email format to HTML
                   $mail->isHTML(true);
                   
                   // Email body content
                   $mail->Body = $message;
                   
                   // Send email
                   if (!$mail->send()) {
                   $this->Models->edit('tr_item','id',$this->input->post('id_edit'),$data);
                       $this->Models->edit('m_stock','id',$qty[0]->id,$data2);
                       $this->Models->insert('m_log',$data3);
                       $this->session->set_flashdata('pesan', '<script>alert("Item Berhasil Di Accept, tetapi email gagal dikirim: ' . $mail->ErrorInfo . '")</script>');
                       redirect(base_url('Transaction'));
                   } else {
                       $this->Models->edit('tr_item','id',$this->input->post('id_edit'),$data);
                       $this->Models->edit('m_stock','id',$qty[0]->id,$data2);
                       $this->Models->insert('m_log',$data3);
                       $this->session->set_flashdata('pesan', '<script>alert("Item Berhasil Di Accept dan email berhasil dikirim")</script>');
                       redirect(base_url('Transaction'));
                   }
                   $this->Models->RepairLogItem($this->input->post('id_item'));
                //    $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));  
                   // $last_id = $this->db->insert_id();

                   $log['label'] = "edit";
                   $log['description'] = "User ".$ID[0]->name." Accept Item Named ".$this->Models->getID('tr_item', 'id', $this->input->post('id_edit'));
                   $log['id_affected'] =  $this->input->post('id_edit');
                   $log['table'] = "m_item";
                   $log['created_by'] = $id[0]->id;

                   
                   $this->Models->insert('log_user',$log);
                }
            }else{
                $this->session->set_flashdata('pesan', '<script>alert("Barang Tersebut Belum ada Mohon Tambahkan di Menu Stock")</script>');
                redirect(base_url('Transaction'));
            }
        }
    }
    public function EditStatusRejected($id){
        $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
        $data['status'] = 2;
        $data['updated_by'] = $ID[0]->id;
        $data['updated_at'] = $this->Models->GetTimestamp();
        $result = $this->Models->edit('tr_item','id',$id,$data);
        if($result){
            $this->session->set_flashdata('pesan', '<script>alert("Data berhasil diubah")</script>');
        }else{
            $this->session->set_flashdata('pesan', '<script>alert("Data Gagal diubah")</script>');
        }
        
        redirect(base_url('Transaction'));
    }


    public function EditStatusAcceptAdmin(){
        $this->form_validation->set_rules($this->rulesTransaction());
        if($this->form_validation->run() === false){
            $data['user'] = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
            $data['transaction'] = $this->Models->AllTransaction();
            $data['title'] = 'Transaction';
            $this->load->view('dashboard/header',$data);
            $this->load->view('Transaction/side',$data);
            $this->load->view('Transaction/main',$data);
            $this->load->view('dashboard/footer');  
            $this->session->set_flashdata('pesan', '<script>alert("Data gagal diubah")</script>');
        }else{
            $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));  
            $qty = $this->Models->GetQuantity($this->input->post('id_item'),$this->input->post('id_warehouse'));
            if($qty){
                if($qty[0]->qty < $this->input->post('qty')){
                    $this->session->set_flashdata('pesan', '<script>alert("Stock barang Tidak Cukup")</script>');
                    redirect(base_url('Transaction'));
                }else{
                    $DataID = $this->Models->getID('tr_item','id',$this->input->post('id_edit'));
                    $UserID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama')); 
                    $data['handover_date'] = $this->input->post('handover_date');   
                    $data['status'] = 1;
                    $data['updated_by'] = $ID[0]->id;
                    $data['updated_at'] = $this->Models->GetTimestamp();
                    $this->Models->edit('tr_item','id',$this->input->post('id_edit'),$data);

                    $data2['qty'] = $qty[0]->qty - $this->input->post('qty');
                    $data2['updated_by'] = $ID[0]->id;
                    $data2['updated_at'] = $this->Models->GetTimestamp();
                    $this->Models->edit('m_stock','id',$qty[0]->id,$data2);
                    
                   
                    $data3['id_item'] = $this->input->post('id_item');   
                    $data3['id_warehouse'] = $this->input->post('id_warehouse');   
                    $data3['description'] = 0;
                    $data3['reason'] = $DataID[0]->reason;
                    $data3['qty1'] = $qty[0]->qty;
                    $data3['balance'] = $this->input->post('qty');
                    $data3['qty2'] = $qty[0]->qty - $this->input->post('qty');
                    $data3['back_date'] = $this->input->post('handover_date')." 00:00:00";
                    $data3['updated_at'] = $this->Models->GetTimestamp();
                    $data3['updated_by'] = $UserID[0]->id;
                    $data3['created_at'] = $this->Models->GetTimestamp();
                    $data3['created_by'] = $DataID[0]->created_by;
                    $this->Models->insert('m_log',$data3);
    
                    $this->session->set_flashdata('pesan', '<script>alert("Data berhasil diubah")</script>');
                    redirect(base_url('Transaction'));
                }
            }else{
                $this->session->set_flashdata('pesan', '<script>alert("Barang Tersebut Belum ada Mohon Tambahkan di Menu Stock")</script>');
                redirect(base_url('Transaction'));
            }
            
          
        }
    }
    public function EditStatusRejectedAdmin($id){
        $ID = $this->Models->getID('m_user', 'username', $this->session->userdata('nama'));   
        $data['status'] = 2;
        $data['updated_by'] = $ID[0]->id;
        $data['updated_at'] = $this->Models->GetTimestamp();
        $result = $this->Models->edit('tr_item','id',$id,$data);
        if($result){
            $this->session->set_flashdata('pesan', '<script>alert("Data berhasil diubah")</script>');
        }else{
            $this->session->set_flashdata('pesan', '<script>alert("Data Gagal diubah")</script>');
        }
        
        redirect(base_url('Transaction/trAdminWarehouse'));
    }

    public function userTransaction()
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['transaction'] = $this->Models->AllItem(false);
        $data['warehouse'] = $this->Models->AllWarehouse();
        $data['category'] = $this->Models->getAll('m_category');
        $data['title'] = 'Transaction';
        $this->load->view('dashboard/header',$data);
        $this->load->view('Usertransaction/side',$data);
        $this->load->view('Usertransaction/main',$data);
        $this->load->view('dashboard/footer');
    }
    public function userRequest()
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $roles = $this->Models->RoleWarehouse($data['user'][0]->id);
        $data['transaction'] = $this->Models->TransactionUser($data['user'][0]->id);
        $data['title'] = 'Request';
        $this->load->view('dashboard/header',$data);
        $this->load->view('Requestuser/side',$data);
        $this->load->view('Requestuser/main',$data);
        $this->load->view('dashboard/footer');
    }
    public function userTransactionWarehouse($id_item)
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['transaction'] = $this->Models->ItemWarehouseSearch($id_item); 
        $data['title'] = 'Transaction';
        $this->load->view('dashboard/header',$data);
        $this->load->view('Usertransaction/side',$data);
        $this->load->view('Usertransaction/main2',$data);
        $this->load->view('dashboard/footer');
    }

    public function trAdminWarehouse()
    {
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $roles = $this->Models->RoleWarehouse($data['user'][0]->id);
        $data['transaction'] = $this->Models->Transaction($roles[0]->id_warehouse);
        $data['title'] = 'Transaction';
        $this->load->view('dashboard/header',$data);
        $this->load->view('Tradminwarehouse/side',$data);
        $this->load->view('Tradminwarehouse/main',$data);
        $this->load->view('dashboard/footer');
    }

    public function requestTransaction(){
        $this->form_validation->set_rules($this->rulesTransaction2());
        $ID = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        if(empty($this->input->post())){
            $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
            $data['transaction'] = $this->Models->AllItem();
            $data['warehouse'] = $this->Models->AllWarehouse();
            $data['category'] = $this->Models->getAll('m_category');
            $data['title'] = 'Transaction';
            $this->load->view('dashboard/header',$data);
            $this->load->view('Usertransaction/side',$data);
            $this->load->view('Usertransaction/main',$data);
            $this->load->view('dashboard/footer');
        }else{
            $insert['id_user'] = $ID[0]->id;
            $insert['id_item'] = $this->input->post('id_item');
            $insert['id_warehouse'] = $this->input->post('id_warehouse');
            $insert['name'] = $this->input->post('name');
            $insert['username'] = $this->input->post('username');
            $insert['email'] = $this->input->post('email');
            $insert['department'] = $this->input->post('department');
            $insert['phone_number'] = $this->input->post('phone_number');
            $insert['reason'] = $this->input->post('reason');
            $insert['image'] = "default.jpg";
            $insert['status'] = "0";
            $insert['qty'] = $this->input->post('qty');
            $insert['created_by'] = $ID[0]->id;
            $insert['updated_by'] = $ID[0]->id;
            $this->Models->insert('tr_item',$insert);
            $this->session->set_flashdata('pesan','<script>alert("Data berhasil disimpan")</script>');
            redirect(base_url('Transaction/userTransaction'));
        }
    }

    public function transactionDetail($username)
    {
        // $data['barang'] = $this->Models->getMyProduct($this->session->userdata('nama'));
        $data['user'] = $this->Models->getID('m_user','username',$this->session->userdata('nama'));
        $data['detail'] = $this->Models->AllDetail($username);
        $data['title'] = 'Transaction';
        $this->load->view('dashboard/header',$data);
        $this->load->view('Transaction/side',$data);
        $this->load->view('Transaction/detail',$data);
        $this->load->view('dashboard/footer');
    }

}