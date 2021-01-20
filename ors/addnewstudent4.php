<?php require_once('Connections/conn.php'); ?>
<?php require_once '../admin/access_restrictions.php'; ?>
<?php
session_start();
if (isset($_POST['cmdSkip']) && $_POST['cmdSkip']="[Skip] --&gt;"){
 header("Location: addnewstudent5.php");
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

if ((isset($_GET['qualification_id'])) && ($_GET['qualification_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM std_qualification WHERE qualification_id=%s",
                       GetSQLValueString($_GET['qualification_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO std_qualification (institute_name, degree_certificate, subject, `session`, grade_percentage, comments, std_id) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['institute_name'], "text"),
                       GetSQLValueString($_POST['degree_certificate'], "text"),
                       GetSQLValueString($_POST['subject'], "text"),
                       GetSQLValueString($_POST['session'], "text"),
                       GetSQLValueString($_POST['grade_percentage'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
					   GetSQLValueString($_SESSION['std_id'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "addnewstudent5.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
if (!$_POST['cmdAddMore']="[Add More]" && $_POST['cmdNext']="[Next] --&gt;")
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_RS_STD_Qualifications = 10;
$pageNum_RS_STD_Qualifications = 0;
if (isset($_GET['pageNum_RS_STD_Qualifications'])) {
  $pageNum_RS_STD_Qualifications = $_GET['pageNum_RS_STD_Qualifications'];
}
$startRow_RS_STD_Qualifications = $pageNum_RS_STD_Qualifications * $maxRows_RS_STD_Qualifications;

$colname_RS_STD_Qualifications = "-1";
if (isset($_SESSION['std_id'])) {
  $colname_RS_STD_Qualifications = $_SESSION['std_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_STD_Qualifications = sprintf("SELECT * FROM std_qualification WHERE std_id = %s", GetSQLValueString($colname_RS_STD_Qualifications, "int"));
$query_limit_RS_STD_Qualifications = sprintf("%s LIMIT %d, %d", $query_RS_STD_Qualifications, $startRow_RS_STD_Qualifications, $maxRows_RS_STD_Qualifications);
$RS_STD_Qualifications = mysql_query($query_limit_RS_STD_Qualifications, $conn) or die(mysql_error());
$row_RS_STD_Qualifications = mysql_fetch_assoc($RS_STD_Qualifications);

if (isset($_GET['totalRows_RS_STD_Qualifications'])) {
  $totalRows_RS_STD_Qualifications = $_GET['totalRows_RS_STD_Qualifications'];
} else {
  $all_RS_STD_Qualifications = mysql_query($query_RS_STD_Qualifications);
  $totalRows_RS_STD_Qualifications = mysql_num_rows($all_RS_STD_Qualifications);
}
$totalPages_RS_STD_Qualifications = ceil($totalRows_RS_STD_Qualifications/$maxRows_RS_STD_Qualifications)-1;
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
                        <p>Please Provide All the Details about the students. This process will be completed in a few steps. When you finish this form please click <strong>[Next]</strong> button to continue.</p>
                        <p>Click the <strong>[Add More]</strong> Button to add more qualifications to the list.</p>
                        <p>Click on the <strong>[Skip]</strong> Button if you have no entry for this section.</p>
                      </div>
                    </div>
                    <div class="MarginStyle1" align="justify">
                      <div class="text" align="justify">                      </div>
                    </div></td>
                  <td align="left" valign="top" width="408"><div class="MarginStyle1" align="left">
                    <table border="0" cellpadding="0" cellspacing="0" width="398">
                      <tbody>
                        <tr>
                          <td class="headerkizmo" align="center" valign="middle" width="398">Qualifications </td>
                        </tr>
                        <tr>
                          <td class="BoxBorderGray">&nbsp;
                            <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                              <table align="center">
                                <tr valign="baseline">
                                  <td width="120" align="right" nowrap="nowrap">Institute Name:</td>
                                  <td width="258"><input type="text" name="institute_name" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Degree/Certificate:</td>
                                  <td><input type="text" name="degree_certificate" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Subject:</td>
                                  <td><input type="text" name="subject" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Session:</td>
                                  <td><input type="text" name="session" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Grade/Percentage:</td>
                                  <td><input type="text" name="grade_percentage" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Comments:</td>
                                  <td><input type="text" name="comments" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Std_id:</td>
                                  <td><?php echo $_SESSION['std_id'];?></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">&nbsp;</td>
                                  <td><input name="cmdAddMore" type="submit" id="cmdAddMore" value="[Add More]" />
                                    <input name="cmdSkip" type="submit" id="cmdSkip" value="[Skip] --&gt;" />
                                    <input name="cmdNext" type="submit" id="cmdNext" value="[Next] --&gt;" /></td>
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
                        <tr class="TopicHeaderWhtTextWithBG">
                          <td>Institute Name</td>
                          <td>Degree/Certificate</td>
                          <td>Subject</td>
                          <td>Session</td>
                          <td>Grade/Percentage</td>
                          </tr>
                        <?php do { ?>
                          <tr>
                            <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=delete&qualification_id=<?php echo $row_RS_STD_Qualifications['qualification_id'] ;?>"><img src="images/icons/b_drop.png" name="solidblockmenu" width="16" height="16" class="myHyperLink" id="solidblockmenu" /></a><?php echo $row_RS_STD_Qualifications['institute_name']; ?></td>
                            <td><?php echo $row_RS_STD_Qualifications['degree_certificate']; ?></td>
                            <td><?php echo $row_RS_STD_Qualifications['subject']; ?></td>
                            <td><?php echo $row_RS_STD_Qualifications['session']; ?></td>
                            <td><?php echo $row_RS_STD_Qualifications['grade_percentage']; ?></td>
                            </tr>
                          <?php } while ($row_RS_STD_Qualifications = mysql_fetch_assoc($RS_STD_Qualifications)); ?>
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
mysql_free_result($RS_STD_Qualifications);
?>