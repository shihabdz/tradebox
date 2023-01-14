<?php namespace App\Modules\User\Controllers\Admin;

class UserController extends BaseController
{
    
    public function index(){


        $page_number      = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
        $data['deposit']  = $this->common_model->get_all('dbt_deposit', array(), 'id','desc',20,($page_number-1)*20);
        $total            = $this->common_model->countRow('dbt_deposit');
        $data['pager']    = $this->pager->makeLinks($page_number, 20, $total);

        $data['content'] = $this->BASE_VIEW . '\user\list';
        return $this->template->admin_layout($data);
    }

    public function ajax_list(){
        $list = $this->user_model->get_datatables();
    
        $data = array();
        $no = $this->request->getvar('start');

        foreach ($list as $users) {


            if($users->verified == 1 || $users->verified == 6 || $users->verified == 8 || $users->verified == 9 || $users->verified == 10 || $users->verified == 12 || $users->verified == 13){

                $emailVerify = '<button class="btn btn-success btn-sm" title='.display('verified').'"> <span> <i class="fas fa-check-square"></i></span>'.display('verified').'</button>';

            } else {

                $emailVerify = '<button verify-type="email" data-id = "'.$users->id.'" data-message="'.display('are_you_sure').'" class="btn btn-danger btn-sm manualVerify" data-toggle="tooltip" data-placement="left" title="'.display('verify_manually').'">'.display('verify_manually').'</button>';
            }

            if($users->verified == 1 || $users->verified == 5 || $users->verified == 7 || $users->verified == 9 || $users->verified == 10 || $users->verified == 12 || $users->verified == 14 || $users->verified == 15){

                $mobileVerify = '<button class="btn btn-success btn-sm" title='.display('verified').'"> <span> <i class="fas fa-check-square"></i></span>'.display('verified').'</button>';

            } else {

                $mobileVerify = '<button verify-type="mobile" data-id = "'.$users->id.'" data-message="'.display('are_you_sure').'" class="btn btn-danger btn-sm manualVerify" data-toggle="tooltip" data-placement="left" title="'.display('verify_manually').'">'.display('verify_manually').'</button>';
            }

            if($users->verified == 4 || $users->verified == 7 || $users->verified == 8 || $users->verified == 1){

                $kycVerify = '<button class="btn btn-success btn-sm" title='.display('verified').'"> <span> <i class="fas fa-check-square"></i></span>'.display('verified').'</button>';

            } else {

                $kycVerify = '<button verify-type="kyc" data-id = "'.$users->id.'" data-message="'.display('are_you_sure').'" class="btn btn-danger btn-sm manualVerify" data-toggle="tooltip" data-placement="left" title="'.display('verify_manually').'">'.display('verify_manually').'</button>';
            }

          $no++;
          $row = array();
            $row[] = $no;
            $row[] = '<a href="'.base_url("backend/user/user-details/$users->id").'">'.$users->user_id.'</a>';
            $row[] = '<a href="'.base_url("backend/user/user-details/$users->id").'">'.$users->first_name." ".$users->last_name.'</a>';
            $row[] = '<a href="'.base_url("backend/user/user-details/$users->id").'">'.$users->referral_id.'</a>';
            $row[] = $users->email;
            $row[] = $users->phone;
            $row[] = (($users->status==1)?'<a class="btn btn-success btn-sm">'.display('active').'</a>':(($users->status==2)?'<a class="btn btn-danger btn-sm">'.display('pending').'</a>':(($users->status==3)?'<a class="btn btn-danger btn-sm">Suspend</a>':'<a class="btn btn-warning btn-sm">Deactive</a>'))).'  '.(($users->verified==1)?'<a class="btn btn-success btn-sm">'.display('verified').'</a>':(($users->verified==2)?'<a class="btn btn-danger btn-sm">'.display('cancel').'</a>':(($users->verified==3)?'<a href='.base_url("backend/user/pending-user-verification/$users->user_id").' class="btn btn-info btn-sm" data-toggle="tooltip">'.display('requested').'</a>':'<a class="btn btn-danger btn-sm">'.display('not').' '.display('verified').'</a>')));
            $row[] = $emailVerify;
            $row[] = $mobileVerify;
            $row[] = $kycVerify;
            $row[] = '<a href="'.base_url("backend/user/edit-user/$users->id").'"'.' class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="'.display('edit').'"><i class="hvr-buzz-out far fa-edit"></i></a><a data-id = "'.$users->id.'" data-url = "'.base_url("backend/user/delete-user/$users->id").'" href="#"'.' data-message="'.display('are_you_sure').'" class="btn btn-danger btn-sm actionDelete" data-toggle="tooltip" data-placement="left" title="'.display('delete').'"><i class="hvr-buzz-out far fa-window-close"></i></a>'.(($users->verified==3)?'<a href='.base_url("backend/user/pending-user-verification/$users->user_id").' class="btn btn-info btn-sm" data-toggle="tooltip">'.display('requested').'</a>':'');
            $data[] = $row;
        }

        $output = array(
            "draw"            => intval($this->request->getvar('draw')),
            "recordsTotal"    => $this->common_model->countRow('dbt_user', array()),
            "recordsFiltered" => $this->user_model->count_filtered(),
            "data"            => $data,
          );
        //output to json format
        echo json_encode($output);
    }

