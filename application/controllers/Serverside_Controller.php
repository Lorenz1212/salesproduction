<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Serverside_Controller extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Serverside_model');
    }
    public function Serverside_Advisor(){
        error_reporting(0);
        $table = 'tbl_advisor';
        $column_where = false;
        $column_order = array(null, 'advisor_code','fname','lname','position','status');
        $column_search = array('advisor_code','fname','lname','position','status');
        $order = array('id' => 'asc');
        $data = $row = array();
        $memData = $this->Serverside_model->getRows($_POST,$table,$column_order,$column_search,$order,$column_where);
        $i = $_POST['start'];
        foreach($memData as $row){
            $i++;
            $data[] = array($i, 
                $row->advisor_code,
                $row->fname.' '.$row->mname.' '.$row->lname, 
                $row->position,
                $row->status,
                $this->encryption->encrypt($row->id));
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside_model->countAll($table,$column_where),
            "recordsFiltered" => $this->Serverside_model->countFiltered($_POST,$table,$column_order,$column_search,$order,$column_where),
            "data" => $data,
        );
        echo json_encode($output);
    }
     public function Serverside_Unit(){
        error_reporting(0);
        $table = 'tbl_team';
        $column_where = false;
        $column_order = array(null, 'name');
        $column_search = array('name');
        $order = array('id' => 'asc');
        $data = $row = array();
        $memData = $this->Serverside_model->getRows($_POST,$table,$column_order,$column_search,$order,$column_where);
        $i = $_POST['start'];
        foreach($memData as $row){
            $i++;
            $data[] = array($i, 
                $row->name,
                $this->encryption->encrypt($row->id));
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside_model->countAll($table,$column_where),
            "recordsFiltered" => $this->Serverside_model->countFiltered($_POST,$table,$column_order,$column_search,$order,$column_where),
            "data" => $data,
        );
        echo json_encode($output);
    }
     public function Serverside_Validation_Date(){
        error_reporting(0);
        $table = 'tbl_generate_date';
        $column_where = 'type=1';
        $column_order = array(null, 'date_from','date_to');
        $column_search = array('date_from','date_to');
        $order = array('id' => 'asc');
        $data = $row = array();
        $memData = $this->Serverside_model->getRows($_POST,$table,$column_order,$column_search,$order,$column_where);
        $i = $_POST['start'];
        foreach($memData as $row){
            $i++;
            $data[] = array($i, 
                date('F d, Y',strtotime($row->date_from)),
                date('F d, Y',strtotime($row->date_to)),
                $this->encryption->encrypt($row->id));
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Serverside_model->countAll($table,$column_where),
            "recordsFiltered" => $this->Serverside_model->countFiltered($_POST,$table,$column_order,$column_search,$order,$column_where),
            "data" => $data,
        );
        echo json_encode($output);
    }
 
}