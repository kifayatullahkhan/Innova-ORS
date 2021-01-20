<?php require_once('Connections/conn.php'); ?>
<?php require_once '../admin/access_restrictions.php'; ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE certificate SET `date`=%s, class_code=%s, grade=%s WHERE cert_id=%s",
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['class_code'], "text"),
                       GetSQLValueString($_POST['grade'], "text"),
                       GetSQLValueString($_POST['cert_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {


$CertificateFoundSQL="SELECT * FROM certificate  WHERE std_id=".$_SESSION['std_id']." AND class_code='".$_POST['class_code']."'"; 					  

  mysql_select_db($database_conn, $conn);
  $ResultCerficateFound = mysql_query($CertificateFoundSQL, $conn) or die(mysql_error());
     $totalRowsinCertitficateFound = mysql_fetch_row($ResultCerficateFound);
  if ($totalRowsinCertitficateFound>0){
       $MM_redirectLoginSuccess = $currentPage."?msg=CERTIFICATEFOUND&action=open&std_id=".$_POST['std_id'];	
        header("Location: " . $MM_redirectLoginSuccess );    
        exit;
	}


	  $insertSQL = sprintf("INSERT INTO certificate (std_id, `date`, class_code, grade) VALUES (%s, %s, %s, %s)",
						   GetSQLValueString($_POST['std_id'], "int"),
						   GetSQLValueString($_POST['date'], "date"),
						   GetSQLValueString($_POST['class_code'], "text"),
						   GetSQLValueString($_POST['grade'], "text"));
	
	  mysql_select_db($database_conn, $conn);
	  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error()); 
	  $_GET['msg']=""; 
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

mysql_select_db($database_conn, $conn);
$query_RS_AllCourses = "SELECT * FROM courses ORDER BY name ASC";
$RS_AllCourses = mysql_query($query_RS_AllCourses, $conn) or die(mysql_error());
$row_RS_AllCourses = mysql_fetch_assoc($RS_AllCourses);
$totalRows_RS_AllCourses = mysql_num_rows($RS_AllCourses);

$colname_RS_StdClasses = "-1";
if (isset($_GET['std_id'])) {
  $colname_RS_StdClasses = $_GET['std_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_StdClasses = sprintf("SELECT * FROM std_classes WHERE std_id = %s ORDER BY joining_date DESC", GetSQLValueString($colname_RS_StdClasses, "int"));
$RS_StdClasses = mysql_query($query_RS_StdClasses, $conn) or die(mysql_error());
$row_RS_StdClasses = mysql_fetch_assoc($RS_StdClasses);
$totalRows_RS_StdClasses = mysql_num_rows($RS_StdClasses);

$maxRows_RS_CurrentClasses = 10;
$pageNum_RS_CurrentClasses = 0;
if (isset($_GET['pageNum_RS_CurrentClasses'])) {
  $pageNum_RS_CurrentClasses = $_GET['pageNum_RS_CurrentClasses'];
}
$startRow_RS_CurrentClasses = $pageNum_RS_CurrentClasses * $maxRows_RS_CurrentClasses;

mysql_select_db($database_conn, $conn);
$query_RS_CurrentClasses = "SELECT classes.*, courses.* FROM classes, courses WHERE classes.course_code=courses.course_code and classes.end_date > '" .date("Y-m-d")."'";
$query_limit_RS_CurrentClasses = sprintf("%s LIMIT %d, %d", $query_RS_CurrentClasses, $startRow_RS_CurrentClasses, $maxRows_RS_CurrentClasses);
$RS_CurrentClasses = mysql_query($query_limit_RS_CurrentClasses, $conn) or die(mysql_error());
$row_RS_CurrentClasses = mysql_fetch_assoc($RS_CurrentClasses);

if (isset($_GET['totalRows_RS_CurrentClasses'])) {
  $totalRows_RS_CurrentClasses = $_GET['totalRows_RS_CurrentClasses'];
} else {
  $all_RS_CurrentClasses = mysql_query($query_RS_CurrentClasses);
  $totalRows_RS_CurrentClasses = mysql_num_rows($all_RS_CurrentClasses);
}
$totalPages_RS_CurrentClasses = ceil($totalRows_RS_CurrentClasses/$maxRows_RS_CurrentClasses)-1;

$colname_RS_SearchCourseFee = "-1";
if (isset($_GET['receipt_id'])) {
  $colname_RS_SearchCourseFee = $_GET['receipt_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_SearchCourseFee = sprintf("SELECT * FROM receipts WHERE receipt_id = %s", GetSQLValueString($colname_RS_SearchCourseFee, "int"));
$RS_SearchCourseFee = mysql_query($query_RS_SearchCourseFee, $conn) or die(mysql_error());
$row_RS_SearchCourseFee = mysql_fetch_assoc($RS_SearchCourseFee);
$totalRows_RS_SearchCourseFee = mysql_num_rows($RS_SearchCourseFee);

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

$colname_RS_SearchCertficate = "-1";
if (isset($_GET['cert_id'])) {
  $colname_RS_SearchCertficate = $_GET['cert_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_SearchCertficate = sprintf("SELECT * FROM certificate WHERE cert_id = %s", GetSQLValueString($colname_RS_SearchCertficate, "int"));
$RS_SearchCertficate = mysql_query($query_RS_SearchCertficate, $conn) or die(mysql_error());
$row_RS_SearchCertficate = mysql_fetch_assoc($RS_SearchCertficate);
$totalRows_RS_SearchCertficate = mysql_num_rows($RS_SearchCertficate);

mysql_select_db($database_conn, $conn);

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
			</div></td>
            <td align="left" valign="top" width="652"><table border="0" cellpadding="0" cellspacing="0" width="640">
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
                        <td width="89" class="headerkizmo">mobile no</td>
                        <td colspan="2" class="smalltextbg"><?php echo $row_RS_Student1['mobile_no']; ?></td>
                        <td class="headerkizmo">Email Address</td>
                        <td colspan="2" class="smalltextbg"><?php echo $row_RS_Student1['email']; ?></td>
                        </tr>
                      <tr>
                        <td width="89" class="headerkizmo">Admin Date</td>
                        <td colspan="2" class="smalltextbg"><?php echo $row_RS_Student1['admission_date']; ?></td>
                        <td class="headerkizmo">Nationality</td>
                        <td colspan="2" class="smalltextbg"><?php echo $row_RS_Student1['nationality']; ?></td>
                        </tr>
                    </table></td>
                    </tr>
                  
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                  </tr>
                  <tr bgcolor="#EBEBEB">
                    <td width="272" align="left" valign="top"><form action="<?php echo $currentPage ?>" method="get">
                      <fieldset>
                      <legend>Search</legend>
                        <ol>
                        <li>
                          <label for="name">By Certificate ID:</label>
                          <br />
                          <input id="cert_id" name="cert_id" class="inputText" type="text" />
                          <input name="cmdSearch" type="image" id="cmdSearch" src="images/icons/b_search.png" alt="[Search]" />
                          <input name="action" type="hidden" id="action" value="open" />
                          <input type="hidden" name="std_id" id="std_id" value="<?php echo $_GET['std_id'];?>"/>
                        </li>
                        </ol>
                        </fieldset>
                    </form></td>
                    <td width="396" align="center" valign="middle"><?php if ($totalRows_RS_SearchCertficate > 0) { // Show if recordset not empty ?>
                        <table width="100%" border="0" cellspacing="1" cellpadding="0">
                          <tr>
                            <td colspan="2" class="headerkizmo">Certificate Found</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                              <td class="headerzorkif">Cert_ID</td>
                            <td class="smalltextbg"><?php echo $row_RS_SearchCertficate['cert_id']; ?></td>
                            <td class="headerzorkif">Date</td>
                            <td class="smalltextbg"><?php echo $row_RS_SearchCertficate['date']; ?></td>
                          </tr>
                          <tr>
                              <td colspan="2" class="headerzorkif">Class Code</td>
                            <td colspan="2" class="smalltextbg"><?php echo $row_RS_SearchCertficate['class_code']; ?></td>
                          </tr>
                          <tr>
                              <td class="headerzorkif">Grade</td>
                            <td colspan="3" class="smalltextbg"><?php echo $row_RS_SearchCertficate['grade']; ?></td>
                            </tr>
                                            </table>
                        <?php } // Show if recordset not empty ?></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
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
                            <td><a href="<?php echo $currentPage."?action=open&std_id=".$_SESSION['std_id']."&cert_id=".$row_RS_CertificatesIssued['cert_id']; ?>"><img src="images/icons/b_edit.png" alt="[Edit]" width="16" height="16" /><?php echo $row_RS_CertificatesIssued['cert_id']; ?></a></td>
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
              </tbody></table>            </td>
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

mysql_free_result($RS_AllCourses);

mysql_free_result($RS_StdClasses);

mysql_free_result($RS_CurrentClasses);

mysql_free_result($RS_SearchCourseFee);

mysql_free_result($RS_CertificatesIssued);

mysql_free_result($RS_SearchCertficate);


?>