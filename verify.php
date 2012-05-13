<?

include_once("consts.php");
include_once("dbconnect.php");
include_once("dbutils.php");
include_once("logging.php");
include_once("utils.php");

function approve($vkey) {
	global $dbt_verify;
	global $dbt_data;
	global $dbt_firmware;
	global $dbt_kernel;
	global $dbt_modem;
	global $dbt_provider;
	$data_entry = -1;
	$approved = false;
	
	connect();
	
	$sql = "SELECT data_entry FROM ". $dbt_verify ." WHERE vkey = '". $vkey ."'";
	logMessage("approve(): >". $sql ."<");
	$result = mysql_query($sql) or die("Fehler bei Abfrage >". $sql ."< : ". mysql_errno ." (". mysql_error() .")");
	if ($result && mysql_num_rows($result) > 0) {
		$row = mysql_fetch_array($result);
		$data_entry = $row[0];
		mysql_free_result($result);
		
		$datasql = "SELECT firmware, kernel, modem, provider FROM ". $dbt_data ." WHERE data_id = ". $data_entry;
		logMessage("approve(): >". $datasql ."<");
		$result = mysql_query($datasql) or die("Fehler bei Abfrage >". $datasql ."< : ". mysql_errno ." (". mysql_error() .")");
		if ($result) {
			$row = mysql_fetch_array($result);
			$appr_sql = array();
			$appr_sql[] = "UPDATE ". $dbt_firmware ." SET approved = 'X' WHERE fw_id = ". $row[0];
			$appr_sql[] = "UPDATE ". $dbt_kernel ." SET approved = 'X' WHERE krnl_id = ". $row[1];
			$appr_sql[] = "UPDATE ". $dbt_modem ." SET approved = 'X' WHERE modem_id = ". $row[2];
			$appr_sql[] = "UPDATE ". $dbt_provider ." SET approved = 'X' WHERE provid = ". $row[3];
			
			// execute the inserts
			foreach ($appr_sql as $i => $sql) {
				mysql_query($sql) or die("Fehler bei Abfrage >". $sql ."< : ". mysql_errno ." (". mysql_error() .")");
			}
			
			mysql_free_result($result);
			
			$upd_datasql = "UPDATE ". $dbt_data ." SET approved = 'X' WHERE data_id = ". $data_entry;
			mysql_query($upd_datasql) or die("Fehler bei Abfrage >". $upd_datasql ."< : ". mysql_errno ." (". mysql_error() .")");
			
			$del_vkeysql = "DELETE FROM ". $dbt_verify ." WHERE vkey = '". $vkey ."'";
			mysql_query($del_vkeysql) or die("Fehler bei Abfrage >". $del_vkeysql ."< : ". mysql_errno ." (". mysql_error() .")");
			
			$approved = true;
		}
	}
	
	disconnect();
	
	return $approved;
}

?>