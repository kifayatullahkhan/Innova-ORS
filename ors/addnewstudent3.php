<?php require_once('Connections/conn.php'); ?>
<?php require_once '../admin/access_restrictions.php'; ?>
<?php
session_start();
if (isset($_POST['cmdSkip']) && $_POST['cmdSkip']="[Skip] --&gt;"){
 header("Location: addnewstudent4.php");
exit;
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO std_temp_address (address, city, post_code, county_province, country) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['post_code'], "text"),
                       GetSQLValueString($_POST['county_province'], "text"),
                       GetSQLValueString($_POST['country'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "addnewstudent4.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
                  <td align="left" valign="top" width="232"><p class="headerkizmo"><strong>Short Description</strong></p>
                    <div class="MarginStyle1" align="justify">
                      <div class="text" align="justify">
                        <p>Please Provide All the Details about the students. This process will be completed in a few steps. When you finish this form please click <strong>[Next]</strong> button to continue.</p>
                        <p>Click on the <strong>[Skip]</strong> Button if you have no entry for this section.</p>
                      </div>
                    </div>
                    <div class="MarginStyle1" align="justify">
                      <div class="text" align="justify">                      </div>
                    </div></td>
                  <td align="left" valign="top" width="408"><div class="MarginStyle1" align="left">
                    <table border="0" cellpadding="0" cellspacing="0" width="398">
                      <tbody>
                        <tr>
                          <td class="headerkizmo" align="center" valign="middle" width="398">Temporary Address </td>
                        </tr>
                        <tr>
                          <td class="BoxBorderGray">&nbsp;
                            <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
                              <table align="center">
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Std_id:</td>
                                  <td><?php echo $_SESSION['std_id'];?></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Address:</td>
                                  <td><input type="text" name="address" value="" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">City:</td>
                                  <td><input type="text" name="city" value="Peshawar" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Post_code:</td>
                                  <td><input type="text" name="post_code" value="25000" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">County_province:</td>
                                  <td><input type="text" name="county_province" value="NWFP" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">Country:</td>
                                  <td><input type="text" name="country" value="Pakistan" size="32" /></td>
                                </tr>
                                <tr valign="baseline">
                                  <td nowrap="nowrap" align="right">&nbsp;</td>
                                  <td><input name="cmdNext" type="submit" id="cmdNext" value="[Next] --&gt;" />
                                    <input type="submit" name="cmdSkip" id="cmdSkip" value="[Skip] --&gt;" /></td>
                                </tr>
                              </table>
                              <input type="hidden" name="MM_insert" value="form1" />
                            </form>
                            <p>&nbsp;</p></td>
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