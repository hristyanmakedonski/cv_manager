<?php
/**
 * Description of DB
 *
 * Here are DB configuration and connection settings
 *
 * @author Hristiyan
 */
class Db{
	public $db;
	public function __construct(){
		global $host,$username,$password,$dbname;
		$this->db=mysqli_connect($host,$username,$password,$dbname);
		mysqli_set_charset($this->db, 'utf8');
		if (!$this->db) {
		    echo 'Error establishing a DB connection';
		}
		mysqli_select_db($this->db,$dbname);
	}
	public function __desctruct(){
		mysqli_close($this->db);
	}
	public function select($query){
		return  $this->toArray(mysqli_query($this->db,$query));
	}
	public function query($query){
		return mysqli_query($this->db,$query);
	}
	private function toArray($query){
            $tmp=array();
            $result=array();
            while ($row = $query->fetch_assoc()) {
                            $tmp[] = $row; 
            }
            foreach ($tmp as $key => $value) {
                            $result[] = $value;
                    }
        return $result;
	}
}