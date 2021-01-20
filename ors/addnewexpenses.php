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
  $insertSQL = sprintf("INSERT INTO expenses (voucher_number, amount, `date`, `description`, exp_type_id) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['voucher_number'], "text"),
                       GetSQLValueString($_POST['amount'], "int"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['exp_type_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
}

if ((isset($_GET['exp_id'])) && ($_GET['exp_id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM expenses WHERE exp_id=%s",
                       GetSQLValueString($_GET['exp_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

mysql_select_db($database_conn, $conn);
$query_RS_ExpensesTypes = "SELECT * FROM exp_type";
$RS_ExpensesTypes = mysql_query($query_RS_ExpensesTypes, $conn) or die(mysql_error());
$row_RS_ExpensesTypes = mysql_fetch_assoc($RS_ExpensesTypes);
$totalRows_RS_ExpensesTypes = mysql_num_rows($RS_ExpensesTypes);

$maxRows_RS_Allexpenses = 17;
$pageNum_RS_Allexpenses = 0;
if (isset($_GET['pageNum_RS_Allexpenses'])) {
  $pageNum_RS_Allexpenses = $_GET['pageNum_RS_Allexpenses'];
}
$startRow_RS_Allexpenses = $pageNum_RS_Allexpenses * $maxRows_RS_Allexpenses;

mysql_select_db($database_conn, $conn);
$query_RS_Allexpenses = "SELECT expenses.*,exp_type.* FROM expenses, exp_type WHERE exp_type.exp_type_id=expenses.exp_type_id ORDER BY  expenses.date DESC";
$query_limit_RS_Allexpenses = sprintf("%s LIMIT %d, %d", $query_RS_Allexpenses, $startRow_RS_Allexpenses, $maxRows_RS_Allexpenses);
$RS_Allexpenses = mysql_query($query_limit_RS_Allexpenses, $conn) or die(mysql_error());
$row_RS_Allexpenses = mysql_fetch_assoc($RS_Allexpenses);

if (isset($_GET['totalRows_RS_Allexpenses'])) {
  $totalRows_RS_Allexpenses = $_GET['totalRows_RS_Allexpenses'];
} else {
  $all_RS_Allexpenses = mysql_query($query_RS_Allexpenses);
  $totalRows_RS_Allexpenses = mysql_num_rows($all_RS_Allexpenses);
}
$totalPages_RS_Allexpenses = ceil($totalRows_RS_Allexpenses/$maxRows_RS_Allexpenses)-1;

mysql_select_db($database_conn, $conn);
$query_RS_TotalExpenses = "SELECT SUM(expenses.amount) AS TotalAmount FROM expenses";
$RS_TotalExpenses = mysql_query($query_RS_TotalExpenses, $conn) or die(mysql_error());
$row_RS_TotalExpenses = mysql_fetch_assoc($RS_TotalExpenses);
$totalRows_RS_TotalExpenses = mysql_num_rows($RS_TotalExpenses);

$queryString_RS_Allexpenses = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_Allexpenses") == false && 
        stristr($param, "totalRows_RS_Allexpenses") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_Allexpenses = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_Allexpenses = sprintf("&totalRows_RS_Allexpenses=%d%s", $totalRows_RS_Allexpenses, $queryString_RS_Allexpenses);
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
              <tbody>
                <tr>
                  <td align="left" valign="top" width="183"><img src="images/2girls.jpg" width="180" height="180" />
                    <div class="MarginStyle1" align="justify">
                        <div class="text" align="justify"> </div>
                    </div></td>
                  <td align="left" valign="top" width="812"><div class="MarginStyle1" align="left">
                      <table border="0" cellpadding="0" cellspacing="0" width="398">
                        <tbody>
                          <tr>
                            <td class="headerkizmo" align="center" valign="middle" width="398">Details...... </td>
                          </tr>
                          <tr>
                            <td class="BoxBorderGray">&nbsp;
                              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                                <table align="center">
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerzorkif">Voucher_number:</td>
                                    <td class="smalltextbg"><input type="text" name="voucher_number" value="0" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerzorkif">Amount:</td>
                                    <td class="smalltextbg"><input type="text" name="amount" value="0" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerzorkif">Date:</td>
                                    <td class="smalltextbg"><input type="text" name="date" value="<?php echo date('Y-m-d'); ?>" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerzorkif">Description:</td>
                                    <td class="smalltextbg"><input type="text" name="description" value="N/A" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerzorkif">Exp_type_id:</td>
                                    <td class="smalltextbg"><select name="exp_type_id">
                                        <?php 
do {  
?>
                                        <option value="<?php echo $row_RS_ExpensesTypes['exp_type_id']?>" ><?php echo $row_RS_ExpensesTypes['name']. " - (" . $row_RS_ExpensesTypes['type'].")"; ?></option>
                                        <?php
} while ($row_RS_ExpensesTypes = mysql_fetch_assoc($RS_ExpensesTypes));
?>
                                      </select>
                                   </td>
                                  </tr>
                                  <tr> </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerzorkif">&nbsp;</td>
                                    <td class="smalltextbg"><input type="submit" value="Add Record Accouts" /></td>
                                  </tr>
                                </table>
                                <input type="hidden" name="MM_insert" value="form1" />
                              </form>
                              </td>
                          </tr>
                        </tbody>
                      </table>
                  </div></td>
                </tr>
                <tr>
                  <td colspan="2" align="left" valign="top">&nbsp;
                    <table width="100%" border="0" cellpadding="0" cellspacing="1">
                      <tr class="tabledatakizmo">
                        <td>exp_id</td>
                        <td>voucher#</td>
                        <td>amount&nbsp;&nbsp;</td>
                        <td>date</td>
                        <td>description</td>
                        <td colspan="2">type</td>
                        <td>Type comments</td>
                      </tr>
                      <?php 
					  $SubTotal=0;
					  
					  do { ?>
                        <tr class="smalltextbg">
                          <td><a href="<?php echo $currentPage."?exp_id=".$row_RS_Allexpenses['exp_id']; ?>"><img src="images/icons/b_drop.png" width="16" height="16" /><?php echo $row_RS_Allexpenses['exp_id']; ?></a></td>
                          <td><?php echo $row_RS_Allexpenses['voucher_number']; ?></td>
                          <td><?php echo $row_RS_Allexpenses['amount']; 
						   $SubTotal= $SubTotal=$row_RS_Allexpenses['amount'];
						  ?></td>
                          <td><?php echo $row_RS_Allexpenses['date']; ?></td>
                          <td><?php echo $row_RS_Allexpenses['description']; ?></td>
                          <td>&nbsp;</td>
                          <td><?php echo $row_RS_Allexpenses['type']; ?></td>
                          <td><?php echo $row_RS_Allexpenses['comments']; ?></td>
                        </tr>
                 <?php } while ($row_RS_Allexpenses = mysql_fetch_assoc($RS_Allexpenses)); ?>
                        <tr>
                          <td colspan="2"><div align="right">Sub Total</div></td>
                          <td>Rs. <?php echo $SubTotal ?></td>
                          <td>&nbsp;</td>
                          <td colspan="4">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2"><div align="right"><strong>Total Amount</strong></div></td>
                          <td colspan="2" class="td_underline"><div align="left">RS.&nbsp;<?php echo $row_RS_TotalExpenses['TotalAmount']; ?></div></td>
                          <td colspan="4" class="tablerowzorkif">
                            <table border="0">
                                <tr>
                                  <td><?php if ($pageNum_RS_Allexpenses > 0) { // Show if not first page ?>
                                    <a href="<?php printf("%s?pageNum_RS_Allexpenses=%d%s", $currentPage, 0, $queryString_RS_Allexpenses); ?>">First</a>
                                    <?php } // Show if not first page ?>                                  </td>
                                  <td><?php if ($pageNum_RS_Allexpenses > 0) { // Show if not first page ?>
                                    <a href="<?php printf("%s?pageNum_RS_Allexpenses=%d%s", $currentPage, max(0, $pageNum_RS_Allexpenses - 1), $queryString_RS_Allexpenses); ?>">Previous</a>
                                    <?php } // Show if not first page ?>                                  </td>
                                  <td><?php if ($pageNum_RS_Allexpenses < $totalPages_RS_Allexpenses) { // Show if not last page ?>
                                    <a href="<?php printf("%s?pageNum_RS_Allexpenses=%d%s", $currentPage, min($totalPages_RS_Allexpenses, $pageNum_RS_Allexpenses + 1), $queryString_RS_Allexpenses); ?>">Next</a>
                                    <?php } // Show if not last page ?>                                  </td>
                                  <td><?php if ($pageNum_RS_Allexpenses < $totalPages_RS_Allexpenses) { // Show if not last page ?>
                                    <a href="<?php printf("%s?pageNum_RS_Allexpenses=%d%s", $currentPage, $totalPages_RS_Allexpenses, $queryString_RS_Allexpenses); ?>">Last</a>
                                    <?php } // Show if not last page ?>                                  </td>
                                </tr>
                                                        </table></td>
                          </tr>
                    </table></td>
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
mysql_free_result($RS_ExpensesTypes);

mysql_free_result($RS_Allexpenses);

mysql_free_result($RS_TotalExpenses);
?>