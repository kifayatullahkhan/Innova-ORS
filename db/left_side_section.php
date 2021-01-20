<?php require_once('Connections/conn.php'); ?>
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

$colname_Rs_GetPage_LeftSection = "-1";
if (isset($_GET['PageID'])) {
  $colname_Rs_GetPage_LeftSection = $_GET['PageID'];
}
mysql_select_db($database_conn, $conn);
$query_Rs_GetPage_LeftSection = sprintf("SELECT page_leftsection.LeftSection FROM page_leftsection, pages_main WHERE pages_main.LeftSectionID=page_leftsection.LeftSectionID  AND pages_main.PageID=%s", GetSQLValueString($colname_Rs_GetPage_LeftSection, "int"));
$Rs_GetPage_LeftSection = mysql_query($query_Rs_GetPage_LeftSection, $conn) or die(mysql_error());
$row_Rs_GetPage_LeftSection = mysql_fetch_assoc($Rs_GetPage_LeftSection);
$totalRows_Rs_GetPage_LeftSection = mysql_num_rows($Rs_GetPage_LeftSection);
?><div>
<?php echo $row_Rs_GetPage_LeftSection['LeftSection']; ?>
</div>      
      <?php
mysql_free_result($Rs_GetPage_LeftSection);
?>
