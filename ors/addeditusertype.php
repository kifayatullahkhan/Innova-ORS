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
  $insertSQL = sprintf("INSERT INTO user_type (user_type_title) VALUES (%s)",
                       GetSQLValueString($_POST['user_type_title'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE user_type SET user_type_title=%s WHERE user_type_id=%s",
                       GetSQLValueString($_POST['user_type_title'], "text"),
                       GetSQLValueString($_POST['user_type_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
}

if ((isset($_GET['user_type_id'])) && ($_GET['user_type_id'] != "") && (isset($_GET['action'])) && $_GET['action']=="delete") {
  $deleteSQL = sprintf("DELETE FROM user_type WHERE user_type_id=%s",
                       GetSQLValueString($_GET['user_type_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

$maxRows_RS_ShowAllUserTypes = 10;
$pageNum_RS_ShowAllUserTypes = 0;
if (isset($_GET['pageNum_RS_ShowAllUserTypes'])) {
  $pageNum_RS_ShowAllUserTypes = $_GET['pageNum_RS_ShowAllUserTypes'];
}
$startRow_RS_ShowAllUserTypes = $pageNum_RS_ShowAllUserTypes * $maxRows_RS_ShowAllUserTypes;

mysql_select_db($database_conn, $conn);
$query_RS_ShowAllUserTypes = "SELECT * FROM user_type ORDER BY user_type_title ASC";
$query_limit_RS_ShowAllUserTypes = sprintf("%s LIMIT %d, %d", $query_RS_ShowAllUserTypes, $startRow_RS_ShowAllUserTypes, $maxRows_RS_ShowAllUserTypes);
$RS_ShowAllUserTypes = mysql_query($query_limit_RS_ShowAllUserTypes, $conn) or die(mysql_error());
$row_RS_ShowAllUserTypes = mysql_fetch_assoc($RS_ShowAllUserTypes);

if (isset($_GET['totalRows_RS_ShowAllUserTypes'])) {
  $totalRows_RS_ShowAllUserTypes = $_GET['totalRows_RS_ShowAllUserTypes'];
} else {
  $all_RS_ShowAllUserTypes = mysql_query($query_RS_ShowAllUserTypes);
  $totalRows_RS_ShowAllUserTypes = mysql_num_rows($all_RS_ShowAllUserTypes);
}
$totalPages_RS_ShowAllUserTypes = ceil($totalRows_RS_ShowAllUserTypes/$maxRows_RS_ShowAllUserTypes)-1;

$colname_RS_SearchUserType = "-1";
if (isset($_GET['user_type_id'])) {
  $colname_RS_SearchUserType = $_GET['user_type_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_SearchUserType = sprintf("SELECT * FROM user_type WHERE user_type_id = %s", GetSQLValueString($colname_RS_SearchUserType, "int"));
$RS_SearchUserType = mysql_query($query_RS_SearchUserType, $conn) or die(mysql_error());
$row_RS_SearchUserType = mysql_fetch_assoc($RS_SearchUserType);
$totalRows_RS_SearchUserType = mysql_num_rows($RS_SearchUserType);

$queryString_RS_ShowAllUserTypes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_ShowAllUserTypes") == false && 
        stristr($param, "totalRows_RS_ShowAllUserTypes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_ShowAllUserTypes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_ShowAllUserTypes = sprintf("&totalRows_RS_ShowAllUserTypes=%d%s", $totalRows_RS_ShowAllUserTypes, $queryString_RS_ShowAllUserTypes);
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
            <td align="left" valign="top" width="652"><table border="0" cellpadding="0" cellspacing="0" width="640">
                <tbody><tr>
                  <td align="left" valign="top" width="232"><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                      <table align="center">
                        <tr valign="baseline" class="headerkizmo">
                          <td colspan="2" align="right" nowrap="nowrap"><div align="center"><strong>Add New User Type</strong></div></td>
                          </tr>
                        <tr valign="baseline">
                          <td align="right" nowrap="nowrap" class="headerkizmo">User_type_title:</td>
                          <td><input type="text" name="user_type_title" value="" size="32" /></td>
                        </tr>
                        <tr valign="baseline">
                          <td align="right" nowrap="nowrap" class="headerkizmo">&nbsp;</td>
                          <td><input type="submit" value="Add New User Type" /></td>
                        </tr>
                      </table>
                      <input type="hidden" name="MM_insert" value="form1" />
                  </form>                   </td>
                  <td align="left" valign="top" width="408">
                    <table width="100%" border="0" cellpadding="1" cellspacing="1">
                      <tr class="headerkizmo">
                        <td><div align="center">Action</div></td>
                        <td>ID</td>
                        <td>user_type_title</td>
                      </tr>
                      <?php do { ?>
                        <tr class="smalltextbg">
                          <td><div align="center"><a href="<?php echo $currentPage."?action=edit&user_type_id=".$row_RS_ShowAllUserTypes['user_type_id']; ?>"><img src="images/icons/b_edit.png" alt="Edit" width="16" height="16" /></a><a href="<?php echo $currentPage."?action=delete&user_type_id=".$row_RS_ShowAllUserTypes['user_type_id']; ?>"><img src="images/icons/b_drop.png" alt="Drop" width="16" height="16" /></a> </div></td>
                          <td><?php echo $row_RS_ShowAllUserTypes['user_type_id']; ?></td>
                          <td><?php echo $row_RS_ShowAllUserTypes['user_type_title']; ?></td>
                        </tr>
                        <?php } while ($row_RS_ShowAllUserTypes = mysql_fetch_assoc($RS_ShowAllUserTypes)); ?>
                         <tr>
                        <td colspan="3">
                          <div align="center">
                            <table border="0">
                                <tr>
                                  <td><?php if ($pageNum_RS_ShowAllUserTypes > 0) { // Show if not first page ?>
                                    <a href="<?php printf("%s?pageNum_RS_ShowAllUserTypes=%d%s", $currentPage, 0, $queryString_RS_ShowAllUserTypes); ?>">First</a>
                                    <?php } // Show if not first page ?>                              </td>
                                  <td><?php if ($pageNum_RS_ShowAllUserTypes > 0) { // Show if not first page ?>
                                    <a href="<?php printf("%s?pageNum_RS_ShowAllUserTypes=%d%s", $currentPage, max(0, $pageNum_RS_ShowAllUserTypes - 1), $queryString_RS_ShowAllUserTypes); ?>">Previous</a>
                                    <?php } // Show if not first page ?>                              </td>
                                  <td><?php if ($pageNum_RS_ShowAllUserTypes < $totalPages_RS_ShowAllUserTypes) { // Show if not last page ?>
                                    <a href="<?php printf("%s?pageNum_RS_ShowAllUserTypes=%d%s", $currentPage, min($totalPages_RS_ShowAllUserTypes, $pageNum_RS_ShowAllUserTypes + 1), $queryString_RS_ShowAllUserTypes); ?>">Next</a>
                                    <?php } // Show if not last page ?>                              </td>
                                  <td><?php if ($pageNum_RS_ShowAllUserTypes < $totalPages_RS_ShowAllUserTypes) { // Show if not last page ?>
                                    <a href="<?php printf("%s?pageNum_RS_ShowAllUserTypes=%d%s", $currentPage, $totalPages_RS_ShowAllUserTypes, $queryString_RS_ShowAllUserTypes); ?>">Last</a>
                                    <?php } // Show if not last page ?>                              </td>
                                </tr>
                                                      </table>
                          </div></td>
                        </tr>
                    </table></td>
                </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;
                      <?php if ($totalRows_RS_SearchUserType > 0) { // Show if recordset not empty ?>
                        <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                            <table align="center">
                                <tr valign="baseline">
                                  <td colspan="2" align="right" nowrap="nowrap" class="headerkizmo"><div align="center">EDIT USER TYPE</div></td>
                                </tr>
                              <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">User Type Id:</td>
                                  <td class="smalltextbg"><?php echo $row_RS_SearchUserType['user_type_id']; ?></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">User Type Title:</td>
                                  <td class="smalltextbg"><input type="text" name="user_type_title" value="<?php echo htmlentities($row_RS_SearchUserType['user_type_title'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">&nbsp;</td>
                                  <td class="smalltextbg"><input type="submit" value="Update User Type Record" /></td>
                                </tr>
                                                    </table>
                          <input type="hidden" name="MM_update" value="form2" />
                            <input type="hidden" name="user_type_id" value="<?php echo $row_RS_SearchUserType['user_type_id']; ?>" />
                                              </form>
                        <?php } // Show if recordset not empty ?>
<p>&nbsp;</p></td>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
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

</body>
</html>
<?php
mysql_free_result($RS_ShowAllUserTypes);

mysql_free_result($RS_SearchUserType);
?>