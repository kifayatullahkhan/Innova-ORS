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

if ((isset($_GET['std_class_id'])) && ($_GET['std_class_id'] != "") && (isset($_GET['action']))) {
  $deleteSQL = sprintf("DELETE FROM std_classes WHERE std_class_id=%s",
                       GetSQLValueString($_GET['std_class_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
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

$maxRows_RS_tAddress = 10000;
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

$maxRows_RS_CurrentClasses = 5;
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

$queryString_RS_CurrentClasses = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_CurrentClasses") == false && 
        stristr($param, "totalRows_RS_CurrentClasses") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_CurrentClasses = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_CurrentClasses = sprintf("&totalRows_RS_CurrentClasses=%d%s", $totalRows_RS_CurrentClasses, $queryString_RS_CurrentClasses);
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
                  <td align="left" valign="top" width="232"><p class="headerkizmo">Student Biodata</p><div class="text" align="justify">
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
                            <td width="40%" class="tabledatakizmo">gender</td>
                              <td class="smalltextbg"><?php echo $row_RS_Student1['gender']; ?></td>
                            </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">course code</td>
                              <td class="smalltextbg"><?php echo $row_RS_Student1['course_code']; ?></td>
                            </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">phone no</td>
                              <td class="smalltextbg"><?php echo $row_RS_Student1['phone_no']; ?></td>
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
                            <td width="40%" class="tabledatakizmo">dob</td>
                              <td class="smalltextbg"><?php echo $row_RS_Student1['dob']; ?></td>
                            </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">adm. date</td>
                              <td class="smalltextbg"><?php echo $row_RS_Student1['admission_date']; ?></td>
                            </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">online sign</td>
                              <td class="smalltextbg"><?php echo $row_RS_Student1['online_sign']; ?></td>
                            </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">Adm. status</td>
                              <td class="smalltextbg"><?php echo $row_RS_Student1['admission_status']; ?></td>
                            </tr>
                          <tr>
                            <td width="40%" class="tabledatakizmo">per. statement</td>
                              <td class="smalltextbg"><?php echo $row_RS_Student1['personal_statement']; ?></td>
                            </tr>
                          </table>
                          <p>&nbsp;</p>
                        </div>
                      <div class="MarginStyle1" align="justify">
                      <div class="curlycontainer" align="justify"></div>
                    </div></td>
                  <td align="left" valign="top" width="408"><div class="MarginStyle1" align="left">                    <table border="0" cellpadding="0" cellspacing="0" width="398">
                      <tbody>
                        <tr>
                          <td class="headerkizmo" align="center" valign="middle" width="398">Parmanent Address</td>
                        </tr>
                        <tr>
                          <td class="BoxBorderGray"><table width="100%" border="0" cellpadding="1" cellspacing="1">
                              <tr class="headerzorkif">
                                <td>address</td>
                                <td>city</td>
                                <td>post code</td>
                                <td>province</td>
                                <td>country</td>
                              </tr>
                              <?php do { ?>
                                <tr class="smalltextbg">
                                  <td><?php echo $row_RS_pAddress['address']; ?></td>
                                  <td><?php echo $row_RS_pAddress['city']; ?></td>
                                  <td><?php echo $row_RS_pAddress['post_code']; ?></td>
                                  <td><?php echo $row_RS_pAddress['county_province']; ?></td>
                                  <td><?php echo $row_RS_pAddress['country']; ?></td>
                                </tr>
                                <?php } while ($row_RS_pAddress = mysql_fetch_assoc($RS_pAddress)); ?>
                            </table></td>
                        </tr>
                      </tbody>
                    </table>
                  </div><br />
                    <div class="MarginStyle1" align="left">                    <table border="0" cellpadding="0" cellspacing="0" width="398">
                      <tbody>
                        <tr>
                          <td class="headerkizmo" align="center" valign="middle" width="398">Temparory Address</td>
                        </tr>
                        <tr>
                          <td class="BoxBorderGray"><table width="100%" border="0" cellpadding="1" cellspacing="1">
                              <tr class="headerzorkif">
                                <td>address</td>
                                <td>city</td>
                                <td>post code</td>
                                <td>province</td>
                                <td>country</td>
                              </tr>
                              <?php do { ?>
                                <tr class="smalltextbg">
                                  <td><?php echo $row_RS_tAddress['address']; ?></td>
                                  <td><?php echo $row_RS_tAddress['city']; ?></td>
                                  <td><?php echo $row_RS_tAddress['post_code']; ?></td>
                                  <td><?php echo $row_RS_tAddress['county_province']; ?></td>
                                  <td><?php echo $row_RS_tAddress['country']; ?></td>
                                </tr>
                                <?php } while ($row_RS_tAddress = mysql_fetch_assoc($RS_tAddress)); ?>
                            </table></td>
                        </tr>
                      </tbody>
                    </table>
                  </div><br /><div class="MarginStyle1" align="left">                    <table border="0" cellpadding="0" cellspacing="0" width="398">
                      <tbody>
                        <tr>
                          <td class="headerkizmo" align="center" valign="middle" width="398">Qualifications</td>
                        </tr>
                        <tr>
                          <td>
                            <table width="100%" border="0" cellpadding="1" cellspacing="1">
                              <tr class="headerzorkif">
                                <td>institute</td>
                                <td>degree</td>
                                <td>subject</td>
                                <td>session</td>
                                <td>grade/ percentage</td>
                              </tr>
                              <?php do { ?>
                                <tr class="smalltextbg">
                                  <td><?php echo $row_RS_stdQualifications['institute_name']; ?></td>
                                  <td><?php echo $row_RS_stdQualifications['degree_certificate']; ?></td>
                                  <td><?php echo $row_RS_stdQualifications['subject']; ?></td>
                                  <td><?php echo $row_RS_stdQualifications['session']; ?></td>
                                  <td><?php echo $row_RS_stdQualifications['grade_percentage']; ?></td>
                                </tr>
                                <?php } while ($row_RS_stdQualifications = mysql_fetch_assoc($RS_stdQualifications)); ?>
                            </table></td>
                        </tr>
                      </tbody>
                    </table>
                  </div><br />
                  <div class="MarginStyle1" align="left">                    <table border="0" cellpadding="0" cellspacing="0" width="398">
                      <tbody>
                        <tr>
                          <td class="headerkizmo" align="center" valign="middle" width="398">Work Experiences</td>
                        </tr>
                        <tr>
                          <td class="BoxBorderGray"><table width="100%" border="0" cellpadding="1" cellspacing="1">
                              <tr class="headerzorkif">
                                <td>position</td>
                                <td>organization</td>
                                <td>start_date</td>
                                <td>end_date</td>
                                <td>address</td>
                              </tr>
                              <?php do { ?>
                                <tr class="smalltextbg">
                                  <td><?php echo $row_RS_stdWorkExp['position']; ?></td>
                                  <td><?php echo $row_RS_stdWorkExp['organization']; ?></td>
                                  <td><?php echo $row_RS_stdWorkExp['start_date']; ?></td>
                                  <td><?php echo $row_RS_stdWorkExp['end_date']; ?></td>
                                  <td><?php echo $row_RS_stdWorkExp['address']; ?></td>
                                </tr>
                                <?php } while ($row_RS_stdWorkExp = mysql_fetch_assoc($RS_stdWorkExp)); ?>
                            </table></td>
                        </tr>
                      </tbody>
                    </table>
                  </div> <br />
                  <div class="MarginStyle1" align="left">                    <table border="0" cellpadding="0" cellspacing="0" width="398">
                      <tbody>
                        <tr>
                          <td class="headerkizmo" align="center" valign="middle" width="398">Refrences</td>
                        </tr>
                        <tr>
                          <td><table width="100%" border="0" cellpadding="1" cellspacing="1">
                              <tr class="headerzorkif">
                                <td>name</td>
                                <td>position</td>
                                <td>address</td>
                                <td>phone_no</td>
                                <td>email</td>
                              </tr>
                              <?php do { ?>
                                <tr class="smalltextbg">
                                  <td><?php echo $row_RS_stdRefrences['name']; ?></td>
                                  <td><?php echo $row_RS_stdRefrences['position']; ?></td>
                                  <td><?php echo $row_RS_stdRefrences['address']; ?></td>
                                  <td><?php echo $row_RS_stdRefrences['phone_no']; ?></td>
                                  <td><?php echo $row_RS_stdRefrences['email']; ?></td>
                                </tr>
                                <?php } while ($row_RS_stdRefrences = mysql_fetch_assoc($RS_stdRefrences)); ?>
                            </table></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>                    </td>
                </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellpadding="1" cellspacing="1">
                        <tr class="headerzorkif">
                          <td>Enter  Fee</td>
                          <td>class_code</td>
                          <td>timing</td>
                          <td>course code</td>
                          <td>start date</td>
                          <td>end date</td>
                          <td>name</td>
                          </tr>
                        <?php do { ?>
                          <tr class="smalltextbg">
                            <td><form id="form1" name="form1" method="get" action="<?php echo $currentPage ?>">
                                <label>
                                <input name="agreed_fee" type="text" class="inputText" id="agreed_fee" value="<?php echo $row_RS_CurrentClasses['fee']; ?>" size="6" maxlength="5" />
                                </label>
                                                            <label>
                                                            <input type="image" name="imageField" id="imageField" src="images/icons/b_newtbl.png" />
                                    </label>
                                                            <input name="action" type="hidden" id="action" value="add_toclass" />
                                                            <input name="class_code" type="hidden" id="class_code" value="<?php echo $row_RS_CurrentClasses['class_code']; ?>" />
                                                            <input name="std_id" type="hidden" id="std_id" value="<?php echo $_GET['std_id'];?>" />
                              </form>                              </td>
                            <td><?php echo $row_RS_CurrentClasses['class_code']; ?></td>
                            <td><?php echo $row_RS_CurrentClasses['timing']; ?></td>
                            <td><?php echo $row_RS_CurrentClasses['course_code']; ?></td>
                            <td><?php echo $row_RS_CurrentClasses['start_date']; ?></td>
                            <td><?php echo $row_RS_CurrentClasses['end_date']; ?></td>
                            <td><?php echo $row_RS_CurrentClasses['name']; ?></td>
                            </tr>
                          <?php } while ($row_RS_CurrentClasses = mysql_fetch_assoc($RS_CurrentClasses)); ?>
                      </table></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top"><table border="0">
                      <tr>
                        <td><?php if ($pageNum_RS_CurrentClasses > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_RS_CurrentClasses=%d%s", $currentPage, 0, $queryString_RS_CurrentClasses); ?>">First</a>
                              <?php } // Show if not first page ?>
                        </td>
                        <td><?php if ($pageNum_RS_CurrentClasses > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_RS_CurrentClasses=%d%s", $currentPage, max(0, $pageNum_RS_CurrentClasses - 1), $queryString_RS_CurrentClasses); ?>">Previous</a>
                              <?php } // Show if not first page ?>
                        </td>
                        <td><?php if ($pageNum_RS_CurrentClasses < $totalPages_RS_CurrentClasses) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_RS_CurrentClasses=%d%s", $currentPage, min($totalPages_RS_CurrentClasses, $pageNum_RS_CurrentClasses + 1), $queryString_RS_CurrentClasses); ?>">Next</a>
                              <?php } // Show if not last page ?>
                        </td>
                        <td><?php if ($pageNum_RS_CurrentClasses < $totalPages_RS_CurrentClasses) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_RS_CurrentClasses=%d%s", $currentPage, $totalPages_RS_CurrentClasses, $queryString_RS_CurrentClasses); ?>">Last</a>
                              <?php } // Show if not last page ?>
                        </td>
                      </tr>
                    </table>
                       
                      <p>&nbsp;</p>
                      <table width="100%" border="0" cellpadding="1" cellspacing="1">
                        <tr class="headerzorkif">
                          <td>Action</td>
                          <td>class code </td>
                          <td>Agreed Fee</td>
                          <td>joining_date</td>
                        </tr>
                        <?php do { ?>
                          <tr class="smalltextbg">
                            <td><a href="<?php echo $currentPage."?"."action=delete&std_class_id=". $row_RS_StdClasses['std_class_id']."&std_id=".$_GET['std_id']; ?>"><img src="images/icons/b_deltbl.png" width="16" height="16" /></a></td>
                            <td class="text"><?php echo $row_RS_StdClasses['class_code']; ?></td>
                            <td><span class="text"><?php echo $row_RS_StdClasses['agreed_fee']; ?></span></td>
                            <td><?php echo $row_RS_StdClasses['joining_date']; ?></td>
                          </tr>
                          <?php } while ($row_RS_StdClasses = mysql_fetch_assoc($RS_StdClasses)); ?>
                      </table></td>
                    </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top">&nbsp;
                      <p>&nbsp;</p></td>
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
mysql_free_result($RS_Student1);

mysql_free_result($RS_pAddress);

mysql_free_result($RS_tAddress);

mysql_free_result($RS_stdQualifications);

mysql_free_result($RS_stdWorkExp);

mysql_free_result($RS_stdRefrences);

mysql_free_result($RS_AllCourses);

mysql_free_result($RS_StdClasses);

mysql_free_result($RS_CurrentClasses);
?>