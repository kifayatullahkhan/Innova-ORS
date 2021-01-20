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

$currentPage = $_SERVER["PHP_SELF"];
// ===========================================================
//  Start and End Date Formation
$Start_Date="";
$End_Date="";
if(isset($_GET['start_day'])){
$Start_Date=$_GET['start_year']."-".$_GET['start_month']."-".$_GET['start_day'];
}
if(isset($_GET['end_day'])){
$End_Date=$_GET['end_year']."-".$_GET['end_month']."-".$_GET['end_day'];
}

// ===========================================================
$maxRows_RS_AllClasses = 10;
$pageNum_RS_AllClasses = 0;
if (isset($_GET['pageNum_RS_AllClasses'])) {
  $pageNum_RS_AllClasses = $_GET['pageNum_RS_AllClasses'];
}
$startRow_RS_AllClasses = $pageNum_RS_AllClasses * $maxRows_RS_AllClasses;

mysql_select_db($database_conn, $conn);
$query_RS_AllClasses = "SELECT * FROM classes";
$query_limit_RS_AllClasses = sprintf("%s LIMIT %d, %d", $query_RS_AllClasses, $startRow_RS_AllClasses, $maxRows_RS_AllClasses);
$RS_AllClasses = mysql_query($query_limit_RS_AllClasses, $conn) or die(mysql_error());
$row_RS_AllClasses = mysql_fetch_assoc($RS_AllClasses);

if (isset($_GET['totalRows_RS_AllClasses'])) {
  $totalRows_RS_AllClasses = $_GET['totalRows_RS_AllClasses'];
} else {
  $all_RS_AllClasses = mysql_query($query_RS_AllClasses);
  $totalRows_RS_AllClasses = mysql_num_rows($all_RS_AllClasses);
}
$totalPages_RS_AllClasses = ceil($totalRows_RS_AllClasses/$maxRows_RS_AllClasses)-1;

$maxRows_RS_getClassesbyClasscode = 10;
$pageNum_RS_getClassesbyClasscode = 0;
if (isset($_GET['pageNum_RS_getClassesbyClasscode'])) {
  $pageNum_RS_getClassesbyClasscode = $_GET['pageNum_RS_getClassesbyClasscode'];
}
$startRow_RS_getClassesbyClasscode = $pageNum_RS_getClassesbyClasscode * $maxRows_RS_getClassesbyClasscode;

$colname_RS_getClassesbyClasscode = "-1";
if (isset($_GET['class_code'])) {
  $colname_RS_getClassesbyClasscode = $_GET['class_code'];
}
mysql_select_db($database_conn, $conn);
$query_RS_getClassesbyClasscode = sprintf("SELECT * FROM classes WHERE class_code = %s ORDER BY end_date DESC", GetSQLValueString($colname_RS_getClassesbyClasscode, "text"));
$query_limit_RS_getClassesbyClasscode = sprintf("%s LIMIT %d, %d", $query_RS_getClassesbyClasscode, $startRow_RS_getClassesbyClasscode, $maxRows_RS_getClassesbyClasscode);
$RS_getClassesbyClasscode = mysql_query($query_limit_RS_getClassesbyClasscode, $conn) or die(mysql_error());
$row_RS_getClassesbyClasscode = mysql_fetch_assoc($RS_getClassesbyClasscode);

if (isset($_GET['totalRows_RS_getClassesbyClasscode'])) {
  $totalRows_RS_getClassesbyClasscode = $_GET['totalRows_RS_getClassesbyClasscode'];
} else {
  $all_RS_getClassesbyClasscode = mysql_query($query_RS_getClassesbyClasscode);
  $totalRows_RS_getClassesbyClasscode = mysql_num_rows($all_RS_getClassesbyClasscode);
}
$totalPages_RS_getClassesbyClasscode = ceil($totalRows_RS_getClassesbyClasscode/$maxRows_RS_getClassesbyClasscode)-1;

