<?php require_once('Connections/conn.php'); ?>
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

$colname_rs_getCourse = "-1";
if (isset($_GET['course_code'])) {
  $colname_rs_getCourse = $_GET['course_code'];
}
mysql_select_db($database_conn, $conn);
$query_rs_getCourse = sprintf("SELECT * FROM courses WHERE course_code = %s", GetSQLValueString($colname_rs_getCourse, "text"));
$rs_getCourse = mysql_query($query_rs_getCourse, $conn) or die(mysql_error());
$row_rs_getCourse = mysql_fetch_assoc($rs_getCourse);
$totalRows_rs_getCourse = mysql_num_rows($rs_getCourse);

$colname_rs_getCourseOutlines = "-1";
if (isset($_GET['course_code'])) {
  $colname_rs_getCourseOutlines = $_GET['course_code'];
}
mysql_select_db($database_conn, $conn);
$query_rs_getCourseOutlines = sprintf("SELECT * FROM course_outline WHERE course_code = %s", GetSQLValueString($colname_rs_getCourseOutlines, "text"));
$rs_getCourseOutlines = mysql_query($query_rs_getCourseOutlines, $conn) or die(mysql_error());
$row_rs_getCourseOutlines = mysql_fetch_assoc($rs_getCourseOutlines);
$totalRows_rs_getCourseOutlines = mysql_num_rows($rs_getCourseOutlines);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-6" />
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
	<link rel="stylesheet" type="text/css" href="gnpcss.css" media="screen" />
    <title>Innova [Course Outlines]</title>
    <style type="text/css">
<!--
.style1 {font-size: xx-large}
-->
    </style>
    </head>
<body>
<div align="center">
  <table border="0" cellpadding="0" cellspacing="0" width="1000">
    <tbody><tr>
      <td class="PageTopHeader" align="left" height="180" valign="middle" width="1000"><img src="images/header_logo.jpg" width="1000" height="250" /></td>
    </tr>
    <tr>
      <td align="left" height="40" valign="middle" width="1000"><?php
				require("top_menu_guest.php");
				?>        <br style="clear: left;" /></td>
    </tr>
    <tr>
      <td><table border="0" cellpadding="0" cellspacing="0" width="1000">
          <tbody><tr>
            <td width="179" height="100%" align="left" valign="top">
			<div>
			  <div align="center"></div>
			</div>			</td>
            <td align="left" valign="top" width="652"><div align="center">
              <table width="100%" border="0" cellspacing="1" cellpadding="5">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="20%" class="smalltextbg"><strong>Course Code</strong></td>
                    <td width="20%" class="smalltextbg"><?php echo $row_rs_getCourse['course_code']; ?></td>
                    <td width="30%" class="smalltextbg"><strong>Course Name</strong></td>
                    <td width="30%" class="smalltextbg"><?php echo $row_rs_getCourse['name']; ?></td>
                  </tr>
                </table>
                <p class="style1"><?php echo $row_rs_getCourseOutlines['Title']; ?></p>
                <div class="text" align="left">
                  <p align="left"><?php echo $row_rs_getCourseOutlines['Details']; ?></p>
                  <p>&nbsp;</p>
                </div>
                <div class="text">
                  <div align="left">
                    <hr />
                    <strong>                    Duration: <?php echo $row_rs_getCourseOutlines['Duration']; ?></strong></div>
                </div>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            </div></td>
            <td align="left" valign="top" width="179">&nbsp;</td>
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
mysql_free_result($rs_getCourse);

mysql_free_result($rs_getCourseOutlines);
?>