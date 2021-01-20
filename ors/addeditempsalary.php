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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO sallaries (amount, `date`, user_id, `month`) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['amount'], "int"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['user_id'], "int"),
                       GetSQLValueString($_POST['month'], "text"));

  mysql_select_db($database_conn, $conn);
  
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE sallaries SET user_id=%s, amount=%s, `date`=%s, `month`=%s WHERE sallary_id=%s",
                       GetSQLValueString($_POST['user_id'], "undefined"),
                       GetSQLValueString($_POST['amount'], "int"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['month'], "text"),
                       GetSQLValueString($_POST['sallary_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
}

if ((isset($_GET['sallary_id'])) && ($_GET['sallary_id'] != "") && (isset($_GET['action'])) && $_GET['action']=="deletesalary") {
  $deleteSQL = sprintf("DELETE FROM sallaries WHERE sallary_id=%s",
                       GetSQLValueString($_GET['sallary_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}


$maxRows_RS_Employees = 10;
$pageNum_RS_Employees = 0;
if (isset($_GET['pageNum_RS_Employees'])) {
  $pageNum_RS_Employees = $_GET['pageNum_RS_Employees'];
}
$startRow_RS_Employees = $pageNum_RS_Employees * $maxRows_RS_Employees;

mysql_select_db($database_conn, $conn);
$query_RS_Employees = "SELECT user_id, username, first_name, last_name FROM users WHERE user_type_id = 2 ORDER BY username ASC";
$query_limit_RS_Employees = sprintf("%s LIMIT %d, %d", $query_RS_Employees, $startRow_RS_Employees, $maxRows_RS_Employees);
$RS_Employees = mysql_query($query_limit_RS_Employees, $conn) or die(mysql_error());
$row_RS_Employees = mysql_fetch_assoc($RS_Employees);

if (isset($_GET['totalRows_RS_Employees'])) {
  $totalRows_RS_Employees = $_GET['totalRows_RS_Employees'];
} else {
  $all_RS_Employees = mysql_query($query_RS_Employees);
  $totalRows_RS_Employees = mysql_num_rows($all_RS_Employees);
}
$totalPages_RS_Employees = ceil($totalRows_RS_Employees/$maxRows_RS_Employees)-1;

mysql_select_db($database_conn, $conn);
$query_RS_12Months = "SELECT * FROM dt_months";
$RS_12Months = mysql_query($query_RS_12Months, $conn) or die(mysql_error());
$row_RS_12Months = mysql_fetch_assoc($RS_12Months);
$totalRows_RS_12Months = mysql_num_rows($RS_12Months);

$colname_RS_SearchEmployee = "-1";
if (isset($_GET['user_id'])) {
  $colname_RS_SearchEmployee = $_GET['user_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_SearchEmployee = sprintf("SELECT user_id, first_name, last_name, fix_salary FROM users WHERE user_id = %s AND users.user_type_id=2", GetSQLValueString($colname_RS_SearchEmployee, "int"));
$RS_SearchEmployee = mysql_query($query_RS_SearchEmployee, $conn) or die(mysql_error());
$row_RS_SearchEmployee = mysql_fetch_assoc($RS_SearchEmployee);
$totalRows_RS_SearchEmployee = mysql_num_rows($RS_SearchEmployee);

$maxRows_RS_ThisEmpSalary = 15;
$pageNum_RS_ThisEmpSalary = 0;
if (isset($_GET['pageNum_RS_ThisEmpSalary'])) {
  $pageNum_RS_ThisEmpSalary = $_GET['pageNum_RS_ThisEmpSalary'];
}
$startRow_RS_ThisEmpSalary = $pageNum_RS_ThisEmpSalary * $maxRows_RS_ThisEmpSalary;

$colname_RS_ThisEmpSalary = "-1";
if (isset($_GET['user_id'])) {
  $colname_RS_ThisEmpSalary = $_GET['user_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_ThisEmpSalary = sprintf("SELECT * FROM sallaries WHERE user_id = %s ORDER BY `date` DESC", GetSQLValueString($colname_RS_ThisEmpSalary, "int"));
$query_limit_RS_ThisEmpSalary = sprintf("%s LIMIT %d, %d", $query_RS_ThisEmpSalary, $startRow_RS_ThisEmpSalary, $maxRows_RS_ThisEmpSalary);
$RS_ThisEmpSalary = mysql_query($query_limit_RS_ThisEmpSalary, $conn) or die(mysql_error());
$row_RS_ThisEmpSalary = mysql_fetch_assoc($RS_ThisEmpSalary);

if (isset($_GET['totalRows_RS_ThisEmpSalary'])) {
  $totalRows_RS_ThisEmpSalary = $_GET['totalRows_RS_ThisEmpSalary'];
} else {
  $all_RS_ThisEmpSalary = mysql_query($query_RS_ThisEmpSalary);
  $totalRows_RS_ThisEmpSalary = mysql_num_rows($all_RS_ThisEmpSalary);
}
$totalPages_RS_ThisEmpSalary = ceil($totalRows_RS_ThisEmpSalary/$maxRows_RS_ThisEmpSalary)-1;

$colname_RS_TotalSalaryofEmp = "-1";
if (isset($_GET['user_id'])) {
  $colname_RS_TotalSalaryofEmp = $_GET['user_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_TotalSalaryofEmp = sprintf("SELECT SUM(amount) as TotalAmount FROM sallaries WHERE user_id = %s", GetSQLValueString($colname_RS_TotalSalaryofEmp, "int"));
$RS_TotalSalaryofEmp = mysql_query($query_RS_TotalSalaryofEmp, $conn) or die(mysql_error());
$row_RS_TotalSalaryofEmp = mysql_fetch_assoc($RS_TotalSalaryofEmp);
$totalRows_RS_TotalSalaryofEmp = mysql_num_rows($RS_TotalSalaryofEmp);

$colname_RS_ShowEditEmpSalay = "-1";
if (isset($_GET['sallary_id'])) {
  $colname_RS_ShowEditEmpSalay = $_GET['sallary_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_ShowEditEmpSalay = sprintf("SELECT * FROM sallaries WHERE sallary_id = %s ORDER BY `date` DESC", GetSQLValueString($colname_RS_ShowEditEmpSalay, "int"));
$RS_ShowEditEmpSalay = mysql_query($query_RS_ShowEditEmpSalay, $conn) or die(mysql_error());
$row_RS_ShowEditEmpSalay = mysql_fetch_assoc($RS_ShowEditEmpSalay);
$totalRows_RS_ShowEditEmpSalay = mysql_num_rows($RS_ShowEditEmpSalay);

$queryString_RS_Employees = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_Employees") == false && 
        stristr($param, "totalRows_RS_Employees") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_Employees = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_Employees = sprintf("&totalRows_RS_Employees=%d%s", $totalRows_RS_Employees, $queryString_RS_Employees);

$queryString_RS_ThisEmpSalary = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_ThisEmpSalary") == false && 
        stristr($param, "totalRows_RS_ThisEmpSalary") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_ThisEmpSalary = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_ThisEmpSalary = sprintf("&totalRows_RS_ThisEmpSalary=%d%s", $totalRows_RS_ThisEmpSalary, $queryString_RS_ThisEmpSalary);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-6" />
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
	<link rel="stylesheet" type="text/css" href="gnpcss.css" media="screen" />
    <title>Innova ORS</title></head>
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
                  <td align="left" valign="top" width="232"><?php if ($totalRows_RS_SearchEmployee > 0 && $_GET['action']=="open") { // Show if recordset not empty ?>
                      <strong class="tabledatakizmo">Add Employee Salary</strong>
                      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                        <table align="center">
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" class="headerzorkif">Amount:</td>
                                <td class="smalltextbg"><input type="text" name="amount" value="<?php echo $row_RS_SearchEmployee['fix_salary']; ?>" size="32" /></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" class="headerzorkif">Date:</td>
                                <td class="smalltextbg"><input name="date" type="text" value="<?php echo date("Y-m-d"); ?>" size="32" /></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" class="headerzorkif">User_id:</td>
                                <td class="smalltextbg"><select name="user_id">
                                    <?php 
do {  
?>
                                  <option value="<?php echo $row_RS_SearchEmployee['user_id']?>" ><?php echo trim($row_RS_SearchEmployee['first_name']." ".$row_RS_SearchEmployee['last_name']);?></option>
                                    <?php
} while ($row_RS_SearchEmployee = mysql_fetch_assoc($RS_SearchEmployee));
?>
                                  </select>                                </td>
                              </tr>
                              <tr> </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" class="headerzorkif">Month:</td>
                                <td class="smalltextbg"><select name="month">
                                    <?php 
do {  
?>
                                    <option value="<?php echo $row_RS_12Months['month_title'] ." - ".date('Y'); ?>" ><?php echo $row_RS_12Months['month_title'] ." - ".date('Y'); ?></option>
                                    <?php
} while ($row_RS_12Months = mysql_fetch_assoc($RS_12Months));
?>
                                  </select>                                </td>
                              </tr>
                              <tr> </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap="nowrap" class="headerzorkif">&nbsp;</td>
                                <td class="smalltextbg"><input type="submit" value="Add Salary" /></td>
                              </tr>
                                                </table>
                        <input type="hidden" name="MM_insert" value="form1" />
                                          </form>
                      <?php } // Show if recordset not empty ?>
                      <?php if ($totalRows_RS_ShowEditEmpSalay > 0) { // Show if recordset not empty ?>
  <p><strong class="tabledatakizmo">Edit Employee Salary</strong></p>
  <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
    <table align="center">
                            <tr valign="baseline">
                              <td align="right" nowrap="nowrap" class="headerzorkif">User_id:</td>
                              <td class="smalltextbg"><?php echo htmlentities($row_RS_ShowEditEmpSalay['user_id'], ENT_COMPAT, 'iso-8859-1'); ?></td>
                            </tr>
                            <tr valign="baseline">
                              <td align="right" nowrap="nowrap" class="headerzorkif">Sallary_id:</td>
                              <td class="smalltextbg"><?php echo $row_RS_ShowEditEmpSalay['sallary_id']; ?></td>
                            </tr>
                            <tr valign="baseline">
                              <td align="right" nowrap="nowrap" class="headerzorkif">Amount:</td>
                              <td class="smalltextbg"><input type="text" name="amount" value="<?php echo htmlentities($row_RS_ShowEditEmpSalay['amount'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                            </tr>
                            <tr valign="baseline">
                              <td align="right" nowrap="nowrap" class="headerzorkif">Date:</td>
                              <td class="smalltextbg"><input type="text" name="date" value="<?php echo htmlentities($row_RS_ShowEditEmpSalay['date'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                            </tr>
                            <tr valign="baseline">
                              <td align="right" nowrap="nowrap" class="headerzorkif">Month:</td>
                              <td class="smalltextbg"><select name="month">
                                  <?php 
do {  
?>
                                  <option value="<?php echo $row_RS_12Months['month_title']?>" <?php if (!(strcmp($row_RS_12Months['month_title'], htmlentities($row_RS_ShowEditEmpSalay['month'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>><?php echo $row_RS_12Months['month_title']?></option>
                                  <?php
} while ($row_RS_12Months = mysql_fetch_assoc($RS_12Months));
?>
                                </select>                              </td>
                            </tr>
                            <tr> </tr>
                            <tr valign="baseline">
                              <td align="right" nowrap="nowrap" class="headerzorkif">&nbsp;</td>
                              <td class="smalltextbg"><input type="submit" value="Update record" /></td>
                            </tr>
                          </table>
                          <input type="hidden" name="MM_update" value="form2" />
                          <input type="hidden" name="sallary_id" value="<?php echo $row_RS_ShowEditEmpSalay['sallary_id']; ?>" />
  </form>
  <?php } // Show if recordset not empty ?>
</td>
                  <td align="left" valign="top" width="408"><span class="tabledatakizmo">&nbsp;All Employees</span><br />
                    <table width="100%" border="0" cellpadding="1" cellspacing="1">
                      <tr class="headerkizmo">
                        <td>Ation</td>
                        <td>user_id</td>
                        <td>username</td>
                        <td>first_name</td>
                        <td>last_name</td>
                      </tr>
                      <?php do { ?>
                        <tr class="smalltextbg">
                          <td><a href="<?php $currentPage; ?>?action=open&user_id=<?php echo $row_RS_Employees['user_id']; ?>""><img src="images/icons/bs_open.gif" alt="[Edit]" width="16" height="16" /></a> </td>
                          <td><?php echo $row_RS_Employees['user_id']; ?></td>
                          <td><?php echo $row_RS_Employees['username']; ?></td>
                          <td><?php echo $row_RS_Employees['first_name']; ?></td>
                          <td><?php echo $row_RS_Employees['last_name']; ?></td>
                        </tr>
                        <?php } while ($row_RS_Employees = mysql_fetch_assoc($RS_Employees)); ?>
                                              <tr>
                        <td colspan="5">   <div align="center">
                          <table border="0">
                            <tr>
                              <td><?php if ($pageNum_RS_Employees > 0) { // Show if not first page ?>
                                  <a href="<?php printf("%s?pageNum_RS_Employees=%d%s", $currentPage, 0, $queryString_RS_Employees); ?>">First</a>
                                  <?php } // Show if not first page ?>                              </td>
                              <td><?php if ($pageNum_RS_Employees > 0) { // Show if not first page ?>
                                  <a href="<?php printf("%s?pageNum_RS_Employees=%d%s", $currentPage, max(0, $pageNum_RS_Employees - 1), $queryString_RS_Employees); ?>">Previous</a>
                                  <?php } // Show if not first page ?>                              </td>
                              <td><?php if ($pageNum_RS_Employees < $totalPages_RS_Employees) { // Show if not last page ?>
                                  <a href="<?php printf("%s?pageNum_RS_Employees=%d%s", $currentPage, min($totalPages_RS_Employees, $pageNum_RS_Employees + 1), $queryString_RS_Employees); ?>">Next</a>
                                  <?php } // Show if not last page ?>                              </td>
                              <td><?php if ($pageNum_RS_Employees < $totalPages_RS_Employees) { // Show if not last page ?>
                                  <a href="<?php printf("%s?pageNum_RS_Employees=%d%s", $currentPage, $totalPages_RS_Employees, $queryString_RS_Employees); ?>">Last</a>
                                  <?php } // Show if not last page ?>                              </td>
                            </tr>
                          </table>
                        </div></td>
                        </tr>
                                              <tr>
                                                <td colspan="5"><span class="tabledatakizmo"> </span>
                                                  <hr class="td_underline" />
                                                  <?php if ($totalRows_RS_ThisEmpSalary > 0) { // Show if recordset not empty ?>
                                                  <span class="tabledatakizmo">Salary History of This Employee </span><br />
                                                  <table width="100%" border="0" cellpadding="1" cellspacing="1">
                                                    <tr class="headerkizmo">
                                                      <td>Action</td>
          <td>sallary id</td>
          <td>amount</td>
          <td>date</td>
         <td>month</td>
        </tr>
                                                    <?php do { ?>
                                                    <tr class="smalltextbg">
                                                      <td><a href="<?php echo  $currentPage."?user_id=".$_GET['user_id']."&action=editsalary&sallary_id=".$row_RS_ThisEmpSalary['sallary_id']; ?>"><img src="images/icons/b_edit.png" alt="[Edit]" width="16" height="16" /></a>| <a href="<?php echo $currentPage."?user_id=".$_GET['user_id']."&action=deletesalary&sallary_id=".$row_RS_ThisEmpSalary['sallary_id']; ?>"><img src="images/icons/b_drop.png" alt="[Edit]" width="16" height="16" /></a></td>
                                                      <td><?php echo $row_RS_ThisEmpSalary['sallary_id']; ?></td>
                                                      <td><?php echo $row_RS_ThisEmpSalary['amount']; ?></td>
                                                      <td><?php echo $row_RS_ThisEmpSalary['date']; ?></td>                                                      <td><?php echo $row_RS_ThisEmpSalary['month']; ?></td>
                                                    </tr>
                                                    <?php } while ($row_RS_ThisEmpSalary = mysql_fetch_assoc($RS_ThisEmpSalary)); ?>
                                                    <tr class="smalltextbg">
                                                      <td>&nbsp;</td>
            <td>Total Salary Paid</td>
            <td class="smallmsgbox"><?php echo $row_RS_TotalSalaryofEmp['TotalAmount']; ?></td>
            <td>&nbsp;</td>     
            <td>&nbsp;</td>
          </tr>
                                                      
                                                    <tr>
                                                      <td colspan="6">    <div align="center">
                                                        <table border="0">
                                                          <tr>
                                                            <td><?php if ($pageNum_RS_ThisEmpSalary > 0) { // Show if not first page ?>
                                                              <a href="<?php printf("%s?pageNum_RS_ThisEmpSalary=%d%s", $currentPage, 0, $queryString_RS_ThisEmpSalary); ?>">First</a>
                                                              <?php } // Show if not first page ?>              </td>
                                                            <td><?php if ($pageNum_RS_ThisEmpSalary > 0) { // Show if not first page ?>
                                                              <a href="<?php printf("%s?pageNum_RS_ThisEmpSalary=%d%s", $currentPage, max(0, $pageNum_RS_ThisEmpSalary - 1), $queryString_RS_ThisEmpSalary); ?>">Previous</a>
                                                              <?php } // Show if not first page ?>              </td>
                                                            <td><?php if ($pageNum_RS_ThisEmpSalary < $totalPages_RS_ThisEmpSalary) { // Show if not last page ?>
                                                              <a href="<?php printf("%s?pageNum_RS_ThisEmpSalary=%d%s", $currentPage, min($totalPages_RS_ThisEmpSalary, $pageNum_RS_ThisEmpSalary + 1), $queryString_RS_ThisEmpSalary); ?>">Next</a>
                                                              <?php } // Show if not last page ?>              </td>
                                                            <td><?php if ($pageNum_RS_ThisEmpSalary < $totalPages_RS_ThisEmpSalary) { // Show if not last page ?>
                                                              <a href="<?php printf("%s?pageNum_RS_ThisEmpSalary=%d%s", $currentPage, $totalPages_RS_ThisEmpSalary, $queryString_RS_ThisEmpSalary); ?>">Last</a>
                                                              <?php } // Show if not last page ?>              </td>
                                                          </tr>
                                                        </table>
                                                      </div></td>
                                                    </tr>
                                                                                                  </table>
                                                    <?php } // Show if recordset not empty ?></td>
                            </tr>
                                              <tr>
                                                <td colspan="5">&nbsp;</td>
                                              </tr>
                    </table></td>
                </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
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

</body>
</html>
<?php
mysql_free_result($RS_Employees);
mysql_free_result($RS_12Months);
mysql_free_result($RS_SearchEmployee);
mysql_free_result($RS_ThisEmpSalary);

mysql_free_result($RS_TotalSalaryofEmp);

mysql_free_result($RS_ShowEditEmpSalay);
?>