$maxRows_RS_getclassesbyCourseCode = 10;
$pageNum_RS_getclassesbyCourseCode = 0;
if (isset($_GET['pageNum_RS_getclassesbyCourseCode'])) {
  $pageNum_RS_getclassesbyCourseCode = $_GET['pageNum_RS_getclassesbyCourseCode'];
}
$startRow_RS_getclassesbyCourseCode = $pageNum_RS_getclassesbyCourseCode * $maxRows_RS_getclassesbyCourseCode;

$colname_RS_getclassesbyCourseCode = "-1";
if (isset($_GET['course_code'])) {
  $colname_RS_getclassesbyCourseCode = $_GET['course_code'];
}
mysql_select_db($database_conn, $conn);
$query_RS_getclassesbyCourseCode = sprintf("SELECT * FROM classes WHERE course_code = %s ORDER BY end_date DESC", GetSQLValueString($colname_RS_getclassesbyCourseCode, "text"));
$query_limit_RS_getclassesbyCourseCode = sprintf("%s LIMIT %d, %d", $query_RS_getclassesbyCourseCode, $startRow_RS_getclassesbyCourseCode, $maxRows_RS_getclassesbyCourseCode);
$RS_getclassesbyCourseCode = mysql_query($query_limit_RS_getclassesbyCourseCode, $conn) or die(mysql_error());
$row_RS_getclassesbyCourseCode = mysql_fetch_assoc($RS_getclassesbyCourseCode);

if (isset($_GET['totalRows_RS_getclassesbyCourseCode'])) {
  $totalRows_RS_getclassesbyCourseCode = $_GET['totalRows_RS_getclassesbyCourseCode'];
} else {
  $all_RS_getclassesbyCourseCode = mysql_query($query_RS_getclassesbyCourseCode);
  $totalRows_RS_getclassesbyCourseCode = mysql_num_rows($all_RS_getclassesbyCourseCode);
}
$totalPages_RS_getclassesbyCourseCode = ceil($totalRows_RS_getclassesbyCourseCode/$maxRows_RS_getclassesbyCourseCode)-1;

$maxRows_RS_getClassesByActiveStatus = 10;
$pageNum_RS_getClassesByActiveStatus = 0;
if (isset($_GET['pageNum_RS_getClassesByActiveStatus'])) {
  $pageNum_RS_getClassesByActiveStatus = $_GET['pageNum_RS_getClassesByActiveStatus'];
}
$startRow_RS_getClassesByActiveStatus = $pageNum_RS_getClassesByActiveStatus * $maxRows_RS_getClassesByActiveStatus;

$colname_RS_getClassesByActiveStatus = "-1";
if (isset($_GET['active'])) {
  $colname_RS_getClassesByActiveStatus = $_GET['active'];
}
mysql_select_db($database_conn, $conn);
$query_RS_getClassesByActiveStatus = sprintf("SELECT * FROM classes WHERE active = %s ORDER BY end_date DESC", GetSQLValueString($colname_RS_getClassesByActiveStatus, "int"));
$query_limit_RS_getClassesByActiveStatus = sprintf("%s LIMIT %d, %d", $query_RS_getClassesByActiveStatus, $startRow_RS_getClassesByActiveStatus, $maxRows_RS_getClassesByActiveStatus);
$RS_getClassesByActiveStatus = mysql_query($query_limit_RS_getClassesByActiveStatus, $conn) or die(mysql_error());
$row_RS_getClassesByActiveStatus = mysql_fetch_assoc($RS_getClassesByActiveStatus);

if (isset($_GET['totalRows_RS_getClassesByActiveStatus'])) {
  $totalRows_RS_getClassesByActiveStatus = $_GET['totalRows_RS_getClassesByActiveStatus'];
} else {
  $all_RS_getClassesByActiveStatus = mysql_query($query_RS_getClassesByActiveStatus);
  $totalRows_RS_getClassesByActiveStatus = mysql_num_rows($all_RS_getClassesByActiveStatus);
}
$totalPages_RS_getClassesByActiveStatus = ceil($totalRows_RS_getClassesByActiveStatus/$maxRows_RS_getClassesByActiveStatus)-1;

