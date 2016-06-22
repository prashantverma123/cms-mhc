<?php 
class Cron{
	public function __construct() {
		//$this -> tableName = 'leadmanager';
		$this -> db = Database::Instance();
		$this -> logs = new Logging();
	}

	function create_tax_constant(){
		$keyValueArray = array();
		$taxes = $this -> db -> getDataFromTable($whereArr, 'tax', "tax.name,tax.value", "", '', false);
		$file = fopen(SITEPATH."/lib/tax_constant.php", "w")or die("Unable to open file!");
		$txt = "John Doe\n";
		fwrite($file, $txt);
		$txt = "Jane Doe\n";
		fwrite($file, $txt);
		fclose($file);
		exit;
	}
}

?>