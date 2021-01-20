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
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO courses (course_code, name, fee) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['course_code'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['fee'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE courses SET name=%s, fee=%s WHERE course_code=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['fee'], "int"),
                       GetSQLValueString($_POST['course_code'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
}

if ((isset($_GET['course_code'])) && ($_GET['course_code'] != "") && (isset($_GET['action']) && $_GET['action']=="delete")) {
  $deleteSQL = sprintf("DELETE FROM courses WHERE course_code=%s",
                       GetSQLValueString($_GET['course_code'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

$maxRows_RS_SHOWCOURSES = 10;
$pageNum_RS_SHOWCOURSES = 0;
if (isset($_GET['pageNum_RS_SHOWCOURSES'])) {
  $pageNum_RS_SHOWCOURSES = $_GET['pageNum_RS_SHOWCOURSES'];
}
$startRow_RS_SHOWCOURSES = $pageNum_RS_SHOWCOURSES * $maxRows_RS_SHOWCOURSES;

mysql_select_db($database_conn, $conn);
$query_RS_SHOWCOURSES = "SELECT * FROM courses ORDER BY course_code ASC";
$query_limit_RS_SHOWCOURSES = sprintf("%s LIMIT %d, %d", $query_RS_SHOWCOURSES, $startRow_RS_SHOWCOURSES, $maxRows_RS_SHOWCOURSES);
$RS_SHOWCOURSES = mysql_query($query_limit_RS_SHOWCOURSES, $conn) or die(mysql_error());
$row_RS_SHOWCOURSES = mysql_fetch_assoc($RS_SHOWCOURSES);

if (isset($_GET['totalRows_RS_SHOWCOURSES'])) {
  $totalRows_RS_SHOWCOURSES = $_GET['totalRows_RS_SHOWCOURSES'];
} else {
  $all_RS_SHOWCOURSES = mysql_query($query_RS_SHOWCOURSES);
  $totalRows_RS_SHOWCOURSES = mysql_num_rows($all_RS_SHOWCOURSES);
}
$totalPages_RS_SHOWCOURSES = ceil($totalRows_RS_SHOWCOURSES/$maxRows_RS_SHOWCOURSES)-1;

$colname_RS_SearchCourse = "-1";
if (isset($_GET['course_code'])) {
  $colname_RS_SearchCourse = $_GET['course_code'];
}
mysql_select_db($database_conn, $conn);
$query_RS_SearchCourse = sprintf("SELECT * FROM courses WHERE course_code = %s", GetSQLValueString($colname_RS_SearchCourse, "text"));
$RS_SearchCourse = mysql_query($query_RS_SearchCourse, $conn) or die(mysql_error());
$row_RS_SearchCourse = mysql_fetch_assoc($RS_SearchCourse);
$totalRows_RS_SearchCourse = mysql_num_rows($RS_SearchCourse);

$queryString_RS_SHOWCOURSES = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_SHOWCOURSES") == false && 
        stristr($param, "totalRows_RS_SHOWCOURSES") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_SHOWCOURSES = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_SHOWCOURSES = sprintf("&totalRows_RS_SHOWCOURSES=%d%s", $totalRows_RS_SHOWCOURSES, $queryString_RS_SHOWCOURSES);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-6" />
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
	<link rel="stylesheet" type="text/css" href="gnpcss.css" media="screen" />
    <title>Innova ORS</title>
    <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
				?>
<br style="clear: left;" /></td>
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
            <td align="left" valign="top" width="652"><table border="0" cellpadding="0" cellspacing="0">
                <tbody><tr>
                  <td align="left" valign="top" width="232"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                          <table align="center">
                            <tr valign="baseline">
                              <td colspan="2" align="right" nowrap="nowrap" class="headerkizmo"><div align="center"><strong>Add New Course </strong></div></td>
                              </tr>
                            <tr valign="baseline">
                              <td align="right" nowrap="nowrap" class="headerzorkif">Course_code:</td>
                                <td class="smalltextbg"><span id="sprycoursecode">
                                  <input name="course_code" type="text" id="course_code" size="32" />
                                <span class="textfieldRequiredMsg">A value is required.</span></span></td>
                              </tr>
                            <tr valign="baseline">
                              <td align="right" nowrap="nowrap" class="headerzorkif">Name:</td>
                                <td class="smalltextbg"><span id="sprytextfield2">
                                  <input name="name" type="text" id="name" size="32" />
                                <span class="textfieldRequiredMsg">A value is required.</span></span></td>
                              </tr>
                            <tr valign="baseline">
                              <td align="right" nowrap="nowrap" class="headerzorkif">Fee:</td>
                                <td class="smalltextbg"><span id="sprytextfield3">
                                  <input name="fee" type="text" id="fee" size="32" />
                                <span class="textfieldRequiredMsg">A value is required.</span></span></td>
                              </tr>
                            <tr valign="baseline">
                              <td align="right" nowrap="nowrap" class="headerzorkif">&nbsp;</td>
                                <td class="smalltextbg"><input type="submit" value="Add New" /></td>
                              </tr>
                            </table>
                            <input type="hidden" name="MM_insert" value="form1" />
                  </form>
                        </td>
                 <td align="left" valign="top" width="408"><div class="MarginStyle1" align="left">
                    <table border="0" cellpadding="0" cellspacing="0">
                      <tbody>
                      
                        <tr>
                          <td class="BoxBorderGray"><?php if ($totalRows_RS_SearchCourse > 0) { // Show if recordset not empty ?>
                              <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                                        <table align="center">
                                          <tr valign="baseline">
                                            <td colspan="2" align="right" nowrap="nowrap" class="headerkizmo"><div align="center">Edit Course</div></td>
                                      </tr>
                                          <tr valign="baseline">
                                            <td align="right" nowrap="nowrap" class="headerzorkif">Course_code:</td>
                      <td class="smalltextbg"><?php echo $row_RS_SearchCourse['course_code']; ?></td>
                                    </tr>
                                          <tr valign="baseline">
                                            <td align="right" nowrap="nowrap" class="headerzorkif">Name:</td>
                                      <td class="smalltextbg"><input type="text" name="name" value="<?php echo htmlentities($row_RS_SearchCourse['name'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                    </tr>
                                          <tr valign="baseline">
                                            <td align="right" nowrap="nowrap" class="headerzorkif">Fee:</td>
                                      <td class="smalltextbg"><input type="text" name="fee" value="<?php echo htmlentities($row_RS_SearchCourse['fee'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                    </tr>
                                          <tr valign="baseline">
                                            <td align="right" nowrap="nowrap" class="headerzorkif">&nbsp;</td>
                                      <td class="smalltextbg"><input type="submit" value="Update " /></td>
                                    </tr>
                                        </table>
                                <input type="hidden" name="MM_update" value="form2" />
                                <input type="hidden" name="course_code" value="<?php echo $row_RS_SearchCourse['course_code']; ?>" />
                                             </form>
                              <?php } // Show if recordset not empty ?>
</td>
                        </tr>
                      </tbody>
                    </table>
                  </div></td>
                </tr>
                  
                  <tr>
                    <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellpadding="1" cellspacing="1">
                        <tr class="headerzorkif">
                          <td width="9%">aCTION</td>
                          <td width="29%">course_code</td>
                          <td width="40%">name</td>
                          <td width="22%">fee</td>
                        </tr>
                        <?php do { ?>
                          <tr class="smalltextbg">
                            <td><a href="<?php echo $currentPage."?action=edit&course_code=".$row_RS_SHOWCOURSES['course_code']; ?>"><img src="images/icons/b_edit.png" width="16" height="16" /></a><a href="<?php echo $currentPage."?action=delete&course_code=".$row_RS_SHOWCOURSES['course_code']; ?>"><img src="images/icons/b_drop.png" alt="" width="16" height="16" /></a></td>
                            <td><?php echo $row_RS_SHOWCOURSES['course_code']; ?></td>
                            <td><?php echo $row_RS_SHOWCOURSES['name']; ?></td>
                            <td><?php echo $row_RS_SHOWCOURSES['fee']; ?></td>
                          </tr>
                          <?php } while ($row_RS_SHOWCOURSES = mysql_fetch_assoc($RS_SHOWCOURSES)); ?>
                      </table>
<table width="100%" border="0" cellpadding="1" cellspacing="1">
                                            </table></td>
                    </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top"><div align="center">
                      <table border="0">
                        <tr>
                          <td><?php if ($pageNum_RS_SHOWCOURSES > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_RS_SHOWCOURSES=%d%s", $currentPage, 0, $queryString_RS_SHOWCOURSES); ?>">First</a>
                                <?php } // Show if not first page ?>                          </td>
                          <td><?php if ($pageNum_RS_SHOWCOURSES > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_RS_SHOWCOURSES=%d%s", $currentPage, max(0, $pageNum_RS_SHOWCOURSES - 1), $queryString_RS_SHOWCOURSES); ?>">Previous</a>
                                <?php } // Show if not first page ?>                          </td>
                          <td><?php if ($pageNum_RS_SHOWCOURSES < $totalPages_RS_SHOWCOURSES) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_RS_SHOWCOURSES=%d%s", $currentPage, min($totalPages_RS_SHOWCOURSES, $pageNum_RS_SHOWCOURSES + 1), $queryString_RS_SHOWCOURSES); ?>">Next</a>
                                <?php } // Show if not last page ?>                          </td>
                          <td><?php if ($pageNum_RS_SHOWCOURSES < $totalPages_RS_SHOWCOURSES) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_RS_SHOWCOURSES=%d%s", $currentPage, $totalPages_RS_SHOWCOURSES, $queryString_RS_SHOWCOURSES); ?>">Last</a>
                                <?php } // Show if not last page ?>                          </td>
                        </tr>
                      </table>
                    </div></td>
                    </tr>
              </tbody></table>            </td>
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

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprycoursecode", "none", {hint:"CCCNCC"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($RS_SHOWCOURSES);

mysql_free_result($RS_SearchCourse);
?>