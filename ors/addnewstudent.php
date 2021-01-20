<?php require_once('Connections/conn.php'); ?>
<?php require_once '../admin/access_restrictions.php'; ?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO students (title, first_name, last_name, father_name, gender, course_code, phone_no, mobile_no, nationality, personal_statement, email, dob, admission_date, online_sign, admission_status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['first_name'], "text"),
                       GetSQLValueString($_POST['last_name'], "text"),
                       GetSQLValueString($_POST['father_name'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['course_code'], "int"),
                       GetSQLValueString($_POST['phone_no'], "text"),
                       GetSQLValueString($_POST['mobile_no'], "text"),
                       GetSQLValueString($_POST['nationality'], "text"),
                       GetSQLValueString($_POST['personal_statement'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['dob'], "date"),
                       GetSQLValueString($_POST['admission_date'], "date"),
                       GetSQLValueString(isset($_POST['online_sign']) ? "true" : "", "defined","'Y'","'N'"),
                       GetSQLValueString(isset($_POST['admission_status']) ? "true" : "", "defined","'Y'","'N'"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  $_SESSION['std_id']=mysql_insert_id();  // 
  $insertGoTo = "addnewstudent2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn, $conn);
$query_RS_Courses = "SELECT * FROM courses ORDER BY name ASC";
$RS_Courses = mysql_query($query_RS_Courses, $conn) or die(mysql_error());
$row_RS_Courses = mysql_fetch_assoc($RS_Courses);
$totalRows_RS_Courses = mysql_num_rows($RS_Courses);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-6" />
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
	<link rel="stylesheet" type="text/css" href="gnpcss.css" media="screen" />
    <title>Innova ORS [New Student]</title>
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
                        <p>Please Provide All the Details about the students. This process will be completed in a few steps. When you finish this form please click [next] button to continue.</p>
                        </td>
                  <td align="left" valign="top" width="408"><div class="MarginStyle1" align="left">
                    <table border="0" cellpadding="0" cellspacing="0" width="398">
                      <tbody>
                        <tr>
                          <td class="headerkizmo" align="center" valign="middle" width="398">Details...... </td>
                        </tr>
                        <tr class="formBIG">
                          <td class="BoxBorderGray">&nbsp;
                            <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                              <table align="center">
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">Title:</td>
                                  <td class="smalltextbg"><select name="title">
                                      <option value="Mr." <?php if (!(strcmp("Mr.", ""))) {echo "SELECTED";} ?>>Mr.</option>
                                      <option value="Miss." <?php if (!(strcmp("Miss.", ""))) {echo "";} ?>>Miss.</option>
                                      <option value="Mrs." <?php if (!(strcmp("Mrs.", ""))) {echo "";} ?>>Mrs.</option>
                                    </select>
                                  </td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">First Name(s):</td>
                                  <td class="smalltextbg"><input type="text" name="first_name" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">Last Name:</td>
                                  <td class="smalltextbg"><input type="text" name="last_name" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">Father Name:</td>
                                  <td class="smalltextbg"><input type="text" name="father_name" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">Gender:</td>
                                  <td class="smalltextbg"><select name="gender">
                                      <option value="M" <?php if (!(strcmp("M", ""))) {echo "SELECTED";} ?>>Male</option>
                                      <option value="F" <?php if (!(strcmp("F", ""))) {echo "";} ?>>Female</option>
                                    </select>
                                  </td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">Course:</td>
                                  <td class="smalltextbg"><select name="course_code">
                                      <?php 
do {  
?>
                                      <option value="<?php echo $row_RS_Courses['course_code']?>" ><?php echo $row_RS_Courses['name']?></option>
                                      <?php
} while ($row_RS_Courses = mysql_fetch_assoc($RS_Courses));
?>
                                    </select>
                                  </td>
                                </tr>
                                <tr> </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">Phone No:</td>
                                  <td class="smalltextbg"><input type="text" name="phone_no" value="0" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">Mobile No:</td>
                                  <td class="smalltextbg"><input type="text" name="mobile_no" value="0" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">Nationality:</td>
                                  <td class="smalltextbg"><input type="text" name="nationality" value="Pakistan" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">Personal Statement:</td>
                                  <td class="smalltextbg"><input type="text" name="personal_statement" value="N/A" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">Email:</td>
                                  <td class="smalltextbg"><input type="text" name="email" value="N/A" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">Dob:</td>
                                  <td class="smalltextbg"><input type="text" name="dob" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">Admission Date:</td>
                                  <td class="smalltextbg"><input type="text" name="admission_date" value="<?php echo date("Y-m-d")?>" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">Online Sign:</td>
                                  <td class="smalltextbg"><input type="checkbox" name="online_sign" value="" checked="checked" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">Admission Status:</td>
                                  <td class="smalltextbg"><input type="checkbox" name="admission_status" value="" checked="checked" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td align="right" nowrap="nowrap" class="headerkizmo">&nbsp;</td>
                                  <td class="smalltextbg"><input name="cmdNext" type="submit" id="cmdNext" value="[ Next ]  -&gt;" /></td>
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
mysql_free_result($RS_Courses);
?>