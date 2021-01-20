<?php
define("EW_PAGE_ID", "view", TRUE); // Page ID
define("EW_TABLE_NAME", 'course_outline', TRUE);
?>
<?php 
session_start(); // Initialize session data
ob_start(); // Turn on output buffering
?>
<?php include "ewcfg50.php" ?>
<?php include "ewmysql50.php" ?>
<?php include "phpfn50.php" ?>
<?php include "course_outlineinfo.php" ?>
<?php include "userfn50.php" ?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Open connection to the database
$conn = ew_Connect();
?>
<?php

// Common page loading event (in userfn*.php)
Page_Loading();
?>
<?php

// Page load event, used in current page
Page_Load();
?>
<?php
$course_outline->Export = @$_GET["export"]; // Get export parameter
$sExport = $course_outline->Export; // Get export parameter, used in header
$sExportFile = $course_outline->TableVar; // Get export file, used in header
?>
<?php
if (@$_GET["course_outline_id"] <> "") {
	$course_outline->course_outline_id->setQueryStringValue($_GET["course_outline_id"]);
} else {
	Page_Terminate("course_outlinelist.php"); // Return to list page
}

// Get action
if (@$_POST["a_view"] <> "") {
	$course_outline->CurrentAction = $_POST["a_view"];
} else {
	$course_outline->CurrentAction = "I"; // Display form
}
switch ($course_outline->CurrentAction) {
	case "I": // Get a record to display
		if (!LoadRow()) { // Load record based on key
			$_SESSION[EW_SESSION_MESSAGE] = "No records found"; // Set no record message
			Page_Terminate("course_outlinelist.php"); // Return to list
		}
}

// Set return url
$course_outline->setReturnUrl("course_outlineview.php");

// Render row
$course_outline->RowType = EW_ROWTYPE_VIEW;
RenderRow();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "view"; // Page id

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker">View TABLE: course outline
<br><br>
<a href="course_outlinelist.php">Back to List</a>&nbsp;
<a href="course_outlineadd.php">Add</a>&nbsp;
<a href="<?php echo $course_outline->EditUrl() ?>">Edit</a>&nbsp;
<a href="<?php echo $course_outline->CopyUrl() ?>">Copy</a>&nbsp;
<a href="<?php echo $course_outline->DeleteUrl() ?>">Delete</a>&nbsp;
</span>
</p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<p>
<form>
<table class="ewTable">
</table>
</form>
<p>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php include "footer.php" ?>
<?php

// If control is passed here, simply terminate the page without redirect
Page_Terminate();

// -----------------------------------------------------------------
//  Subroutine Page_Terminate
//  - called when exit page
//  - clean up connection and objects
//  - if url specified, redirect to url, otherwise end response
function Page_Terminate($url = "") {
	global $conn;

	// Page unload event, used in current page
	Page_Unload();

	// Global page unloaded event (in userfn*.php)
	Page_Unloaded();

	 // Close Connection
	$conn->Close();

	// Go to url if specified
	if ($url <> "") {
		ob_end_clean();
		header("Location: $url");
	}
	exit();
}
?>
<?php

// Load row based on key values
function LoadRow() {
	global $conn, $Security, $course_outline;
	$sFilter = $course_outline->SqlKeyFilter();
	if (!is_numeric($course_outline->course_outline_id->CurrentValue)) {
		return FALSE; // Invalid key, exit
	}
	$sFilter = str_replace("@course_outline_id@", ew_AdjustSql($course_outline->course_outline_id->CurrentValue), $sFilter); // Replace key value

	// Call Row Selecting event
	$course_outline->Row_Selecting($sFilter);

	// Load sql based on filter
	$course_outline->CurrentFilter = $sFilter;
	$sSql = $course_outline->SQL();
	if ($rs = $conn->Execute($sSql)) {
		if ($rs->EOF) {
			$LoadRow = FALSE;
		} else {
			$LoadRow = TRUE;
			$rs->MoveFirst();
			LoadRowValues($rs); // Load row values

			// Call Row Selected event
			$course_outline->Row_Selected($rs);
		}
		$rs->Close();
	} else {
		$LoadRow = FALSE;
	}
	return $LoadRow;
}

// Load row values from recordset
function LoadRowValues(&$rs) {
	global $course_outline;
	$course_outline->course_outline_id->setDbValue($rs->fields('course_outline_id'));
	$course_outline->course_code->setDbValue($rs->fields('course_code'));
	$course_outline->Title->setDbValue($rs->fields('Title'));
	$course_outline->Details->setDbValue($rs->fields('Details'));
	$course_outline->Duration->setDbValue($rs->fields('Duration'));
}
?>
<?php

// Render row values based on field settings
function RenderRow() {
	global $conn, $Security, $course_outline;

	// Call Row Rendering event
	$course_outline->Row_Rendering();

	// Common render codes for all row types
	if ($course_outline->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($course_outline->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($course_outline->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($course_outline->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$course_outline->Row_Rendered();
}
?>
<?php

// Set up Starting Record parameters based on Pager Navigation
function SetUpStartRec() {
	global $nDisplayRecs, $nStartRec, $nTotalRecs, $nPageNo, $course_outline;
	if ($nDisplayRecs == 0) return;

	// Check for a START parameter
	if (@$_GET[EW_TABLE_START_REC] <> "") {
		$nStartRec = $_GET[EW_TABLE_START_REC];
		$course_outline->setStartRecordNumber($nStartRec);
	} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
		$nPageNo = $_GET[EW_TABLE_PAGE_NO];
		if (is_numeric($nPageNo)) {
			$nStartRec = ($nPageNo-1)*$nDisplayRecs+1;
			if ($nStartRec <= 0) {
				$nStartRec = 1;
			} elseif ($nStartRec >= intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1) {
				$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1;
			}
			$course_outline->setStartRecordNumber($nStartRec);
		} else {
			$nStartRec = $course_outline->getStartRecordNumber();
		}
	} else {
		$nStartRec = $course_outline->getStartRecordNumber();
	}

	// Check if correct start record counter
	if (!is_numeric($nStartRec) || $nStartRec == "") { // Avoid invalid start record counter
		$nStartRec = 1; // Reset start record counter
		$course_outline->setStartRecordNumber($nStartRec);
	} elseif (intval($nStartRec) > intval($nTotalRecs)) { // Avoid starting record > total records
		$nStartRec = intval(($nTotalRecs-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to last page first record
		$course_outline->setStartRecordNumber($nStartRec);
	} elseif (($nStartRec-1) % $nDisplayRecs <> 0) {
		$nStartRec = intval(($nStartRec-1)/$nDisplayRecs)*$nDisplayRecs+1; // Point to page boundary
		$course_outline->setStartRecordNumber($nStartRec);
	}
}
?>
<?php

// Page Load event
function Page_Load() {

	//echo "Page Load";
}

// Page Unload event
function Page_Unload() {

	//echo "Page Unload";
}
?>
