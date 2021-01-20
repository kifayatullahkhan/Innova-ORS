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

if ((isset($_GET['user_type_id'])) && ($_GET['user_type_id'] != "") && (isset($_GET['action']) && $_GET['action']=="delete")) {
  $deleteSQL = sprintf("DELETE FROM user_type WHERE user_type_id=%s",
                       GetSQLValueString($_GET['user_type_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE user_type SET user_type_title=%s WHERE user_type_id=%s",
                       GetSQLValueString($_POST['user_type_title'], "text"),
                       GetSQLValueString($_POST['user_type_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
}

$maxRows_RS_UserTypes = 20;
$pageNum_RS_UserTypes = 0;
if (isset($_GET['pageNum_RS_UserTypes'])) {
  $pageNum_RS_UserTypes = $_GET['pageNum_RS_UserTypes'];
}
$startRow_RS_UserTypes = $pageNum_RS_UserTypes * $maxRows_RS_UserTypes;

mysql_select_db($database_conn, $conn);
$query_RS_UserTypes = "SELECT * FROM user_type ORDER BY user_type_title ASC";
$query_limit_RS_UserTypes = sprintf("%s LIMIT %d, %d", $query_RS_UserTypes, $startRow_RS_UserTypes, $maxRows_RS_UserTypes);
$RS_UserTypes = mysql_query($query_limit_RS_UserTypes, $conn) or die(mysql_error());
$row_RS_UserTypes = mysql_fetch_assoc($RS_UserTypes);

if (isset($_GET['totalRows_RS_UserTypes'])) {
  $totalRows_RS_UserTypes = $_GET['totalRows_RS_UserTypes'];
} else {
  $all_RS_UserTypes = mysql_query($query_RS_UserTypes);
  $totalRows_RS_UserTypes = mysql_num_rows($all_RS_UserTypes);
}
$totalPages_RS_UserTypes = ceil($totalRows_RS_UserTypes/$maxRows_RS_UserTypes)-1;

$colname_RS_UserType_byID = "-1";
if (isset($_GET['user_type_id'])) {
  $colname_RS_UserType_byID = $_GET['user_type_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_UserType_byID = sprintf("SELECT * FROM user_type WHERE user_type_id = %s", GetSQLValueString($colname_RS_UserType_byID, "int"));
$RS_UserType_byID = mysql_query($query_RS_UserType_byID, $conn) or die(mysql_error());
$row_RS_UserType_byID = mysql_fetch_assoc($RS_UserType_byID);
$totalRows_RS_UserType_byID = mysql_num_rows($RS_UserType_byID);
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
                  <td align="left" valign="top" width="232"><p class="headerkizmo"><strong>Short Description</strong></p>
                    <div class="MarginStyle1" align="justify">
                      <div class="text" align="justify">
                        <p>Please Provide All the Details about the students. This process will be completed in a few steps. When you finish this form please click [next] button to continue.</p>
                        </div>
                    </div>
                    <div class="MarginStyle1" align="justify">
                      <div class="text" align="justify">                      </div>
                    </div></td>
                  <td align="left" valign="top" width="408"><div class="MarginStyle1" align="left">
                    <table border="0" cellpadding="0" cellspacing="0" width="398">
                      <tbody>
                        <tr>
                          <td class="headerkizmo" align="center" valign="middle" width="398">Add User Type</td>
                        </tr>
                        <tr>
                          <td class="BoxBorderGray">&nbsp;
                            <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                              <table align="center">
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Enter New User type title:</td>
                                  <td><input type="text" name="user_type_title" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">&nbsp;</td>
                                  <td><input type="submit" value="Insert record" /></td>
                                </tr>
                              </table>
                              <input type="hidden" name="MM_insert" value="form1" />
                            </form>
                            <p>&nbsp;</p></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                    
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;
                        <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                          <?php if ($totalRows_RS_UserType_byID > 0) { // Show if recordset not empty ?>
                            <table width="100%" align="center">
                                <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="TopicHeader">User_type_id:</td>
                                    <td><?php echo $row_RS_UserType_byID['user_type_id']; ?></td>
                                </tr>
                                <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="TopicHeader">User_type_title:</td>
                                    <td><input type="text" name="user_type_title" value="<?php echo htmlentities($row_RS_UserType_byID['user_type_title'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="TopicHeader">&nbsp;</td>
                                    <td><input type="submit" value="Update record" /></td>
                                </tr>
                                                      </table>
                            <?php } // Show if recordset not empty ?>
<input type="hidden" name="MM_update" value="form2" />
                          <input type="hidden" name="user_type_id" value="<?php echo $row_RS_UserType_byID['user_type_id']; ?>" />
                        </form>
                        <p>&nbsp;</p></td>
                    </tr>
                  </table></td>
                </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellpadding="1" cellspacing="1">
                        <tr class="headerzorkif">
                          <td>Action</td>
                          <td>user type id</td>
                          <td>user type title</td>
                        </tr>
                        <?php do { ?>
                          <tr class="smalltextbg">
                            <td>
<a href="<?php echo $currentPage. "?action=edit&user_type_id=" . $row_RS_UserTypes['user_type_id'];?>">
<img src="images/icons/b_edit.png" width="16" height="16" /></a>| <a href="<?php echo $currentPage. "?action=delete&user_type_id=" . $row_RS_UserTypes['user_type_id'];?>">
<img src="images/icons/b_drop.png" width="16" height="16" /></a></td>
                            <td><?php echo $row_RS_UserTypes['user_type_id']; ?></td>
                            <td><?php echo $row_RS_UserTypes['user_type_title']; ?></td>
                          </tr>
                          <?php } while ($row_RS_UserTypes = mysql_fetch_assoc($RS_UserTypes)); ?>
                      </table></td>
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
mysql_free_result($RS_UserTypes);

mysql_free_result($RS_UserType_byID);
?>