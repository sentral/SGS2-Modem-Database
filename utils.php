<?php

include_once("logging.php");

function dumpRequest() {
	// DEBUG purposes
	foreach ($_REQUEST as $key => $val) {
		if (is_array($val)) {
			echo $key ." => ". var_dump($val) ."<br />";
		}
		else {
			echo $key ." => ". $val ."<br />";
		}
	}
}

/*************************************************
 *
 * Page buttons support
 * helper methods included
 *
 *************************************************/

function getCurrentPage() {
	return (!isset($_REQUEST['page'])) ? 0 : $_REQUEST['page'];
}

function calculateFromEntryForSQL($maxentries) {
	return max(0, getCurrentPage() * $maxentries - $maxentries);
}
 
function addPageButtons($entriesPerPage, $maxentries) {
	$page = (!isset($_REQUEST['page'])) ? 0 : $_REQUEST['page'];
	$maxpage = ceil($entriesPerPage / $maxentries);
	logMessage("addPageButtons: page => ". $page ."; maxpage => ". $maxpage);
	if ($page == 0) {
		logMessage("addPageButtons: $page is 0 => incrementing by 1");
		$page++;
	}
?>
<script type="text/javascript">
	$("#content a").click(function() {
		var toLoad = $(this).attr('href');
		var aclass = $(this).attr('class');
		if (aclass == "pagebutton") {
			$('#content').load(toLoad, function(response, status, xhr) {
					if (status == "error") {
						$("#content").html("An error occured: " + xhr.status + " - " + xhr.statusText);
					}
				});
			
			return false;
		}
	});
</script>
<div id="paging">
<?php
	$prevButtonVisible = $page - 1 > 0;
	$nextButtonVisible = $page + 1 <= $maxpage;
	$anyButtonVisible = $prevButtonVisible || $nextButtonVisible;
	
	if ($page - 1 > 0) {
?>
  <a href="<?php echo $_SERVER['PHP_SELF'] ?>?page=<?php echo $page - 1 ?>" class="pagebutton" alt="Seite <?php echo $page - 1 ?>">&lt;</a>
<?php
	}
	if ($anyButtonVisible) {
		echo "&nbsp;Seite ". $page ."/". $maxpage ."&nbsp;";
	}
	if ($page + 1 <= $maxpage) {
?>
  <a href="<?php echo $_SERVER['PHP_SELF'] ?>?page=<?php echo $page + 1 ?>" class="pagebutton" alt="Seite <?php echo $page + 1 ?>">&gt;</a>
<?php
	}
	else {
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	}
?>
</div>
<?php
}

/*************************************************
 *
 * Regex support
 * helper methods included
 *
 *************************************************/

function regex_escape($regex) {
	//$ret = preg_quote($regex);
	//$ret = preg_replace("/\~/", "~~", $ret);
	$ret = preg_replace("/\\/", "#092;", $ret);
	return $ret;
}

function regex_unescape($escaped_regex) {
	//$ret = preg_replace("/\~\~/", "~", $escaped_regex);
	//$ret = preg_replace("/\\\\/", "\\", $ret);
	$ret = preg_replace("/#092;/", "\\", $ret);
	return $ret;
}

/*************************************************
 *
 * Locale support
 * helper methods included
 *
 *************************************************/
