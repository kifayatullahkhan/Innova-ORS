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

mysql_select_db($database_conn, $conn);
$query_Rs_GetHorzMenu = "SELECT * FROM page_horzmenu ORDER BY OrderNumber ASC";
$Rs_GetHorzMenu = mysql_query($query_Rs_GetHorzMenu, $conn) or die(mysql_error());
$row_Rs_GetHorzMenu = mysql_fetch_assoc($Rs_GetHorzMenu);
$totalRows_Rs_GetHorzMenu = mysql_num_rows($Rs_GetHorzMenu);


?>

<table width="100%" >
  <tr>
    <td align="left" valign="middle"><div>
        <ul id="MenuBarMain" class="MenuBarHorizontal">
          <?php do { ?>    
            <li><a href="index.php?PageID=<?php echo $row_Rs_GetHorzMenu['LinkPageID']; ?>" title="<?php echo $row_Rs_GetHorzMenu['LinkTitle']; ?>"><?php echo $row_Rs_GetHorzMenu['LinkName'];?></a>
              <?php if ($row_Rs_GetHorzMenu['HasSubMenu']==1) { ?>
              <!--  Begin of Sub Links  --><ul> 
                <?php
		  mysql_select_db($database_conn, $conn);
$query_Rs_GetSubLinks = "SELECT * FROM page_submenu WHERE linkID = ".$row_Rs_GetHorzMenu['linkID'] ." ORDER BY OrderNumber Asc";
$Rs_GetSubLinks = mysql_query($query_Rs_GetSubLinks, $conn) or die(mysql_error());
$row_Rs_GetSubLinks = mysql_fetch_assoc($Rs_GetSubLinks);
$totalRows_Rs_GetSubLinks = mysql_num_rows($Rs_GetSubLinks);
		   do { ?>
                  <li><a href="index.php?PageID=<?php echo $row_Rs_GetSubLinks['LinkPageID'].'&linkID='.$row_Rs_GetHorzMenu['linkID']; ?>" title="<?php echo $row_Rs_GetSubLinks['LinkTitle']; ?>"><?php echo  $row_Rs_GetSubLinks['LinkName']; ?></a></li>    
                <?php } while ($row_Rs_GetSubLinks = mysql_fetch_assoc($Rs_GetSubLinks)); ?>
                </ul> <!-- Endof Sub menu Links -->
              <?php } //end of HasSubmenu If?>
            </li>  <!-- End of Main Horz Menu -->
            <?php } while ($row_Rs_GetHorzMenu = mysql_fetch_assoc($Rs_GetHorzMenu)); ?>
          <li><a href="gallery.php" target="_blank">Gallery</a></li>
        <li><a href="http://mail.google.com/a/zorkif.com" target="_blank">Mail </a></li>
    </ul>
    </div>    </td>
  </tr>
</table>
  <?php
@mysql_free_result($Rs_GetHorzMenu);
@mysql_free_result($Rs_GetSubLinks);
?>