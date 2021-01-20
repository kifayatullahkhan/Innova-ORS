<?php
ob_start();
require_once('Connections/conn.php'); 
if(!isset($_SESSION)){
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
$LeftSectionID=0;
$RightSectionID=0;
if (isset($_GET['PageID'])) {
	$colname_Rs_GetPageSections = "-1";
	if (isset($_GET['PageID'])) {
	  $colname_Rs_GetPageSections = $_GET['PageID'];
	}
	mysql_select_db($database_conn, $conn);
	$query_Rs_GetPageSections = sprintf("SELECT pages_main.PageID, pages_main.HeaderSectionID, pages_main.LeftSectionID, pages_main.RightSectionID, pages_main.FooterSectionID FROM pages_main WHERE pages_main.PageID=%s", GetSQLValueString($colname_Rs_GetPageSections, "int"));
	$Rs_GetPageSections = mysql_query($query_Rs_GetPageSections, $conn) or die(mysql_error());
	$row_Rs_GetPageSections = mysql_fetch_assoc($Rs_GetPageSections);
	$totalRows_Rs_GetPageSections = mysql_num_rows($Rs_GetPageSections);
	
	$LeftSectionID=$row_Rs_GetPageSections['LeftSectionID'];
	$RightSectionID=$row_Rs_GetPageSections['RightSectionID'];
}//

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Zorkif Technology Center [Web Development, Software Applicaiton Development, Best Software House in Pakistan]</title>
<meta name="description" content="Welcome!. Zorkif Technology Center is a leading software development and designing company operating in Pakistan and providing high quality, affordable software development and designing services. We have a team of high skilled engineers and designers who work hard to provide best solutions.">
    <meta name="keywords" content="Zorkif, Zorkif Technology Center, Web Side Development, Software Development Company, Best Software Development Company in Pakistan, Software Outsourcing, news, finance, sport, entertainment, Pakistan, Software Development, VB.Net, Visual Studio .Net, Database Applications">

<link href="includes/zorkif_style_2010.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="includes/jquery-1.4.1.min.js"></script> 
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript" src="includes/pngfix/jquery.pngFix.js"></script> 
<script type="text/javascript"> 
    $(document).ready(function(){ 
        $(document).pngFix(); 
    }); 
</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#000000" background="images/index_page/header_bg.jpg">
    <td  background="images/index_page/header_bg.jpg">&nbsp;</td>
    <td width="992" background="images/index_page/header_bg.jpg"><?php require_once ("header_section_of_the_page.php"); ?></td>
    <td  background="images/index_page/header_bg.jpg">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF" id="mnu_bar"><?php require_once ("top_menu_dynamic.php"); ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#FFFFFF" width="992"><table border="0" cellpadding="0" cellspacing="10" bgcolor="#FFFFFF">
      <tr>
        <?php if($LeftSectionID>1) {?>
        <td width="204" valign="top" bgcolor="#FFFFFF"><?php require_once ("left_side_section.php"); ?></td>
        <?php 
	} 
	?>
        <td  valign="top"><div id="PageBodyText">


              <div id="PageTextMargins">
                <?php require_once("body_of_the_page.php"); ?>
              </div>

        </div>
            <div id="PageTextBottomEmptyHeight"></div></td>
        <?php if($RightSectionID>1) { ?>
        <td width="204" valign="top" bgcolor="#FFFFFF"><?php require_once ("right_side_section.php"); ?></td>
        <?php
	} 
	?>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#000000">
    <td>&nbsp;</td>
    <td><!-- ******************** START OF FOOTER ******************** -->
  <?php require_once ("footer_section_of_the_page.php"); ?>
  <!-- ******************** END OF FOOTER ******************** --></td>
    <td>&nbsp;</td>
  </tr>
</table>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBarMain", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>
<?php
@mysql_free_result($Rs_GetPageSections);
?>
