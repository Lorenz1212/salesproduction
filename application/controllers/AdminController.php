<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminController extends CI_Controller {
   function __construct(){
       parent::__construct();      
       $this->load->model('Admin_Model');    
    } 
      public function Controller(){
         $action = $this->input->post('data1');
         switch($action){
            case"advisor":{
               $type = $this->input->post('data2');
               $id = $this->input->post('data3');
               $val = $this->input->post('data4');
               $val1 = $this->input->post('data5');
               $model_response = $this->Admin_Model->Advisor($type,$id,$val,$val1,false,false,false,false,false,false,false,false,false,false,false,false,false);
              $data = array(
                'status' => 'success',
                'message' => 'request accepted',
                'payload' => base64_encode(json_encode($model_response))
              );
              echo json_encode($data);
               break;
            }
            case "unit":{
               $type = $this->input->post('data2');
               $id = $this->input->post('data3');
               $val = $this->input->post('data4');
               $model_response = $this->Admin_Model->Unit($type,$id,$val);
                 $data = array(
                   'status' => 'success',
                   'message' => 'request accepted',
                   'payload' => base64_encode(json_encode($model_response))
                 );
              echo json_encode($data);
               break;
            }
            case "validation":{
                $type = $this->input->post('data2');
                $id = $this->input->post('data3');
                $date = $this->input->post('data4');
                $month = $this->input->post('data5');
                $year = $this->input->post('data6');
                $team = $this->input->post('data7');
                $amount = $this->input->post('data8');
                $advisor_code = $this->input->post('data9');
                $status = $this->input->post('data10');
                 $model_response = $this->Admin_Model->Validation($type,$id,false,false,$amount,false,$date,$month,$year,$team,$advisor_code,$status);
                $data = array(
                   'status' => 'success',
                   'message' => 'request accepted',
                   'payload' => base64_encode(json_encode($model_response))
                 );
               echo json_encode($data);
               break;
            }
         }
      }
      public function Action(){
         $action = $this->input->post('action');
         switch($action){
            case"advisor":{
               $type = $this->input->post('type');
               $id = $this->input->post('id');
               $advisor_code=$this->input->post('advisor_code');
               $fname = $this->input->post('fname');
               $lname = $this->input->post('lname');
               $mname = $this->input->post('mname');
               $gender = $this->input->post('gender');
               $position = $this->input->post('position');
               $team = $this->input->post('team');
               $date_coded = date('Y-m-d',strtotime($this->input->post('date_coded')));
               $mobile = $this->input->post('mobile');
               $email = $this->input->post('email');
               $image = ($_FILES["image"]["name"])?$_FILES["image"]["name"]:false;
               $tmp = ($_FILES["image"]["tmp_name"])?$_FILES["image"]["tmp_name"]:false;
               $model_response = $this->Admin_Model->Advisor($type,$id,false,false,$advisor_code,$fname,$lname,$mname,$gender,$mobile,$email,$position,$team,$date_coded,$image,$tmp);
               if($model_response != false){
                 $data = array(
                    'status' => 'success',
                    'message' => 'request accepted',
                    'payload' => base64_encode(json_encode($model_response))
                 );
               }else{
                     $data = array(
                        'status' => 'error',
                        'message' => 'Something went wrong, Please try again later.',
                        'payload' => base64_encode(json_encode($model_response))
                  );
               }
               echo json_encode($data);
               break;
            }
            case "unit":{
                $type = $this->input->post('type');
                $id = $this->input->post('id');
                $name = $this->input->post('name');
                $model_response = $this->Admin_Model->Unit($type,$id,$name);
                if($model_response != false){
                 $data = array(
                    'status' => 'success',
                    'message' => 'request accepted',
                    'payload' => base64_encode(json_encode($model_response))
                 );
               }else{
                     $data = array(
                        'status' => 'error',
                        'message' => 'Something went wrong, Please try again later.',
                        'payload' => base64_encode(json_encode($model_response))
                  );
               }
               echo json_encode($data);
               break;
         }
         case "validation":{
             $type = $this->input->post('type');
             $id = $this->input->post('id');
             $from = $this->input->post('from');
             $to = $this->input->post('to');
             $amount = $this->input->post('amount');
             $generate_id = $this->input->post('generate_id');
             $model_response = $this->Admin_Model->Validation($type,$id,$from,$to,$amount,$generate_id,false,false,false,false,false,false);
             if($model_response != false){
              $data = array(
                 'status' => 'success',
                 'message' => 'request accepted',
                 'payload' => base64_encode(json_encode($model_response))
              );
            }else{
                  $data = array(
                     'status' => 'error',
                     'message' => 'Something went wrong, Please try again later.',
                     'payload' => base64_encode(json_encode($model_response))
               );
            }
            echo json_encode($data);
            break;
         }
      }
   }
}
