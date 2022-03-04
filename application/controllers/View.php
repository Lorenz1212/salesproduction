<?php defined('BASEPATH') OR exit('No direct script access allowed');
class View extends CI_Controller {
    function __construct(){
       parent::__construct();
    }
    public function AdminView($view=null){
        if($this->session->userdata('view')){
             $this->load->view('admin/content');
             switch ($view){
                  case 'dashboard':{$this->session->set_userdata('view',$view);break;}
                  case 'advisor':{$this->session->set_userdata('view',$view);break;}
                  case 'unit':{$this->session->set_userdata('view',$view);break;} 
                  case 'validation':{$this->session->set_userdata('view',$view);break;} 
                  case 'medallion':{$this->session->set_userdata('view',$view);break;}
                  case 'macaulay':{$this->session->set_userdata('view',$view);break;}  
                  default: {redirect(base_url().'view/adminview/dashboard');break;} 
             }
        }else{;
             redirect(base_url().'authentication/adminlogin');
        }
    }
   public function page(){
        if($this->input->post('page')){
               $this->load->view('admin/view/'.$this->input->post('page'));;
        }
    }
}
?>