    public function manaual_verify(){

        $id          = $this->request->getPost('id', FILTER_SANITIZE_STRING);
        $verify_type = $this->request->getPost('verify_type', FILTER_SANITIZE_STRING);

        $userInfo = $this->common_model->findById('dbt_user', array('id' => $id));

        $verified = 0;

        if($verify_type == "email"){

            if($userInfo->verified == 0 ) {
                $verified = 6;
            } else if($userInfo->verified == 2 ) {
                $verified = 11;
            } else if($userInfo->verified == 3 ) {
                $verified = 13;
            } else if($userInfo->verified == 4 ) {
                $verified = 8;
            } else if($userInfo->verified == 5 ) {
                $verified = 9;
            } else if($userInfo->verified == 7 ) {
                $verified = 1;
            } else if($userInfo->verified == 14 ) {
                $verified = 12;
            } else if($userInfo->verified == 15 ) {
                $verified = 10;
            } 

        } else if($verify_type == "mobile"){

            if($userInfo->verified == 0 ) {
                $verified = 5;
            } else if($userInfo->verified == 2 ) {
                $verified = 15;
            } else if($userInfo->verified == 3 ) {
                $verified = 14;
            } else if($userInfo->verified == 4 ) {
                $verified = 7;
            } else if($userInfo->verified == 6 ) {
                $verified = 9;
            } else if($userInfo->verified == 8 ) {
                $verified = 1;
            } else if($userInfo->verified == 11 ) {
                $verified = 10;
            } else if($userInfo->verified == 13 ) {
                $verified = 12;
            } 

        } else if($verify_type == "kyc"){

            if($userInfo->verified == 0){
                $verified = 4;
            }else if($userInfo->verified == 3 ) {
                $verified = 4;
            } else if($userInfo->verified == 13 || $userInfo->verified == 6) {
                $verified = 8;
            } else if($userInfo->verified == 12 ) {
                $verified = 1;
            } else if($userInfo->verified == 14 || $userInfo->verified == 5) {
                $verified = 7;
            } else if($userInfo->verified == 9){

                $verified = 1;
            }
        }

        $updateData = array('verified' => $verified);

        $restult = $this->common_model->update('dbt_user', $updateData, array('id' => $id));

        if($restult){

            echo json_encode(array('status' => 'success', 'msg' => 'Your Verification successfully done'));
        } else {

            echo json_encode(array('status' => 'fail', 'msg' => 'Something went wrong, please try again.'));
        }
        
    }

    public function pending_user_verification_list(){

        $page_number      = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
        $data['users']    = $this->common_model->get_all('dbt_user', array('verified' => 3), 'id','asc',20,($page_number-1)*20);
        $total            = $this->common_model->countRow('dbt_user', array('verified' => 3));
        $data['pager']    = $this->pager->makeLinks($page_number, 20, $total);

        $data['content'] = $this->BASE_VIEW . '\user\pending_user_verification_list';
        return $this->template->admin_layout($data);
    }

    public function subscriber_list(){

        $page_number        = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
        $data['subscriber'] = $this->common_model->get_all('web_subscriber', array(), '','',20,($page_number-1)*20);
        $total              = $this->common_model->countRow('web_subscriber');
        $data['pager']      = $this->pager->makeLinks($page_number, 20, $total);

        $data['content'] = $this->BASE_VIEW . '\user\subscribelist';
        return $this->template->admin_layout($data);
    }

    public function pending_user_verification($user_id = null)
    {
        $data['title']  = "Pending User verify";
        $data['user']   = $this->user_model->singleUserVerifyDoc($user_id);

        $rules = array('user_id' =>'required|trim',);

        if ($this->validate($rules, $rules)) 
        {

            if (isset($_POST['cancel'])) {
                
                $c_data = (object)$cdata = array('verified' => 2);
                $update_verify = $this->common_model->update('dbt_user', $c_data, array('user_id' => $this->request->getPost('user_id')));

                if ($update_verify) {

                    $this->session->setFlashdata('message', display('save_successfully'));
                    return  redirect()->to(base_url('/backend/user/pending-user-verification/'.$user_id));

                } else {

                    $this->session->setFlashdata('exception', display('please_try_again'));
                    return  redirect()->to(base_url('/backend/user/pending-user-verification/'.$user_id));

                }
            }

            if (isset($_POST['approve'])) {
                
                $c_data = (object)$cdata = array('verified' => 1);
                $update_verify = $this->common_model->update('dbt_user', $c_data, array('user_id' => $this->request->getPost('user_id')));

                if ($update_verify) {

                    $this->session->setFlashdata('message', display('save_successfully'));
                    return  redirect()->to(base_url('/backend/user/pending-user-verification/'.$user_id));

                } else {

                    $this->session->setFlashdata('exception', display('please_try_again'));
                    return  redirect()->to(base_url('/backend/user/pending-user-verification/'.$user_id));

                }
            }
        }

        $data['content'] = $this->BASE_VIEW . '\user\pending_user_verification';
        return $this->template->admin_layout($data);
    }