function generateCountryDropDown($country = "DE") {
?>
<select name="country" id="country">
	<option value="">Country</option>
	<option<?=$country == 'AF' ? ' selected="selected"' : '' ;?> value="AF">Afghanistan</option>
	<option<?=$country == 'AL' ? ' selected="selected"' : '' ;?> value="AL">Albania</option>
	<option<?=$country == 'AG' ? ' selected="selected"' : '' ;?> value="AG">Algeria</option>
	<option<?=$country == 'AS' ? ' selected="selected"' : '' ;?> value="AS">American Samoa</option>
	<option<?=$country == 'AD' ? ' selected="selected"' : '' ;?> value="AD">Andorra</option>
	<option<?=$country == 'AO' ? ' selected="selected"' : '' ;?> value="AO">Angola</option>
	<option<?=$country == 'AI' ? ' selected="selected"' : '' ;?> value="AI">Anguilla</option>
	<option<?=$country == 'AQ' ? ' selected="selected"' : '' ;?> value="AQ">Antarctica</option>
	<option<?=$country == 'AB' ? ' selected="selected"' : '' ;?> value="AB">Antigua and Barbuda</option>
	<option<?=$country == 'AR' ? ' selected="selected"' : '' ;?> value="AR">Argentina</option>
	<option<?=$country == 'AM' ? ' selected="selected"' : '' ;?> value="AM">Armenia</option>
	<option<?=$country == 'AW' ? ' selected="selected"' : '' ;?> value="AW">Aruba</option>
	<option<?=$country == 'AU' ? ' selected="selected"' : '' ;?> value="AU">Australia</option>
	<option<?=$country == 'AT' ? ' selected="selected"' : '' ;?> value="AT">Austria</option>
	<option<?=$country == 'AZ' ? ' selected="selected"' : '' ;?> value="AZ">Azerbaidjan</option>
	<option<?=$country == 'BS' ? ' selected="selected"' : '' ;?> value="BS">Bahamas</option>
	<option<?=$country == 'BH' ? ' selected="selected"' : '' ;?> value="BH">Bahrain</option>
	<option<?=$country == 'BD' ? ' selected="selected"' : '' ;?> value="BD">Bangladesh</option>
	<option<?=$country == 'BB' ? ' selected="selected"' : '' ;?> value="BB">Barbados</option>
	<option<?=$country == 'BY' ? ' selected="selected"' : '' ;?> value="BY">Belarus</option>
	<option<?=$country == 'BE' ? ' selected="selected"' : '' ;?> value="BE">Belgium</option>
	<option<?=$country == 'BZ' ? ' selected="selected"' : '' ;?> value="BZ">Belize</option>
	<option<?=$country == 'BJ' ? ' selected="selected"' : '' ;?> value="BJ">Benin</option>
	<option<?=$country == 'BM' ? ' selected="selected"' : '' ;?> value="BM">Bermuda</option>
	<option<?=$country == 'BT' ? ' selected="selected"' : '' ;?> value="BT">Bhutan</option>
	<option<?=$country == 'BO' ? ' selected="selected"' : '' ;?> value="BO">Bolivia</option>
	<option<?=$country == 'BA' ? ' selected="selected"' : '' ;?> value="BA">Bosnia-Herzegovina</option>
	<option<?=$country == 'BW' ? ' selected="selected"' : '' ;?> value="BW">Botswana</option>
	<option<?=$country == 'BV' ? ' selected="selected"' : '' ;?> value="BV">Bouvet Island</option>
	<option<?=$country == 'BR' ? ' selected="selected"' : '' ;?> value="BR">Brazil</option>
	<option<?=$country == 'IO' ? ' selected="selected"' : '' ;?> value="IO">British Indian Ocean Territory</option>
	<option<?=$country == 'BN' ? ' selected="selected"' : '' ;?> value="BN">Brunei Darussalam</option>
	<option<?=$country == 'BG' ? ' selected="selected"' : '' ;?> value="BG">Bulgaria</option>
	<option<?=$country == 'BF' ? ' selected="selected"' : '' ;?> value="BF">Burkina Faso</option>
	<option<?=$country == 'BI' ? ' selected="selected"' : '' ;?> value="BI">Burundi</option>
	<option<?=$country == 'KH' ? ' selected="selected"' : '' ;?> value="KH">Cambodia</option>
	<option<?=$country == 'CM' ? ' selected="selected"' : '' ;?> value="CM">Cameroon</option>
    <option<?=$country == 'CA' ? ' selected="selected"' : '' ;?> value="CA">Canada</option>
	<option<?=$country == 'CV' ? ' selected="selected"' : '' ;?> value="CV">Cape Verde</option>
	<option<?=$country == 'KY' ? ' selected="selected"' : '' ;?> value="KY">Cayman Islands</option>
	<option<?=$country == 'CF' ? ' selected="selected"' : '' ;?> value="CF">Central African Republic</option>
	<option<?=$country == 'TD' ? ' selected="selected"' : '' ;?> value="TD">Chad</option>
	<option<?=$country == 'CL' ? ' selected="selected"' : '' ;?> value="CL">Chile</option>
	<option<?=$country == 'CN' ? ' selected="selected"' : '' ;?> value="CN">China</option>
	<option<?=$country == 'CX' ? ' selected="selected"' : '' ;?> value="CX">Christmas Island</option>
	<option<?=$country == 'CC' ? ' selected="selected"' : '' ;?> value="CC">Cocos (Keeling) Islands</option>
	<option<?=$country == 'CO' ? ' selected="selected"' : '' ;?> value="CO">Colombia</option>
	<option<?=$country == 'KM' ? ' selected="selected"' : '' ;?> value="KM">Comoros</option>
	<option<?=$country == 'CG' ? ' selected="selected"' : '' ;?> value="CG">Congo</option>
	<option<?=$country == 'CK' ? ' selected="selected"' : '' ;?> value="CK">Cook Islands</option>
	<option<?=$country == 'CR' ? ' selected="selected"' : '' ;?> value="CR">Costa Rica</option>
	<option<?=$country == 'HR' ? ' selected="selected"' : '' ;?> value="HR">Croatia</option>
	<option<?=$country == 'CU' ? ' selected="selected"' : '' ;?> value="CU">Cuba</option>
	<option<?=$country == 'CY' ? ' selected="selected"' : '' ;?> value="CY">Cyprus</option>
	<option<?=$country == 'CZ' ? ' selected="selected"' : '' ;?> value="CZ">Czech Republic</option>
	<option<?=$country == 'DK' ? ' selected="selected"' : '' ;?> value="DK">Denmark</option>
	<option<?=$country == 'DJ' ? ' selected="selected"' : '' ;?> value="DJ">Djibouti</option>
	<option<?=$country == 'DM' ? ' selected="selected"' : '' ;?> value="DM">Dominica</option>
	<option<?=$country == 'DO' ? ' selected="selected"' : '' ;?> value="DO">Dominican Republic</option>
	<option<?=$country == 'TP' ? ' selected="selected"' : '' ;?> value="TP">East Timor</option>
	<option<?=$country == 'EC' ? ' selected="selected"' : '' ;?> value="EC">Ecuador</option>
	<option<?=$country == 'EG' ? ' selected="selected"' : '' ;?> value="EG">Egypt</option>
	<option<?=$country == 'SV' ? ' selected="selected"' : '' ;?> value="SV">El Salvador</option>
	<option<?=$country == 'GQ' ? ' selected="selected"' : '' ;?> value="GQ">Equatorial Guinea</option>
	<option<?=$country == 'ER' ? ' selected="selected"' : '' ;?> value="ER">Eritrea</option>
	<option<?=$country == 'EE' ? ' selected="selected"' : '' ;?> value="EE">Estonia</option>
	<option<?=$country == 'ET' ? ' selected="selected"' : '' ;?> value="ET">Ethiopia</option>
	<option<?=$country == 'FK' ? ' selected="selected"' : '' ;?> value="FK">Falkland Islands</option>
	<option<?=$country == 'FO' ? ' selected="selected"' : '' ;?> value="FO">Faroe Islands</option>
	<option<?=$country == 'FJ' ? ' selected="selected"' : '' ;?> value="FJ">Fiji</option>
	<option<?=$country == 'FI' ? ' selected="selected"' : '' ;?> value="FI">Finland</option>
	<option<?=$country == 'CS' ? ' selected="selected"' : '' ;?> value="CS">Former Czechoslovakia</option>
	<option<?=$country == 'SU' ? ' selected="selected"' : '' ;?> value="SU">Former USSR</option>
	<option<?=$country == 'FR' ? ' selected="selected"' : '' ;?> value="FR">France</option>
	<option<?=$country == 'FX' ? ' selected="selected"' : '' ;?> value="FX">France (European Territory)</option>
	<option<?=$country == 'GF' ? ' selected="selected"' : '' ;?> value="GF">French Guyana</option>
	<option<?=$country == 'TF' ? ' selected="selected"' : '' ;?> value="TF">French Southern Territories</option>
	<option<?=$country == 'GA' ? ' selected="selected"' : '' ;?> value="GA">Gabon</option>
	<option<?=$country == 'GM' ? ' selected="selected"' : '' ;?> value="GM">Gambia</option>
	<option<?=$country == 'GE' ? ' selected="selected"' : '' ;?> value="GE">Georgia</option>
	<option<?=$country == 'DE' ? ' selected="selected"' : '' ;?> value="DE">Germany</option>
	<option<?=$country == 'GH' ? ' selected="selected"' : '' ;?> value="GH">Ghana</option>
	<option<?=$country == 'GI' ? ' selected="selected"' : '' ;?> value="GI">Gibraltar</option>
	<option<?=$country == 'GB' ? ' selected="selected"' : '' ;?> value="GB">Great Britain</option>
	<option<?=$country == 'GR' ? ' selected="selected"' : '' ;?> value="GR">Greece</option>
	<option<?=$country == 'GL' ? ' selected="selected"' : '' ;?> value="GL">Greenland</option>
	<option<?=$country == 'GD' ? ' selected="selected"' : '' ;?> value="GD">Grenada</option>
	<option<?=$country == 'GP' ? ' selected="selected"' : '' ;?> value="GP">Guadeloupe (French)</option>
	<option<?=$country == 'GU' ? ' selected="selected"' : '' ;?> value="GU">Guam (USA)</option>
	<option<?=$country == 'GT' ? ' selected="selected"' : '' ;?> value="GT">Guatemala</option>
	<option<?=$country == 'GN' ? ' selected="selected"' : '' ;?> value="GN">Guinea</option>
	<option<?=$country == 'GW' ? ' selected="selected"' : '' ;?> value="GW">Guinea Bissau</option>
	<option<?=$country == 'GY' ? ' selected="selected"' : '' ;?> value="GY">Guyana</option>
	<option<?=$country == 'HT' ? ' selected="selected"' : '' ;?> value="HT">Haiti</option>
	<option<?=$country == 'HM' ? ' selected="selected"' : '' ;?> value="HM">Heard and McDonald Islands</option>
	<option<?=$country == 'HN' ? ' selected="selected"' : '' ;?> value="HN">Honduras</option>
	<option<?=$country == 'HK' ? ' selected="selected"' : '' ;?> value="HK">Hong Kong</option>
	<option<?=$country == 'HU' ? ' selected="selected"' : '' ;?> value="HU">Hungary</option>
	<option<?=$country == 'IS' ? ' selected="selected"' : '' ;?> value="IS">Iceland</option>
	<option<?=$country == 'IN' ? ' selected="selected"' : '' ;?> value="IN">India</option>
	<option<?=$country == 'ID' ? ' selected="selected"' : '' ;?> value="ID">Indonesia</option>
	<option<?=$country == 'INT' ? ' selected="selected"' : '' ;?> value="INT">International</option>
	<option<?=$country == 'IR' ? ' selected="selected"' : '' ;?> value="IR">Iran</option>
	<option<?=$country == 'IQ' ? ' selected="selected"' : '' ;?> value="IQ">Iraq</option>
	<option<?=$country == 'IE' ? ' selected="selected"' : '' ;?> value="IE">Ireland</option>
	<option<?=$country == 'IL' ? ' selected="selected"' : '' ;?> value="IL">Israel</option>
	<option<?=$country == 'IT' ? ' selected="selected"' : '' ;?> value="IT">Italy</option>
	<option<?=$country == 'CI' ? ' selected="selected"' : '' ;?> value="CI">Ivory Coast (Cote D&#39;Ivoire)</option>
	<option<?=$country == 'JM' ? ' selected="selected"' : '' ;?> value="JM">Jamaica</option>
	<option<?=$country == 'JP' ? ' selected="selected"' : '' ;?> value="JP">Japan</option>
	<option<?=$country == 'JO' ? ' selected="selected"' : '' ;?> value="JO">Jordan</option>
	<option<?=$country == 'KZ' ? ' selected="selected"' : '' ;?> value="KZ">Kazakhstan</option>
	<option<?=$country == 'KE' ? ' selected="selected"' : '' ;?> value="KE">Kenya</option>
	<option<?=$country == 'KI' ? ' selected="selected"' : '' ;?> value="KI">Kiribati</option>
	<option<?=$country == 'KW' ? ' selected="selected"' : '' ;?> value="KW">Kuwait</option>
	<option<?=$country == 'KG' ? ' selected="selected"' : '' ;?> value="KG">Kyrgyzstan</option>
	<option<?=$country == 'LA' ? ' selected="selected"' : '' ;?> value="LA">Laos</option>
	<option<?=$country == 'LV' ? ' selected="selected"' : '' ;?> value="LV">Latvia</option>
	<option<?=$country == 'LB' ? ' selected="selected"' : '' ;?> value="LB">Lebanon</option>
	<option<?=$country == 'LS' ? ' selected="selected"' : '' ;?> value="LS">Lesotho</option>
	<option<?=$country == 'LR' ? ' selected="selected"' : '' ;?> value="LR">Liberia</option>
	<option<?=$country == 'LY' ? ' selected="selected"' : '' ;?> value="LY">Libya</option>
	<option<?=$country == 'LI' ? ' selected="selected"' : '' ;?> value="LI">Liechtenstein</option>
	<option<?=$country == 'LT' ? ' selected="selected"' : '' ;?> value="LT">Lithuania</option>
	<option<?=$country == 'LU' ? ' selected="selected"' : '' ;?> value="LU">Luxembourg</option>
	<option<?=$country == 'MO' ? ' selected="selected"' : '' ;?> value="MO">Macau</option>
	<option<?=$country == 'MK' ? ' selected="selected"' : '' ;?> value="MK">Macedonia</option>
	<option<?=$country == 'MG' ? ' selected="selected"' : '' ;?> value="MG">Madagascar</option>
	<option<?=$country == 'MW' ? ' selected="selected"' : '' ;?> value="MW">Malawi</option>
	<option<?=$country == 'MY' ? ' selected="selected"' : '' ;?> value="MY">Malaysia</option>
	<option<?=$country == 'MV' ? ' selected="selected"' : '' ;?> value="MV">Maldives</option>
	<option<?=$country == 'ML' ? ' selected="selected"' : '' ;?> value="ML">Mali</option>
	<option<?=$country == 'MT' ? ' selected="selected"' : '' ;?> value="MT">Malta</option>
	<option<?=$country == 'MH' ? ' selected="selected"' : '' ;?> value="MH">Marshall Islands</option>
	<option<?=$country == 'MQ' ? ' selected="selected"' : '' ;?> value="MQ">Martinique (French)</option>
	<option<?=$country == 'MR' ? ' selected="selected"' : '' ;?> value="MR">Mauritania</option>
	<option<?=$country == 'MU' ? ' selected="selected"' : '' ;?> value="MU">Mauritius</option>
	<option<?=$country == 'YT' ? ' selected="selected"' : '' ;?> value="YT">Mayotte</option>
	<option<?=$country == 'MX' ? ' selected="selected"' : '' ;?> value="MX">Mexico</option>
	<option<?=$country == 'FM' ? ' selected="selected"' : '' ;?> value="FM">Micronesia</option>
	<option<?=$country == 'MD' ? ' selected="selected"' : '' ;?> value="MD">Moldavia</option>
	<option<?=$country == 'MC' ? ' selected="selected"' : '' ;?> value="MC">Monaco</option>
	<option<?=$country == 'MN' ? ' selected="selected"' : '' ;?> value="MN">Mongolia</option>
	<option<?=$country == 'MS' ? ' selected="selected"' : '' ;?> value="MS">Montserrat</option>
	<option<?=$country == 'MA' ? ' selected="selected"' : '' ;?> value="MA">Morocco</option>
	<option<?=$country == 'MZ' ? ' selected="selected"' : '' ;?> value="MZ">Mozambique</option>
	<option<?=$country == 'MM' ? ' selected="selected"' : '' ;?> value="MM">Myanmar</option>
	<option<?=$country == 'NA' ? ' selected="selected"' : '' ;?> value="NA">Namibia</option>
	<option<?=$country == 'NR' ? ' selected="selected"' : '' ;?> value="NR">Nauru</option>
	<option<?=$country == 'NP' ? ' selected="selected"' : '' ;?> value="NP">Nepal</option>
	<option<?=$country == 'NL' ? ' selected="selected"' : '' ;?> value="NL">Netherlands</option>
	<option<?=$country == 'AN' ? ' selected="selected"' : '' ;?> value="AN">Netherlands Antilles</option>
	<option<?=$country == 'NT' ? ' selected="selected"' : '' ;?> value="NT">Neutral Zone</option>
	<option<?=$country == 'NC' ? ' selected="selected"' : '' ;?> value="NC">New Caledonia (French)</option>
	<option<?=$country == 'NZ' ? ' selected="selected"' : '' ;?> value="NZ">New Zealand</option>
	<option<?=$country == 'NI' ? ' selected="selected"' : '' ;?> value="NI">Nicaragua</option>
	<option<?=$country == 'NE' ? ' selected="selected"' : '' ;?> value="NE">Niger</option>
	<option<?=$country == 'NG' ? ' selected="selected"' : '' ;?> value="NG">Nigeria</option>
	<option<?=$country == 'NU' ? ' selected="selected"' : '' ;?> value="NU">Niue</option>
	<option<?=$country == 'NF' ? ' selected="selected"' : '' ;?> value="NF">Norfolk Island</option>
	<option<?=$country == 'KP' ? ' selected="selected"' : '' ;?> value="KP">North Korea</option>
	<option<?=$country == 'MP' ? ' selected="selected"' : '' ;?> value="MP">Northern Mariana Islands</option>
	<option<?=$country == 'NO' ? ' selected="selected"' : '' ;?> value="NO">Norway</option>
	<option<?=$country == 'OM' ? ' selected="selected"' : '' ;?> value="OM">Oman</option>
	<option<?=$country == 'PK' ? ' selected="selected"' : '' ;?> value="PK">Pakistan</option>
	<option<?=$country == 'PW' ? ' selected="selected"' : '' ;?> value="PW">Palau</option>
	<option<?=$country == 'PA' ? ' selected="selected"' : '' ;?> value="PA">Panama</option>
	<option<?=$country == 'PG' ? ' selected="selected"' : '' ;?> value="PG">Papua New Guinea</option>
	<option<?=$country == 'PY' ? ' selected="selected"' : '' ;?> value="PY">Paraguay</option>
	<option<?=$country == 'PE' ? ' selected="selected"' : '' ;?> value="PE">Peru</option>
	<option<?=$country == 'PH' ? ' selected="selected"' : '' ;?> value="PH">Philippines</option>
	<option<?=$country == 'PN' ? ' selected="selected"' : '' ;?> value="PN">Pitcairn Island</option>
	<option<?=$country == 'PL' ? ' selected="selected"' : '' ;?> value="PL">Poland</option>
	<option<?=$country == 'PF' ? ' selected="selected"' : '' ;?> value="PF">Polynesia (French)</option>
	<option<?=$country == 'PT' ? ' selected="selected"' : '' ;?> value="PT">Portugal</option>
	<option<?=$country == 'PR' ? ' selected="selected"' : '' ;?> value="PR">Puerto Rico</option>
	<option<?=$country == 'QA' ? ' selected="selected"' : '' ;?> value="QA">Qatar</option>
	<option<?=$country == 'RE' ? ' selected="selected"' : '' ;?> value="RE">Reunion (French)</option>
	<option<?=$country == 'RO' ? ' selected="selected"' : '' ;?> value="RO">Romania</option>
	<option<?=$country == 'RU' ? ' selected="selected"' : '' ;?> value="RU">Russian Federation</option>
	<option<?=$country == 'RW' ? ' selected="selected"' : '' ;?> value="RW">Rwanda</option>
	<option<?=$country == 'GS' ? ' selected="selected"' : '' ;?> value="GS">S. Georgia & S. Sandwich Isls.</option>
	<option<?=$country == 'SH' ? ' selected="selected"' : '' ;?> value="SH">Saint Helena</option>
	<option<?=$country == 'KN' ? ' selected="selected"' : '' ;?> value="KN">Saint Kitts & Nevis Anguilla</option>
	<option<?=$country == 'LC' ? ' selected="selected"' : '' ;?> value="LC">Saint Lucia</option>
	<option<?=$country == 'PM' ? ' selected="selected"' : '' ;?> value="PM">Saint Pierre and Miquelon</option>
	<option<?=$country == 'ST' ? ' selected="selected"' : '' ;?> value="ST">Saint Tome (Sao Tome) and Principe</option>
	<option<?=$country == 'VC' ? ' selected="selected"' : '' ;?> value="VC">Saint Vincent & Grenadines</option>
	<option<?=$country == 'WS' ? ' selected="selected"' : '' ;?> value="WS">Samoa</option>
	<option<?=$country == 'SM' ? ' selected="selected"' : '' ;?> value="SM">San Marino</option>
	<option<?=$country == 'SA' ? ' selected="selected"' : '' ;?> value="SA">Saudi Arabia</option>
	<option<?=$country == 'SN' ? ' selected="selected"' : '' ;?> value="SN">Senegal</option>
	<option<?=$country == 'SC' ? ' selected="selected"' : '' ;?> value="SC">Seychelles</option>
	<option<?=$country == 'SL' ? ' selected="selected"' : '' ;?> value="SL">Sierra Leone</option>
	<option<?=$country == 'SG' ? ' selected="selected"' : '' ;?> value="SG">Singapore</option>
	<option<?=$country == 'SK' ? ' selected="selected"' : '' ;?> value="SK">Slovak Republic</option>
	<option<?=$country == 'SI' ? ' selected="selected"' : '' ;?> value="SI">Slovenia</option>
	<option<?=$country == 'SB' ? ' selected="selected"' : '' ;?> value="SB">Solomon Islands</option>
	<option<?=$country == 'SO' ? ' selected="selected"' : '' ;?> value="SO">Somalia</option>
	<option<?=$country == 'ZA' ? ' selected="selected"' : '' ;?> value="ZA">South Africa</option>
	<option<?=$country == 'KR' ? ' selected="selected"' : '' ;?> value="KR">South Korea</option>
	<option<?=$country == 'ES' ? ' selected="selected"' : '' ;?> value="ES">Spain</option>
	<option<?=$country == 'LK' ? ' selected="selected"' : '' ;?> value="LK">Sri Lanka</option>
	<option<?=$country == 'SD' ? ' selected="selected"' : '' ;?> value="SD">Sudan</option>
	<option<?=$country == 'SR' ? ' selected="selected"' : '' ;?> value="SR">Suriname</option>
	<option<?=$country == 'SJ' ? ' selected="selected"' : '' ;?> value="SJ">Svalbard and Jan Mayen Islands</option>
	<option<?=$country == 'SZ' ? ' selected="selected"' : '' ;?> value="SZ">Swaziland</option>
	<option<?=$country == 'SE' ? ' selected="selected"' : '' ;?> value="SE">Sweden</option>
	<option<?=$country == 'CH' ? ' selected="selected"' : '' ;?> value="CH">Switzerland</option>
	<option<?=$country == 'SY' ? ' selected="selected"' : '' ;?> value="SY">Syria</option>
	<option<?=$country == 'TJ' ? ' selected="selected"' : '' ;?> value="TJ">Tadjikistan</option>
	<option<?=$country == 'TW' ? ' selected="selected"' : '' ;?> value="TW">Taiwan</option>
	<option<?=$country == 'TZ' ? ' selected="selected"' : '' ;?> value="TZ">Tanzania</option>
	<option<?=$country == 'TH' ? ' selected="selected"' : '' ;?> value="TH">Thailand</option>
	<option<?=$country == 'TG' ? ' selected="selected"' : '' ;?> value="TG">Togo</option>
	<option<?=$country == 'TK' ? ' selected="selected"' : '' ;?> value="TK">Tokelau</option>
	<option<?=$country == 'TO' ? ' selected="selected"' : '' ;?> value="TO">Tonga</option>
	<option<?=$country == 'TT' ? ' selected="selected"' : '' ;?> value="TT">Trinidad and Tobago</option>
	<option<?=$country == 'TN' ? ' selected="selected"' : '' ;?> value="TN">Tunisia</option>
	<option<?=$country == 'TR' ? ' selected="selected"' : '' ;?> value="TR">Turkey</option>
	<option<?=$country == 'TM' ? ' selected="selected"' : '' ;?> value="TM">Turkmenistan</option>
	<option<?=$country == 'TC' ? ' selected="selected"' : '' ;?> value="TC">Turks and Caicos Islands</option>
	<option<?=$country == 'TV' ? ' selected="selected"' : '' ;?> value="TV">Tuvalu</option>
	<option<?=$country == 'UG' ? ' selected="selected"' : '' ;?> value="UG">Uganda</option>
	<option<?=$country == 'UA' ? ' selected="selected"' : '' ;?> value="UA">Ukraine</option>
	<option<?=$country == 'AE' ? ' selected="selected"' : '' ;?> value="AE">United Arab Emirates</option>
	<option<?=$country == 'GB' ? ' selected="selected"' : '' ;?> value="GB">United Kingdom</option>
    <option<?=$country == 'US' ? ' selected="selected"' : '' ;?> value="US">United States</option>
	<option<?=$country == 'UY' ? ' selected="selected"' : '' ;?> value="UY">Uruguay</option>
	<option<?=$country == 'MIL' ? ' selected="selected"' : '' ;?> value="MIL">USA Military</option>
	<option<?=$country == 'UM' ? ' selected="selected"' : '' ;?> value="UM">USA Minor Outlying Islands</option>
	<option<?=$country == 'UZ' ? ' selected="selected"' : '' ;?> value="UZ">Uzbekistan</option>
	<option<?=$country == 'YU' ? ' selected="selected"' : '' ;?> value="VU">Vanuatu</option>
	<option<?=$country == 'VA' ? ' selected="selected"' : '' ;?> value="VA">Vatican City State</option>
	<option<?=$country == 'VE' ? ' selected="selected"' : '' ;?> value="VE">Venezuela</option>
	<option<?=$country == 'VN' ? ' selected="selected"' : '' ;?> value="VN">Vietnam</option>
	<option<?=$country == 'VG' ? ' selected="selected"' : '' ;?> value="VG">Virgin Islands (British)</option>
	<option<?=$country == 'VI' ? ' selected="selected"' : '' ;?> value="VI">Virgin Islands (USA)</option>
	<option<?=$country == 'WF' ? ' selected="selected"' : '' ;?> value="WF">Wallis and Futuna Islands</option>
	<option<?=$country == 'EH' ? ' selected="selected"' : '' ;?> value="EH">Western Sahara</option>
	<option<?=$country == 'YE' ? ' selected="selected"' : '' ;?> value="YE">Yemen</option>
	<option<?=$country == 'YU' ? ' selected="selected"' : '' ;?> value="YU">Yugoslavia</option>
	<option<?=$country == 'ZR' ? ' selected="selected"' : '' ;?> value="ZR">Zaire</option>
	<option<?=$country == 'ZM' ? ' selected="selected"' : '' ;?> value="ZM">Zambia</option>
	<option<?=$country == 'ZW' ? ' selected="selected"' : '' ;?> value="ZW">Zimbabwe</option>
</select>
<?
}

?>