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

if ((isset($_GET['std_class_id'])) && ($_GET['std_class_id'] != "") && (isset($_GET['action']))) {
  $deleteSQL = sprintf("DELETE FROM std_classes WHERE std_class_id=%s",
                       GetSQLValueString($_GET['std_class_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE receipts SET recipt_number=%s, amount=%s, `date`=%s, class_code=%s WHERE receipt_id=%s",
                       GetSQLValueString($_POST['recipt_number'], "text"),
                       GetSQLValueString($_POST['amount'], "int"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['class_code'], "text"),
                       GetSQLValueString($_POST['receipt_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
}

if ((isset($_GET['receipt_id'])) && ($_GET['receipt_id'] != "") && (isset($_GET['action'])) && $_GET['action']=="delete") {
  $deleteSQL = sprintf("DELETE FROM receipts WHERE receipt_id=%s",
                       GetSQLValueString($_GET['receipt_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

if ((isset($_GET["MM_insert"])) && ($_GET["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO receipts (recipt_number, std_id, amount, date, class_code) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_GET['recipt_number'], "text"),
					   GetSQLValueString($_SESSION['std_id'], "text"),
                       GetSQLValueString($_GET['amount'], "int"),
					   GetSQLValueString(date('Y-m-d'), "date"),
                       GetSQLValueString($_GET['class_code'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET["action"])) && ($_GET["action"] == "add_toclass")) {
  $insertSQL = sprintf("INSERT INTO std_classes (std_id, class_code, joining_date, agreed_fee) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_GET['std_id'], "int"),
                       GetSQLValueString($_GET['class_code'], "text"),
                       GetSQLValueString(date("Y-m-d"), "date"),
					   GetSQLValueString($_GET['agreed_fee'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
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

$colname_RS_Student1 = "-1";
if (isset($_GET['std_id'])) {
  $colname_RS_Student1 = $_GET['std_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_Student1 = sprintf("SELECT * FROM students WHERE std_id = %s", GetSQLValueString($colname_RS_Student1, "int"));
$RS_Student1 = mysql_query($query_RS_Student1, $conn) or die(mysql_error());
$row_RS_Student1 = mysql_fetch_assoc($RS_Student1);
$totalRows_RS_Student1 = mysql_num_rows($RS_Student1);

$maxRows_RS_pAddress = 10;
$pageNum_RS_pAddress = 0;
if (isset($_GET['pageNum_RS_pAddress'])) {
  $pageNum_RS_pAddress = $_GET['pageNum_RS_pAddress'];
}
$startRow_RS_pAddress = $pageNum_RS_pAddress * $maxRows_RS_pAddress;

$colname_RS_pAddress = "-1";
if (isset($_GET['std_id'])) {
  $colname_RS_pAddress = $_GET['std_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_pAddress = sprintf("SELECT address, city, post_code, county_province, country FROM std_perm_address WHERE std_id = %s", GetSQLValueString($colname_RS_pAddress, "int"));
$query_limit_RS_pAddress = sprintf("%s LIMIT %d, %d", $query_RS_pAddress, $startRow_RS_pAddress, $maxRows_RS_pAddress);
$RS_pAddress = mysql_query($query_limit_RS_pAddress, $conn) or die(mysql_error());
$row_RS_pAddress = mysql_fetch_assoc($RS_pAddress);

if (isset($_GET['totalRows_RS_pAddress'])) {
  $totalRows_RS_pAddress = $_GET['totalRows_RS_pAddress'];
} else {
  $all_RS_pAddress = mysql_query($query_RS_pAddress);
  $totalRows_RS_pAddress = mysql_num_rows($all_RS_pAddress);
}
$totalPages_RS_pAddress = ceil($totalRows_RS_pAddress/$maxRows_RS_pAddress)-1;

$maxRows_RS_tAddress = 10;
$pageNum_RS_tAddress = 0;
if (isset($_GET['pageNum_RS_tAddress'])) {
  $pageNum_RS_tAddress = $_GET['pageNum_RS_tAddress'];
}
$startRow_RS_tAddress = $pageNum_RS_tAddress * $maxRows_RS_tAddress;

$colname_RS_tAddress = "-1";
if (isset($_GET['std_id'])) {
  $colname_RS_tAddress = $_GET['std_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_tAddress = sprintf("SELECT address, city, post_code, county_province, country FROM std_temp_address WHERE std_id = %s", GetSQLValueString($colname_RS_tAddress, "int"));
$query_limit_RS_tAddress = sprintf("%s LIMIT %d, %d", $query_RS_tAddress, $startRow_RS_tAddress, $maxRows_RS_tAddress);
$RS_tAddress = mysql_query($query_limit_RS_tAddress, $conn) or die(mysql_error());
$row_RS_tAddress = mysql_fetch_assoc($RS_tAddress);

if (isset($_GET['totalRows_RS_tAddress'])) {
  $totalRows_RS_tAddress = $_GET['totalRows_RS_tAddress'];
} else {
  $all_RS_tAddress = mysql_query($query_RS_tAddress);
  $totalRows_RS_tAddress = mysql_num_rows($all_RS_tAddress);
}
$totalPages_RS_tAddress = ceil($totalRows_RS_tAddress/$maxRows_RS_tAddress)-1;

$colname_RS_stdQualifications = "-1";
if (isset($_GET['std_id'])) {
  $colname_RS_stdQualifications = $_GET['std_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_stdQualifications = sprintf("SELECT institute_name, degree_certificate, subject, `session`, grade_percentage FROM std_qualification WHERE std_id = %s", GetSQLValueString($colname_RS_stdQualifications, "int"));
$RS_stdQualifications = mysql_query($query_RS_stdQualifications, $conn) or die(mysql_error());
$row_RS_stdQualifications = mysql_fetch_assoc($RS_stdQualifications);
$totalRows_RS_stdQualifications = mysql_num_rows($RS_stdQualifications);

$colname_RS_stdWorkExp = "-1";
if (isset($_GET['std_id'])) {
  $colname_RS_stdWorkExp = $_GET['std_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_stdWorkExp = sprintf("SELECT `position`, organization, start_date, end_date, address FROM std_work_experience WHERE std_id = %s", GetSQLValueString($colname_RS_stdWorkExp, "int"));
$RS_stdWorkExp = mysql_query($query_RS_stdWorkExp, $conn) or die(mysql_error());
$row_RS_stdWorkExp = mysql_fetch_assoc($RS_stdWorkExp);
$totalRows_RS_stdWorkExp = mysql_num_rows($RS_stdWorkExp);

$colname_RS_stdRefrences = "-1";
if (isset($_GET['std_id'])) {
  $colname_RS_stdRefrences = $_GET['std_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_stdRefrences = sprintf("SELECT name, `position`, address, country, post_code, phone_no, fax_no, email FROM std_references WHERE std_id = %s", GetSQLValueString($colname_RS_stdRefrences, "int"));
$RS_stdRefrences = mysql_query($query_RS_stdRefrences, $conn) or die(mysql_error());
$row_RS_stdRefrences = mysql_fetch_assoc($RS_stdRefrences);
$totalRows_RS_stdRefrences = mysql_num_rows($RS_stdRefrences);

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

$maxRows_RS_StdAllFee = 20;
$pageNum_RS_StdAllFee = 0;
if (isset($_GET['pageNum_RS_StdAllFee'])) {
  $pageNum_RS_StdAllFee = $_GET['pageNum_RS_StdAllFee'];
}
$startRow_RS_StdAllFee = $pageNum_RS_StdAllFee * $maxRows_RS_StdAllFee;

$colname_RS_StdAllFee = "-1";
if (isset($_SESSION['std_id'])) {
  $colname_RS_StdAllFee = $_SESSION['std_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_StdAllFee = sprintf("SELECT * FROM receipts WHERE std_id = %s ORDER BY class_code ASC", GetSQLValueString($colname_RS_StdAllFee, "int"));
$query_limit_RS_StdAllFee = sprintf("%s LIMIT %d, %d", $query_RS_StdAllFee, $startRow_RS_StdAllFee, $maxRows_RS_StdAllFee);
$RS_StdAllFee = mysql_query($query_limit_RS_StdAllFee, $conn) or die(mysql_error());
$row_RS_StdAllFee = mysql_fetch_assoc($RS_StdAllFee);

if (isset($_GET['totalRows_RS_StdAllFee'])) {
  $totalRows_RS_StdAllFee = $_GET['totalRows_RS_StdAllFee'];
} else {
  $all_RS_StdAllFee = mysql_query($query_RS_StdAllFee);
  $totalRows_RS_StdAllFee = mysql_num_rows($all_RS_StdAllFee);
}
$totalPages_RS_StdAllFee = ceil($totalRows_RS_StdAllFee/$maxRows_RS_StdAllFee)-1;

$colname_RS_STD_TotalFeeAmount = "-1";
if (isset($_SESSION['std_id'])) {
  $colname_RS_STD_TotalFeeAmount = $_SESSION['std_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_STD_TotalFeeAmount = sprintf("SELECT SUM(amount) as amount FROM receipts WHERE std_id = %s", GetSQLValueString($colname_RS_STD_TotalFeeAmount, "int"));
$RS_STD_TotalFeeAmount = mysql_query($query_RS_STD_TotalFeeAmount, $conn) or die(mysql_error());
$row_RS_STD_TotalFeeAmount = mysql_fetch_assoc($RS_STD_TotalFeeAmount);
$totalRows_RS_STD_TotalFeeAmount = mysql_num_rows($RS_STD_TotalFeeAmount);

$colname_RS_SearchCourseFee = "-1";
if (isset($_GET['receipt_id'])) {
  $colname_RS_SearchCourseFee = $_GET['receipt_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_SearchCourseFee = sprintf("SELECT * FROM receipts WHERE receipt_id = %s", GetSQLValueString($colname_RS_SearchCourseFee, "int"));
$RS_SearchCourseFee = mysql_query($query_RS_SearchCourseFee, $conn) or die(mysql_error());
$row_RS_SearchCourseFee = mysql_fetch_assoc($RS_SearchCourseFee);
$totalRows_RS_SearchCourseFee = mysql_num_rows($RS_SearchCourseFee);

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
			</div>			</td>
            <td align="left" valign="top" width="652"><table border="0" cellpadding="0" cellspacing="0" width="640">
                <tbody><tr>
                  <td align="left" valign="top" width="232"><p class="headerkizmo">Student Biodata</p>
                    <div align="justify">
                      <div class="text" align="justify">
                        <table width="100%" border="0" cellspacing="1" cellpadding="1">
                          <tr>
                            <td width="40%" class="tabledatakizmo"><u>std id</u></td>
                            <td width="49%" class="smalltextbg"><?php echo $row_RS_Student1['std_id']; ?></td>
                          </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">title</td>
                            <td class="smalltextbg"><?php echo $row_RS_Student1['title']; ?></td>
                          </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">first name</td>
                            <td class="smalltextbg"><?php echo $row_RS_Student1['first_name']; ?></td>
                          </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">last name</td>
                            <td class="smalltextbg"><?php echo $row_RS_Student1['last_name']; ?></td>
                          </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">father name</td>
                            <td class="smalltextbg"><?php echo $row_RS_Student1['father_name']; ?></td>
                          </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">mobile no</td>
                            <td class="smalltextbg"><?php echo $row_RS_Student1['mobile_no']; ?></td>
                          </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">nationality</td>
                            <td class="smalltextbg"><?php echo $row_RS_Student1['nationality']; ?></td>
                          </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">email</td>
                            <td class="smalltextbg"><?php echo $row_RS_Student1['email']; ?></td>
                          </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">adm. date</td>
                            <td class="smalltextbg"><?php echo $row_RS_Student1['admission_date']; ?></td>
                          </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">Adm. status</td>
                            <td class="smalltextbg"><?php echo $row_RS_Student1['admission_status']; ?></td>
                          </tr>
                        </table>
                        </div>
                    </div>
                    <div class="MarginStyle1" align="justify"></div></td>
                  <td align="left" valign="top" width="408"><br />
                    <?php if ($totalRows_RS_SearchCourseFee > 0) { // Show if recordset not empty ?>
                      <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                          <table align="center">
                              <tr valign="baseline">
                                <td colspan="2" align="right" nowrap="nowrap" class="headerkizmo"><div align="center">Edit a Perticular Fee Record</div></td>
                                </tr>
                              <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="tabledatakizmo">Receipt_id:</td>
                                <td class="smalltextbg"><?php echo $row_RS_SearchCourseFee['receipt_id']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="tabledatakizmo">Recipt_number:</td>
                                <td class="smalltextbg"><input type="text" name="recipt_number2" value="<?php echo htmlentities($row_RS_SearchCourseFee['recipt_number'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                              </tr>
                              <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="tabledatakizmo">Amount:</td>
                                <td class="smalltextbg"><input type="text" name="amount2" value="<?php echo htmlentities($row_RS_SearchCourseFee['amount'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                              </tr>
                              <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="tabledatakizmo">Date:</td>
                                <td class="smalltextbg"><input type="text" name="date2" value="<?php echo htmlentities($row_RS_SearchCourseFee['date'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                              </tr>
                              <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="tabledatakizmo">Class_code:</td>
                                <td class="smalltextbg"><select name="class_code2">
                                      <?php 
do {  
?>
                                      <option value="<?php echo $row_RS_StdClasses['class_code']?>" <?php if (!(strcmp($row_RS_StdClasses['class_code'], htmlentities($row_RS_SearchCourseFee['class_code'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>><?php echo $row_RS_StdClasses['class_code']?></option>
                                      <?php
} while ($row_RS_StdClasses = mysql_fetch_assoc($RS_StdClasses));
?>
                                                                </select>                                                            </td>
                              </tr>
                              
                              <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="tabledatakizmo">&nbsp;</td>
                                <td class="smalltextbg"><input type="submit" value="Update" /></td>
                              </tr>
                                                </table>
                        <input type="hidden" name="MM_update" value="form2" />
                          <input type="hidden" name="receipt_id" value="<?php echo $row_RS_SearchCourseFee['receipt_id']; ?>" />
                                          </form>
                      <?php } // Show if recordset not empty ?>
<br /></td>
                </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellpadding="1" cellspacing="1">
                        <tr class="headerzorkif">
                          <td width="437">Add Fee Record</td>
                          <td width="203">class code </td>
                          <td width="359">Agreed Fee</td>
                          <td width="365">joining_date</td>
                        </tr>
                        <?php do { ?>
                          <tr class="tablerowzorkif">
                            <td>
                            <?php
							$query_RS_TotalCourseFeePaid = "SELECT SUM( receipts.amount) as total_coursefeepaid FROM receipts WHERE receipts.std_id=".$_SESSION['std_id']." AND receipts.class_code='".$row_RS_StdClasses['class_code']."'";
$RS_TotalCourseFeePaid = mysql_query($query_RS_TotalCourseFeePaid, $conn) or die(mysql_error());
$row_RS_TotalCourseFeePaid = mysql_fetch_assoc($RS_TotalCourseFeePaid);
$totalRows_RS_TotalCourseFeePaid = mysql_num_rows($RS_TotalCourseFeePaid);
if ($row_RS_TotalCourseFeePaid['total_coursefeepaid']<$row_RS_StdClasses['agreed_fee']) {
							?>
                              <form action="<?php echo $editFormAction; ?>" method="get" name="form1" id="form1">
                                <table width="309" align="center">
                                  <tr valign="baseline">
                                    <td width="107" align="right" nowrap="nowrap">Recipt No:
                                      <input name="recipt_number" type="text" value="" size="5" maxlength="4" />
                                      :</td>
                                    <td width="53">Amount:</td>
                                    <td width="145"><input name="amount" type="text" value="<?php 
if ($row_RS_TotalCourseFeePaid['total_coursefeepaid']<$row_RS_StdClasses['agreed_fee']) {
$CurrentBalance= $row_RS_StdClasses['agreed_fee']-$row_RS_TotalCourseFeePaid['total_coursefeepaid'];
									echo $CurrentBalance;
									}
									?>" size="6" maxlength="5" />
                                      <label>
                                      <input name="submit" type="image" id="submit" src="images/icons/b_newtbl.png" alt="Add New" />
                                      </label></td>
                                  </tr>
                                </table>
                                <input type="hidden" name="MM_insert" value="form1" />
                                <input name="class_code" type="hidden" id="class_code" value="<?php echo $row_RS_StdClasses['class_code']; ?>" />
                                <input name="date" type="hidden" id="class_code2" value="<?php  echo date('Y-m-d')?>" />
                                <input name="std_id" type="hidden" id="class_code3" value="<?php  echo $_SESSION['std_id']; ?>" />
                              </form>    
                              <div align="center">
                                <?php 
							  }else {
							  ?>
                              </div>
                              <p align="center" class="smallmsgbox">Fee Paid </p>
                              <div align="center">
                                <?php }?>
                                
                                  </div></td>
                            <td width="203" class="text"><?php echo $row_RS_StdClasses['class_code']; ?></td>
                            <td width="359"><span class="text"><?php echo $row_RS_StdClasses['agreed_fee']; ?></span></td>
                            <td width="365"><?php echo $row_RS_StdClasses['joining_date']; ?></td>
                          </tr>
                          <?php } while ($row_RS_StdClasses = mysql_fetch_assoc($RS_StdClasses)); ?>
                      </table></td>
                    </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top">&nbsp;
                      <?php if ($totalRows_RS_StdAllFee > 0) { // Show if recordset not empty ?>
                        <table width="100%" border="0" cellpadding="1" cellspacing="1">
                          <tr class="headerzorkif">
                            <td>Action</td>
                                <td>recipt_number</td>
                                <td>amount</td>
                                <td>date</td>
                                <td>class_code</td>
                            </tr>
                          <?php do { ?>
                            <tr class="smalltextbg">
                              <td><a href="<?php echo $currentPage."?action=edit&std_id=".$_GET['std_id']."&receipt_id=".$row_RS_StdAllFee['receipt_id']; ?>"><img src="images/icons/b_edit.png" width="16" height="16" /></a> | <a href="<?php echo $currentPage."?action=delete&std_id=".$_GET['std_id']."&receipt_id=".$row_RS_StdAllFee['receipt_id']; ?>"><img src="images/icons/b_drop.png" width="16" height="16" /></a> </td>
                              <td><?php echo $row_RS_StdAllFee['recipt_number']; ?></td>
                              <td><?php echo $row_RS_StdAllFee['amount']; ?></td>
                              <td><?php echo $row_RS_StdAllFee['date']; ?></td>
                              <td><?php echo $row_RS_StdAllFee['class_code']; ?></td>
                            </tr>
                             <?php } while ($row_RS_StdAllFee = mysql_fetch_assoc($RS_StdAllFee)); ?>
                          <tr>
                            <td>&nbsp;</td>
                                <td class="headerkizmo">Total Amount Paid:</td>
                                <td class="headerkizmo"><?php echo $row_RS_STD_TotalFeeAmount['amount']; ?></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                        </table>
                        <?php } // Show if recordset not empty ?></td>
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

mysql_free_result($RS_pAddress);

mysql_free_result($RS_tAddress);

mysql_free_result($RS_stdQualifications);

mysql_free_result($RS_stdWorkExp);

mysql_free_result($RS_stdRefrences);

mysql_free_result($RS_AllCourses);

mysql_free_result($RS_StdClasses);

mysql_free_result($RS_CurrentClasses);

mysql_free_result($RS_StdAllFee);

mysql_free_result($RS_STD_TotalFeeAmount);

mysql_free_result($RS_SearchCourseFee);

mysql_free_result($RS_TotalCourseFeePaid);
?>