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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_RS_Courses = 20;
$pageNum_RS_Courses = 0;
if (isset($_GET['pageNum_RS_Courses'])) {
  $pageNum_RS_Courses = $_GET['pageNum_RS_Courses'];
}
$startRow_RS_Courses = $pageNum_RS_Courses * $maxRows_RS_Courses;

mysql_select_db($database_conn, $conn);
$query_RS_Courses = "SELECT * FROM courses ORDER BY name ASC";
$query_limit_RS_Courses = sprintf("%s LIMIT %d, %d", $query_RS_Courses, $startRow_RS_Courses, $maxRows_RS_Courses);
$RS_Courses = mysql_query($query_limit_RS_Courses, $conn) or die(mysql_error());
$row_RS_Courses = mysql_fetch_assoc($RS_Courses);

if (isset($_GET['totalRows_RS_Courses'])) {
  $totalRows_RS_Courses = $_GET['totalRows_RS_Courses'];
} else {
  $all_RS_Courses = mysql_query($query_RS_Courses);
  $totalRows_RS_Courses = mysql_num_rows($all_RS_Courses);
}
$totalPages_RS_Courses = ceil($totalRows_RS_Courses/$maxRows_RS_Courses)-1;

$queryString_RS_Courses = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_Courses") == false && 
        stristr($param, "totalRows_RS_Courses") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_Courses = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_Courses = sprintf("&totalRows_RS_Courses=%d%s", $totalRows_RS_Courses, $queryString_RS_Courses);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-6" />
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1256" />
	<link rel="stylesheet" type="text/css" href="gnpcss.css" media="screen" />
    <title>Innova [Courses Offered]</title>
</head>
<body>
<div align="center">
  <table border="0" cellpadding="0" cellspacing="0" width="1000">
    <tbody><tr>
      <td class="PageTopHeader" align="left" height="180" valign="middle" width="1000"><img src="images/header_logo.jpg" width="1000" height="250" /></td>
    </tr>
    <tr>
      <td align="left" height="40" valign="middle" width="1000"><?php
				require("top_menu_guest.php");
				?>        <br style="clear: left;" /></td>
    </tr>
    <tr>
      <td><table border="0" cellpadding="0" cellspacing="0" width="1000">
          <tbody><tr>
            <td width="179" height="653" align="left" valign="top"><?php
				require("left_menu_guest.php");
				?>
			<div>
			  <div align="center"></div>
			</div>			</td>
            <td align="left" valign="top" width="652"><table border="0" cellpadding="0" cellspacing="0" width="640">
                <tbody><tr>
                  <td align="left" valign="top" width="232"><p class="headerkizmo"><strong>Courses Offered at Innova</strong></p>
                    <img src="images/careers_head.jpg" width="250" height="179" /></td>
                  <td align="left" valign="top" width="408"><div class="text" align="left">                  
                    <table border="0">
                      <tr>
                        <td><?php if ($pageNum_RS_Courses > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_RS_Courses=%d%s", $currentPage, 0, $queryString_RS_Courses); ?>">First</a>
                              <?php } // Show if not first page ?>
                        </td>
                        <td><?php if ($pageNum_RS_Courses > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_RS_Courses=%d%s", $currentPage, max(0, $pageNum_RS_Courses - 1), $queryString_RS_Courses); ?>">Previous</a>
                              <?php } // Show if not first page ?>
                        </td>
                        <td><?php if ($pageNum_RS_Courses < $totalPages_RS_Courses) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_RS_Courses=%d%s", $currentPage, min($totalPages_RS_Courses, $pageNum_RS_Courses + 1), $queryString_RS_Courses); ?>">Next</a>
                              <?php } // Show if not last page ?>
                        </td>
                        <td><?php if ($pageNum_RS_Courses < $totalPages_RS_Courses) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_RS_Courses=%d%s", $currentPage, $totalPages_RS_Courses, $queryString_RS_Courses); ?>">Last</a>
                              <?php } // Show if not last page ?>
                        </td>
                      </tr>
                    </table>
                  
<table width="100%" border="0" cellpadding="5" cellspacing="1">
                      <tr>
                        <td class="headerkizmo">course_code</td>
                        <td class="headerkizmo">name</td>
                        <td class="headerkizmo">fee</td>
                        <td class="headerkizmo">Course_Outlines</td>
                      </tr>
                      <?php do { ?>
                        <tr class="smalltextbg">
                          <td><?php echo $row_RS_Courses['course_code']; ?></td>
                          <td><?php echo $row_RS_Courses['name']; ?></td>
                          <td>Rs.<?php echo $row_RS_Courses['fee']; ?></td>
                          <td><img src="images/icons/b_search.png" width="16" height="16" /><a href="course_getoutlines.php?course_code=<?php echo $row_RS_Courses['course_code']; ?>">View</a></td>
                        </tr>
                        <?php } while ($row_RS_Courses = mysql_fetch_assoc($RS_Courses)); ?>
</table>
                                        <table border="0">
                                          <tr>
                                            <td><?php if ($pageNum_RS_Courses > 0) { // Show if not first page ?>
                                                  <a href="<?php printf("%s?pageNum_RS_Courses=%d%s", $currentPage, 0, $queryString_RS_Courses); ?>">First</a>
                                                  <?php } // Show if not first page ?>
                                            </td>
                                            <td><?php if ($pageNum_RS_Courses > 0) { // Show if not first page ?>
                                                  <a href="<?php printf("%s?pageNum_RS_Courses=%d%s", $currentPage, max(0, $pageNum_RS_Courses - 1), $queryString_RS_Courses); ?>">Previous</a>
                                                  <?php } // Show if not first page ?>
                                            </td>
                                            <td><?php if ($pageNum_RS_Courses < $totalPages_RS_Courses) { // Show if not last page ?>
                                                  <a href="<?php printf("%s?pageNum_RS_Courses=%d%s", $currentPage, min($totalPages_RS_Courses, $pageNum_RS_Courses + 1), $queryString_RS_Courses); ?>">Next</a>
                                                  <?php } // Show if not last page ?>
                                            </td>
                                            <td><?php if ($pageNum_RS_Courses < $totalPages_RS_Courses) { // Show if not last page ?>
                                                  <a href="<?php printf("%s?pageNum_RS_Courses=%d%s", $currentPage, $totalPages_RS_Courses, $queryString_RS_Courses); ?>">Last</a>
                                                  <?php } // Show if not last page ?>
                                            </td>
                                          </tr>
                                        </table>
                                        </p>
</div></td>
                </tr>
              </tbody></table>            </td>
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
mysql_free_result($RS_Courses);
?>