    public function form($id = null)
    { 

        $this->validation->setRule('first_name', display('firstname'),'required|max_length[50]');        

        if (!empty($id)) {   
            $this->validation->setRule('email', display('email'), "required|valid_email|max_length[100]|trim"); 
            $this->validation->setRule('mobile', display('mobile'),"required|max_length[100]");
        } else {
            $this->validation->setRule('email', display('email'),'required|valid_email|is_unique[dbt_user.email]|max_length[100]');
            $this->validation->setRule('mobile', display('mobile'),'required|is_unique[dbt_user.phone]|max_length[100]');
        }
        $this->validation->setRule('status', display('status'),'required|max_length[1]');

        $existingData = $this->common_model->findById('dbt_user', array('id' => $id));

        $dlanguage = $this->common_model->findById('setting', array());

        if(!empty($this->request->getPost('password',FILTER_SANITIZE_STRING))){
            $this->validation->setRule('password', display('password'),'required|min_length[6]|max_length[32]|md5');
            $this->validation->setRule('conf_password', display('conf_password'),'required|min_length[6]|max_length[32]|md5|matches[password]');
            $newpassword = md5($this->request->getPost('password',FILTER_SANITIZE_STRING));
        } else if(empty($existingData)){
            $this->validation->setRule('password', display('password'),'required|min_length[6]|max_length[32]|md5');
            $this->validation->setRule('conf_password', display('conf_password'),'required|min_length[6]|max_length[32]|md5|matches[password]');
            $newpassword = md5($this->request->getPost('password',FILTER_SANITIZE_STRING));
        } else {
            $newpassword = $existingData->password;
        }

        if (empty($id))
        { 
            $data['user'] = (object)$userdata = array(
                'id'          => $this->request->getPost('id', FILTER_SANITIZE_STRING),
                'user_id'     => $this->randomID(),
                'referral_id' => $this->request->getPost('referral_id', FILTER_SANITIZE_STRING),
                'language'    => @$dlanguage->language,
                'first_name'  => $this->request->getPost('first_name', FILTER_SANITIZE_STRING),
                'last_name'   => $this->request->getPost('last_name', FILTER_SANITIZE_STRING),
                'email'       => $this->request->getPost('email', FILTER_SANITIZE_STRING),
                'password'    => $newpassword,
                'phone'       => $this->request->getPost('mobile', FILTER_SANITIZE_STRING),
                'ip'          => $this->request->getipAddress(),
                'status'      => $this->request->getPost('status', FILTER_SANITIZE_STRING),
                'created_date'=> date("Y-m-d H:i:s"),
            );
        } else {
            $data['user'] = (object)$userdata = array(
                'id'          => $this->request->getPost('id', FILTER_SANITIZE_STRING),
                'user_id'     => $this->request->getPost('user_id', FILTER_SANITIZE_STRING),
                'first_name'  => $this->request->getPost('first_name', FILTER_SANITIZE_STRING),
                'last_name'   => $this->request->getPost('last_name', FILTER_SANITIZE_STRING),
                'email'       => $this->request->getPost('email', FILTER_SANITIZE_STRING),
                'language'    => @$dlanguage->language,
                'password'    => $newpassword,
                'phone'       => $this->request->getPost('mobile', FILTER_SANITIZE_STRING),
                'ip'          => $this->request->getipAddress(),
                'status'      => $this->request->getPost('status', FILTER_SANITIZE_STRING),
            );
        }

        if($this->request->getMethod() == 'post'){

            $existemail = $this->email_check($this->request->getPost('email'), $id);
            $existphone = $this->phone_check($this->request->getPost('mobile'), $id);

            if($existemail == 0){
                $this->session->setFlashdata('exception',"This Email Already Registered, Please Use Another E-mail!");
                return redirect()->route('backend/user/user-list');
            }

            if($existphone == 0){
                $this->session->setFlashdata('exception',"This Mobile Number Already Registered, Please Use Another Mobile Number!");
                return redirect()->route('backend/user/user-list');
            }

            if ($this->validation->withRequest($this->request)->run()) 
            {

                if (empty($id)) 
                {
                    if ($this->common_model->save('dbt_user', $userdata)) {
                        $this->session->setFlashdata('message', display('save_successfully'));
                    } else {
                        $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                    return redirect()->route('backend/user/user-list');
                } else {
                    if ($this->common_model->update('dbt_user',$userdata, array('id' => $id))) {
                        $this->session->setFlashdata('message', display('update_successfully'));
                    } else {
                        $this->session->setFlashdata('exception', display('please_try_again'));
                    }
                    return redirect()->route('backend/user/user-list');
                }

            } else { 
                $this->session->setFlashdata("exception", $this->validation->listErrors());

                if(!empty($id)){

                    return redirect()->to(base_url('backend/user/edit-user/'.$id));

                } else {

                    return redirect()->route('backend/user/user-list');
                }
               
            }
        } else {

            if(!empty($id)) {
                $data['title'] = display('edit_user');
                $data['user']   = $this->common_model->findById('dbt_user', array('id' => $id));
            }

            $data['module'] = "User";
            $data['content'] = $this->BASE_VIEW . '\user\form';
            return $this->template->admin_layout($data);
        }
    }



    public function email_check($email, $id)
    { 
      
        $emailExists = $this->common_model->findById('dbt_user', array('email'=>$email, 'id !=' => $id));
        if (!empty($emailExists)) {
            return false;
        } else {
            return true;
        }
    }

    public function phone_check($phone, $id)
    { 
      
        $phoneExist = $this->common_model->findById('dbt_user', array('phone'=>$phone, 'id !=' => $id));
        if (!empty($phoneExist)) {
            return false;
        } else {
            return true;
        }
    }

    public function user_details($id = null)
    { 
      
        if(!empty($id)) {
            $data['user']    = $this->common_model->findById('dbt_user',array('id' => $id));
            $data['balance'] = $this->user_model->checkUserAllBalance($data['user']->user_id);

            $data['user_trade_history'] = $this->user_model->userTradeHistory($data['user']->user_id);
            $data['user_balanceLog']    = $this->user_model->userBalanceLog($data['user']->user_id);
        } else {
            $user_id = $this->request->getPost('user_id');

            $data['user']            = $this->common_model->findById('dbt_user', array('user_id' => $user_id));
            $data['balance']         = $this->user_model->checkUserAllBalance($user_id);
            $data['user_balanceLog'] = $this->user_model->userBalanceLog($user_id);
        }

        $data['module'] = "User";
        $data['content'] = $this->BASE_VIEW . '\user\search_user';
        return $this->template->admin_layout($data);
    }
    public function delete_user($id = null)
    { 
      
        if(!empty($id)) {
           
            $userdelet    = $this->common_model->delete('dbt_user',array('id' => $id));
            if($userdelet ) {
                $data['success'] = true;
                $data['message'] = "You have successsfully deleted this user!";

            } else {
                $data['success'] = false;
                $data['message'] = "Failed to delete user. Please try again!";
            }
             echo json_encode($data);            
        } 
    }


    function ajax_tradelist()
    {
        $uri = current_url(true);
        $segemt = $uri->getSegments();
        $user_id = $this->request->uri->setSilent()->getSegment(4);

        $total_rows = $this->db->table('dbt_biding bidmaster')
            ->select('bidmaster.*, biddetail.bid_type as bid_type1, biddetail.bid_price as bid_price1, biddetail.market_symbol as market_symbol1, biddetail.complete_amount as complete_amount1, biddetail.success_time as success_time1, biddetail.complete_qty, biddetail.complete_amount, biddetail.success_time')
            ->join('dbt_biding_log biddetail', 'biddetail.bid_id = bidmaster.id', 'left')
            ->where('bidmaster.user_id', $user_id)
            ->get()
            ->getResult();

        $page_number      = (!empty($this->request->getGet('page'))?$this->request->getGet('page'):1);
        $total            = count($total_rows);
        $data['pager']    = $this->pager->makeLinks($page_number, 50, $total);

        $output = array(
            'pagination_link' => $data['pager'],
            'country_table'   => $this->user_model->ajax_trade_fetch_details(100, ($page_number-1), $user_id)
        );
        echo json_encode($output);
    }


    /*
    |----------------------------------------------
    |        id genaretor
    |----------------------------------------------     
    */
    public function randomID($mode = 2, $len = 6)
    {
        $result = "";
        if($mode == 1):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 2):
            $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        elseif($mode == 3):
            $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        elseif($mode == 4):
            $chars = "0123456789";
        endif;

        $charArray = str_split($chars);
        for($i = 0; $i < $len; $i++) {
                $randItem = array_rand($charArray);
                $result .="".$charArray[$randItem];
        }
        return $result;
    }
}
