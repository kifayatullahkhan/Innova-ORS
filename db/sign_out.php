<?php
// *** Logout the current user.
$logoutGoTo = "/?MSG=LOGOUT";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
$_SESSION['MM_UserGroupID']=NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
unset($_SESSION['MM_UserGroupID']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>