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
  $insertSQL = sprintf("INSERT INTO exp_type (name, type, comments) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['comments'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE exp_type SET name=%s, type=%s, comments=%s WHERE exp_type_id=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['type'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['exp_type_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
}

$maxRows_RS_allExpTypes = 15;
$pageNum_RS_allExpTypes = 0;
if (isset($_GET['pageNum_RS_allExpTypes'])) {
  $pageNum_RS_allExpTypes = $_GET['pageNum_RS_allExpTypes'];
}
$startRow_RS_allExpTypes = $pageNum_RS_allExpTypes * $maxRows_RS_allExpTypes;

mysql_select_db($database_conn, $conn);
$query_RS_allExpTypes = "SELECT * FROM exp_type";
$query_limit_RS_allExpTypes = sprintf("%s LIMIT %d, %d", $query_RS_allExpTypes, $startRow_RS_allExpTypes, $maxRows_RS_allExpTypes);
$RS_allExpTypes = mysql_query($query_limit_RS_allExpTypes, $conn) or die(mysql_error());
$row_RS_allExpTypes = mysql_fetch_assoc($RS_allExpTypes);

if (isset($_GET['totalRows_RS_allExpTypes'])) {
  $totalRows_RS_allExpTypes = $_GET['totalRows_RS_allExpTypes'];
} else {
  $all_RS_allExpTypes = mysql_query($query_RS_allExpTypes);
  $totalRows_RS_allExpTypes = mysql_num_rows($all_RS_allExpTypes);
}
$totalPages_RS_allExpTypes = ceil($totalRows_RS_allExpTypes/$maxRows_RS_allExpTypes)-1;

$colname_RS_SearchRecord = "-1";
if (isset($_GET['exp_type_id'])) {
  $colname_RS_SearchRecord = $_GET['exp_type_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_SearchRecord = sprintf("SELECT * FROM exp_type WHERE exp_type_id = %s", GetSQLValueString($colname_RS_SearchRecord, "int"));
$RS_SearchRecord = mysql_query($query_RS_SearchRecord, $conn) or die(mysql_error());
$row_RS_SearchRecord = mysql_fetch_assoc($RS_SearchRecord);
$totalRows_RS_SearchRecord = mysql_num_rows($RS_SearchRecord);
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
            <td align="left" valign="top" width="652"><table border="0" cellpadding="0" cellspacing="0" width="100%">
              <tbody>
                <tr>
                  <td align="left" valign="top" width="202"><?php if ($totalRows_RS_SearchRecord > 0) { // Show if recordset not empty ?>
                      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                        <table align="center">
                              <tr valign="baseline" class="headerkizmo">
                                <td>Exp_type_id:</td>
                              </tr>
                          <tr valign="baseline">
                                <td class="smalltextbg"><?php echo $row_RS_SearchRecord['exp_type_id']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td class="headerkizmo">Name:</td>
                              </tr>
                          <tr valign="baseline">
                                <td class="smalltextbg"><input type="text" name="name" value="<?php echo $row_RS_SearchRecord['name']; ?>" size="32" /></td>
                              </tr>
                              <tr valign="baseline">
                                <td class="headerkizmo">Type:</td>
                              </tr>
                          <tr valign="baseline">
                                <td class="smalltextbg"><input type="text" name="type" value="<?php echo $row_RS_SearchRecord['type']; ?>" size="32" /> 
                                  (V / F)
                                  Variable = V or 
                                  Fix=F</td>
                              </tr>
                              <tr valign="baseline">
                                <td class="headerkizmo">Comments:</td>
                              </tr>
                          <tr valign="baseline">
                                <td class="smalltextbg"><textarea name="comments" cols="25" rows="3" id="comments"><?php echo $row_RS_SearchRecord['comments']; ?></textarea></td>
                              </tr>
                              <tr valign="baseline">
                                <td class="smalltextbg"><div align="center">
                                  <input name="cmdUpdate" type="submit" id="cmdUpdate" value="Update " />
                                  </div></td>
                              </tr>
                                                </table>
                        <input type="hidden" name="MM_update" value="form2" />
                          <input type="hidden" name="exp_type_id" value="<?php echo $row_RS_allExpTypes['exp_type_id']; ?>" />
                        </form>
                      <?php } // Show if recordset not empty ?>
</td>
                  <td align="left" valign="top" width="512">
                        
                          
                          <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                            <table align="center">
                              <tr valign="baseline">
                                <td colspan="2" align="right" nowrap="nowrap" class="headerkizmo"><div align="center"><strong>Add New Expense Type</strong></div></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" class="headerzorkif">Name:</td>
                                <td class="smalltextbg"><input type="text" name="name" value="Type-Name-Here" size="32" /></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" class="headerzorkif">Type:</td>
                                <td class="smalltextbg"><select name="type">
                                    <option value="F" <?php if (!(strcmp("F", ""))) {echo "SELECTED";} ?>>Fix Amount</option>
                                    <option value="V" <?php if (!(strcmp("V", ""))) {echo "SELECTED";} ?>>Variable Amount</option>
                                    </select>                                </td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" valign="top" nowrap="nowrap" class="headerzorkif">Comments:</td>
                                <td class="smalltextbg"><textarea name="comments" cols="30" rows="4">N/A</textarea>                                </td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" class="headerzorkif">&nbsp;</td>
                                <td class="smalltextbg"><input name="cmdadd" type="submit" id="cmdadd" value="Add" /></td>
                              </tr>
                            </table>
                            <input type="hidden" name="MM_insert" value="form1" />
                          </form>
                          </td>
                  </tr>
                <tr>
                  <td colspan="2" align="left" valign="top">&nbsp;
                    <table width="100%" border="0" cellpadding="0" cellspacing="1">
                      <tr class="tabledatakizmo">
                        <td>Action</td>
                        <td>exp_type_id</td>
                        <td>name</td>
                        <td>type</td>
                        <td>comments</td>
                      </tr>
                      <?php do { ?>
                        <tr class="smalltextbg">
                          <td><a href="<?php echo $currentPage."?exp_type_id=".$row_RS_allExpTypes['exp_type_id']; ?>"><img src="images/icons/b_edit.png" alt="[Edit]" width="16" height="16" /></a></td>
                          <td><?php echo $row_RS_allExpTypes['exp_type_id']; ?></td>
                          <td><?php echo $row_RS_allExpTypes['name']; ?></td>
                          <td><?php echo $row_RS_allExpTypes['type']; ?></td>
                          <td><?php echo $row_RS_allExpTypes['comments']; ?></td>
                        </tr>
                        <?php } while ($row_RS_allExpTypes = mysql_fetch_assoc($RS_allExpTypes)); ?>
                    </table></td>
                  </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
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
mysql_free_result($RS_allExpTypes);

mysql_free_result($RS_SearchRecord);
?>