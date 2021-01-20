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

$colname_Rs_GetHeaderHtML = "-1";
if (isset($_GET['PageID'])) {
  $colname_Rs_GetHeaderHtML = $_GET['PageID'];
}
mysql_select_db($database_conn, $conn);
$query_Rs_GetHeaderHtML = sprintf("SELECT page_headers.HeaderSectionID, page_headers.HeaderBody, pages_main.PageID FROM page_headers, pages_main WHERE pages_main.HeaderSectionID=page_headers.HeaderSectionID AND pages_main.PageID=%s", GetSQLValueString($colname_Rs_GetHeaderHtML, "int"));
$Rs_GetHeaderHtML = mysql_query($query_Rs_GetHeaderHtML, $conn) or die(mysql_error());
$row_Rs_GetHeaderHtML = mysql_fetch_assoc($Rs_GetHeaderHtML);
$totalRows_Rs_GetHeaderHtML = mysql_num_rows($Rs_GetHeaderHtML);
?>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>



    <table width="100%" border="0" cellpadding="0" cellspacing="0" background="images/index_page/header_bg.jpg">
  <tr>
    <td width="307"  height="147">    <div  id="header">
      <script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','307','height','147','src','images/flash/ztc_logo','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','images/flash/ztc_logo' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="307" height="147">
        <param name="movie" value="images/flash/ztc_logo.swf" />
        <param name="quality" value="high" />
        <embed src="images/flash/ztc_logo.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="307" height="147"></embed>
      </object>
    </noscript></div></td>
    <td width="57%" height="147">&nbsp;</td>
    <td width="20%" height="147" valign="top">       <div id="right_top" align="right">
      <div align="center">
    <?php if (isset($_SESSION['MM_Username'])){ 
	echo "<a href=\"zpanel/main.php\">" .$_SESSION['MM_Username']."</a> |  <a href=\"sign_out.php\">Signout</a>";
	}else{
	?>
    <a href="sign_in.php">Sign In</a> | <a href="sign_up.php">Sign Up</a>
    <?php }?>
    </div></td>
  </tr>
</table>
