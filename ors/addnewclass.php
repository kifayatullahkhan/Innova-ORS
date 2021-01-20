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

$maxRows_RS_AllCourses = 40;
$pageNum_RS_AllCourses = 0;
if (isset($_GET['pageNum_RS_AllCourses'])) {
  $pageNum_RS_AllCourses = $_GET['pageNum_RS_AllCourses'];
}
$startRow_RS_AllCourses = $pageNum_RS_AllCourses * $maxRows_RS_AllCourses;

mysql_select_db($database_conn, $conn);
$query_RS_AllCourses = "SELECT * FROM courses ORDER BY name ASC";
$query_limit_RS_AllCourses = sprintf("%s LIMIT %d, %d", $query_RS_AllCourses, $startRow_RS_AllCourses, $maxRows_RS_AllCourses);
$RS_AllCourses = mysql_query($query_limit_RS_AllCourses, $conn) or die(mysql_error());
$row_RS_AllCourses = mysql_fetch_assoc($RS_AllCourses);

if (isset($_GET['totalRows_RS_AllCourses'])) {
  $totalRows_RS_AllCourses = $_GET['totalRows_RS_AllCourses'];
} else {
  $all_RS_AllCourses = mysql_query($query_RS_AllCourses);
  $totalRows_RS_AllCourses = mysql_num_rows($all_RS_AllCourses);
}
$totalPages_RS_AllCourses = ceil($totalRows_RS_AllCourses/$maxRows_RS_AllCourses)-1;

$queryString_RS_AllCourses = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_AllCourses") == false && 
        stristr($param, "totalRows_RS_AllCourses") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_AllCourses = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_AllCourses = sprintf("&totalRows_RS_AllCourses=%d%s", $totalRows_RS_AllCourses, $queryString_RS_AllCourses);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                  <td align="left" valign="top" width="292"><div class="MarginStyle1" align="justify"><img src="images/icons/b_tipp.png" width="16" height="16" />Please Select a Course To create class for it!</div>
                    <div class="MarginStyle1" align="justify">
                        <div class="text" align="justify"> </div>
                    </div></td>
                  <td align="left" valign="top" width="348"><div class="MarginStyle1" align="left"></div></td>
                </tr>
                <tr>
                  <td colspan="2" align="left" valign="top">&nbsp;
                    <table width="100%" border="0" cellpadding="1" cellspacing="1">
                      <tr>
                        <td class="headerzorkif">Select</td>
                        <td class="headerzorkif">course_code</td>
                        <td class="headerzorkif">name</td>
                        <td class="headerzorkif">fee</td>
                      </tr>
                      <?php do { ?>
                        <tr>
                          <td><a href="addnewclass2.php?course_code=<?php echo $row_RS_AllCourses['course_code']; ?>"><?php echo $row_RS_AllCourses['course_code']; ?></a></td>
                          <td><?php echo $row_RS_AllCourses['course_code']; ?></td>
                          <td><?php echo $row_RS_AllCourses['name']; ?></td>
                          <td><?php echo $row_RS_AllCourses['fee']; ?></td>
                        </tr>
                        <?php } while ($row_RS_AllCourses = mysql_fetch_assoc($RS_AllCourses)); ?>
                    </table></td>
                  </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;
                    <table border="0">
                      <tr>
                        <td><?php if ($pageNum_RS_AllCourses > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_RS_AllCourses=%d%s", $currentPage, 0, $queryString_RS_AllCourses); ?>">First</a>
                              <?php } // Show if not first page ?>
                        </td>
                        <td><?php if ($pageNum_RS_AllCourses > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_RS_AllCourses=%d%s", $currentPage, max(0, $pageNum_RS_AllCourses - 1), $queryString_RS_AllCourses); ?>">Previous</a>
                              <?php } // Show if not first page ?>
                        </td>
                        <td><?php if ($pageNum_RS_AllCourses < $totalPages_RS_AllCourses) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_RS_AllCourses=%d%s", $currentPage, min($totalPages_RS_AllCourses, $pageNum_RS_AllCourses + 1), $queryString_RS_AllCourses); ?>">Next</a>
                              <?php } // Show if not last page ?>
                        </td>
                        <td><?php if ($pageNum_RS_AllCourses < $totalPages_RS_AllCourses) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_RS_AllCourses=%d%s", $currentPage, $totalPages_RS_AllCourses, $queryString_RS_AllCourses); ?>">Last</a>
                              <?php } // Show if not last page ?>
                        </td>
                      </tr>
                    </table></td>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
              </tbody>
            </table></td>
            <td align="left" valign="top" width="179"><div id="leftbar">
              <div id="searchBox">
                <p align="center"><img src="images/onlinetest_pic.jpg" width="165" height="475" /></p>
                <p align="center"><img src="images/photo99999p.jpg" width="135" height="126" /></p>
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
mysql_free_result($RS_AllCourses);
?>