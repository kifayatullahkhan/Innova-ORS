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

$colname_Rs_GetFooterHtML = "-1";
if (isset($_GET['PageID'])) {
  $colname_Rs_GetFooterHtML = $_GET['PageID'];
}
mysql_select_db($database_conn, $conn);
$query_Rs_GetFooterHtML = sprintf("SELECT page_footers.FooterSectionID, page_footers.FooterBody, pages_main.PageID FROM page_footers, pages_main WHERE pages_main.FooterSectionID=page_footers.FooterSectionID AND pages_main.PageID=%s", GetSQLValueString($colname_Rs_GetFooterHtML, "int"));
$Rs_GetFooterHtML = mysql_query($query_Rs_GetFooterHtML, $conn) or die(mysql_error());
$row_Rs_GetFooterHtML = mysql_fetch_assoc($Rs_GetFooterHtML);
$totalRows_Rs_GetFooterHtML = mysql_num_rows($Rs_GetFooterHtML);
?>
<?php if ($row_Rs_GetFooterHtML['FooterSectionID']>1) {?>
<div id="footer">
<div id="footer_text">     
		<div class="footer_text_from_db"><?php echo $row_Rs_GetFooterHtML['FooterBody']; ?></div>
      </div><a href="http://www.zorkif.com/" target="_blank" class="k_float k_bottom k_right" onClick="return true;"><img src="images/body_images/zorkif_bottom_corner_logo.gif" alt="Zorkif Technology Center" width="80" height="80" /></a> 
    </div>
<?php 
}else{ ?>
<div id="footer">
<div id="footer_text"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="140"> <div id="footer_icon"><img src="images/mix/firefox_icon.png" alt="Best View with Firefox 3.0" width="128" height="128" /></div></td>
    <td valign="top">This web site is best view in Firefox 3.6 or above, Internet Explorer 8.0, any other latest browser. Older Browser such as Internet Explorer 5 or 6 may have some compatibility issues. Please upgrade to the latest version of the browser / Firefox and enjoy CSS3 compatible standard view of this web site.</td>
  </tr>
</table>    
		<div class="footer_text_from_db"><?php echo $row_Rs_GetFooterHtML['FooterBody']; ?></div>
      </div><a href="http://www.zorkif.com/" target="_blank" class="k_float k_bottom k_right" onClick="return true;"><img src="images/body_images/zorkif_bottom_corner_logo.gif" alt="Zorkif Technology Center" width="80" height="80" /></a> 
    </div>

  <?php
  }// End of Else
mysql_free_result($Rs_GetFooterHtML);
?>
