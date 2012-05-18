<?

include_once("consts.php");
include_once("dbconnect.php");
include_once("dbutils.php");
include_once("logging.php");
include_once("utils.php");

connect();

if ($_REQUEST["action"]) {
	//dumpRequest();
	logMessage("add_db.php: Adding an entry...");
	if (addEntry()) {
?>
Der Eintrag wurde hinzugef&uuml;gt, ist jedoch noch nicht freigeschaltet ! Bitte klicke auf den Aktivierungslink, der an deine angegebene Email-Adresse versandt wurde !
<?
	}
	else {
?>
Es ging etwas schief. Der Eintrag wurde nicht hinzugef&uuml;gt. Das tut uns leid !
<?
	}
}
else {

?>
<script type="text/javascript">
	$(document).ready(function(){
		// setup forms
		var optionsAdd = {
			target:			'#content',
			beforeSubmit:	validateAdd,
			success:		afterPost
		};
		
		$("#add_entry").ajaxForm(optionsAdd);
		$('#triggeradd').button().click(function() {
			$("#add_entry").ajaxSubmit(optionsAdd);
		});

		function validateAdd(formData, jqForm, options) {
			// formData is an array; here we use $.param to convert it to a string to display it 
			// but the form plugin does this for you automatically when it submits the data 
			//var queryString = $.param(formData); 

			// jqForm is a jQuery object encapsulating the form element.  To access the 
			// DOM element for the form do this: 
			// var formElement = jqForm[0]; 

			//alert('About to submit: \n\n' + queryString);
			
			var valid = false;
			if (jqForm[0].id == "add_entry") {

				var email = $("input[name=add_email]").fieldValue();
				var r_city = $("input[name=add_region_city]").fieldValue();
				var r_postal = $("input[name=add_region_postalcode]").fieldValue();
				var r_area = $("input[name=add_region_area]").fieldValue();
				var dbm = $("input[name=add_avgdbm]").fieldValue();
				var timerange = $("input[name=add_timetested]").fieldValue();
				var i_dbm = parseInt(dbm);
				var i_timerange = parseInt(timerange);
				
				if (validateEmail(email) || (r_city != "" && r_postal != "" && r_area != "") &&
					(!isNaN(i_dbm) && i_dbm >= 65 && i_dbm <= 117) &&
					(!isNaN(i_timerange) && i_timerange > 0)
					)
				{
					valid = true;
				}
				else {
					if (!validateEmail(email)) {
						$("#add_entry input[name=add_email]").effect('pulsate', { times: 3 }, 'slow');
					}
					if (isNaN(i_dbm) || i_dbm < 65 || i_dbm > 117) {
						$("#add_entry input[name=add_avgdbm]").effect('pulsate', { times: 3 }, 'slow');
					}
					if (isNaN(i_timerange) || i_timerange <= 0) {
						$("#add_entry input[name=add_timetested]").effect('pulsate', { times: 3 }, 'slow');
					}
					if (
						(r_city != "" && (r_postal == "" || r_area == "")) ||
						(r_postal != "" && (r_city == "" || r_area == "")) ||
						(r_area != "" && (r_city == "" || r_postal == ""))
						)
					{
						if (r_city == "") {
							$("#add_entry input[name=add_region_city]").effect('pulsate', { times: 3 }, 'slow');
						}
						if (r_postal == "") {
							$("#add_entry input[name=add_region_postalcode]").effect('pulsate', { times: 3 }, 'slow');
						}
						if (r_area == "") {
							$("#add_entry input[name=add_region_area]").effect('pulsate', { times: 3 }, 'slow');
						}
					}
				}
			}

			// here we could return false to prevent the form from being submitted; 
			// returning anything other than false will allow the form submit to continue 
			return valid; 
		}
		
		// post-submit callback 
		function afterPost(responseText, statusText, xhr, $form)  { 
			// for normal html responses, the first argument to the success callback 
			// is the XMLHttpRequest object's responseText property 

			// if the ajaxSubmit method was passed an Options Object with the dataType 
			// property set to 'xml' then the first argument to the success callback 
			// is the XMLHttpRequest object's responseXML property 

			// if the ajaxSubmit method was passed an Options Object with the dataType 
			// property set to 'json' then the first argument to the success callback 
			// is the json data object returned by the server 

			//alert('status: ' + statusText + '\n\nresponseText: \n' + responseText + 
			//  '\n\nThe output div should have already been updated with the responseText.');
		}
		
		function validateEmail(email) { 
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		}
 	});
</script>

	<form id="add_entry" method="POST" action="<? echo $_SERVER['PHP_SELF']; ?>">
	  <input type="hidden" name="action" value="addentry">
	  <table>
	    <tr>
		  <td colspan="2">Achtung: in Textfeldern eingegebene Werte haben eine h&ouml;here Priorit&auml;t als ausgew&auml;hlte Werte !</td>
		</tr>
	    <tr>
		  <td>Email:</td>
		  <td><input type="text" name="add_email"> (Achtung: eine Email wird im Anschlu&szlig; an diese versandt !)</td>
		</tr>
		<tr>
		  <td>Modem (ausw&auml;hlen ODER eingeben):</td>
		  <td>
		    <select name="modem">
			  <? tableToSelect($dbt_modem, "modem_id", "modem", "modem"); ?>
			</select>
			<input type="text" name="add_modem">
			<input type="checkbox" name="modem_ics" value="X"> ICS only
		  </td>
		</tr>
		<tr>
		  <td>Firmware (ausw&auml;hlen ODER eingeben):</td>
		  <td>
		    <select name="firmware">
			  <? tableToSelect($dbt_firmware, "fw_id", "firmware", "firmware"); ?>
			</select>
			<input type="text" name="add_firmware">
		  </td>
		</tr>
		<tr>
		  <td>Kernel (ausw&auml;hlen ODER eingeben):</td>
		  <td>
		    <select name="kernel">
			  <? tableToSelect($dbt_kernel, "krnl_id", "kernel", "kernel"); ?>
			</select>
			<input type="text" name="add_kernel">
		  </td>
		</tr>
		<tr>
		  <td>Provider (ausw&auml;hlen ODER eingeben):</td>
		  <td>
		    <select name="provider">
			  <? tableToSelect($dbt_provider, "provid", "provider", "provid"); ?>
			</select>
			<input type="text" name="add_provider">
		  </td>
		</tr>
		<tr>
		  <td>Region (ausw&auml;hlen ODER eingeben):</td>
		  <td>
		    <table>
			  <tr>
			    <td>
		          <select name="region">
			        <? tableToSelect($dbt_region, "region_id", "city", "city"); ?>
			      </select>
				</td>
			  </tr>
			  <tr>
			    <td>
				  Stadt: <input type="text" name="add_region_city">
				</td>
				<td>
				  PLZ: <input type="text" name="add_region_postalcode">
				</td>
				<td>
				  Bundesland / Kanton / ...: <input type="text" name="add_region_area">
				</td>
				<td>
				  Land: <? generateCountryDropDown(); ?>
				</td>
			  </tr>
			</table>
		  </td>
		</tr>
		<tr>
		  <td>Telefon Qualit&auml;t:</td>
		  <td>
		    <select name="phoneq">
			  <? tableToSelect($dbt_rating, "rating_id", "rating", "rating_id"); ?>
			</select>
		  </td>
		</tr>
		<tr>
		  <td>Internet Qualit&auml;t:</td>
		  <td>
		    <select name="inetq">
			  <? tableToSelect($dbt_rating, "rating_id", "rating", "rating_id"); ?>
			</select>
		  </td>
		</tr>
		<tr>
		  <td>Avg. dBm:</td>
		  <td>
			- <input type="text" name="add_avgdbm" size="3"> dBm
		  </td>
		</tr>
		<tr>
		  <td>beobachtete Zeitspanne:</td>
		  <td>
			<input type="text" name="add_timetested" size="3"> Tag(e)
		  </td>
		</tr>
	  </table>
	  <button id="triggeradd">Submit data</button>
	</form>
<?
}

