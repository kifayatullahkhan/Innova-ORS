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

function GetMonthString($n)
{
    $timestamp = mktime(0, 0, 0, $n, 1, 2005);
    
    return date("M", $timestamp);
}


$StartDate=date('Y-m-')."1";
$EndDate=date('Y-m-').cal_days_in_month(CAL_GREGORIAN, date('m'),date('Y'));
$StatementHeader="For the Month of ". date('M-Y');

if (isset($_GET['month'])){
$StartDate=date('Y')."-".$_GET['month']."-"."1";
$EndDate=date('Y')."-".$_GET['month']."-".cal_days_in_month(CAL_GREGORIAN, $_GET['month'],date('Y'));
$StatementHeader="For the month of ".GetMonthString ($_GET['month']). "-". date('Y');
}

if (isset($_GET['year'])){
$StartDate=$_GET['year']."-1-1";
$EndDate=$_GET['year']."-12-31";;
$StatementHeader="For the Year  ".$_GET['year'];
}


if (isset($_GET['start_day'])){
$StartDate=$_GET['start_year']."-".$_GET['start_month']."-".$_GET['start_day'];
$EndDate=$_GET['end_year']."-".$_GET['end_month']."-".$_GET['end_day'];

$StatementHeader="For the for the period from  ".$StartDate. " to ".$EndDate;
}

mysql_select_db($database_conn, $conn);
$query_RS_AllExpenses = "SELECT SUM(expenses.amount) AS TotalExpenses, exp_type.name FROM expenses, exp_type WHERE expenses.exp_type_id=exp_type.exp_type_id AND expenses.date BETWEEN '$StartDate' AND '$EndDate'  GROUP BY expenses.exp_type_id";
$RS_AllExpenses = mysql_query($query_RS_AllExpenses, $conn) or die(mysql_error());
$row_RS_AllExpenses = mysql_fetch_assoc($RS_AllExpenses);
$totalRows_RS_AllExpenses = mysql_num_rows($RS_AllExpenses);

mysql_select_db($database_conn, $conn);
$query_RS_TotalSalariesPaid = "SELECT SUM( sallaries.amount) as TotalSallaries FROM sallaries WHERE sallaries.`date` BETWEEN '$StartDate' AND '$EndDate'  ORDER BY `date` ASC";

$RS_TotalSalariesPaid = mysql_query($query_RS_TotalSalariesPaid, $conn) or die(mysql_error());
$row_RS_TotalSalariesPaid = mysql_fetch_assoc($RS_TotalSalariesPaid);
$totalRows_RS_TotalSalariesPaid = mysql_num_rows($RS_TotalSalariesPaid);

mysql_select_db($database_conn, $conn);
$query_RS_TotalFeeCollectedThisMonth = "SELECT SUM(amount) as TotalAmount FROM receipts WHERE `date` BETWEEN '$StartDate' AND '$EndDate'  ORDER BY `date` ASC";

$RS_TotalFeeCollectedThisMonth = mysql_query($query_RS_TotalFeeCollectedThisMonth, $conn) or die(mysql_error());
$row_RS_TotalFeeCollectedThisMonth = mysql_fetch_assoc($RS_TotalFeeCollectedThisMonth);
$totalRows_RS_TotalFeeCollectedThisMonth = mysql_num_rows($RS_TotalFeeCollectedThisMonth);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-6" />
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
	<link rel="stylesheet" type="text/css" href="gnpcss.css" media="screen" />
    <title>Innova Monthly Income Statement</title>
    <style type="text/css">
<!--
.style1 {
	font-size: large;
	font-weight: bold;
}
-->
    </style>
    </head>
<body>
<div align="center">
  <table border="0" cellpadding="0" cellspacing="0" width="1000">
    <tbody>
      <tr>
      <td><table border="0" cellpadding="0" cellspacing="0" width="1000">
          <tbody><tr>
            <td height="653" align="left" valign="top"><div>
              <div align="center">
                <table width="800" border="0" cellspacing="0" cellpadding="5">
                  <tr>
                    <td colspan="3" style="border-bottom-color:#000000; border-bottom:dashed; border-width:thin;"><p><img src="images/innova_logo.jpg" width="221" height="95" /></p>
                      <p align="center"><span class="style1">Income Statement</span><br />
                          <strong><?php echo $StatementHeader; ?></strong></p></td>
                    </tr>
                  <tr>
                    <td width="610"><p><strong>Income from Fee</strong><br />
                              Total Fee (collected in this month)</p>                      </td>
                    <td rowspan="3" style="border-right-color:#000000; border-right:dashed; border-width:thin;"></td>
                    <td width="159"><?php echo $row_RS_TotalFeeCollectedThisMonth['TotalAmount']; ?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;
                      <table width="100%" border="0">
                        <tr>
                          <td width="75%" bgcolor="#F2F2F2"><strong>Expense Heads</strong></td>
                          <td width="208" bgcolor="#F2F2F2"><div align="right"><strong>Amount</strong></div></td>
                          </tr>
                        <?php 
						$TotalExpenses=0;
						do { ?>
                          <tr>
                            <td width="75%"><?php echo $row_RS_AllExpenses['name']; ?></td>
                            <td><div align="right"><?php echo $row_RS_AllExpenses['TotalExpenses']; 
							$TotalExpenses=$TotalExpenses+$row_RS_AllExpenses['TotalExpenses'];
							?></div></td>
                            </tr>
                             <?php } while ($row_RS_AllExpenses = mysql_fetch_assoc($RS_AllExpenses)); ?>
                          <tr>
                            <td width="75%">Total Salaries</td>
                            <td style="border-bottom-color:#000000; border-bottom:dashed; border-width:thin;"><div align="right"><?php echo $row_RS_TotalSalariesPaid['TotalSallaries']; ?></div></td>
                          </tr>
                          <tr>
                            <td width="75%"><div align="right"></div></td>
                            <td><div align="right"><strong>Total Amount</strong>:
                              <?php 
							echo $TotalExpenses+$row_RS_TotalSalariesPaid['TotalSallaries'];
							$Profit_or_Loss=($row_RS_TotalFeeCollectedThisMonth['TotalAmount'])-($TotalExpenses+$row_RS_TotalSalariesPaid['TotalSallaries'])
							?></div></td>
                          </tr>
                      </table></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="right" style="font-weight:bold"><?php
					 if ($Profit_or_Loss<0)
							echo "Loss";
						else if ($Profit_or_Loss==0)
							echo "Equal (No Loss No Profit)";
							else if ($Profit_or_Loss>0)
							echo "Profit";
					 ?></div></td>
                    <td>RS. 
                      <?php echo $Profit_or_Loss; ?></td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
              </div>
            </div></td>
            </tr>
        </tbody></table></td>
    </tr>
    <tr>
      <td align="right" height="19"><img src="images/kmz_innova.gif" width="80" height="15" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </tbody></table>
</div>

</body>
</html>
<?php
mysql_free_result($RS_AllExpenses);

mysql_free_result($RS_TotalSalariesPaid);

mysql_free_result($RS_TotalFeeCollectedThisMonth);
?>