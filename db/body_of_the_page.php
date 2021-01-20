<?php  require_once('Connections/conn.php'); ?>
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

$colname_Rs_GetPageHTML = "-1";
if (isset($_GET['PageID'])) {
  $colname_Rs_GetPageHTML = $_GET['PageID'];
}
mysql_select_db($database_conn, $conn);
$query_Rs_GetPageHTML = sprintf("SELECT pages_main.PageID, pages_main.PageName, pages_main.CenterBody FROM pages_main WHERE pages_main.IsDefault=1");
if (isset($_GET['PageID'])) {
$query_Rs_GetPageHTML = sprintf("SELECT pages_main.PageID, pages_main.PageName, pages_main.CenterBody FROM pages_main WHERE pages_main.PageID=%s", GetSQLValueString($colname_Rs_GetPageHTML, "int"));
}
$Rs_GetPageHTML = mysql_query($query_Rs_GetPageHTML, $conn) or die(mysql_error());
$row_Rs_GetPageHTML = mysql_fetch_assoc($Rs_GetPageHTML);
$totalRows_Rs_GetPageHTML = mysql_num_rows($Rs_GetPageHTML);
?><?php echo $row_Rs_GetPageHTML['CenterBody']; ?>
<?php
mysql_free_result($Rs_GetPageHTML);
?>
