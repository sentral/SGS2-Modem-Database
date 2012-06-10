<?

include_once("dbconnect.php");
include_once("logging.php");

function tableToSelectM($dbtable, $dbColForValue, array $dbColForOption, $orderByCol = "", $whereClause = "") {
	connect();
	
	$sqlDbColsForDisplay = "";
	// loop through the display columns for select control / combobox
	foreach ($dbColForOption as $col) {
		$sqlDbColsForDisplay .= ", ". $col;
	}
	
	$sql = "SELECT ". $dbColForValue . $sqlDbColsForDisplay ." FROM ". $dbtable;
	if ($whereClause != "") {
		$sql .= " WHERE ". $whereClause;
	}
	if ($orderByCol != "") {
		$sql .= " ORDER BY ". $orderByCol;
	}
	$sql .= ";";
	
	//logMessage("tableToSelect: ". $sql);
	
	$result = mysql_query($sql) or die("Fehler bei Abfrage >". $sql ."< : ". mysql_errno ." (". mysql_error() .")");

	if ($result && mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_array($result)) {
			// assemble the columns to be displayed to a string of "... / ... / ..."
			$display = "";
			// count($row) delivered crapy values - use the parameter array instead + 1 for considering $dbColForValue in result
			$cnt = count($dbColForOption) + 1;
			for ($i = 1; $i < $cnt; $i++) {
				$display .= $row[$i];
				if ($i + 1 < $cnt) {
					$display .= " / ";
				}
			}
			$strOption = "<option value=\"". $row[0] ."\">". $display ."</option>\n";
			//logMessage("tableToSelect: ". htmlspecialchars($strOption));
			print $strOption;
		}
	}
	
	disconnect();
}

function tableToSelect($dbtable, $dbColForValue, $dbColForOption, $orderByCol = "", $whereClause = "") {
	tableToSelectM($dbtable, $dbColForValue, array($dbColForOption), $orderByCol, $whereClause);
}

//
// Transforms a resultset into a HTML table structure with the opportunity to expand certain columns by its index to values
//
// param $resultSet			:	the resultset from a query to the database performed before the call
// param $displayColumns	:	an array of pairs of technical column names to displayed column names
//									array( /TechnicalName/ => /DisplayName/, ... )
// param $expandColumns		:	an array of pairs of technical column names to be expanded and an array of database retrieval information
//									array( /TechnicalName/ => array( /DataTableName/, /TechnicalNameIndexColumn/, array( /Col1/, /Col2/, ... ) ), ... )
//
function resultToTable($resultSet, array $displayColumns, array $expandColumns = null) {
	$expandedColumnsCache = null;
	// setup the cache for sub-tables
	if ($expandColumns != null) {
		logMessage("resultToTable: there are columns to be expanded");
		$keys = array_keys($expandColumns);
		foreach ($keys as $k) {
			logMessage("resultToTable: column to be expanded >". $k ."<");
			$expandedColumnsCache[$k] = array();
		}
	}
	
	$columnHeaders = array_values($displayColumns);
	print "<table>\n<tr>\n";
	foreach ($columnHeaders as $ch) {
		print "<th>". $ch ."</th>\n";
	}
	print "</tr>\n<tr>\n";
	
	while ($row = mysql_fetch_assoc($resultSet)) {
		foreach ($displayColumns as $technicalCol => $displayCol) {
			// look for a possible expansion of the current db column
			if ($expandColumns[$technicalCol]) {
				$dbInfoToFetch = $expandColumns[$technicalCol];
				// if the data has not been cached, yet retrieve it and store it in the cache
				if (!$expandedColumnsCache[$technicalCol]) {
					logMessage("resultToTable: fetching and caching data for column >". $technicalCol ."<");
					$expandedColumnsCache[$technicalCol] = tableToArray($dbInfoToFetch[0], $dbInfoToFetch[1], $dbInfoToFetch[2]);
				}
				
				print "<td>". $expandedColumnsCache[$technicalCol][$row[$technicalCol]] ."</td>\n";
			}
			else {
				print "<td>". $row[$technicalCol] ."</td>\n";
			}
		}
		print "</tr><tr>\n";
	}
	
	print "</tr>\n</table>\n";
}

//
// Retrieves datatable contents from a given table with one specific index and a bunch of columns into an array
//
// param $dbtable	:	the datatable to get the data from
// param $idxCol	:	the index column technical name
// param $columns	:	an array of columns to retrieve. If multiple columns are given they will be concatenated via "/"
//
// return			:	an array of the format array( /IndexColumnValue/ => /CellValue/ ), ... )
//
function tableToArray($dbtable, $idxCol, $columns) {
	$ret = array();
	$sql = "SELECT ". $idxCol;
	
	foreach ($columns as $c) {
		$sql .= ", ". $c;
	}
	
	$sql .= " FROM ". $dbtable .";";
	logMessage("tableToArray: ". $sql);
	$result = mysql_query($sql) or die("Fehler bei Abfrage >". $sql ."< : ". mysql_errno ." (". mysql_error() .")");

	if ($result && mysql_num_rows($result) > 0) {
		while ($row = mysql_fetch_assoc($result)) {
			foreach ($columns as $c) {
				logMessage("tableToArray: \$c >". $c ."<, \$idxCol >". $idxCol ."<, \$row[\$idxCol] >". $row[$idxCol] ."<, \$row[\$c] >". $row[$c] ."<");
				if ($ret[$row[$idxCol]] && $ret[$row[$idxCol]] != "") {
					$ret[$row[$idxCol]] .= " / ". $row[$c];
				}
				else {
					$ret[$row[$idxCol]] = $row[$c];
				}
			}
		}
	}
	
	return $ret;
}

?>