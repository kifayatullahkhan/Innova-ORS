<?php require_once('Connections/conn.php'); ?>
<?php
session_start();
if (isset($_GET['std_id']))
$_SESSION['std_id']=$_GET['std_id'];

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


$colname_RS_Student1 = "-1";
if (isset($_GET['std_id'])) {
  $colname_RS_Student1 = $_GET['std_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_Student1 = sprintf("SELECT * FROM students WHERE std_id = %s", GetSQLValueString($colname_RS_Student1, "int"));
$RS_Student1 = mysql_query($query_RS_Student1, $conn) or die(mysql_error());
$row_RS_Student1 = mysql_fetch_assoc($RS_Student1);
$totalRows_RS_Student1 = mysql_num_rows($RS_Student1);

$maxRows_RS_CertificatesIssued = 10;
$pageNum_RS_CertificatesIssued = 0;
if (isset($_GET['pageNum_RS_CertificatesIssued'])) {
  $pageNum_RS_CertificatesIssued = $_GET['pageNum_RS_CertificatesIssued'];
}
$startRow_RS_CertificatesIssued = $pageNum_RS_CertificatesIssued * $maxRows_RS_CertificatesIssued;

$colname_RS_CertificatesIssued = "-1";
if (isset($_GET['std_id'])) {
  $colname_RS_CertificatesIssued = $_GET['std_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_CertificatesIssued = sprintf("SELECT * FROM certificate WHERE std_id = %s", GetSQLValueString($colname_RS_CertificatesIssued, "int"));
$query_limit_RS_CertificatesIssued = sprintf("%s LIMIT %d, %d", $query_RS_CertificatesIssued, $startRow_RS_CertificatesIssued, $maxRows_RS_CertificatesIssued);
$RS_CertificatesIssued = mysql_query($query_limit_RS_CertificatesIssued, $conn) or die(mysql_error());
$row_RS_CertificatesIssued = mysql_fetch_assoc($RS_CertificatesIssued);

if (isset($_GET['totalRows_RS_CertificatesIssued'])) {
  $totalRows_RS_CertificatesIssued = $_GET['totalRows_RS_CertificatesIssued'];
} else {
  $all_RS_CertificatesIssued = mysql_query($query_RS_CertificatesIssued);
  $totalRows_RS_CertificatesIssued = mysql_num_rows($all_RS_CertificatesIssued);
}
$totalPages_RS_CertificatesIssued = ceil($totalRows_RS_CertificatesIssued/$maxRows_RS_CertificatesIssued)-1;

mysql_select_db($database_conn, $conn);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-6" />
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
	<link rel="stylesheet" type="text/css" href="gnpcss.css" media="screen" />
    <title>Innova [Certificate Verification]</title>
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
            <td width="179" height="653" align="left" valign="top"><?php
				require("left_menu_guest.php");
				?>
			<div>
			  <div align="center"></div>
			</div></td>
            <td align="left" valign="top" width="652"><form action="<?php echo $currentPage ?>" method="get">
              <fieldset>
              <legend>Search</legend>
                <ol>
                <li>
                  <label for="name">Sudent ID:</label>
                  <br />
                  <input id="std_id" name="std_id" class="inputText" type="text" />
          	 <input name="cmdSearch" type="image" id="cmdSearch" src="images/icons/b_search.png" alt="[Search]" />
                    <input name="action" type="hidden" id="action" value="open" />
                </li>
                  </ol>
Please enter student ID to verify certificates         
              </fieldset>
            </form>
            <br />
            <?php if ($totalRows_RS_Student1 == 0 && $_GET['action']) { // Show if recordset empty ?>
              <div class="smallmsgbox" align="center"> <strong> Recrod Not Found</strong></div>
              <?php } // Show if recordset empty ?>

            <?php if ($totalRows_RS_Student1 > 0) { // Show if recordset not empty ?>
              <table border="0" cellpadding="0" cellspacing="0" width="640">
                <tbody>
                  <tr>
                    <td colspan="2" align="left" valign="top" class="tabledatakizmo">Student Biodata</td>
                        </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                      <tr>
                        <td width="89" class="headerkizmo"><u>Student ID</u></td>
                                <td width="149" class="smalltextbg"><?php echo $row_RS_Student1['std_id']; ?></td>
                                <td width="110" class="headerkizmo">Full Name</td>
                                <td width="221" class="smalltextbg"><?php echo $row_RS_Student1['title']; ?> <?php echo $row_RS_Student1['first_name']; ?><?php echo $row_RS_Student1['last_name']; ?></td>
                                <td width="100" class="headerkizmo">father name</td>
                                <td width="168" class="smalltextbg"><?php echo $row_RS_Student1['father_name']; ?></td>
                              </tr>
                      <tr>
                        <td width="89" class="headerkizmo">Nationality</td>
                                <td colspan="2" class="smalltextbg"><?php echo $row_RS_Student1['nationality']; ?></td>
                                <td class="smalltextbg">&nbsp;</td>
                                <td colspan="2" class="smalltextbg">&nbsp;</td>
                              </tr>
                      </table></td>
                        </tr>
                  
                  <tr>
                    <td width="272" align="left" valign="top">&nbsp;</td>
                          <td width="396" align="center" valign="middle">&nbsp;</td>
                        </tr>
                  
                  <tr>
                    <td colspan="2" align="left" valign="top"></td>
                        </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top">
                            <table width="100%" border="0" cellpadding="0" cellspacing="1">
                              <tr>
                                <td colspan="2" class="headerkizmo">All Certificates</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr class="tabledatakizmo">
                                <td>cert id / Serial</td>
                                <td>date of Isscue</td>
                                <td>class code</td>
                                <td>grade</td>
                              </tr>
                              <?php do { ?>
                                <tr class="smalltextbg">
                                  <td><?php echo $row_RS_CertificatesIssued['cert_id']; ?></td>
                                  <td><?php echo $row_RS_CertificatesIssued['date']; ?></td>
                                  <td><?php echo $row_RS_CertificatesIssued['class_code']; ?></td>
                                  <td><?php echo $row_RS_CertificatesIssued['grade']; ?></td>
                                </tr>
                                <?php } while ($row_RS_CertificatesIssued = mysql_fetch_assoc($RS_CertificatesIssued)); ?>
                          </table></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top">&nbsp;</td>
                        </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top">&nbsp;</td>
                        </tr>
                  </tbody>
              </table>
              <?php } // Show if recordset not empty ?></td>
            <td align="left" valign="top" width="179"><div id="leftbar"></div>              </td>
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


<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($RS_Student1);

mysql_free_result($RS_CertificatesIssued);
?>