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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE users SET username=%s, password=%s, user_type_id=%s, title=%s, first_name=%s, last_name=%s, phone_no=%s, mobile_no=%s, nationality=%s, email=%s, dob=%s, create_date=%s, fix_salary=%s WHERE user_id=%s",
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['user_type_id'], "int"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['first_name'], "text"),
                       GetSQLValueString($_POST['last_name'], "text"),
                       GetSQLValueString($_POST['phone_no'], "text"),
                       GetSQLValueString($_POST['mobile_no'], "text"),
                       GetSQLValueString($_POST['nationality'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['dob'], "date"),
                       GetSQLValueString($_POST['create_date'], "date"),
                       GetSQLValueString($_POST['fix_salary'], "int"),
                       GetSQLValueString($_POST['user_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
}

if ((isset($_GET['user_id'])) && ($_GET['user_id'] != "") && (isset($_GET['action']) && $_GET['action']=="delete")) {
  $deleteSQL = sprintf("DELETE FROM users WHERE user_id=%s",
                       GetSQLValueString($_GET['user_id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());
}

$maxRows_RS_ShowAllUsers = 10;
$pageNum_RS_ShowAllUsers = 0;
if (isset($_GET['pageNum_RS_ShowAllUsers'])) {
  $pageNum_RS_ShowAllUsers = $_GET['pageNum_RS_ShowAllUsers'];
}
$startRow_RS_ShowAllUsers = $pageNum_RS_ShowAllUsers * $maxRows_RS_ShowAllUsers;

mysql_select_db($database_conn, $conn);
$query_RS_ShowAllUsers = "SELECT * FROM users ORDER BY username ASC";
$query_limit_RS_ShowAllUsers = sprintf("%s LIMIT %d, %d", $query_RS_ShowAllUsers, $startRow_RS_ShowAllUsers, $maxRows_RS_ShowAllUsers);
$RS_ShowAllUsers = mysql_query($query_limit_RS_ShowAllUsers, $conn) or die(mysql_error());
$row_RS_ShowAllUsers = mysql_fetch_assoc($RS_ShowAllUsers);

if (isset($_GET['totalRows_RS_ShowAllUsers'])) {
  $totalRows_RS_ShowAllUsers = $_GET['totalRows_RS_ShowAllUsers'];
} else {
  $all_RS_ShowAllUsers = mysql_query($query_RS_ShowAllUsers);
  $totalRows_RS_ShowAllUsers = mysql_num_rows($all_RS_ShowAllUsers);
}
$totalPages_RS_ShowAllUsers = ceil($totalRows_RS_ShowAllUsers/$maxRows_RS_ShowAllUsers)-1;

mysql_select_db($database_conn, $conn);
$query_RS_ShowUserType = "SELECT * FROM user_type";
$RS_ShowUserType = mysql_query($query_RS_ShowUserType, $conn) or die(mysql_error());
$row_RS_ShowUserType = mysql_fetch_assoc($RS_ShowUserType);
$totalRows_RS_ShowUserType = mysql_num_rows($RS_ShowUserType);

$colname_RS_ShowUser = "-1";
if (isset($_GET['user_id'])) {
  $colname_RS_ShowUser = $_GET['user_id'];
}
mysql_select_db($database_conn, $conn);
$query_RS_ShowUser = sprintf("SELECT * FROM users WHERE user_id = %s", GetSQLValueString($colname_RS_ShowUser, "int"));
$RS_ShowUser = mysql_query($query_RS_ShowUser, $conn) or die(mysql_error());
$row_RS_ShowUser = mysql_fetch_assoc($RS_ShowUser);
$totalRows_RS_ShowUser = mysql_num_rows($RS_ShowUser);

$queryString_RS_ShowAllUsers = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RS_ShowAllUsers") == false && 
        stristr($param, "totalRows_RS_ShowAllUsers") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RS_ShowAllUsers = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RS_ShowAllUsers = sprintf("&totalRows_RS_ShowAllUsers=%d%s", $totalRows_RS_ShowAllUsers, $queryString_RS_ShowAllUsers);
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
                  <td align="left" valign="top" width="232"><p class="headerkizmo"><strong>Admin Panel</strong></p>
                    <div class="MarginStyle1" align="justify">
                      <form action="<?php echo $currentPage ?>" method="get">
                        <fieldset>
                        <legend>Search</legend>
                          <ol>
                          <li>
                            <label for="name">By User ID:</label>
                            <br />
                            <input id="user_id" name="user_id" class="inputText" type="text" />
                            <input name="cmdSearch" type="image" id="cmdSearch" src="images/icons/b_search.png" alt="[Search]" />
                          </li>
                          </ol>
                          </fieldset>
                      </form>
                    </div>
                    <div class="MarginStyle1" align="justify">
                      <div class="text" align="justify">                      </div>
                    </div></td>
                  <td align="left" valign="top" width="408"><div class="MarginStyle1" align="left">
                    <table border="0" cellpadding="0" cellspacing="0" width="398">
                      <tbody>
                        <tr>
                          <td align="center" valign="middle" width="398"></td>
                        </tr>
                        <tr>
                          <td class="BoxBorderGray">&nbsp;
                            <?php if ($totalRows_RS_ShowUser > 0) { // Show if recordset not empty ?>
                              <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                                <table align="center">
                                  <tr valign="baseline">
                                    <td colspan="2" align="right" nowrap="nowrap" class="headerkizmo"><div align="center">eDIT uSER dETAILS</div></td>
                                    </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">User_id:</td>
                                    <td class="smalltextbg"><?php echo $row_RS_ShowUser['user_id']; ?></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">Username:</td>
                                    <td class="smalltextbg"><input type="text" name="username" value="<?php echo htmlentities($row_RS_ShowUser['username'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">Password:</td>
                                    <td class="smalltextbg"><input type="text" name="password" value="<?php echo htmlentities($row_RS_ShowUser['password'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">User_type_id:</td>
                                    <td class="smalltextbg"><select name="user_type_id">
                                      <?php 
do {  
?>
                                      <option value="<?php echo $row_RS_ShowUserType['user_type_id']?>" <?php if (!(strcmp($row_RS_ShowUserType['user_type_id'], htmlentities($row_RS_ShowUser['user_type_id'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>><?php echo $row_RS_ShowUserType['user_type_title']?></option>
                                      <?php
} while ($row_RS_ShowUserType = mysql_fetch_assoc($RS_ShowUserType));
?>
                                    </select>                                    </td>
                                  </tr>
                                  
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">Title:</td>
                                    <td class="smalltextbg"><input type="text" name="title" value="<?php echo htmlentities($row_RS_ShowUser['title'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">First_name:</td>
                                    <td class="smalltextbg"><input type="text" name="first_name" value="<?php echo htmlentities($row_RS_ShowUser['first_name'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">Last_name:</td>
                                    <td class="smalltextbg"><input type="text" name="last_name" value="<?php echo htmlentities($row_RS_ShowUser['last_name'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">Phone_no:</td>
                                    <td class="smalltextbg"><input type="text" name="phone_no" value="<?php echo htmlentities($row_RS_ShowUser['phone_no'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">Mobile_no:</td>
                                    <td class="smalltextbg"><input type="text" name="mobile_no" value="<?php echo htmlentities($row_RS_ShowUser['mobile_no'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">Nationality:</td>
                                    <td class="smalltextbg"><input type="text" name="nationality" value="<?php echo htmlentities($row_RS_ShowUser['nationality'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">Email:</td>
                                    <td class="smalltextbg"><input type="text" name="email" value="<?php echo htmlentities($row_RS_ShowUser['email'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">Dob:</td>
                                    <td class="smalltextbg"><input type="text" name="dob" value="<?php echo htmlentities($row_RS_ShowUser['dob'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">Create_date:</td>
                                    <td class="smalltextbg"><input type="text" name="create_date" value="<?php echo htmlentities($row_RS_ShowUser['create_date'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">Fix_salary:</td>
                                    <td class="smalltextbg"><input type="text" name="fix_salary" value="<?php echo htmlentities($row_RS_ShowUser['fix_salary'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td align="right" nowrap="nowrap" class="headerkizmo">&nbsp;</td>
                                    <td class="smalltextbg"><input type="submit" value="Update record" /></td>
                                  </tr>
                                </table>
                                <input type="hidden" name="MM_update" value="form1" />
                                <input type="hidden" name="user_id" value="<?php echo $row_RS_ShowUser['user_id']; ?>" />
                              </form>
                              <?php } // Show if recordset not empty ?>
<p>&nbsp;</p></td>
                        </tr>
                      </tbody>
                    </table>
                  </div></td>
                </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top">&nbsp;
                      <table width="100%" border="0" cellpadding="1" cellspacing="1">
                        <tr class="headerzorkif">
                          <td width="40">Action</td>
                          <td>username</td>
                          <td>first_name</td>
                          <td>last_name</td>
                          <td>mobile_no</td>
                          <td>email</td>
                          </tr>
                        <?php do { ?>
                          <tr class="smalltextbg">
                            <td><a href="<?php echo $currentPage."?action=edit&user_id=".$row_RS_ShowAllUsers['user_id']; ?>"><img src="images/icons/b_edit.png" width="16" height="16" /></a><a href="<?php echo $currentPage."?action=delete&user_id=".$row_RS_ShowAllUsers['user_id']; ?>"><img src="images/icons/b_drop.png" width="16" height="16" /></a>
                            </td>
                            <td><?php echo $row_RS_ShowAllUsers['username']; ?></td>
                            <td><?php echo $row_RS_ShowAllUsers['first_name']; ?></td>
                            <td><?php echo $row_RS_ShowAllUsers['last_name']; ?></td>
                            <td><?php echo $row_RS_ShowAllUsers['mobile_no']; ?></td>
                            <td><?php echo $row_RS_ShowAllUsers['email']; ?></td>
                            </tr>
                          <?php } while ($row_RS_ShowAllUsers = mysql_fetch_assoc($RS_ShowAllUsers)); ?>
                      </table></td>
                    </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top"><div align="center">
                      <table border="0">
                        <tr>
                          <td><?php if ($pageNum_RS_ShowAllUsers > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_RS_ShowAllUsers=%d%s", $currentPage, 0, $queryString_RS_ShowAllUsers); ?>">First</a>
                                <?php } // Show if not first page ?>
                          </td>
                          <td><?php if ($pageNum_RS_ShowAllUsers > 0) { // Show if not first page ?>
                                <a href="<?php printf("%s?pageNum_RS_ShowAllUsers=%d%s", $currentPage, max(0, $pageNum_RS_ShowAllUsers - 1), $queryString_RS_ShowAllUsers); ?>">Previous</a>
                                <?php } // Show if not first page ?>
                          </td>
                          <td><?php if ($pageNum_RS_ShowAllUsers < $totalPages_RS_ShowAllUsers) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_RS_ShowAllUsers=%d%s", $currentPage, min($totalPages_RS_ShowAllUsers, $pageNum_RS_ShowAllUsers + 1), $queryString_RS_ShowAllUsers); ?>">Next</a>
                                <?php } // Show if not last page ?>
                          </td>
                          <td><?php if ($pageNum_RS_ShowAllUsers < $totalPages_RS_ShowAllUsers) { // Show if not last page ?>
                                <a href="<?php printf("%s?pageNum_RS_ShowAllUsers=%d%s", $currentPage, $totalPages_RS_ShowAllUsers, $queryString_RS_ShowAllUsers); ?>">Last</a>
                                <?php } // Show if not last page ?>
                          </td>
                        </tr>
                      </table>
                    </div></td>
                    </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
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
mysql_free_result($RS_ShowAllUsers);

mysql_free_result($RS_ShowUserType);

mysql_free_result($RS_ShowUser);
?>