$maxRows_Rs_getClassesBetweenDates = 10;
$pageNum_Rs_getClassesBetweenDates = 0;
if (isset($_GET['pageNum_Rs_getClassesBetweenDates'])) {
  $pageNum_Rs_getClassesBetweenDates = $_GET['pageNum_Rs_getClassesBetweenDates'];
}
$startRow_Rs_getClassesBetweenDates = $pageNum_Rs_getClassesBetweenDates * $maxRows_Rs_getClassesBetweenDates;

mysql_select_db($database_conn, $conn);
$query_Rs_getClassesBetweenDates = "SELECT * FROM classes WHERE start_date >='".$Start_Date."' AND  end_date<='".$Start_Date."' ORDER BY end_date DESC";
$query_limit_Rs_getClassesBetweenDates = sprintf("%s LIMIT %d, %d", $query_Rs_getClassesBetweenDates, $startRow_Rs_getClassesBetweenDates, $maxRows_Rs_getClassesBetweenDates);
$Rs_getClassesBetweenDates = mysql_query($query_limit_Rs_getClassesBetweenDates, $conn) or die(mysql_error());
$row_Rs_getClassesBetweenDates = mysql_fetch_assoc($Rs_getClassesBetweenDates);

if (isset($_GET['totalRows_Rs_getClassesBetweenDates'])) {
  $totalRows_Rs_getClassesBetweenDates = $_GET['totalRows_Rs_getClassesBetweenDates'];
} else {
  $all_Rs_getClassesBetweenDates = mysql_query($query_Rs_getClassesBetweenDates);
  $totalRows_Rs_getClassesBetweenDates = mysql_num_rows($all_Rs_getClassesBetweenDates);
}
$totalPages_Rs_getClassesBetweenDates = ceil($totalRows_Rs_getClassesBetweenDates/$maxRows_Rs_getClassesBetweenDates)-1;

$queryString_RS_AllClasses = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_AllClasses") == false && 
        stristr($param, "totalRows_RS_AllClasses") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_AllClasses = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_AllClasses = sprintf("&totalRows_RS_AllClasses=%d%s", $totalRows_RS_AllClasses, $queryString_RS_AllClasses);

$queryString_RS_getClassesbyClasscode = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_getClassesbyClasscode") == false && 
        stristr($param, "totalRows_RS_getClassesbyClasscode") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_getClassesbyClasscode = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_getClassesbyClasscode = sprintf("&totalRows_RS_getClassesbyClasscode=%d%s", $totalRows_RS_getClassesbyClasscode, $queryString_RS_getClassesbyClasscode);

$queryString_RS_getclassesbyCourseCode = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_getclassesbyCourseCode") == false && 
        stristr($param, "totalRows_RS_getclassesbyCourseCode") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_getclassesbyCourseCode = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_getclassesbyCourseCode = sprintf("&totalRows_RS_getclassesbyCourseCode=%d%s", $totalRows_RS_getclassesbyCourseCode, $queryString_RS_getclassesbyCourseCode);

$queryString_RS_getClassesByActiveStatus = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_getClassesByActiveStatus") == false && 
        stristr($param, "totalRows_RS_getClassesByActiveStatus") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_getClassesByActiveStatus = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_getClassesByActiveStatus = sprintf("&totalRows_RS_getClassesByActiveStatus=%d%s", $totalRows_RS_getClassesByActiveStatus, $queryString_RS_getClassesByActiveStatus);

