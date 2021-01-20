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

$colname_Rs_GetPageRightSection = "-1";
if (isset($_GET['PageID'])) {
  $colname_Rs_GetPageRightSection = $_GET['PageID'];
}
mysql_select_db($database_conn, $conn);
$query_Rs_GetPageRightSection = sprintf("SELECT page_rightsection.RightSection FROM page_rightsection, pages_main WHERE page_rightsection.RightSectionID=pages_main.RightSectionID  AND pages_main.PageID=%s", GetSQLValueString($colname_Rs_GetPageRightSection, "int"));
$Rs_GetPageRightSection = mysql_query($query_Rs_GetPageRightSection, $conn) or die(mysql_error());
$row_Rs_GetPageRightSection = mysql_fetch_assoc($Rs_GetPageRightSection);
$totalRows_Rs_GetPageRightSection = mysql_num_rows($Rs_GetPageRightSection);
?>
<?php echo $row_Rs_GetPageRightSection['RightSection']; ?>
<?php
mysql_free_result($Rs_GetPageRightSection);
?>