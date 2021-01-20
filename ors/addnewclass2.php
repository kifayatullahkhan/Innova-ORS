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

$editFormAction = $_SERVER['PHP_SELF'];
/* 
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

*/

if (isset($_POST['course_code'])){
$_GET['course_code']=$_POST['course_code'];
}
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO classes (class_code, timing, course_code, start_date, end_date, active, modified_fee) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['class_code'], "text"),
                       GetSQLValueString($_POST['timing'], "text"),
                       GetSQLValueString($_POST['course_code'], "text"),
                       GetSQLValueString($_POST['start_date'], "date"),
                       GetSQLValueString($_POST['end_date'], "date"),
                       GetSQLValueString(isset($_POST['active']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['modified_fee'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}

if ((isset($_GET['class_code']) && $_GET['action']=="deactivate")) {
  $updateSQL ="UPDATE classes SET active=0 WHERE class_code='".$_GET['class_code']."'";

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
}

if ((isset($_GET['class_code'])) && ($_GET['class_code'] != "") && (isset($_GET['action'])) && $_GET['action']=="delete") {
  $deleteSQL = sprintf("DELETE FROM classes WHERE class_code=%s",
                       GetSQLValueString($_GET['class_code'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

$colname_RS_getCourse = "-1";
if (isset($_GET['course_code'])) {
  $colname_RS_getCourse = $_GET['course_code'];
}
mysql_select_db($database_conn, $conn);
$query_RS_getCourse = sprintf("SELECT * FROM courses WHERE course_code = %s", GetSQLValueString($colname_RS_getCourse, "text"));
$RS_getCourse = mysql_query($query_RS_getCourse, $conn) or die(mysql_error());
$row_RS_getCourse = mysql_fetch_assoc($RS_getCourse);
$totalRows_RS_getCourse = mysql_num_rows($RS_getCourse);

$maxRows_RS_getClasses = 20;
$pageNum_RS_getClasses = 0;
if (isset($_GET['pageNum_RS_getClasses'])) {
  $pageNum_RS_getClasses = $_GET['pageNum_RS_getClasses'];
}
$startRow_RS_getClasses = $pageNum_RS_getClasses * $maxRows_RS_getClasses;

$colname_RS_getClasses = "-1";
if (isset($_GET['course_code'])) {
  $colname_RS_getClasses = $_GET['course_code'];
}
mysql_select_db($database_conn, $conn);
$query_RS_getClasses = sprintf("SELECT * FROM classes WHERE course_code = %s ORDER BY end_date DESC", GetSQLValueString($colname_RS_getClasses, "text"));
$query_limit_RS_getClasses = sprintf("%s LIMIT %d, %d", $query_RS_getClasses, $startRow_RS_getClasses, $maxRows_RS_getClasses);
$RS_getClasses = mysql_query($query_limit_RS_getClasses, $conn) or die(mysql_error());
$row_RS_getClasses = mysql_fetch_assoc($RS_getClasses);

if (isset($_GET['totalRows_RS_getClasses'])) {
  $totalRows_RS_getClasses = $_GET['totalRows_RS_getClasses'];
} else {
  $all_RS_getClasses = mysql_query($query_RS_getClasses);
  $totalRows_RS_getClasses = mysql_num_rows($all_RS_getClasses);
}
$totalPages_RS_getClasses = ceil($totalRows_RS_getClasses/$maxRows_RS_getClasses)-1;

$colname_RS_CountAlCourseClass = $_GET['course_code'];
if (!isset($_GET['course_code'])) {
  $colname_RS_CountAlCourseClass = -1;
}
mysql_select_db($database_conn, $conn);
$query_RS_CountAlCourseClass = sprintf("SELECT COUNT(*) AS TotalClasses FROM classes WHERE course_code = %s ORDER BY end_date DESC", GetSQLValueString($colname_RS_CountAlCourseClass, "text"));
$RS_CountAlCourseClass = mysql_query($query_RS_CountAlCourseClass, $conn) or die(mysql_error());
$row_RS_CountAlCourseClass = mysql_fetch_assoc($RS_CountAlCourseClass);
$totalRows_RS_CountAlCourseClass = mysql_num_rows($RS_CountAlCourseClass);

$colname_RS_TotalActiveClasses = "-1";
if (isset($_GET['course_code'])) {
  $colname_RS_TotalActiveClasses = $_GET['course_code'];
}
mysql_select_db($database_conn, $conn);
$query_RS_TotalActiveClasses = sprintf("SELECT COUNT(*) AS TotalActiveClasses FROM classes WHERE course_code = %s AND classes.active=1 ORDER BY end_date DESC", GetSQLValueString($colname_RS_TotalActiveClasses, "text"));
$RS_TotalActiveClasses = mysql_query($query_RS_TotalActiveClasses, $conn) or die(mysql_error());
$row_RS_TotalActiveClasses = mysql_fetch_assoc($RS_TotalActiveClasses);
$totalRows_RS_TotalActiveClasses = mysql_num_rows($RS_TotalActiveClasses);

$queryString_RS_getClasses = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_getClasses") == false && 
        stristr($param, "totalRows_RS_getClasses") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_getClasses = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_getClasses = sprintf("&totalRows_RS_getClasses=%d%s", $totalRows_RS_getClasses, $queryString_RS_getClasses);
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
      <td><table border="0" cellpadding="0" cellspacing="0" width="1000">
          <tbody><tr>
            <td width="179" height="653" align="left" valign="top"><?php
				require("left_menu.php");
				?>
			<div>
			  <div align="center"></div>
			</div>			</td>
            <td align="left" valign="top" width="652"><table border="0" cellpadding="0" cellspacing="0" width="232">
                <tbody><tr>
                  <td align="left" valign="top" width="232">                    
<table width="100%" border="0" cellpadding="1" cellspacing="1">
                      <tr>
                        <td class="tabledatakizmo">course_code</td>
                        <td class="tabledatakizmo">name</td>
                        <td class="tabledatakizmo">fee</td>
                      </tr>
                  
                        <tr class="tablerowzorkif">
                          <td><?php echo $row_RS_getCourse['course_code']; ?></td>
                          <td><?php echo $row_RS_getCourse['name']; ?></td>
                          <td><?php echo $row_RS_getCourse['fee']; ?></td>
                        </tr>
                    </table>
                    <div class="MarginStyle1" align="justify"></div>
                    <div class="MarginStyle1" align="justify">
                      <div class="text" align="justify">                      </div>
                    </div></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
                      <table width="100%" align="center" class="small_borders">
                        <tr valign="baseline">
                          <td colspan="4" align="right" nowrap="nowrap" class="headerkizmo"><div align="left">Add Nea Class for This course</div></td>
                          </tr>
                        <tr valign="baseline">
                          <td align="right" nowrap="nowrap" class="tablerowzorkif">Class_code:</td>
                          <td><input type="text" name="class_code" value="<?php 
							echo $_GET['course_code'].date(ymd)
							 ?>" size="16" /></td>
                          <td class="tablerowzorkif">Timing:</td>
                          <td><select name="timing">
                            <?php
							   for ($H=8;$H<20;$H++){
							   	for($M=0;$M<=59;$M=$M+15) {
								if ($H<10)
										$Hour="0".$H;
								else
									$Hour=$H;
								if($M<10) 
								$Minute="0".$M;
								else
								$Minute=$M;
							   echo " <option value=\"$Hour:$Minute:00\" >$Hour:$Minute</option>";
							     }//end of $M
							   } // end of $H
							   ?>
                          </select></td>
                        </tr>
                        
                        <tr valign="baseline">
                          <td align="right" nowrap="nowrap" class="tablerowzorkif">Start_date:</td>
                          <td><input type="text" name="start_date" value="<?php  echo date('Y-m-d'); ?>" size="12" />
eg. yyyy-mm-dd (2009-01-28)</td>
                          <td class="tablerowzorkif">End_date:</td>
                          <td><input type="text" name="end_date" value="<?php  echo date('Y-m-d'); ?>" size="12" /> 
                          eg. yyyy-mm-dd (2009-01-28)</td>
                        </tr>
                        
                        <tr valign="baseline">
                          <td align="right" nowrap="nowrap" class="tablerowzorkif">Modified_fee:</td>
                          <td><input type="text" name="modified_fee" value="<?php echo $row_RS_getCourse['fee']; ?>" size="7" /></td>
                          <td class="tablerowzorkif">Active:</td>
                          <td><input type="checkbox" name="active" value="" checked="checked" /></td>
                        </tr>
                        
                        <tr valign="baseline">
                          <td nowrap="nowrap" align="right"><input type="hidden" name="course_code" value="<?php echo $_GET['course_code'];?>" size="32" /></td>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td><input type="submit" value="Add New Class" /></td>
                        </tr>
                      </table>
                      <input type="hidden" name="MM_insert" value="form1" />
                      <input type="hidden" name="MM_update" value="form1" />
                    </form></td>
                    </tr>
                  <tr class="small_borders">
                    <td align="left" valign="top">&nbsp;
                      <?php if ($totalRows_RS_getClasses > 0) { // Show if recordset not empty ?>
                        <table width="100%" border="0" cellpadding="1" cellspacing="1" class="small_borders">
                          <tr class="headerzorkif">
                            <td>DeActivate</td>
                            <td>Delete</td>
                            <td>class_code</td>
                            <td>timing</td>
                            <td>start_date</td>
                            <td>end_date</td>
                            <td>active</td>
                            <td>modified_fee</td>
                          </tr>
                          <?php do { ?>
                            <tr>
                              <td class="small_borders"><a href="<?php echo $currenntPage."?action=deactivate&course_code=".$row_RS_getClasses['course_code']."&class_code=".$row_RS_getClasses['class_code']; ?>"><img src="images/icons/lock1.gif" width="16" height="16" /></a></td>
                              <td class="small_borders"><a href="<?php echo $currenntPage."?action=delete&course_code=".$row_RS_getClasses['course_code']."&class_code=".$row_RS_getClasses['class_code']; ?>"><img src="images/icons/b_drop1.gif" width="16" height="16" /></a></td>
                              <td class="small_borders"><?php echo $row_RS_getClasses['class_code']; ?></td>
                              <td><div align="center"><?php echo $row_RS_getClasses['timing']; ?></div></td>
                              <td class="small_borders"><?php echo $row_RS_getClasses['start_date']; ?></td>
                              <td><?php echo $row_RS_getClasses['end_date']; ?></td>
                              <td class="small_borders"><div align="center"><?php echo $row_RS_getClasses['active']; ?></div></td>
                              <td><div align="center"><?php echo $row_RS_getClasses['modified_fee']; ?></div></td>
                            </tr>
                            <?php } while ($row_RS_getClasses = mysql_fetch_assoc($RS_getClasses)); ?>
                        </table>
                        <?php } // Show if recordset not empty ?>
</td>
                    </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;
                      <?php if ($totalRows_RS_getClasses == 0) { // Show if recordset empty ?>
                        <p align="center" class="smallmsgbox">No Classes Record Found.You can add Classes for this course</p>
                        <?php } // Show if recordset empty ?>
<table border="0">
                        <tr>
                          <td><?php if ($pageNum_RS_getClasses > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_RS_getClasses=%d%s", $currentPage, 0, $queryString_RS_getClasses); ?>">First</a>
                              <?php } // Show if not first page ?>                          </td>
                          <td><?php if ($pageNum_RS_getClasses > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_RS_getClasses=%d%s", $currentPage, max(0, $pageNum_RS_getClasses - 1), $queryString_RS_getClasses); ?>">Previous</a>
                              <?php } // Show if not first page ?>                          </td>
                          <td><?php if ($pageNum_RS_getClasses < $totalPages_RS_getClasses) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_RS_getClasses=%d%s", $currentPage, min($totalPages_RS_getClasses, $pageNum_RS_getClasses + 1), $queryString_RS_getClasses); ?>">Next</a>
                              <?php } // Show if not last page ?>                          </td>
                          <td><?php if ($pageNum_RS_getClasses < $totalPages_RS_getClasses) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_RS_getClasses=%d%s", $currentPage, $totalPages_RS_getClasses, $queryString_RS_getClasses); ?>">Last</a>
                              <?php } // Show if not last page ?>                          </td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    </tr>
              </tbody></table>            </td>
            <td align="left" valign="top" width="179"><div id="leftbar">
              <div id="searchBox">
                <p>Total Classes In Course: <strong><?php echo $row_RS_CountAlCourseClass['TotalClasses']; ?></strong></p>
                Total Active Classes:<?php echo $row_RS_TotalActiveClasses['TotalActiveClasses']; ?></div>
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
mysql_free_result($RS_CountAlCourseClass);

mysql_free_result($RS_TotalActiveClasses);

mysql_free_result($RS_getCourse);

mysql_free_result($RS_getClasses);
?>