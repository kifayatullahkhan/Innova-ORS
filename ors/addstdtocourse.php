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

if ((isset($_GET['std_id'])) && ($_GET['std_id'] != "") && (isset($_GET['action']))) {
  $deleteSQL = sprintf("DELETE FROM students WHERE std_id=%s",
                       GetSQLValueString($_GET['std_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_RS_STUDENT = 20;
$pageNum_RS_STUDENT = 0;
if (isset($_GET['pageNum_RS_STUDENT'])) {
  $pageNum_RS_STUDENT = $_GET['pageNum_RS_STUDENT'];
}
$startRow_RS_STUDENT = $pageNum_RS_STUDENT * $maxRows_RS_STUDENT;

mysql_select_db($database_conn, $conn);

//$query_RS_STUDENT = "SELECT std_id, first_name, last_name, father_name, admission_date FROM students ORDER BY std_id DESC";
$query_RS_STUDENT = "SELECT std_id, first_name, last_name, father_name, admission_date FROM students ORDER BY std_id DESC";



$SortType="DESC";
$NextSortType="ASC";

if ($_GET['stype']=="ASC"){
$SortType="ASC";
$NextSortType="DESC";
}

// Search by ID,Names,or dates
if (isset($_GET['std_id']) && $_GET['action']!="delete"){
$Filter=" WHERE std_id ='".$_GET['std_id']."' ";
}

if (isset($_GET['std_name'])){
$Filter=" WHERE first_name LIKE '%".$_GET['std_name']."%' OR last_name LIKE '%".$_GET['std_name']."%'";
}

if (isset($_GET['std_fname'])){
$Filter=" WHERE father_name LIKE '%".$_GET['std_fname']."%'";
}

if (isset($_GET['start_day'])){
$StartDate=$_GET['start_year']."-".$_GET['start_month']."-".$_GET['start_day'];
$EndDate=$_GET['end_year']."-".$_GET['end_month']."-".$_GET['end_day'];
$Filter=" WHERE admission_date BETWEEN '$StartDate' And '$EndDate'";
}


$query_RS_STUDENT = "SELECT std_id, first_name, last_name, father_name, admission_date FROM students ".$Filter." ORDER BY std_id DESC";
//echo $query_RS_STUDENT;


if (isset($_GET['sort']) && ($_GET['sort']=="std_id") )
{
$query_RS_STUDENT = "SELECT std_id, first_name, last_name, father_name, admission_date FROM students ".$Filter." ORDER BY std_id ".$SortType;
}

if (isset($_GET['sort']) && ($_GET['sort']=="first_name") )
{
$query_RS_STUDENT = "SELECT std_id, first_name, last_name, father_name, admission_date FROM students ".$Filter." ORDER BY first_name ".$SortType;
}
if (isset($_GET['sort']) && ($_GET['sort']=="last_name") )
{
$query_RS_STUDENT = "SELECT std_id, first_name, last_name, father_name, admission_date FROM students ".$Filter." ORDER BY last_name ".$SortType;
}
if (isset($_GET['sort']) && ($_GET['sort']=="father_name") )
{
$query_RS_STUDENT = "SELECT std_id, first_name, last_name, father_name, admission_date FROM students ".$Filter." ORDER BY father_name ".$SortType;
}
if (isset($_GET['sort']) && ($_GET['sort']=="admission_date") )
{
$query_RS_STUDENT = "SELECT std_id, first_name, last_name, father_name, admission_date FROM students ".$Filter." ORDER BY admission_date ".$SortType;
}


$query_limit_RS_STUDENT = sprintf("%s LIMIT %d, %d", $query_RS_STUDENT, $startRow_RS_STUDENT, $maxRows_RS_STUDENT);
$RS_STUDENT = mysql_query($query_limit_RS_STUDENT, $conn) or die(mysql_error());
$row_RS_STUDENT = mysql_fetch_assoc($RS_STUDENT);

if (isset($_GET['totalRows_RS_STUDENT'])) {
  $totalRows_RS_STUDENT = $_GET['totalRows_RS_STUDENT'];
} else {
  $all_RS_STUDENT = mysql_query($query_RS_STUDENT);
  $totalRows_RS_STUDENT = mysql_num_rows($all_RS_STUDENT);
}
$totalPages_RS_STUDENT = ceil($totalRows_RS_STUDENT/$maxRows_RS_STUDENT)-1;

$queryString_RS_STUDENT = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_STUDENT") == false && 
        stristr($param, "totalRows_RS_STUDENT") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_STUDENT = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_STUDENT = sprintf("&totalRows_RS_STUDENT=%d%s", $totalRows_RS_STUDENT, $queryString_RS_STUDENT);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                <tbody><tr>
                  <td align="left" valign="top" width="232"><p class="headerkizmo">Filters</p>
                  <table width="100%" border="0" cellspacing="0" cellpadding="1">
                      <tr>
                        <td>                       
      <form action="<?php echo $currentPage ?>" method="get">  
<fieldset>  
<legend>Search</legend>  
<ol>  
<li>  
<label for="name">By Student ID:</label>  <br />
<input id="std_id" name="std_id" class="inputText" type="text" />
<input name="cmdSearch" type="image" id="cmdSearch" src="images/icons/b_search.png" alt="[Search]" />
<input name="sort" type="hidden" id="sort" value="<?php echo $_GET['sort'];?>" />
<input type="hidden" name="stype" id="stype" value="<?php echo $_GET['stype'];?>"/>
</li>
 </ol>
</fieldset>  
</form>                        </td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><form action="<?php echo $currentPage ?>" method="get">
                          <fieldset>
                          <legend>Search</legend>
                            <ol>
                            <li>
                              <label for="name">By  Name:</label>
                              <br />
                              <input id="std_name" name="std_name" class="inputText" type="text" />
                              <input name="cmdSearch2" type="image" id="cmdSearch2" src="images/icons/b_search.png" alt="[Search]" />
                              <input name="sort" type="hidden" id="sort" value="<?php echo $_GET['sort'];?>" />
                              <input type="hidden" name="stype" id="stype" value="<?php echo $_GET['stype'];?>"/>
                            </li>
                            </ol>
                            </fieldset>
                        </form></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><form action="<?php echo $currentPage ?>" method="get">
                          <fieldset>
                          <legend>Search</legend>
                            <ol>
                            <li>
                              <label for="name">By Father Name:</label>
                              <br />
                              <input id="std_fname" name="std_fname" class="inputText" type="text" />
                              <input name="cmdSearch3" type="image" id="cmdSearch3" src="images/icons/b_search.png" alt="[Search]" />
                              <input name="sort" type="hidden" id="sort" value="<?php echo $_GET['sort'];?>" />
                              <input type="hidden" name="stype" id="stype" value="<?php echo $_GET['stype'];?>"/>
                            </li>
                            </ol>
                            </fieldset>
                        </form></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td><form action="<?php echo $currentPage ?>" method="get">
                          <fieldset>
                          <legend>Search</legend>
                            <ol>
                            <li>
                              <label for="name">By Admission Date:</label>
                              <br />
                              Start Date:&nbsp;<br />
                              <label>
                              <select name="start_day" class="DatePickers" id="start_day">
                              <?php
							  for ($day=1;$day<=31;$day++)
									echo "<option value=\"$day\">$day</option>";
								?>
                              </select>
                              </label>                              
                              <select name="start_month" class="DatePickers" id="start_month">
                                <option value="01">JAN</option>
                                <option value="02">FEB</option>
                                <option value="03">MAR</option>
                                <option value="04">APR</option>
                                <option value="05">MAY</option>
                                <option value="06">JUN</option>
                                <option value="07">JUL</option>
                                <option value="08">AUG</option>
                                <option value="09">SEP</option>
                                <option value="10">OCT</option>
                                <option value="11">NOV</option>
                                <option value="12">DEC</option>
                              </select>
                              <select name="start_year" class="DatePickers" id="start_year">
                                <?php
							  for ($year=date("Y");$year>=date("Y")-50;$year--)
									echo "<option value=\"$year\">$year</option>";
								?>
                                                            </select>
                              <br />
                              End&nbsp;&nbsp;&nbsp;Date:&nbsp;<br />  
                              <select name="end_day" class="DatePickers" id="end_day">
                              <?php
							  for ($day=1;$day<=31;$day++)
									echo "<option value=\"$day\">$day</option>";
								?>
                              </select>
                              </label>
                              <select name="end_month" class="DatePickers" id="end_month">
                                <option value="01">JAN</option>
                                <option value="02">FEB</option>
                                <option value="03">MAR</option>
                                <option value="04">APR</option>
                                <option value="05">MAY</option>
                                <option value="06">JUN</option>
                                <option value="07">JUL</option>
                                <option value="08">AUG</option>
                                <option value="09">SEP</option>
                                <option value="10">OCT</option>
                                <option value="11">NOV</option>
                                <option value="12">DEC</option>
                              </select>
                              <select name="end_year" class="DatePickers" id="end_year">
                                <?php
							  for ($year=date("Y");$year>=date("Y")-50;$year--)
									echo "<option value=\"$year\">$year</option>";
								?>
                              </select>
                              <input name="cmdSearch4" type="image" id="cmdSearch4" src="images/icons/b_search.png" alt="[Search]" />
                              <input name="sort" type="hidden" id="sort" value="<?php echo $_GET['sort'];?>" />
                              <input type="hidden" name="stype" id="stype" value="<?php echo $_GET['stype'];?>"/>
                            </li>
                            </ol>
                            </fieldset>
                        </form></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
                  <td align="left" valign="top" width="408"><div class="MarginStyle1" align="left">
                    <table border="0" cellpadding="0" cellspacing="0" width="398">
                      <tbody>
                        <tr>
                          <td class="headerkizmo" align="center" background="get'n'put [Home]_files/msg_bar.png" valign="middle" width="398">Student Details</td>
                        </tr>
                        <tr class="BoxBorderGray">
                          <td class="BoxBorderGray">&nbsp;
                            <div align="center">
                              <table width="100%" border="0" cellpadding="1" cellspacing="1">
                                  <tr class="headerzorkif">
                                    <td width="55">Action</td>
                                    <td width="40"><a href="<?php echo $currentPage."?sort=std_id&stype=".$NextSortType;?>">STD ID</a></td>
                                    <td><a href="<?php echo $currentPage."?sort=first_name&stype=".$NextSortType;?>">First Name</a></td>
                                    <td><a href="<?php echo $currentPage."?sort=last_name&stype=".$NextSortType;?>">Last Name</a></td>
                                    <td><a href="<?php echo $currentPage."?sort=father_name&stype=".$NextSortType;?>">Father Name</a></td>
                                    <td width="60"><a href="<?php echo $currentPage."?sort=admission_date&stype=".$NextSortType;?>">Adm Date</a></td>
                                  </tr>
                                  <?php do { ?>
                                    <tr class="tablerowzorkif">
                                      <td width="55"><a href="showstudentform.php?action=open&std_id=<?php echo $row_RS_STUDENT['std_id']; ?>""><img src="images/icons/bs_open.gif" alt="[Edit]" width="16" height="16" /></a></td>
                                      <td><?php echo $row_RS_STUDENT['std_id']; ?></td>
                                      <td><?php echo $row_RS_STUDENT['first_name']; ?></td>
                                      <td><?php echo $row_RS_STUDENT['last_name']; ?></td>
                                      <td><?php echo $row_RS_STUDENT['father_name']; ?></td>
                                      <td width="60"><?php echo $row_RS_STUDENT['admission_date']; ?></td>
                                    </tr>
<?php } while ($row_RS_STUDENT = mysql_fetch_assoc($RS_STUDENT)); ?>
                                                          </table>
                            </div></td>
                        </tr>
                        <tr>
                          <td class="BoxBorderGray">&nbsp;
                            <div align="center" class="curlycontainer">
                              <table width="381" border="0">
                                  <tr>
                                    <td width="33"><?php if ($pageNum_RS_STUDENT > 0) { // Show if not first page ?>
                                          <a href="<?php printf("%s?pageNum_RS_STUDENT=%d%s", $currentPage, 0, $queryString_RS_STUDENT). "sort=".$_GET['sort']."&stype=".$_GET['stype']; ?>">First</a>
                                      
<?php } // Show if not first page ?>
<?php if ($pageNum_RS_STUDENT == 0) { // Show if first page ?>
  First
  <?php } // Show if first page ?></td>
                                    <td width="1"><div align="center">|</div></td>
                                    <td width="60"><?php if ($pageNum_RS_STUDENT > 0) { // Show if not first page ?>
                                          <a href="<?php printf("%s?pageNum_RS_STUDENT=%d%s", $currentPage, max(0, $pageNum_RS_STUDENT - 1), $queryString_RS_STUDENT). "sort=".$_GET['sort']."&stype=".$_GET['stype']; ?>">Previous</a>
                                          <?php } // Show if not first page ?>
                                          <?php if ($pageNum_RS_STUDENT == 0) { // Show if first page ?>
Previous
<?php } // Show if first page ?></td>
                                    <td width="1"><div align="center">|</div></td>
                                    <td width="35"><?php if ($pageNum_RS_STUDENT < $totalPages_RS_STUDENT) { // Show if not last page ?>
                                          <a href="<?php printf("%s?pageNum_RS_STUDENT=%d%s", $currentPage, min($totalPages_RS_STUDENT, $pageNum_RS_STUDENT + 1), $queryString_RS_STUDENT) . "sort=".$_GET['sort']."&stype=".$_GET['stype']; ?>">Next</a>
                                          <?php } // Show if not last page ?>
                                          <?php if ($pageNum_RS_STUDENT >= $totalPages_RS_STUDENT) { // Show if last page ?>
Next
<?php } // Show if last page ?></td>
                                    <td width="1"><div align="center">|</div></td>
                                    <td width="64"><?php if ($pageNum_RS_STUDENT < $totalPages_RS_STUDENT) { // Show if not last page ?>
                                          <a href="<?php printf("%s?pageNum_RS_STUDENT=%d%s", $currentPage, $totalPages_RS_STUDENT, $queryString_RS_STUDENT). "sort=".$_GET['sort']."&stype=".$_GET['stype']; ?>">Last</a>
                                          <?php } // Show if not last page ?>                                    <?php if ($pageNum_RS_STUDENT >= $totalPages_RS_STUDENT) { // Show if last page ?>
Last
<?php } // Show if last page ?></td>
                                  </tr>
                                      </table>
                              </div></td>
                        </tr>
                      </tbody>
                    </table>
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
mysql_free_result($RS_STUDENT);
?>