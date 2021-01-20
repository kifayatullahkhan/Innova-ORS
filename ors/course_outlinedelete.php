<?php
define("EW_PAGE_ID", "delete", TRUE); // Page ID
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

// Load Key Parameters
$sKey = "";
$bSingleDelete = TRUE; // Initialize as single delete
$arRecKeys = array();
$nKeySelected = 0; // Initialize selected key count
$sFilter = "";
if (@$_GET["course_outline_id"] <> "") {
	$course_outline->course_outline_id->setQueryStringValue($_GET["course_outline_id"]);
	if (!is_numeric($course_outline->course_outline_id->QueryStringValue)) {
		Page_Terminate($course_outline->getReturnUrl()); // Prevent sql injection, exit
	}
	$sKey .= $course_outline->course_outline_id->QueryStringValue;
} else {
	$bSingleDelete = FALSE;
}
if ($bSingleDelete) {
	$nKeySelected = 1; // Set up key selected count
	$arRecKeys[0] = $sKey;
} else {
	if (isset($_POST["key_m"])) { // Key in form
		$nKeySelected = count($_POST["key_m"]); // Set up key selected count
		$arRecKeys = ew_StripSlashes($_POST["key_m"]);
	}
}
if ($nKeySelected <= 0) Page_Terminate($course_outline->getReturnUrl()); // No key specified, exit

// Build filter
foreach ($arRecKeys as $sKey) {
	$sFilter .= "(";

	// Set up key field
	$sKeyFld = $sKey;
	if (!is_numeric($sKeyFld)) {
		Page_Terminate($course_outline->getReturnUrl()); // Prevent sql injection, exit
	}
	$sFilter .= "`course_outline_id`=" . ew_AdjustSql($sKeyFld) . " AND ";
	if (substr($sFilter, -5) == " AND ") $sFilter = substr($sFilter, 0, strlen($sFilter)-5) . ") OR ";
}
if (substr($sFilter, -4) == " OR ") $sFilter = substr($sFilter, 0, strlen($sFilter)-4);

// Set up filter (Sql Where Clause) and get Return Sql
// Sql constructor in course_outline class, course_outlineinfo.php

$course_outline->CurrentFilter = $sFilter;

// Get action
if (@$_POST["a_delete"] <> "") {
	$course_outline->CurrentAction = $_POST["a_delete"];
} else {
	$course_outline->CurrentAction = "I"; // Display record
}
switch ($course_outline->CurrentAction) {
	case "D": // Delete
		$course_outline->SendEmail = TRUE; // Send email on delete success
		if (DeleteRows()) { // delete rows
			$_SESSION[EW_SESSION_MESSAGE] = "Delete Successful"; // Set up success message
			Page_Terminate($course_outline->getReturnUrl()); // Return to caller
		}
}

// Load records for display
$rs = LoadRecordset();
$nTotalRecs = $rs->RecordCount(); // Get record count
if ($nTotalRecs <= 0) { // No record found, exit
	$rs->Close();
	Page_Terminate($course_outline->getReturnUrl()); // Return to caller
}
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "delete"; // Page id

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker">Delete from TABLE: course outline<br><br><a href="<?php echo $course_outline->getReturnUrl() ?>">Go Back</a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form action="course_outlinedelete.php" method="post">
<p>
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($arRecKeys as $sKey) { ?>
<input type="hidden" name="key_m[]" id="key_m[]" value="<?php echo ew_HtmlEncode($sKey) ?>">
<?php } ?>
<table class="ewTable">
	<tr class="ewTableHeader">
		<td valign="top">course outline id</td>
		<td valign="top">course code</td>
		<td valign="top">Title</td>
		<td valign="top">Duration</td>
	</tr>
<?php
$nRecCount = 0;
$i = 0;
while (!$rs->EOF) {
	$nRecCount++;

	// Set row class and style
	$course_outline->CssClass = "ewTableRow";
	$course_outline->CssStyle = "";

	// Display alternate color for rows
	if ($nRecCount % 2 <> 1) {
		$course_outline->CssClass = "ewTableAltRow";
	}

	// Get the field contents
	LoadRowValues($rs);

	// Render row value
	$course_outline->RowType = EW_ROWTYPE_VIEW; // view
	RenderRow();
?>
	<tr<?php echo $course_outline->DisplayAttributes() ?>>
		<td<?php echo $course_outline->course_outline_id->CellAttributes() ?>>
<div<?php echo $course_outline->course_outline_id->ViewAttributes() ?>><?php echo $course_outline->course_outline_id->ViewValue ?></div>
</td>
		<td<?php echo $course_outline->course_code->CellAttributes() ?>>
<div<?php echo $course_outline->course_code->ViewAttributes() ?>><?php echo $course_outline->course_code->ViewValue ?></div>
</td>
		<td<?php echo $course_outline->Title->CellAttributes() ?>>
<div<?php echo $course_outline->Title->ViewAttributes() ?>><?php echo $course_outline->Title->ViewValue ?></div>
</td>
		<td<?php echo $course_outline->Duration->CellAttributes() ?>>
<div<?php echo $course_outline->Duration->ViewAttributes() ?>><?php echo $course_outline->Duration->ViewValue ?></div>
</td>
	</tr>
<?php
	$rs->MoveNext();
}
$rs->Close();
?>
</table>
<p>
<input type="submit" name="Action" id="Action" value="Confirm Delete">
</form>
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

