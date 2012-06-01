<?

include_once("consts.php");
include_once("dbconnect.php");
include_once("dbutils.php");
include_once("logging.php");

connect();

$sql = "SELECT * FROM ". $dbt_data ." WHERE ";
$where_clause = "approved = 'X' ";

if ($_REQUEST["modem"] && $_REQUEST["modem"] != "NULL") {
	if ($where_clause != "") {
		$where_clause .= " AND ";
	}
	$where_clause .= "modem = ". $_REQUEST["modem"];
}
if ($_REQUEST["firmware"] && $_REQUEST["firmware"] != "NULL") {
	if ($where_clause != "") {
		$where_clause .= " AND ";
	}
	$where_clause .= "firmware = ". $_REQUEST["firmware"];
}
if ($_REQUEST["kernel"] && $_REQUEST["kernel"] != "NULL") {
	if ($where_clause != "") {
		$where_clause .= " AND ";
	}
	$where_clause .= "kernel = ". $_REQUEST["kernel"];
}
if ($_REQUEST["provider"] && $_REQUEST["provider"] != "NULL") {
	if ($where_clause != "") {
		$where_clause .= " AND ";
	}
	$where_clause .= "provider = ". $_REQUEST["provider"];
}

logMessage("query_db: ". $sql .$where_clause);

$result = mysql_query($sql . $where_clause) or die("Fehler bei Abfrage >". $sql ."< : ". mysql_errno ." (". mysql_error() .")");
resultToTable($result, array("firmware" => "Firmware", "kernel" => "Kernel", "modem" => "Modem / ICS only", "provider" => "Provider", "region" => "Region", "phone_quality" => "Telefon Q", "internet_quality" => "Internet Q", "avg_dBm" => "Avg. dBm", "avg_dBm_wifi" => "Avg. dBm WiFi"), array("phone_quality" => array($dbt_rating, "rating_id", array("rating")), "internet_quality" => array($dbt_rating, "rating_id", array("rating")), "provider" => array($dbt_provider, "provid", array("provider")), "firmware" => array($dbt_firmware, "fw_id", array("firmware")), "kernel" => array($dbt_kernel, "krnl_id", array("kernel")), "region" => array($dbt_region, "region_id", array("city", "postalcode", "area", "country")), "modem" => array($dbt_modem, "modem_id", array("modem", "ics_only"))));

disconnect();

//dumpLog();

?>