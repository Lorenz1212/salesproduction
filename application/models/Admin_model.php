<?php 
class Admin_Model extends CI_Model {
    function __construct() {
        $this->admin_id = $this->session->userdata('TREE_ADMIN_ID');
    }
    private function move_to_folder($image,$tmp,$path,$table,$column,$name,$size){
         $newimage=$this->Get_Image_Code($table, $column, $name, $size, $image);
         $path_folder = $path.$newimage;
         copy($tmp, $path_folder);
         return $newimage;
    }
    private function move_to_folder_resize($image,$tmp,$path,$targetWidth,$targetHeight,$table,$column,$name,$size){
      $newimage=$this->Get_Image_Code($table, $column, $name, $size, $image);
      $extension=pathinfo($image, PATHINFO_EXTENSION);
      $path_folder = $path.$newimage;
      list($width, $height) = getimagesize($tmp);
      $file = $this->imageType($extension,$path_folder,$tmp,$targetWidth,$targetHeight,$width,$height);
        if($file == true){
          return $newimage;
        }else{
          return false;
        }
    }
    private function imageType($extension,$path_folder,$tmp,$targetWidth,$targetHeight,$width,$height){
       if($extension=='png' || $extension=='PNG'){
               $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
               $imageResourceId = imagecreatefrompng($tmp); 
               if(!imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight,$width,$height)){
                   return false;
             }else{
                  imagepng($targetLayer,$path_folder);
                return true;
             }
       }else if($extension=='jpg'  || $extension=='jpeg' || $extension=='JPG' || $extension=='JPEG'){
                $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
                $imageResourceId = imagecreatefromjpeg($tmp); 
                if(!imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight,$width,$height)){
                   return false;
             }else{
                  imagejpeg($targetLayer,$path_folder);
                return true;
             }
       }
    }
    private function Ac_Code($key, $length){ 
      $random="";srand((double)microtime()*1000000);
      $data = "ABCDEFGHJKLMNPQRSTUVWXYZ"; 
      $data .= "123456789"; 
      $data .= "54321ABCXVXV6789";
      for($i = 0; $i < $length; $i++) {

        $random .= substr($data, (rand()%(strlen($data))), 1);
      }
      return $key.$random; 
    }
   private function Get_Image_Code($table, $column, $key, $length, $image){
      $code = $this->Ac_Code($key, $length);
      if($code){
        $arr_image = explode('.', $image);
        $fileActualExt = strtolower(end($arr_image));
        $newimage = $code."-".str_replace(array( '-', '_', ' ', ',' , '(', ')'), '', $arr_image[0]).".". $fileActualExt;
        $check = $this->Check_Code($table, $column, $newimage);
        while ($check){
          $code = $profile_trans->get_code();
          if($code){
            $arr_image = explode('.', $image);
            $fileActualExt = strtolower(end($arr_image));
            $newimage = $code."-".str_replace(array( '-', '_', ' ', ',' , '(', ')'), '', $arr_image[0]).".". $fileActualExt;
            $check = $this->Check_Code($table, $column, $newimage);
          }else{
            return false;
          }
        }
      }else{
        return false;
      }
      return $newimage;
  }
  private function Get_CODE($table, $column, $key, $length){
       $gen_code = new TransGen($key, $length);
         $code = $gen_code->get_code();
         if($code){
             $check = $this->Check_Code($table, $column, $code);
              while ($check){
            $code = $gen_code->get_code();
            if($code){
              $check = $this->Check_Code($table, $column, $code);
            }else{
                  return false;
            }
        }
      }else{
        return false;
      }
          return $code;
        }
   private function Check_Code($table, $column, $code){
      $query = $this->db->select($column)->from($table)->where($column,$code)->get();
      if($query->num_rows() >= 1){ 
            return true;
        }else{
            return false;
          }
    }
    private function Generate_Random_Code($length,$type,$delimeter){
      $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $str = '';
      $max = mb_strlen($keyspace, '8bit') - 1;
      if ($max < 1) {
          throw new Exception('error');
      }
      for ($i = 0; $i < $length; ++$i){
          $str .= $keyspace[random_int(0, $max)];
      }
      return $type.$delimeter.$str;
    }
    private function _error($type,$description,$username){
       $sql="INSERT INTO tbl_error_execution (type,description,username) VALUES('$type','$description','$username')";
       $result=$this->crud->execute($sql);
       return true;
    } 
   function Advisor($type,$id,$val,$val1,$advisor_code,$fname,$lname,$mname,$gender,$mobile,$email,$position,$team,$date_coded,$image,$tmp){
       switch($type){
          case "fetch_advisor":{
            $id = $this->encryption->decrypt($id);
            $result = $this->db->select('*')->from('tbl_advisor')->where('id',$id)->get()->row();
            return array('id'=>$this->encryption->encrypt($result->id),'result'=>$result,'date'=>date('m/d/Y',strtotime($result->date_coded)));
            break;
          }
          case "update_advisor_status":{
             $id = $this->encryption->decrypt($id);
            $result = $this->db->query("UPDATE tbl_advisor SET status='$val' WHERE id='$id'");
            if($result){
             return 'Saved Changes';
            }else{
             return 'Nothing Changes';
            }
            break;
          }
          case "create_advisor":{
             if($image){
                $newimage=$this->move_to_folder_resize($image,$tmp,'images/profile/',200,200,'tbl_advisor','image','IMAGE',14);
             }else{
                $newimage='default.png';
             } 
             $this->db->insert('tbl_advisor',array('advisor_code'=>$advisor_code,'fname'=>$fname,'mname'=>$mname,'lname'=>$lname,'gender'=>$gender,'mobile'=>$mobile,'email'=>$email,'team'=>$team,'position'=>$position,'image'=>$newimage,'status'=>1,'date_coded'=>$date_coded,'date_created'=>date('Y-m-d H:i:s'),'created_by'=>$this->admin_id));
              return 'Created Successfully';
            break;
          }
          case "update_advisor":{
             $id = $this->encryption->decrypt($id);
             if($val1 == 'date_coded'){
               $data = array("".$val1.""=>date('Y-m-d',strtotime($val)));
             }else{
               $data = array("".$val1.""=>$val);
             }
             
              $this->db->where('id',$id);
              $result =$this->db->update('tbl_advisor',$data);
              if($result){
                return 'Saved Changes';
              }else{
                return 'Nothing Changes';
              }
            break;
          }
          case "update_advisor_image":{
            if($image){
                $id = $this->encryption->decrypt($id);
                $row = $this->db->query("SELECT * FROM tbl_advisor WHERE id='$id'")->row();
                if($row->image != 'default.png'){
                  unlink('images/profile/'.$row->image);
                }
                $newimage=$this->move_to_folder_resize($image,$tmp,'images/profile/',200,200,'tbl_advisor','image','IMAGE',14);
                $data = array('image'=>$newimage);
                $this->db->where('id',$id);
                $result =$this->db->update('tbl_advisor',$data);
                if($result){
                  return array('status' => 'Saved Image Changes','image'=>$newimage);
                }else{
                  return 'Nothing Changes';
                }
            }
            break;
          }
       }
    }
    function Unit($type,$id,$val){
      switch($type){
        case "fetch_unit":{
           $id = $this->encryption->decrypt($id);
           $result = $this->db->select('*')->from('tbl_team')->where('id',$id)->get()->row();
          return array('id'=>$this->encryption->encrypt($result->id),'result'=>$result);
          break;
        }
        case"create_unit":{
           $this->db->insert('tbl_team',array('name'=>$val,'status'=>1,'date_created'=>date('Y-m-d H:i:s'),'created_by'=>$this->admin_id));
           return 'Created Successfully';
          break;
        }
        case"update_unit":{
           $id = $this->encryption->decrypt($id);
           $result = $this->db->query("UPDATE tbl_team SET name='$val' WHERE id='$id'");
              if($result){
                return 'Saved Changes';
              }else{
                return 'Nothing Changes';
              }
          break;
        }
      }
    }
    function Validation($type,$id,$from,$to,$amount,$generate_id,$date,$month,$year,$team,$advisor_code,$status){
      $data_advisor = array();
      switch($type){
         case "create_validation_date":{
           $sql = $this->db->select('*')->from('tbl_generate_date')->where('date_from',$to)->where('date_to',$from)->get()->row();
          if($sql){
             return 'Date Target is already existing';
          }else{
             $this->db->insert('tbl_generate_date',array('date_from'=>date('Y-m-d',strtotime($from)),'date_to'=>date('Y-m-d',strtotime($to)),'type'=>1,'date_created'=>date('Y-m-d H:i:s'),'created_by'=>$this->admin_id));
           return 'Created Successfully';
          }
          break;
        }
        case "update_validation_date":{
          $this->db->where('id',$this->encryption->decrypt($id));
          $result = $this->db->update('tbl_generate_date',array('date_from'=>date('Y-m-d',strtotime($from)),'date_to'=>date('Y-m-d',strtotime($to)),'type'=>1,'latest_update'=>date('Y-m-d H:i:s'),'update_by'=>$this->admin_id));
          if($result){
            return 'Update Successfully';
          }else{
            return false;
          }
          break;
        }
        case "create_target":{
          $sql = $this->db->select('*')->from('tbl_sales_target')->where('generate_date',$generate_id)->where('type',1)->get()->row();
          if($sql){
             $this->db->where('generate_date',$sql->id);
             $this->db->update('tbl_sales_target',array('amount'=>floatval(str_replace(',', '', $amount)),'latest_update'=>date('Y-m-d H:i:s'),'update_by'=>$this->admin_id));
             return 'Updated Successfully';
          }else{
            $this->db->insert('tbl_sales_target',array('cat_id'=>1,'amount'=>floatval(str_replace(',', '', $amount)),'generate_date'=>$generate_id,'type'=>1,'date_created'=>date('Y-m-d H:i:s'),'created_by'=>$this->admin_id));
             return 'Created Successfully';
          }
          break;
        }
        case "fetch_validation_target":{
          $row = $this->db->select('*')->from('tbl_sales_target')->where('generate_date',$id)->where('type',1)->get()->row();
          if($row){
             return number_format($row->amount,2);
          }else{
             return " ";
          }
          break;
        }
        case "fetch_validation_date":{
          $row = $this->db->select('*')->from('tbl_generate_date')->where('id',$this->encryption->decrypt($id))->get()->row();
          if($row){
             $data = array('id'=>$this->encryption->encrypt($row->id),
                           'date_from'=>date('m/d/Y',strtotime($row->date_from)),
                           'date_to'=>date('m/d/Y',strtotime($row->date_to)));
             return $data;
          }else{
             return " ";
          }
          break;
        }
        case "fetch_advisor_production":{
          $array = array('generate_date'=>$date,'month'=> $month,'year' => $year);
          $sql = $this->db->select('*,CONCAT(fname, " ",lname) AS fullname')->from('tbl_advisor')->where('team',$team)->get();
          foreach($sql->result() as $row){
            $query = $this->db->select('*')->from('tbl_generate_sales')->where('advisor_code',$row->advisor_code)->where($array)->get()->row();
            if($query){
              $submitted = $query->submitted;
              $settled = $query->settled;
              $ac = $query->ac;
              $nsc = $query->nsc;
            }else{
              $submitted ="";
              $settled ="";
              $ac ="";
              $nsc ="";
            }
            if($row->position == 1){
               $position = 'BM';
            }else if($row->position == 2){
              $position = 'SM';
            }else if($row->position == 3){
              $position = 'UM';
            }else if($row->position == 4){
              $position = 'UM';
            }else if($row->position == 5){
              $position = 'A';
            }
            $data_advisor[] = array('id'=>$this->encryption->encrypt($row->advisor_code),
                                    'advisor_code'=> $row->advisor_code,
                                    'fullname'=> $row->fullname,
                                    'position'=>$position,
                                    'submitted'=>$submitted,
                                    'settled'=>$settled,
                                    'ac'=>number_format($ac,2),
                                    'nsc'=>number_format($nsc,2));
          }
          return $data_advisor;
          break;
        }
        case "create_advisor_production":{
          $advisor_codes =$this->encryption->decrypt($advisor_code);
          $array = array('generate_date'=>$date,'month'=> $month,'year' => $year);
          $row = $this->db->select('*')->from('tbl_generate_sales')->where('advisor_code',$advisor_codes)->where($array)->get()->row();
           if($row){
              $this->db->where('id',$row->id);
              $this->db->update('tbl_generate_sales',array($status=>floatval(str_replace(',', '', $amount)),'latest_update'=>date('Y-m-d H:i:s'),'update_by'=>$this->admin_id));
           }else{
              if($amount > 0){
                 $this->db->insert('tbl_generate_sales',array('advisor_code'=>$advisor_codes,$status=>floatval(str_replace(',', '', $amount)),'type'=>1,'generate_date'=>$date,'month'=>$month,'year'=>$year,'date_created'=>date('Y-m-d H:i:s'),'created_by'=>$this->admin_id));
                 return 'Created Successfully';
              }
           }
          break;
        }
        case "fetch_validation_product":{
          $html ="";
          $s=1;
          $total_submitted=0;
          $total_settled=0;
          $total_ac=0;
          $total_nsc=0;
          $total_b_ac=0;
          $total_b_nsc=0;
          $target=0;
          $query = $this->db->select('*')->from('tbl_team')->where('status',1)->get();
          foreach($query->result() as $row){
            $html .='<table  class="table-bordered" style="text-align: center; width: 130%;">
                        <thead>
                          <tr style="background-color: #00ffff; ">
                            <th style="width: 2%;font-size: 10pt">No.</th>
                            <th style="width: 5%;font-size: 10pt">'.$row->name.'</th>
                            <th style="width: 2%;font-size: 10pt">Code</th>
                            <th style="width: 2%;font-size: 10pt">APP </br> SUB</th>
                            <th style="width: 2%;font-size: 10pt">APP </br> SETTLED</th>
                            <th style="width: 3%;font-size: 10pt">AC</th>
                            <th style="width: 3%;font-size: 10pt">NSC</th>
                            <th style="width: 3%;font-size: 10pt">Target AC&NSC</th>
                            <th style="width: 3%;font-size: 10pt">Balance for AC</th>
                            <th style="width: 3%;font-size: 10pt">Balance for NSC</th>
                        </tr>
                        </thead>
                  <tbody>';
                $advisor_query = $this->db->select('*')->from('tbl_advisor')->where('team',$row->id)->get()->result();
                foreach($advisor_query as $advisor){
                  $row = $this->db->select('sum(submitted) as submitted,sum(settled) as settled,sum(ac) as ac,sum(nsc) as nsc')->from('tbl_generate_sales')->where('advisor_code',$advisor->advisor_code)->where('generate_date',$date)->where('type',1)->get()->row();
                  if($row){
                    $target = $this->db->select('*')->from('tbl_sales_target')->where('cat_id',1)->where('generate_date',$date)->get()->row();
                    if($target){
                      $target = $target->amount;
                    }
                    $balance_ac =$row->ac-$target;
                    $balance_nsc=$row->nsc-$target;
                    ($balance_ac <= 0)?$color_ac = '#00cc00': $color_ac = '#cc0000';  
                    ($balance_nsc <= 0)?$color_nsc = '#00cc00': $color_nsc = '#cc0000';
                    $html .='<tr>
                            <td style="font-size: 8pt">'.$s.'</td>
                            <td style="text-align:left;font-size: 8pt"> '.$advisor->fname.' '.$advisor->lname.'</td>
                            <td style="font-size: 10pt">'.$advisor->advisor_code.'</td>
                            <td style="font-size: 10pt">'.number_format($row->submitted,2).'</td>
                            <td style="font-size: 10pt">'.number_format($row->settled,2).'</td>
                            <td style="font-size: 10pt">'.number_format($row->ac,2).'</td>
                            <td style="font-size: 10pt">'.number_format($row->nsc,2).'</td>
                            <td style="font-size: 10pt;background-color:#ffbf00">'.number_format($target,2).'</td>
                            <td style="font-size: 10pt;font-weight: bold;color: '.$color_ac.'">'.number_format(abs($balance_ac),2).'</td>
                            <td style="font-size: 10pt;font-weight: bold;color: '.$color_nsc.'">'.number_format(abs($balance_nsc),2).'</td>
                        </tr>';
                      $s++;
                      $total_submitted += $row->submitted;
                      $total_settled += $row->settled;
                      $total_ac += $row->ac;
                      $total_nsc += $row->nsc;
                      $total_b_ac += $balance_ac;
                      $total_b_nsc += $balance_nsc;
                    }
                }
                $html .='<tr>
                        <td colspan="3" style="background-color:#ebf52f;">TOTAL :</td>
                        <td style="background-color:#ebf52f;">'.number_format($total_submitted,2).'</td>
                        <td style="background-color:#ebf52f;">'.number_format($total_settled,2).'</td>
                        <td style="background-color:#ebf52f;">'.number_format($total_ac,2).'</td>
                        <td style="background-color:#ebf52f;">'.number_format($total_nsc,2).'</td>
                        <td style="background-color:#ebf52f;"></td>
                        <td style="background-color:#ebf52f;">'.number_format(abs($total_b_ac),2).'</td>
                        <td style="background-color:#ebf52f;">'.number_format(abs($total_b_nsc),2).'</td>
                      </tr><tbody></table></br>';
          }
           return $html;
          break;
        }


      }
    }
    //PUBLIC END
    
}
?>