$queryString_Rs_getClassesBetweenDates = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Rs_getClassesBetweenDates") == false && 
        stristr($param, "totalRows_Rs_getClassesBetweenDates") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Rs_getClassesBetweenDates = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Rs_getClassesBetweenDates = sprintf("&totalRows_Rs_getClassesBetweenDates=%d%s", $totalRows_Rs_getClassesBetweenDates, $queryString_Rs_getClassesBetweenDates);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-6" />
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
	<link rel="stylesheet" type="text/css" href="gnpcss.css" media="screen" />
    <title>Innova ORS</title>
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
      <td><table border="0" cellpadding="0" cellspacing="0">
          <tbody><tr>
            <td width="179" height="653" align="left" valign="top"><?php
				require("left_menu.php");
				?>
			<div>
			  <div align="center"></div>
			</div>			</td>
            <td align="left" valign="top" width="652"><table border="0" cellpadding="0" cellspacing="0">
                <tbody><tr>
                  <td align="left" valign="top" width="280"><form action="<?php echo $currentPage ?>" method="get">
                    <fieldset>
                    <legend>Search</legend>
                      <ol>
                      <li>
                        <label for="name">By class code:</label>
                        <br />
                        <input id="class_code" name="class_code" class="inputText" type="text" />
                        <input name="cmdSearch" type="image" id="cmdSearch" src="images/icons/b_search.png" alt="[Search]" />
                      </li>
                      </ol>
                      </fieldset>
                  </form>                  <p class="TopicHeaderWhtTextWithBG">&nbsp;</p>                    </td>
                  <td align="left" valign="top" width="111">&nbsp;</td>
                  <td align="left" valign="top" width="280"><form action="<?php echo $currentPage ?>" method="get">
                    <fieldset>
                    <legend>Search</legend>
                      <ol>
                      <li>
                        <label for="name">By Course code:</label>
                        <br />
                        <input id="course_code" name="course_code" class="inputText" type="text" />
                        <input name="cmdSearch3" type="image" id="cmdSearch3" src="images/icons/b_search.png" alt="[Search]" />
                      </li>
                      </ol>
                      </fieldset>
                  </form></td>
                </tr>
                  <tr>
                    <td width="280" align="left" valign="top"><form action="<?php echo $currentPage ?>" method="get">
                      <fieldset>
                      <legend>Search</legend>
                        <ol>
                        <li>
                          <label for="name">By  Date:</label>
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
							  for ($year=date("Y");$year>=date("Y")-50;$year--)
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
							  for ($year=date("Y");$year>=date("Y")-50;$year--)
									echo "<option value=\"$year\">$year</option>";
								?>
                          </select>
                          <input name="cmdSearch2" type="image" id="cmdSearch2" src="images/icons/b_search.png" alt="[Search]" />
                          <input name="sort" type="hidden" id="sort" value="<?php echo $_GET['sort'];?>" />
                          <input type="hidden" name="stype" id="stype" value="<?php echo $_GET['stype'];?>"/>
                        </li>
                        </ol>
                        </fieldset>
                    </form></td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td width="280" align="left" valign="top"><form action="<?php echo $currentPage ?>" method="get">
                      <fieldset>
                      <legend>Search</legend>
                        <ol>
                        <li>
                          <label for="name">By Active Status:</label>
                          <br />
                          <select name="active" id="active">
                            <option value="1">Active</option>
                            <option value="0">Deactive</option>
                          </select>
                          <input name="cmdSearch4" type="image" id="cmdSearch4" src="images/icons/b_search.png" alt="[Search]" />
                        </li>
                        </ol>
                        </fieldset>
                    </form>
                      <form action="<?php echo $currentPage ?>" method="get">
                        <fieldset>
                        <legend>Clear Filter</legend>
                          
                          <img src="images/icons/bs_search.gif" width="16" height="16" /> <a href="<?php echo $currentPage; ?>">View All </a>
                        </fieldset>
                      </form>
                      <br /></td>
                  </tr>
                  <tr>
                    <td width="280" align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td width="280" align="left" valign="top">&nbsp;</td>
                  </tr>
              </tbody></table>            
              
              <?php if ($totalRows_RS_getClassesbyClasscode == 0 && $totalRows_RS_getclassesbyCourseCode ==0 &&$totalRows_RS_getClassesByActiveStatus ==0 && $totalRows_Rs_getClassesBetweenDates ==0) { // Show if recordset empty ?>
                <div style="margin:3px">
                  <p>Viewing All Classes</p>
                  <table width="100%" border="0" cellpadding="1" cellspacing="1">
                        <tr class="tabledatakizmo">
                          <td>class_code</td>
                          <td>timing</td>
                          <td>course_code</td>
                          <td>start_date</td>
                          <td>end_date</td>
                          <td>active</td>
                          <td>modified_fee</td>
                        </tr>
                        <?php do { ?>
                          <tr>
                            <td><?php echo $row_RS_AllClasses['class_code']; ?></td>
                            <td><?php echo $row_RS_AllClasses['timing']; ?></td>
                            <td><?php echo $row_RS_AllClasses['course_code']; ?></td>
                            <td><?php echo $row_RS_AllClasses['start_date']; ?></td>
                            <td><?php echo $row_RS_AllClasses['end_date']; ?></td>
                            <td><?php echo $row_RS_AllClasses['active']; ?></td>
                            <td><?php echo $row_RS_AllClasses['modified_fee']; ?></td>
                          </tr>
                          <?php } while ($row_RS_AllClasses = mysql_fetch_assoc($RS_AllClasses)); ?>
                    </table>
                  <div align="center">
                    
                    <table border="0">
                          <tr>
                            <td><?php if ($pageNum_RS_AllClasses > 0) { // Show if not first page ?>
                                      <a href="<?php printf("%s?pageNum_RS_AllClasses=%d%s", $currentPage, 0, $queryString_RS_AllClasses); ?>">First</a>
                                      <?php } // Show if not first page ?>                                                                            </td>
                            <td><?php if ($pageNum_RS_AllClasses > 0) { // Show if not first page ?>
                                      <a href="<?php printf("%s?pageNum_RS_AllClasses=%d%s", $currentPage, max(0, $pageNum_RS_AllClasses - 1), $queryString_RS_AllClasses); ?>">Previous</a>
                                      <?php } // Show if not first page ?>                                                                            </td>
                            <td><?php if ($pageNum_RS_AllClasses < $totalPages_RS_AllClasses) { // Show if not last page ?>
                                      <a href="<?php printf("%s?pageNum_RS_AllClasses=%d%s", $currentPage, min($totalPages_RS_AllClasses, $pageNum_RS_AllClasses + 1), $queryString_RS_AllClasses); ?>">Next</a>
                                      <?php } // Show if not last page ?>                                                                            </td>
                            <td><?php if ($pageNum_RS_AllClasses < $totalPages_RS_AllClasses) { // Show if not last page ?>
                                      <a href="<?php printf("%s?pageNum_RS_AllClasses=%d%s", $currentPage, $totalPages_RS_AllClasses, $queryString_RS_AllClasses); ?>">Last</a>
                                      <?php } // Show if not last page ?>                                                                            </td>
                          </tr>
                                                                </table>
                  </div>
                </div>
                <?php } // Show if recordset empty ?>
