<?php
class Dashboard {
	protected $finalData = array();
	private $db;
	private $tableName;
	/********************* START OF CONSTRUCTOR *******************************/
	public function __construct() {
		//$this -> tableName = 'leadsource';
		$this -> db = Database::Instance();
	}

	public function get_statistics($tableName){
		$keyValueArray['status'] = 0;
		$dataArr = $this -> db -> getDataFromTable($keyValueArray, $tableName, "count(id) as cnt");
		$sql_count = $dataArr[0]['cnt'];
		return $sql_count;
	}
}
?>