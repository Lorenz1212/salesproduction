<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class SpreadSheet_model extends CI_Model {
    function __construct() {
       $this->admin_id = $this->session->userdata('TREE_ADMIN_ID');
    }
    function validation($type,$date,$month,$year,$file,$tmp,$advisor_code,$team,$name,$submitted,$settled,$ac,$nsc){
        switch($type){
            case "import_validation":{
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($tmp);
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $row = $this->db->select('*')->from('tbl_generate_date')->where('id',$date)->get()->row();
                $data[] = array('id'=>$row->id,'from'=>date('F d, Y',strtotime($row->date_from)),
                    'to'=>date('F d, Y',strtotime($row->date_to)),
                    'month'=>$month,
                    'monthname'=>date('F',strtotime($month)),
                    'year'=>date('Y',strtotime($year)));
                $reader->setReadDataOnly(TRUE);
                $spreadsheet = $reader->load($tmp);
                $row = $spreadsheet->getActiveSheet()->toArray();
                $total_submitted=0;
                $total_settled=0;
                $total_ac=0;
                $total_nsc=0;
                for ($i=2; $i<count($row); $i++) {
                    ($row[$i][3] != null)?$submitted = $row[$i][3]:$submitted = 0;
                    ($row[$i][4] != null)?$settled = $row[$i][4]:$settled = 0;
                    ($row[$i][5] != null)?$ac = $row[$i][5]:$ac = 0;
                    ($row[$i][6] != null)?$nsc = $row[$i][6]:$nsc = 0;
                    $data[] = array('team'=>$row[$i][0],
                                    'advisor_code'=> str_replace(' ', '', $row[$i][1]),
                                    'name' => $row[$i][2],
                                    'submitted' =>$submitted,
                                    'settled'=>$settled,
                                    'ac'=>$ac,
                                    'nsc'=>$nsc);
                }
                return $data;
                break;
            }
            case "create_validation":{
                
                break;
            }

        }
    }
}
?>