function addEntry() {
	global $dbt_data;
	global $dbt_modem;
	global $dbt_firmware;
	global $dbt_kernel;
	global $dbt_provider;
	global $dbt_region;
	global $dbt_verify;
	$added = false;
	
	if ($_REQUEST["add_email"] &&
			($_REQUEST["modem"] || $_REQUEST["add_modem"]) &&
			($_REQUEST["firmware"] || $_REQUEST["add_firmware"]) &&
			($_REQUEST["kernel"] || $_REQUEST["add_kernel"]) &&
			($_REQUEST["provider"] || $_REQUEST["add_provider"]) &&
			($_REQUEST["region"] || 
					($_REQUEST["add_region_city"] &&
					 $_REQUEST["add_region_postalcode"] &&
					 $_REQUEST["add_region_area"] &&
					 $_REQUEST["country"]
					)
			) &&
			$_REQUEST["phoneq"] && $_REQUEST["inetq"] && $_REQUEST["add_avgdbm"] && $_REQUEST["add_timetested"]
	) {
		logMessage("addEntry(): data validation successful");

		$data_items = array("modem" => $_REQUEST["modem"], "firmware" => $_REQUEST["firmware"], "kernel" => $_REQUEST["kernel"], "provider" => $_REQUEST["provider"], "region" => $_REQUEST["region"]);
		// generate insert and retrieve statements upfront
		$inserts = array();
		$retrieves = array();
		if ($_REQUEST["add_modem"]) {
			$inserts["modem"] = "INSERT INTO ". $dbt_modem ." SET modem = '". $_REQUEST["add_modem"] ."', ics_only = '". $_REQUEST["modem_ics"] ."'";
		}
		if ($_REQUEST["add_firmware"]) {
			$inserts["firmware"] = "INSERT INTO ". $dbt_firmware ." SET firmware = '". $_REQUEST["add_firmware"] ."'";
		}
		if ($_REQUEST["add_kernel"]) {
			$inserts["kernel"] = "INSERT INTO ". $dbt_kernel ." SET kernel = '". $_REQUEST["add_kernel"] ."'";
		}
		if ($_REQUEST["add_provider"]) {
			$inserts["provider"] = "INSERT INTO ". $dbt_provider ." SET provider = '". $_REQUEST["add_provider"] ."'";
		}
		if ($_REQUEST["add_region_city"]) {
			$inserts["region"] = "INSERT INTO ". $dbt_region ." SET city = '". $_REQUEST["add_region_city"] ."', postalcode = '". $_REQUEST["add_region_postalcode"] ."', area = '". $_REQUEST["add_region_area"] ."', country = '". $_REQUEST["country"] ."'";
		}
		
		// execute the inserts
		foreach ($inserts as $category => $sql) {
			$result = mysql_query($sql) or die("Fehler bei Abfrage >". $sql ."< : ". mysql_errno ." (". mysql_error() .")");
			$id = mysql_insert_id();
			
			switch ($category) {
				case "modem":
					$data_items["modem"] = $id;
					break;
				case "firmware":
					$data_items["firmware"] = $id;
					break;
				case "kernel":
					$data_items["kernel"] = $id;
					break;
				case "provider":
					$data_items["provider"] = $id;
					break;
				case "region":
					$data_items["region"] = $id;
					break;
			}
			$id = -1;
		}
		
		// preserve the "-" if there is already one, otherwise add it
		$avg_dBm = $_REQUEST["add_avgdbm"];
		$avg_dBm = ($_REQUEST["add_avgdbm"] != "" && substr($_REQUEST["add_avgdbm"], 0, 1) == "-") ? $avg_dBm : "-". $avg_dBm;
		
		$sql = "INSERT INTO ". $dbt_data ." SET provider = ". $data_items["provider"] .", modem = ". $data_items["modem"] .", firmware = ". $data_items["firmware"] .", kernel = ". $data_items["kernel"] .", region = ". $data_items["region"] .", phone_quality = ". $_REQUEST["phoneq"] .", internet_quality = ". $_REQUEST["inetq"] .", avg_dBm = '". avg_dBm ."', timetested = ". $_REQUEST["add_timetested"];
		logMessage("addEntry: $sql >". $sql ."<");
		mysql_query($sql) or die("Fehler bei Abfrage >". $sql ."< : ". mysql_errno ." (". mysql_error() .")");

		$data_entry = mysql_insert_id();
		$vkey = uniqid();
		$vsql = "INSERT INTO ". $dbt_verify ." SET vkey = '". $vkey ."', data_entry = ". $data_entry;
		logMessage("addEntry: $vsql >". $vsql ."<");
		mysql_query($vsql) or die("Fehler bei Abfrage >". $vsql ."< : ". mysql_errno ." (". mysql_error() .")");
		
		mail($_REQUEST["add_email"], "SGS2 Modem Database Verification",
		"Hello,\n
please click the following link to approve your identity and your entry to our database. Please notice that your email was not stored in the database and is just used for verification purposes !\n\n
Click here to finish verification: http://www.advins.de/modemdb/index.php?vkey=". $vkey ."\n\n
Thanks + Regards,\n
SGS2 Modem DB Team");
		
		$added = true;
	}
	
	return $added;
}

disconnect();

dumpLog();

?>