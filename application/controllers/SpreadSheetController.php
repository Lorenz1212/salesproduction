<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
class SpreadSheetController extends CI_Controller {
    function __construct(){
       parent::__construct();
       $this->xlsx = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
       $this->csv = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
       $this->spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();  
       $this->load->model('spreadSheet_model'); 
       $this->load->helper('download');  
    }
    public function AdminAction(){
      $action = $this->input->post('action');
      switch($action){
         case "validation":{
            $type = $this->input->post('type');
            $date = $this->input->post('date_target');
            $month = $this->input->post('month_target');
            $year = $this->input->post('year_target');
            $team = $this->input->post('team');
            $advisor_code = $this->input->post('advisor_code');
            $name = $this->input->post('name');
            $submitted = $this->input->post('submitted');
            $settled = $this->input->post('settled');
            $ac = $this->input->post('ac');
            $nsc = $this->input->post('nsc');
            $file = (isset($_FILES["file"]["name"]))?$_FILES["file"]["name"]:false;
            $tmp = (isset($_FILES["file"]["tmp_name"]))?$_FILES["file"]["tmp_name"]:false;
            $model_response = $this->spreadSheet_model->validation($type,$date,$month,$year,$file,$tmp,$advisor_code,$team,$name,$submitted,$settled,$ac,$nsc);
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
      public function DownloadTemplate(){
             $spreadsheet = $this->spreadsheet;
             $sheet = $spreadsheet->getActiveSheet();
             $sheet->setCellValue('A1', 'Team');
             $sheet->setCellValue('B1', 'Code');
             $sheet->setCellValue('C1', 'Name');
             $sheet->setCellValue('D1', 'Submitted');
             $sheet->setCellValue('E1', 'Settled');
             $sheet->setCellValue('F1', 'AC');
             $sheet->setCellValue('G1', 'NSC');
             $sql = $this->db->select('*')->from('tbl_advisor as a')->join('tbl_team as t','a.team=t.id','LEFT')->get();
             $count = 2;
             foreach($sql->result() as $row){
                 $sheet->setCellValue('A' .$count, $row->name);
                 $sheet->setCellValue('B' .$count, $row->advisor_code);
                 $sheet->setCellValue('C' .$count, $row->fname.' '.$row->mname.' '.$row->lname);
                 $count++;
            }
            $file_name = 'template.xls';
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\xls($spreadsheet);
            $writer->save($file_name);
            header("Content-Type: application/vnd.ms-excel");
            header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length:' . filesize($file_name));
            flush();
            readfile($file_name);
            exit;
      }
}
?>