<p>&nbsp;</p>
              
              <?php if ($totalRows_RS_getClassesbyClasscode > 0) { // Show if recordset not empty ?>
                <div style="margin:3px">
                  <p>Seearching by Class Code.....</p>
                  <table width="100%" border="0" cellpadding="1" cellspacing="1">
                        <tr class="tabledatakizmo">
                          <td>class_code</td>
                          <td>timing</td>
                          <td>course_code</td>
                          <td>start_date</td>
                          <td>end_date</td>
                          <td>active</td>
                          <td>modified_fee</td>
                        </tr>
                        <?php do { ?>
                      <tr>
                        <td><?php echo $row_RS_getClassesbyClasscode['class_code']; ?></td>
                        <td><?php echo $row_RS_getClassesbyClasscode['timing']; ?></td>
                        <td><?php echo $row_RS_getClassesbyClasscode['course_code']; ?></td>
                        <td><?php echo $row_RS_getClassesbyClasscode['start_date']; ?></td>
                        <td><?php echo $row_RS_getClassesbyClasscode['end_date']; ?></td>
                        <td><?php echo $row_RS_getClassesbyClasscode['active']; ?></td>
                        <td><?php echo $row_RS_getClassesbyClasscode['modified_fee']; ?></td>
                      </tr>
                      <?php } while ($row_RS_getClassesbyClasscode = mysql_fetch_assoc($RS_getClassesbyClasscode)); ?>
                      </table>
                  <div align="center">
                    <table border="0">
                      <tr>
                        <td><?php if ($pageNum_RS_getClassesbyClasscode > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_RS_getClassesbyClasscode=%d%s", $currentPage, 0, $queryString_RS_getClassesbyClasscode); ?>">First</a>
                              <?php } // Show if not first page ?>                        </td>
                        <td><?php if ($pageNum_RS_getClassesbyClasscode > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_RS_getClassesbyClasscode=%d%s", $currentPage, max(0, $pageNum_RS_getClassesbyClasscode - 1), $queryString_RS_getClassesbyClasscode); ?>">Previous</a>
                              <?php } // Show if not first page ?>                        </td>
                        <td><?php if ($pageNum_RS_getClassesbyClasscode < $totalPages_RS_getClassesbyClasscode) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_RS_getClassesbyClasscode=%d%s", $currentPage, min($totalPages_RS_getClassesbyClasscode, $pageNum_RS_getClassesbyClasscode + 1), $queryString_RS_getClassesbyClasscode); ?>">Next</a>
                              <?php } // Show if not last page ?>                        </td>
                        <td><?php if ($pageNum_RS_getClassesbyClasscode < $totalPages_RS_getClassesbyClasscode) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_RS_getClassesbyClasscode=%d%s", $currentPage, $totalPages_RS_getClassesbyClasscode, $queryString_RS_getClassesbyClasscode); ?>">Last</a>
                              <?php } // Show if not last page ?>                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <?php } // Show if recordset not empty ?>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <?php if ($totalRows_RS_getclassesbyCourseCode > 0) { // Show if recordset not empty ?>
                <div>
                  <p>Searching By Course Code</p>
                  <table width="100%" border="0" cellpadding="1" cellspacing="1">
                    <tr class="tabledatakizmo">
                      <td>class_code</td>
                      <td>timing</td>
                      <td>course_code</td>
                      <td>start_date</td>
                      <td>end_date</td>
                      <td>active</td>
                      <td>modified_fee</td>
                    </tr>
                    <?php do { ?>
                      <tr>
                        <td><?php echo $row_RS_getclassesbyCourseCode['class_code']; ?></td>
                        <td><?php echo $row_RS_getclassesbyCourseCode['timing']; ?></td>
                        <td><?php echo $row_RS_getclassesbyCourseCode['course_code']; ?></td>
                        <td><?php echo $row_RS_getclassesbyCourseCode['start_date']; ?></td>
                        <td><?php echo $row_RS_getclassesbyCourseCode['end_date']; ?></td>
                        <td><?php echo $row_RS_getclassesbyCourseCode['active']; ?></td>
                        <td><?php echo $row_RS_getclassesbyCourseCode['modified_fee']; ?></td>
                      </tr>
                      <?php } while ($row_RS_getclassesbyCourseCode = mysql_fetch_assoc($RS_getclassesbyCourseCode)); ?>
                  </table>
                  <div>
                    <div align="center">
                      <table border="0">
                        <tr>
                          <td><?php if ($pageNum_RS_getclassesbyCourseCode > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_RS_getclassesbyCourseCode=%d%s", $currentPage, 0, $queryString_RS_getclassesbyCourseCode); ?>">First</a>
                                <?php } // Show if not first page ?>
                          </td>
                          <td><?php if ($pageNum_RS_getclassesbyCourseCode > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_RS_getclassesbyCourseCode=%d%s", $currentPage, max(0, $pageNum_RS_getclassesbyCourseCode - 1), $queryString_RS_getclassesbyCourseCode); ?>">Previous</a>
                                <?php } // Show if not first page ?>
                          </td>
                          <td><?php if ($pageNum_RS_getclassesbyCourseCode < $totalPages_RS_getclassesbyCourseCode) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_RS_getclassesbyCourseCode=%d%s", $currentPage, min($totalPages_RS_getclassesbyCourseCode, $pageNum_RS_getclassesbyCourseCode + 1), $queryString_RS_getclassesbyCourseCode); ?>">Next</a>
                                <?php } // Show if not last page ?>
                          </td>
                          <td><?php if ($pageNum_RS_getclassesbyCourseCode < $totalPages_RS_getclassesbyCourseCode) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_RS_getclassesbyCourseCode=%d%s", $currentPage, $totalPages_RS_getclassesbyCourseCode, $queryString_RS_getclassesbyCourseCode); ?>">Last</a>
                                <?php } // Show if not last page ?>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
                <?php } // Show if recordset not empty ?>
              <p>&nbsp;</p>
              <?php if ($totalRows_RS_getClassesByActiveStatus > 0) { // Show if recordset not empty ?>
                <div>
                  <p>Searching by Active Status</p>
                  <table width="100%" border="0" cellpadding="1" cellspacing="1">
                    <tr class="tabledatakizmo">
                      <td>class_code</td>
                      <td>timing</td>
                      <td>course_code</td>
                      <td>start_date</td>
                      <td>end_date</td>
                      <td>active</td>
                      <td>modified_fee</td>
                    </tr>
                    <?php do { ?>
                      <tr>
                        <td><?php echo $row_RS_getClassesByActiveStatus['class_code']; ?></td>
                        <td><?php echo $row_RS_getClassesByActiveStatus['timing']; ?></td>
                        <td><?php echo $row_RS_getClassesByActiveStatus['course_code']; ?></td>
                        <td><?php echo $row_RS_getClassesByActiveStatus['start_date']; ?></td>
                        <td><?php echo $row_RS_getClassesByActiveStatus['end_date']; ?></td>
                        <td><?php echo $row_RS_getClassesByActiveStatus['active']; ?></td>
                        <td><?php echo $row_RS_getClassesByActiveStatus['modified_fee']; ?></td>
                      </tr>
                      <?php } while ($row_RS_getClassesByActiveStatus = mysql_fetch_assoc($RS_getClassesByActiveStatus)); ?>
                  </table>
                  <div>
                    <div align="center">
                      <table border="0">
                        <tr>
                          <td><?php if ($pageNum_RS_getClassesByActiveStatus > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_RS_getClassesByActiveStatus=%d%s", $currentPage, 0, $queryString_RS_getClassesByActiveStatus); ?>">First</a>
                                <?php } // Show if not first page ?>
                          </td>
                          <td><?php if ($pageNum_RS_getClassesByActiveStatus > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_RS_getClassesByActiveStatus=%d%s", $currentPage, max(0, $pageNum_RS_getClassesByActiveStatus - 1), $queryString_RS_getClassesByActiveStatus); ?>">Previous</a>
                                <?php } // Show if not first page ?>
                          </td>
                          <td><?php if ($pageNum_RS_getClassesByActiveStatus < $totalPages_RS_getClassesByActiveStatus) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_RS_getClassesByActiveStatus=%d%s", $currentPage, min($totalPages_RS_getClassesByActiveStatus, $pageNum_RS_getClassesByActiveStatus + 1), $queryString_RS_getClassesByActiveStatus); ?>">Next</a>
                                <?php } // Show if not last page ?>
                          </td>
                          <td><?php if ($pageNum_RS_getClassesByActiveStatus < $totalPages_RS_getClassesByActiveStatus) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_RS_getClassesByActiveStatus=%d%s", $currentPage, $totalPages_RS_getClassesByActiveStatus, $queryString_RS_getClassesByActiveStatus); ?>">Last</a>
                                <?php } // Show if not last page ?>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
                <?php } // Show if recordset not empty ?>
              <?php if ($totalRows_Rs_getClassesBetweenDates > 0) { // Show if recordset not empty ?>
                    <div>
                      <p>Searching by Start and End dates<br />
                      </p>
                      <table width="100%" border="0" cellpadding="1" cellspacing="1">
                        <tr class="tabledatakizmo">
                          <td>class_code</td>
                          <td>timing</td>
                          <td>course_code</td>
                          <td>start_date</td>
                          <td>end_date</td>
                          <td>active</td>
                          <td>modified_fee</td>
                        </tr>
                        <?php do { ?>
                          <tr>
                            <td><?php echo $row_Rs_getClassesBetweenDates['class_code']; ?></td>
                            <td><?php echo $row_Rs_getClassesBetweenDates['timing']; ?></td>
                            <td><?php echo $row_Rs_getClassesBetweenDates['course_code']; ?></td>
                            <td><?php echo $row_Rs_getClassesBetweenDates['start_date']; ?></td>
                            <td><?php echo $row_Rs_getClassesBetweenDates['end_date']; ?></td>
                            <td><?php echo $row_Rs_getClassesBetweenDates['active']; ?></td>
                            <td><?php echo $row_Rs_getClassesBetweenDates['modified_fee']; ?></td>
                          </tr>
                          <?php } while ($row_Rs_getClassesBetweenDates = mysql_fetch_assoc($Rs_getClassesBetweenDates)); ?>
                                    </table>
                      <div>
                        <div align="center">                                       
                          <table border="0">
                            <tr>
                              <td><?php if ($pageNum_Rs_getClassesBetweenDates > 0) { // Show if not first page ?>
                                  <a href="<?php printf("%s?pageNum_Rs_getClassesBetweenDates=%d%s", $currentPage, 0, $queryString_Rs_getClassesBetweenDates); ?>">First</a>
                              <?php } // Show if not first page ?>                              </td>
                              <td><?php if ($pageNum_Rs_getClassesBetweenDates > 0) { // Show if not first page ?>
                                  <a href="<?php printf("%s?pageNum_Rs_getClassesBetweenDates=%d%s", $currentPage, max(0, $pageNum_Rs_getClassesBetweenDates - 1), $queryString_Rs_getClassesBetweenDates); ?>">Previous</a>
                              <?php } // Show if not first page ?>                              </td>
                              <td><?php if ($pageNum_Rs_getClassesBetweenDates < $totalPages_Rs_getClassesBetweenDates) { // Show if not last page ?>
                                  <a href="<?php printf("%s?pageNum_Rs_getClassesBetweenDates=%d%s", $currentPage, min($totalPages_Rs_getClassesBetweenDates, $pageNum_Rs_getClassesBetweenDates + 1), $queryString_Rs_getClassesBetweenDates); ?>">Next</a>
                              <?php } // Show if not last page ?>                              </td>
                              <td><?php if ($pageNum_Rs_getClassesBetweenDates < $totalPages_Rs_getClassesBetweenDates) { // Show if not last page ?>
                                  <a href="<?php printf("%s?pageNum_Rs_getClassesBetweenDates=%d%s", $currentPage, $totalPages_Rs_getClassesBetweenDates, $queryString_Rs_getClassesBetweenDates); ?>">Last</a>
                              <?php } // Show if not last page ?>                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <p>&nbsp;</p>
                    </div>
                    <?php } // Show if recordset not empty ?>
<p>&nbsp;</p>
              <p>&nbsp;</p></td>
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
mysql_free_result($RS_AllClasses);

mysql_free_result($RS_getClassesbyClasscode);

mysql_free_result($RS_getclassesbyCourseCode);

mysql_free_result($RS_getClassesByActiveStatus);

mysql_free_result($Rs_getClassesBetweenDates);
?>