<?php 
class Authentication_Model extends CI_Model {
    private function setCookies($token, $data, $days){
        $auth = array('name' =>'sunlife_admin_auth','value'=> $token,'expire' => time() + (86400 * $days),'secure' => FALSE);
        $this->input->set_cookie($auth);
        $user = array('name' => 'sunlife_admin_user','value'=> $this->encryption->encrypt($data),'expire' => time() + (86400 * $days),'secure' => FALSE);
        $this->input->set_cookie($user);
    }
    private function User_Data($type){
        return $this->input->cookie('ADMIN_'.$type,true);
    }
     private function TODAY(){
       date_default_timezone_set('Asia/Manila');
       $datestamp = date("Y-m-d");
       $timestamp = date("H:i:s");
       return $now = $datestamp.' '.$timestamp;
    }
    private function _set_data($result){
        $data = array(
          'TREE_ADMIN_ID'=>$result->id,
          'TREE_ADMIN_FNAME'=>$result->fname, 
          'TREE_ADMIN_LNAME'=> $result->lname, 
          'TREE_ADMIN_UNAME'=>$result->username, 
          'TREE_ADMIN_EMAIL'=>$result->email, 
          'TREE_ADMIN_PROFILE' =>$result->profile_img, 
          'TREE_ADMIN_AdSTATUS'=>md5("active"), 
          'TREE_ADMIN_TYPE'=>md5('admin'),
          'TREE_ADMIN_COUNTRY'=>$result->country,
          'TREE_ADMIN_ROLE'=>$result->role_name,  
          'TREE_ADMIN_ROLE_ID'=>$result->role  
        );
        $this->session->set_userdata($data);
        return $data;
      }
     function Login_User($email,$password,$remember){  
            error_reporting(0);  
            $remember = ($remember) ? 30 : 1;
            //GET first 9 digit of NEW IP ADDRESS
            $ip_address_main=$this->input->ip_address();
            $arr = explode(".",$ip_address_main);
            unset($arr[3]);
            $ip_address = implode(".",$arr);

            $data_response = array();
            $admin = $this->db->select('*')->from('tbl_administrator')->where('password="'.md5($password).'" AND (email="'.$email.'" OR username="'.$email.'")')->get()->row();
            if(!$admin){
              return 'Login failed! wrong username/password.';
            }else{
              if($admin->status=='0'){
                return 'Sorry, your account is deactivated. You cannot sign-in right now.';
              }else if($admin->status=='2'){
                return 'Sorry, your account is temporary on-hold. Please try again later.';
              }
              $email=$admin->email;
              $token="";
              $data = array();
              //GET first 9 digit of OLD IP ADDRESS
              $arr = explode(".",$admin->ipadd_prev);
              unset($arr[3]);
              $ip_address_prev = implode(".",$arr);

              //CHECK IF IP ADDRESS WAS CHANGE
              if($ip_address_prev == $ip_address || $row->ipadd_prev === null){
                $this->db->where('email',$email);
                $this->db->update('tbl_administrator',array('ipadd_prev'=>$ip_address_main));
                $token = md5($admin->username.''.$this->TODAY().''.$ip_address_main);
                $device = "setupbrowsecap";
                $admin_id=$admin->id;
                $data = $this->_set_data($admin);
                $result = $this->db->query("INSERT INTO tbl_administrator_login_details (admin_id, expiration, device, ip_add, token, token_status, role) VALUES ('".$admin->id."', DATE_ADD(NOW(), INTERVAL ".$remember." DAY), '$device', '$ip_address_main', '$token', '1','".$admin->role."') ON DUPLICATE KEY UPDATE login_date= VALUES(login_date), expiration= VALUES(expiration), device= VALUES(device), ip_add= VALUES(ip_add), token= VALUES(token), token_status= VALUES(token_status), role= VALUES(role)");
                if($result){
                  $this->session->set_userdata('user_days_to_remember',$remember);
                  $this->session->set_userdata('view','dashboard');
                  $this->setCookies($token, $data, $remember);
                  $data_response=array('url'=>'view/adminview/dashboard');
                  return $data_response;
                }else{
                   return 'Opsss, Something went wrong, Please try again later.';
                }
              }else{
                $pin = random_int(100000, 999999);
                $this->db->query("UPDATE tbl_administrator SET ipadd_pin='$pin', expiry= DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email='".$email."'");
                 return 'ip_check';
              }
            }
          }
       public function Login_Ipcheck($pin,$email,$remember){
            $remember = ($remember) ? 30 : 1;
            //GET first 9 digit of NEW IP ADDRESS
            $ip_address_main=$this->input->ip_address();
            $data=array();
            $sql= $this->db->query("SELECT a.*,r.role_name FROM tbl_administrator a RIGHT JOIN tbl_administrator_role r ON r.id=a.role WHERE (a.email='$email' OR a.username ='$email')");
            $admin=$sql->row();
            if(!$admin){
              return 'Sorry, looks like there are some errors detected, please try again.';
            }else{
              if($admin->status=='0'){
                return 'Sorry, your account is deactivated. You cannot sign-in right now.';
              }else if($admin->status=='2'){
                return 'Sorry, your account is temporary on-hold. Please try again later.';
              }
              $email=$admin->email;
              if($admin->expiry < $this->TODAY()){
                return 'Verification failed! Your code has been expired.';   
              }else{
                if($admin['ipadd_pin'] != $pin){
                  return 'Verification failed! Your code is incorrect.'; 
                }else{
                  $sql= $this->db->query("UPDATE tbl_administrator SET ipadd_prev='$ip_address_main' WHERE email='$email'")->get();
                  $result=$sql->row();
                  if(!$result){
                    return 'Sorry, looks like there are some errors detected, please try again.';   
                  }else{
                    $token = md5($admin->username.''.$this->TODAY().''.$ip_address_main);
                    $device = "setupbrowsecap";
                    $data = $this->_set_data($admin);
                    $sql = $this->db->query("INSERT INTO tbl_administrator_login_details (admin_id, expiration, device, ip_add, token, token_status, role) VALUES ('".$admin->id."', DATE_ADD(NOW(), INTERVAL ".$remember." DAY), '$device', '$ip_address_main', '$token', '1','".$admin->role."') ON DUPLICATE KEY UPDATE login_date= VALUES(login_date), expiration= VALUES(expiration), device= VALUES(device), ip_add= VALUES(ip_add), token= VALUES(token), token_status= VALUES(token_status), role= VALUES(role)");
                    if($sql){
                      $this->setCookies($token, $data, $remember);
                      $data_response=array('url'=>'dashboard');
                      return $data_response;
                    }else{
                      return 'Opsss, Something went wrong, Please try again later.';
                    }
                  }
                }
              }
            } 
          }    
}
?>