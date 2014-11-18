<?php
/**
 * Description of Cv
 *
 *This file update information in the database
 *
 * @author Hristiyan
 */
require_once './config.php';
require_once './lib/Db.php';
class Cv extends Db{
    public function __construct(){
    	parent::__construct();
    }
    /**
     * 
     * @param Int $filter. Default value is set to false and the method will return all results.
     * If you want single result the filter has to be provided as Integer value
     */
    public function View($filter = false){
        $sql = "SELECT
            person.id as person_id,
            person.first_name,
            person.last_name,
            person.address as personal_address ,
            person.phone,person.birthday,
            education.id as education_id,
            education.education_type, 
            education.organization_name as education_organization,
            education.specialty as education_specialty,
            education.city as education_city, 
            education.degree as education_degree, 
            education.graduation,
            experience.id as experience_id ,
            experience.`from` as experience_from ,
            experience.`to` as experience_to, 
            experience.position as eperience_position,
            experience.`type` as experince_type,
            experience.organization as experience_organization,
            experience.city as experience_city,
            interest.id as interest_id ,
            interest.interst_name ,
            skill.id as skill_id , skill.skill_name , skill.type as skill_type
            FROM person
                INNER JOIN education on education.person_id = person.id
                INNER JOIN experience on experience.person_id = person.id
                INNER JOIN interest on interest.person_id = person.id
                INNER JOIN skill on skill.person_id= person.id ";
        if($filter !== false){
            $sql .= ' WHERE person.id='.$filter;
        }
        $result = $this->select($sql);
        //Array containing the table results 
        $finalResults = array(
            'personalinfo'=>array(),
            'education'=>array(),
            'experience'=>array(),
            'interest'=>array(),
            'skill'=>array()
        );
        foreach ($result as $k=>$v){           
            if(!key_exists($v['person_id'], $finalResults['personalinfo'])){
                $finalResults['personalinfo'][$v['person_id']]['first_name']= $v['first_name'];
                $finalResults['personalinfo'][$v['person_id']]['last_name'] = $v['last_name'];
                $finalResults['personalinfo'][$v['person_id']]['personal_address'] = $v['personal_address'];
                $finalResults['personalinfo'][$v['person_id']]['phone'] = $v['phone'];
                $finalResults['personalinfo'][$v['person_id']]['birthday'] = $v['birthday'];
            }
            if(!key_exists($v['education_id'], $finalResults['education'])){
                $finalResults['education'][$v['person_id']][$v['education_id']]['education_type'] = $v['education_type'];
                $finalResults['education'][$v['person_id']][$v['education_id']]['education_organization'] = $v['education_organization'];
                $finalResults['education'][$v['person_id']][$v['education_id']]['education_specialty'] = $v['education_specialty'];
                $finalResults['education'][$v['person_id']][$v['education_id']]['education_city'] = $v['education_city'];
                $finalResults['education'][$v['person_id']][$v['education_id']]['education_degree'] = $v['education_degree'];
                $finalResults['education'][$v['person_id']][$v['education_id']]['graduation'] = $v['graduation'];
            }
            if(!key_exists($v['experience_id'], $finalResults['experience'])){
                $finalResults['experience'][$v['person_id']][$v['experience_id']]['experience_from'] = $v['experience_from'];
                $finalResults['experience'][$v['person_id']][$v['experience_id']]['experience_to'] = $v['experience_to'];
                $finalResults['experience'][$v['person_id']][$v['experience_id']]['eperience_position'] = $v['eperience_position'];
                $finalResults['experience'][$v['person_id']][$v['experience_id']]['experince_type'] = $v['experince_type'];
                $finalResults['experience'][$v['person_id']][$v['experience_id']]['experience_organization'] = $v['experience_organization'];
                $finalResults['experience'][$v['person_id']][$v['experience_id']]['experience_city'] = $v['experience_city'];
            }
            if(!key_exists($v['interest_id'], $finalResults['interest'])){
                $finalResults['interest'][$v['person_id']][$v['interest_id']]['interst_name'] = $v['interst_name'];
            }
            if(!key_exists($v["skill_id"], $finalResults['skill'])){
                $finalResults['skill'][$v['person_id']][$v["skill_id"]]['skill_name'] = $v["skill_name"];
                $finalResults['skill'][$v['person_id']][$v["skill_id"]]['skill_type'] = $v["skill_type"];
            }   
        }
        return $finalResults;
    }
    // following methods fill the data in the appropriate tables in the database
    public function UpdatePersonalInfo($data){
        if(empty($data))die;
            $data = $data['Params'];
            $stmt = $this->db->prepare("UPDATE `cvmanagement`.`person` 
                                        SET `first_name`=?, last_name=?, `phone`=?, `birthday`=?, `address`=? 
                                        WHERE `id`=?");
            $stmt->bind_param('sssssi', $data['first_name'], $data['last_name'], $data['phone'], $data['birthday'], $data['personal_address'], $data['person_id']);
            $status = $stmt->execute();
            $stmt->close();
    }
    public function UpdateEducationInfo($data){
        if(empty($data))die;
            $data = $data['Params'];
            $stmt = $this->db->prepare("UPDATE `cvmanagement`.`education` 
                                        SET `education_type`=?, organization_name=?, `specialty`=?, `city`=?, `degree`=?, `graduation`=? 
                                        WHERE `id`=?");
            $stmt->bind_param('ssssssi', $data['education_type'], $data['education_organization'], $data['education_specialty'], $data['education_city'], $data['education_degree'], $data['graduation'], $data['education_id']);
            $status = $stmt->execute();
            $stmt->close();
    }
    public function UpdateExperienceInfo($data){
        if(empty($data))die;
            $data = $data['Params'];
            $stmt = $this->db->prepare("UPDATE `cvmanagement`.`experience` 
                                        SET `from`=?, `to`=?, `position`=?, `type`=?, `organization`=?, `city`=? 
                                        WHERE `id`=?");
            $stmt->bind_param('ssssssi', $data['experience_from'], $data['experience_to'], $data['experience_position'], $data['experince_type'], $data['experience_organization'], $data['experience_city'], $data['experience_id']);
            $status = $stmt->execute();
            $stmt->close();
    }
    public function UpdateInterestInfo($data){
        if(empty($data))die;
            $data = $data['Params'];
            $stmt = $this->db->prepare("UPDATE `cvmanagement`.`interest` 
                                        SET `interst_name`=?
                                        WHERE `id`=?");
            $stmt->bind_param('si', $data['interest_name'], $data['interest_id']);
            $status = $stmt->execute();
            $stmt->close();
    }
    public function UpdateSkillsInfo($data){
        if(empty($data))die;
            $data = $data['Params'];
            $stmt = $this->db->prepare("UPDATE `cvmanagement`.`skill` 
                                        SET `skill_name`=?, `type`=?
                                        WHERE `id`=?");
            $stmt->bind_param('ssi', $data['skill_name'], $data['skill_type'], $data['skill_id']);
            $status = $stmt->execute();
            $stmt->close();
    }
}
