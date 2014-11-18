<?php
/**
 * Description of UploadCv
 *
 *This file insert data in to BD
 *
 * @author Hristiyan
 */
require_once '../config.php';
require_once './Db.php';
class UploadCv extends Db{
    private $person_id;
    public function __construct(){        
        parent::__construct(); //initiate db connection
    }    
    public  function start($uploadXML=false){ //Load and parse xml
        $xml = simplexml_load_file($_FILES['fileToUpload']['tmp_name']); //Insert data
        $this->person_id = $this->insertPerson($xml->personalinfo);
        $this->insertEducation($xml->education);
        $this->insertExperience($xml->workingexperience);
        $this->insertInterests($xml->intersts);
        $this->insertSkills($xml->skills);
    }
    public function insertPerson($data){
        $stmt = $this->db->prepare('INSERT INTO `cvmanagement`.`person`(`first_name`, `last_name`, `address`, `phone`, `birthday`) VALUES (?,?,?,?,?)');
        $stmt->bind_param('sssss', $data->firstname, $data->lastname, $data->address, $data->phone, $data->yearofbirth); 
        $stmt->execute();
        //printf("%d Row inserted into person.<br>", $stmt->affected_rows);
        $stmt->close();
        return mysqli_insert_id($this->db);
    }
    public function insertEducation($data){
        $education_type = 'school';
        foreach($data->school as $key=>$val ){
            $stmt = $this->db->prepare("INSERT INTO `cvmanagement`.`education` (`person_id`, `education_type`, `organization_name`, `specialty`, `city`, `degree`, `graduation`) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param('issssss', $this->person_id, $education_type, $val->name, $val->specialty, $val->city, $val->degree, $val->graduation);   
        }
        $stmt->execute();
        //printf("%d Row inserted into education/school.<br>", $stmt->affected_rows);
        $stmt->close();
        $education_type = 'university';
        foreach($data->university as $key=>$val){
            $stmt = $this->db->prepare("INSERT INTO `cvmanagement`.`education` (`person_id`, `education_type`, `organization_name`, `specialty`, `city`, `degree`, `graduation`) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param('issssss', $this->person_id, $education_type, $val->name, $val->specialty, $val->city, $val->degree, $val->graduation);   
        }
        $stmt->execute();
        //printf("%d Row inserted into education/university.<br>", $stmt->affected_rows);
        $stmt->close();        
    }
    public function insertExperience($data){        
        $type = "internship";
        foreach ($data->internship as $key=>$val){
            $stmt = $this->db->prepare( "INSERT INTO `cvmanagement`.`experience` (`person_id`, `from`, `to`, `position`, `type`, `organization`, `city`) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param('sssssss', $this->person_id, $val->from, $val->to, $val->position, $type, $val->organization, $val->city);  
            $stmt->execute();
            //printf("%d Row inserted into experience/intership.<br>", $stmt->affected_rows);
            $stmt->close();
        }
        $type = "realjob";
        foreach ($data->internship as $key=>$val){
            $stmt = $this->db->prepare( "INSERT INTO `cvmanagement`.`experience` (`person_id`, `from`, `to`, `position`, `type`, `organization`, `city`) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param('sssssss', $this->person_id, $val->from, $val->to, $val->position, $type, $val->organization, $val->city);  
            $stmt->execute();
            //printf("%d Row inserted into experience/realjob.<br>", $stmt->affected_rows);
            $stmt->close();
        }
    }
    public function insertInterests($data){        
        foreach($data->interstname as $key=>$val){
            $stmt = $this->db->prepare("INSERT INTO `cvmanagement`.`interest` (`person_id`, `interst_name`) VALUES (?,?)");
            $stmt->bind_param('is',$this->person_id, $val);
            $stmt->execute();
            //printf("%d Row inserted into interests.<br>", $stmt->affected_rows);
            $stmt->close();
        }
    }
    public function insertSkills($data){        
        $type = "personal";
        foreach($data->personal as $key=>$val){
            $stmt = $this->db->prepare("INSERT INTO `cvmanagement`.`skill` (`person_id`, `skill_name`, `type`) VALUES (?,?,?)");
            $stmt->bind_param('iss',$this->person_id, $val->skillname, $type); 
            $stmt->execute();
            //printf("%d Row inserted into skill/personal.<br>", $stmt->affected_rows);
            $stmt->close();            
        }        
        $type = "technical";
        foreach($data->technical as $key=>$val){
             $stmt = $this->db->prepare("INSERT INTO `cvmanagement`.`skill` (`person_id`, `skill_name`, `type`) VALUES (?,?,?)");
            $stmt->bind_param('iss',$this->person_id, $val->skillname, $type);
            $stmt->execute();
            //printf("%d Row inserted into skills/technical.<br>", $stmt->affected_rows);
            $stmt->close();            
        }
    }        
}
try {
   $uploadCv = new UploadCv(); 
   $uploadCv->start(UploadXml);
} catch (Exception $e) {
    $db->rollback();
}
echo "<script>alert('The xml was added!')</script>"
?>
<a href = '../view.php'> Back</a> 