// ------------------------------------------------
//  Function DeleteRows
//  - Delete Records based on current filter
function DeleteRows() {
	global $conn, $Security, $course_outline;
	$DeleteRows = TRUE;
	$sWrkFilter = $course_outline->CurrentFilter;

	// Set up filter (Sql Where Clause) and get Return Sql
	// Sql constructor in course_outline class, course_outlineinfo.php

	$course_outline->CurrentFilter = $sWrkFilter;
	$sSql = $course_outline->SQL();
	$conn->raiseErrorFn = 'ew_ErrorFn';
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';
	if ($rs === FALSE) {
		return FALSE;
	} elseif ($rs->EOF) {
		$_SESSION[EW_SESSION_MESSAGE] = "No records found"; // No record found
		$rs->Close();
		return FALSE;
	}
	$conn->BeginTrans();

	// Clone old rows
	$rsold = ($rs) ? $rs->GetRows() : array();
	if ($rs) $rs->Close();

	// Call row deleting event
	if ($DeleteRows) {
		foreach ($rsold as $row) {
			$DeleteRows = $course_outline->Row_Deleting($row);
			if (!$DeleteRows) break;
		}
	}
	if ($DeleteRows) {
		$sKey = "";
		foreach ($rsold as $row) {
			$sThisKey = "";
			if ($sThisKey <> "") $sThisKey .= EW_COMPOSITE_KEY_SEPARATOR;
			$sThisKey .= $row['course_outline_id'];
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$DeleteRows = $conn->Execute($course_outline->DeleteSQL($row)); // Delete
			$conn->raiseErrorFn = '';
			if ($DeleteRows === FALSE)
				break;
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}
	} else {

		// Set up error message
		if ($course_outline->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $course_outline->CancelMessage;
			$course_outline->CancelMessage = "";
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = "Delete cancelled";
		}
	}
	if ($DeleteRows) {
		$conn->CommitTrans(); // Commit the changes
	} else {
		$conn->RollbackTrans(); // Rollback changes
	}

	// Call recordset deleted event
	if ($DeleteRows) {
		foreach ($rsold as $row) {
			$course_outline->Row_Deleted($row);
		}	
	}
	return $DeleteRows;
}
?>
<?php

// Load recordset
function LoadRecordset($offset = -1, $rowcnt = -1) {
	global $conn, $course_outline;

	// Call Recordset Selecting event
	$course_outline->Recordset_Selecting($course_outline->CurrentFilter);

	// Load list page sql
	$sSql = $course_outline->SelectSQL();
	if ($offset > -1 && $rowcnt > -1) $sSql .= " LIMIT $offset, $rowcnt";

	// Load recordset
	$conn->raiseErrorFn = 'ew_ErrorFn';	
	$rs = $conn->Execute($sSql);
	$conn->raiseErrorFn = '';

	// Call Recordset Selected event
	$course_outline->Recordset_Selected($rs);
	return $rs;
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
	// course_outline_id

	$course_outline->course_outline_id->CellCssStyle = "white-space: nowrap;";
	$course_outline->course_outline_id->CellCssClass = "";

	// course_code
	$course_outline->course_code->CellCssStyle = "white-space: nowrap;";
	$course_outline->course_code->CellCssClass = "";

	// Title
	$course_outline->Title->CellCssStyle = "white-space: nowrap;";
	$course_outline->Title->CellCssClass = "";

	// Duration
	$course_outline->Duration->CellCssStyle = "white-space: nowrap;";
	$course_outline->Duration->CellCssClass = "";
	if ($course_outline->RowType == EW_ROWTYPE_VIEW) { // View row

		// course_outline_id
		$course_outline->course_outline_id->ViewValue = $course_outline->course_outline_id->CurrentValue;
		$course_outline->course_outline_id->CssStyle = "";
		$course_outline->course_outline_id->CssClass = "";
		$course_outline->course_outline_id->ViewCustomAttributes = "";

		// course_code
		if (!is_null($course_outline->course_code->CurrentValue)) {
			$sSqlWrk = "SELECT `course_code`, `name` FROM `courses` WHERE `course_code` = '" . ew_AdjustSql($course_outline->course_code->CurrentValue) . "'";
			$sSqlWrk .= " ORDER BY `name` Asc";
			$rswrk = $conn->Execute($sSqlWrk);
			if ($rswrk) {
				if (!$rswrk->EOF) {
					$course_outline->course_code->ViewValue = $rswrk->fields('course_code');
					$course_outline->course_code->ViewValue .= ew_ValueSeparator(0) . $rswrk->fields('name');
				}
				$rswrk->Close();
			} else {
				$course_outline->course_code->ViewValue = $course_outline->course_code->CurrentValue;
			}
		} else {
			$course_outline->course_code->ViewValue = NULL;
		}
		$course_outline->course_code->CssStyle = "";
		$course_outline->course_code->CssClass = "";
		$course_outline->course_code->ViewCustomAttributes = "";

		// Title
		$course_outline->Title->ViewValue = $course_outline->Title->CurrentValue;
		$course_outline->Title->CssStyle = "";
		$course_outline->Title->CssClass = "";
		$course_outline->Title->ViewCustomAttributes = "";

		// Duration
		$course_outline->Duration->ViewValue = $course_outline->Duration->CurrentValue;
		$course_outline->Duration->CssStyle = "";
		$course_outline->Duration->CssClass = "";
		$course_outline->Duration->ViewCustomAttributes = "";

		// course_outline_id
		$course_outline->course_outline_id->HrefValue = "";

		// course_code
		$course_outline->course_code->HrefValue = "";

		// Title
		$course_outline->Title->HrefValue = "";

		// Duration
		$course_outline->Duration->HrefValue = "";
	} elseif ($course_outline->RowType == EW_ROWTYPE_ADD) { // Add row
	} elseif ($course_outline->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($course_outline->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$course_outline->Row_Rendered();
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
