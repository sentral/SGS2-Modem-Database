<?

include_once("config.php");
include_once("dbutils.php");
include_once("logging.php");
include_once("consts.php");
include_once("verify.php");

?>

	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	  <head>
	    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link type="text/css" rel="stylesheet" media="all" href="styles/style.css">
		<style type="text/css">
		body {
			background: transparent url('images/bgtile.jpg') repeat-x;
			font-family: Arial, sans-serif;
			font-size: 13px;    /* 13px */
			line-height: 1.461em;    /* 19px */
		}
		
		.ui-button { margin-left: -1px; }
		.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
		.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }

		</style>
		<script src="http://code.jquery.com/jquery.min.js"></script>
        <script src="scripts/jquery-ui-1.8.18.custom.min.js"></script>
        <script src="scripts/jquery_combobox.js"></script>
		<link rel="stylesheet" href="styles/black-tie/jquery-ui-1.8.18.custom.css" type="text/css">
        <script type="text/javascript" src="scripts/jquery.form.js?v2.43"></script>
        <script type="text/javascript" src="scripts/index_jquery.js"></script>
	  </head>
	  <body>
        <div id="container">
          <div id="header">
            <div id="logo-wrapper">
              <div id="logo"></div>
              <h1 class="site-name"><a href="/modemdb/" title="Startseite"><img src="images/sitelogo.png" alt="Startseite"> Modem Database</a></h1>
            </div>
            <!-- /logo-wrapper-->
          </div>

          <div id="displaybody">
		    <div id="query">
			  <form id="query-main" action="query_db.php" method="POST">
			    <table>
				  <tr>
				    <td colspan="2">
						Modem:&nbsp;
						<select name="modem">
						  <option value="NULL">Select...</option>
						  <? tableToSelect($dbt_modem, "modem_id", "modem", "modem", "approved = 'X'"); ?>
						</select>
						Firmware:&nbsp;
						<select name="firmware">
						  <option value="NULL">Select...</option>
						  <? tableToSelect($dbt_firmware, "fw_id", "firmware", "firmware", "approved = 'X'"); ?>
						</select>
						Kernel:&nbsp;
						<select name="kernel">
						  <option value="NULL">Select...</option>
						  <? tableToSelect($dbt_kernel, "krnl_id", "kernel", "kernel", "approved = 'X'"); ?>
						</select>
						Provider:&nbsp;
						<select name="provider">
						  <option value="NULL">Select...</option>
						  <? tableToSelect($dbt_provider, "provid", "provider", "provid", "approved = 'X'"); ?>
						</select>
				    </td>
				  </tr>
				  <tr>
				    <td>
					  <button id="query_db">Query DB</button>
					  <!--
					  <input type="submit" value="Query DB">
					  -->
					</td>
				    <td style="text-align: right;">
					  <button id="add_db">Add entry</button>
					  <!--
					  <input type="button" id="add_db" value="Add Entry">
					  -->
					</td>
				  </tr>
				</table>
			  </form>
			</div>
		    <div id="content">
			  Willkommen auf der Modem-Datenbank f&uuml;r das Samsung Galaxy S2.
			  <? dumpLog(); ?>
<?
if ($_REQUEST["vkey"]) {
	if (approve($_REQUEST["vkey"])) {
?>
			  Dein Eintrag wurde freigeschaltet.
<?
	}
	else {
?>
			  Dieser Eintrag kann nicht mehr freigeschaltet werden.
<?
	}
}
?>
			</div>
	      </div>
	    </div>
	  </body>
	</html>
