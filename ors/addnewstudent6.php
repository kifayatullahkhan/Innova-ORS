<?php require_once('Connections/conn.php'); ?>
<?php require_once '../admin/access_restrictions.php'; ?>
<?php
session_start();
if (isset($_POST['cmdSkip']) && $_POST['cmdSkip']="[Skip] --&gt;"){
 header("Location: addnewstudent7.php");
exit;
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

if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM std_references WHERE reference_id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO std_references (std_id, name, `position`, address, country, post_code, phone_no, fax_no, email) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
  					   GetSQLValueString($_SESSION['std_id'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['position'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['country'], "text"),
                       GetSQLValueString($_POST['post_code'], "text"),
                       GetSQLValueString($_POST['phone_no'], "text"),
                       GetSQLValueString($_POST['fax_no'], "text"),
                       GetSQLValueString($_POST['email'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "addnewstudent7.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  if (!$_POST['cmdAddMore']="[Add More]" && $_POST['cmdFinish']="[Finish]")
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_RS_STD_REFRENCES = 10;
$pageNum_RS_STD_REFRENCES = 0;
if (isset($_GET['pageNum_RS_STD_REFRENCES'])) {
  $pageNum_RS_STD_REFRENCES = $_GET['pageNum_RS_STD_REFRENCES'];
}
$startRow_RS_STD_REFRENCES = $pageNum_RS_STD_REFRENCES * $maxRows_RS_STD_REFRENCES;

$colname_RS_STD_REFRENCES = "-1";
if (isset($_SESSION['std_id'])) {
  $colname_RS_STD_REFRENCES = $_SESSION['std_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_STD_REFRENCES = sprintf("SELECT `reference_id`, `name`, `position`, address, country, post_code, phone_no, fax_no, email FROM std_references WHERE std_id = %s ORDER BY name ASC", GetSQLValueString($colname_RS_STD_REFRENCES, "int"));
$query_limit_RS_STD_REFRENCES = sprintf("%s LIMIT %d, %d", $query_RS_STD_REFRENCES, $startRow_RS_STD_REFRENCES, $maxRows_RS_STD_REFRENCES);
$RS_STD_REFRENCES = mysql_query($query_limit_RS_STD_REFRENCES, $conn) or die(mysql_error());
$row_RS_STD_REFRENCES = mysql_fetch_assoc($RS_STD_REFRENCES);

if (isset($_GET['totalRows_RS_STD_REFRENCES'])) {
  $totalRows_RS_STD_REFRENCES = $_GET['totalRows_RS_STD_REFRENCES'];
} else {
  $all_RS_STD_REFRENCES = mysql_query($query_RS_STD_REFRENCES);
  $totalRows_RS_STD_REFRENCES = mysql_num_rows($all_RS_STD_REFRENCES);
}
$totalPages_RS_STD_REFRENCES = ceil($totalRows_RS_STD_REFRENCES/$maxRows_RS_STD_REFRENCES)-1;
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
                        <p>Please click <strong>[Finished]</strong> button to end Student Registration form. Your entries on this page will be added to the database by clicking the finished button. </p>
                        <p>Click the<strong> [Add More]</strong> Button to add more Refrences to the list.</p>
                        <p>Click on the <strong>[Skip]</strong> Button if you have no more entry for this section and will end the student registration form.</p>
                      </div>
                    </div>
                    <div class="MarginStyle1" align="justify">
                      <div class="text" align="justify">                      </div>
                    </div></td>
                  <td align="left" valign="top" width="408"><div class="MarginStyle1" align="left">
                    <table border="0" cellpadding="0" cellspacing="0" width="398">
                      <tbody>
                        <tr>
                          <td class="TopicHeaderWhtTextWithBG" align="center" background="get'n'put [Home]_files/msg_bar.png" valign="middle" width="398">Student Refrences </td>
                        </tr>
                        <tr>
                          <td class="BoxBorderGray">&nbsp;
                            <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                              <table align="center">
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Std_id:</td>
                                  <td><?php echo $_SESSION['std_id'];?></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Name:</td>
                                  <td><input type="text" name="name" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Position:</td>
                                  <td><input type="text" name="position" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Address:</td>
                                  <td><input type="text" name="address" value="Peshawar" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Country:</td>
                                  <td><input type="text" name="country" value="Pakistan" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Post Code:</td>
                                  <td><input type="text" name="post_code" value="25000" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Phone No:</td>
                                  <td><input type="text" name="phone_no" value="091" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Fax No:</td>
                                  <td><input type="text" name="fax_no" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Email:</td>
                                  <td><input type="text" name="email" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">&nbsp;</td>
                                  <td><input name="cmdAddMore" type="submit" id="cmdAddMore" value="[Add More]" />
                                    <input name="cmdSkip" type="submit" id="cmdSkip" value="[Skip] --&gt;" />
                                    <input name="cmdFinish" type="submit" id="cmdFinish" value="[Finish]" /></td>
                                </tr>
                              </table>
                              <input type="hidden" name="MM_insert" value="form1" />
                            </form>
                            <p>&nbsp;</p></td>
                        </tr>
                      </tbody>
                    </table>
                  </div></td>
                </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top">&nbsp;
                      <table width="100%" border="0" cellpadding="1" cellspacing="1">
                        <tr class="headerzorkif">
                          <td>Name</td>
                          <td>Position</td>
                          <td>Address</td>
                          <td>Country</td>
                          <td>Post / Code</td>
                          <td>Phone No:</td>
                          <td>Fax No:</td>
                          <td>Email</td>
                        </tr>
                        <?php do { ?>
                          <tr class="tablerowzorkif">
                            <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=delete&id=<?php echo $row_RS_STD_REFRENCES['reference_id']; ?>"><img src="images/icons/b_drop.png" alt="Drop" name="DeleteMenu" width="16" height="16" class="myHyperLink" id="DeleteMenu" /></a><?php echo $row_RS_STD_REFRENCES['name']; ?></td>
                            <td><?php echo $row_RS_STD_REFRENCES['position']; ?></td>
                            <td><?php echo $row_RS_STD_REFRENCES['address']; ?></td>
                            <td><?php echo $row_RS_STD_REFRENCES['country']; ?></td>
                            <td><?php echo $row_RS_STD_REFRENCES['post_code']; ?></td>
                            <td><?php echo $row_RS_STD_REFRENCES['phone_no']; ?></td>
                            <td><?php echo $row_RS_STD_REFRENCES['fax_no']; ?></td>
                            <td><?php echo $row_RS_STD_REFRENCES['email']; ?></td>
                          </tr>
                          <?php } while ($row_RS_STD_REFRENCES = mysql_fetch_assoc($RS_STD_REFRENCES)); ?>
                      </table></td>
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
mysql_free_result($RS_STD_REFRENCES);
?>