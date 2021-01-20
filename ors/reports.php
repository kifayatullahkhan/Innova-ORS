<?php require_once('Connections/conn.php'); ?>
<?php require_once '../admin/access_restrictions.php'; ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conn, $conn);
$query_RS_Month = "SELECT * FROM dt_months";
$RS_Month = mysql_query($query_RS_Month, $conn) or die(mysql_error());
$row_RS_Month = mysql_fetch_assoc($RS_Month);
$totalRows_RS_Month = mysql_num_rows($RS_Month);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-6" />
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
	<link rel="stylesheet" type="text/css" href="gnpcss.css" media="screen" />
    <title>Innova ORS Reporting</title>
</head>
<body>
<div align="center">
  <table border="0" cellpadding="0" cellspacing="0" width="1000">
    <tbody><tr>
      <td class="PageTopHeader" align="left" height="180" valign="middle" width="1000"><img src="images/header_logo.jpg" width="1000" height="250" /></td>
    </tr>
    <tr>
      <td align="left" height="40" valign="middle" width="1000"><?php
				require("top_menu.php");
				?>        <br style="clear: left;" /></td>
    </tr>
    <tr>
      <td><table border="0" cellpadding="0" cellspacing="0" width="1000">
          <tbody><tr>
            <td width="179" height="653" align="left" valign="top"><?php
				require("left_menu.php");
				?>
			<div>
			  <div align="center"></div>
			</div>			</td>
            <td align="left" valign="top" width="652"><div align="center">
              <p>&nbsp;</p>
              <table width="100%" border="0" cellspacing="0" cellpadding="1">
                <tr>
                  <td>                        <fieldset>
                        <legend>Search</legend>
                          <ol>
                          <li>
                            <label for="name">Income Statment for current Month</label>
                            <a href="report_incomestatement.php"><img src="images/icons/b_search.png" width="16" height="16" /></a><br />
                            </li>
                          </ol>
                        </fieldset></td></tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><form action="report_incomestatement.php" method="get">
                      <fieldset>
                      <legend>Search</legend>
                        <ol>
                        <li>
                          <label for="name">Income Statement for the Month</label>
                          <br />
                          <select name="month" class="DatePickers" id="month">
                            <?php
do {  
?>
                            <option value="<?php echo $row_RS_Month['month_dgt']?>"><?php echo $row_RS_Month['month_title']." - ".date('Y');?></option>
                            <?php
} while ($row_RS_Month = mysql_fetch_assoc($RS_Month));
  $rows = mysql_num_rows($RS_Month);
  if($rows > 0) {
      mysql_data_seek($RS_Month, 0);
	  $row_RS_Month = mysql_fetch_assoc($RS_Month);
  }
?>
                                                    </select>
                          <input name="cmdSearch2" type="image" id="cmdSearch2" src="images/icons/b_search.png" alt="[Search]" />
                        </li>
                        </ol>
                        </fieldset>
                  </form></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><form action="report_incomestatement.php" method="get">
                      <fieldset>
                      <legend>Search</legend>
                        <ol>
                        <li>
                          <label for="name">Income Statement </label>
                          for the Year<br />
                          <select name="year" class="DatePickers" id="year">
                            <?php
							  for ($year=date("Y");$year>=2008;$year--)
									echo "<option value=\"$year\">$year</option>";
								?>
                                                    </select>
                          <input name="cmdSearch3" type="image" id="cmdSearch3" src="images/icons/b_search.png" alt="[Search]" />
                        </li>
                        </ol>
                        </fieldset>
                  </form></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><form action="report_incomestatement.php" method="get">
                      <fieldset>
                      <legend>Search</legend>
                        <ol>
                        <li>Income Statement between these 
                          <label for="name"> Dates:</label>
                          <br />
                          Start Date:&nbsp;<br />
                          <label>
                            <select name="start_day" class="DatePickers" id="start_day">
                              <?php
							  for ($day=1;$day<=31;$day++)
									echo "<option value=\"$day\">$day</option>";
								?>
                            </select>
                            </label>
                          <select name="start_month" class="DatePickers" id="start_month">
                            <option value="01">JAN</option>
                            <option value="02">FEB</option>
                            <option value="03">MAR</option>
                            <option value="04">APR</option>
                            <option value="05">MAY</option>
                            <option value="06">JUN</option>
                            <option value="07">JUL</option>
                            <option value="08">AUG</option>
                            <option value="09">SEP</option>
                            <option value="10">OCT</option>
                            <option value="11">NOV</option>
                            <option value="12">DEC</option>
                          </select>
                          <select name="start_year" class="DatePickers" id="start_year">
                            <?php
							  for ($year=date("Y");$year>=2008;$year--)
									echo "<option value=\"$year\">$year</option>";
								?>
                          </select>
                          <br />
                          End&nbsp;&nbsp;&nbsp;Date:&nbsp;<br />
                          <select name="end_day" class="DatePickers" id="end_day">
                            <?php
							  for ($day=1;$day<=31;$day++)
									echo "<option value=\"$day\">$day</option>";
								?>
                          </select>
                          </label>
                          <select name="end_month" class="DatePickers" id="end_month">
                            <option value="01">JAN</option>
                            <option value="02">FEB</option>
                            <option value="03">MAR</option>
                            <option value="04">APR</option>
                            <option value="05">MAY</option>
                            <option value="06">JUN</option>
                            <option value="07">JUL</option>
                            <option value="08">AUG</option>
                            <option value="09">SEP</option>
                            <option value="10">OCT</option>
                            <option value="11">NOV</option>
                            <option value="12">DEC</option>
                          </select>
                          <select name="end_year" class="DatePickers" id="end_year">
                            <?php
							  for ($year=date("Y");$year>=2008;$year--)
									echo "<option value=\"$year\">$year</option>";
								?>
                          </select>
                          <input name="cmdSearch4" type="image" id="cmdSearch4" src="images/icons/b_search.png" alt="[Search]" />
                        </li>
                        </ol>
                        </fieldset>
                  </form></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table>
              <p>&nbsp;</p>
              <p><br />
              </p>
            </div></td>
            <td align="left" valign="top" width="179"><div id="leftbar">
              <div id="searchBox">
                <p>&nbsp;</p>
                </div>
              </div>              </td>
          </tr>
        </tbody></table></td>
    </tr>
    <tr>
      <td align="right" height="19"><img src="images/kmz_innova.gif" width="80" height="15" /><img src="images/php.gif" alt="PHP|Powered" height="15" width="80" /></td>
    </tr>
    <tr>
      <td><?php
				require("footer.php");
				?></td>
    </tr>
  </tbody></table>
</div>

</body>
</html>
<?php
mysql_free_result($RS_Month);
?>