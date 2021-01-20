<?php
define("EW_PAGE_ID", "list", TRUE); // Page ID
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
?>
<?php

// Paging variables
$nStartRec = 0; // Start record index
$nStopRec = 0; // Stop record index
$nTotalRecs = 0; // Total number of records
$nDisplayRecs = 20;
$nRecRange = 10;
$nRecCount = 0; // Record count

// Search filters
$sSrchAdvanced = ""; // Advanced search filter
$sSrchBasic = ""; // Basic search filter
$sSrchWhere = ""; // Search where clause
$sFilter = "";

// Master/Detail
$sDbMasterFilter = ""; // Master filter
$sDbDetailFilter = ""; // Detail filter
$sSqlMaster = ""; // Sql for master record

// Handle reset command
ResetCmd();

// Build filter
$sFilter = "";
if ($sDbDetailFilter <> "") {
	if ($sFilter <> "") $sFilter .= " AND ";
	$sFilter .= "(" . $sDbDetailFilter . ")";
}
if ($sSrchWhere <> "") {
	if ($sFilter <> "") $sFilter .= " AND ";
	$sFilter .= "(" . $sSrchWhere . ")";
}

// Set up filter in Session
$course_outline->setSessionWhere($sFilter);
$course_outline->CurrentFilter = "";

// Set Up Sorting Order
SetUpSortOrder();

// Set Return Url
$course_outline->setReturnUrl("course_outlinelist.php");
?>
<?php include "header.php" ?>
<?php if ($course_outline->Export == "") { ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "list"; // Page id

//-->
</script>
<script type="text/javascript">
<!--
var firstrowoffset = 1; // First data row start at
var lastrowoffset = 0; // Last data row end at
var EW_LIST_TABLE_NAME = 'ewlistmain'; // Table name for list page
var rowclass = 'ewTableRow'; // Row class
var rowaltclass = 'ewTableAltRow'; // Row alternate class
var rowmoverclass = 'ewTableHighlightRow'; // Row mouse over class
var rowselectedclass = 'ewTableSelectRow'; // Row selected class
var roweditclass = 'ewTableEditRow'; // Row edit class

//-->
</script>
<script type="text/javascript">
<!--
var ew_DHTMLEditors = [];

//-->
</script>
<script type="text/javascript">
<!--

// js for Popup Calendar
//-->

</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php if ($course_outline->Export == "") { ?>
<?php } ?>
<?php

// Load recordset
$bExportAll = (defined("EW_EXPORT_ALL") && $course_outline->Export <> "");
$bSelectLimit = ($course_outline->Export == "" && $course_outline->SelectLimit);
if (!$bSelectLimit) $rs = LoadRecordset();
$nTotalRecs = ($bSelectLimit) ? $course_outline->SelectRecordCount() : $rs->RecordCount();
$nStartRec = 1;
if ($nDisplayRecs <= 0) $nDisplayRecs = $nTotalRecs; // Display all records
if (!$bExportAll) SetUpStartRec(); // Set up start record position
if ($bSelectLimit) $rs = LoadRecordset($nStartRec-1, $nDisplayRecs);
?>
<p><span class="phpmaker" style="white-space: nowrap;">TABLE: course outline
</span></p>
<?php if ($course_outline->Export == "") { ?>
<?php } ?>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") {
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
	$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message
}
?>
<form method="post" name="fcourse_outlinelist" id="fcourse_outlinelist">
<?php if ($course_outline->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<a href="course_outlineadd.php">Add</a>&nbsp;&nbsp;
	</span></td></tr>
</table>
<?php } ?>
<?php if ($nTotalRecs > 0) { ?>
<table id="ewlistmain" class="ewTable">
<?php
	$OptionCnt = 0;
	$OptionCnt++; // view
	$OptionCnt++; // edit
	$OptionCnt++; // copy
	$OptionCnt++; // delete
?>
	<!-- Table header -->
	<tr class="ewTableHeader">
		<td valign="top" style="white-space: nowrap;">
<?php if ($course_outline->Export <> "") { ?>
course outline id
<?php } else { ?>
	<a href="course_outlinelist.php?order=<?php echo urlencode('course_outline_id') ?>&ordertype=<?php echo $course_outline->course_outline_id->ReverseSort() ?>">course outline id<?php if ($course_outline->course_outline_id->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($course_outline->course_outline_id->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top" style="white-space: nowrap;">
<?php if ($course_outline->Export <> "") { ?>
course code
<?php } else { ?>
	<a href="course_outlinelist.php?order=<?php echo urlencode('course_code') ?>&ordertype=<?php echo $course_outline->course_code->ReverseSort() ?>">course code<?php if ($course_outline->course_code->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($course_outline->course_code->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top" style="white-space: nowrap;">
<?php if ($course_outline->Export <> "") { ?>
Title
<?php } else { ?>
	<a href="course_outlinelist.php?order=<?php echo urlencode('Title') ?>&ordertype=<?php echo $course_outline->Title->ReverseSort() ?>">Title<?php if ($course_outline->Title->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($course_outline->Title->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
		<td valign="top" style="white-space: nowrap;">
<?php if ($course_outline->Export <> "") { ?>
Duration
<?php } else { ?>
	<a href="course_outlinelist.php?order=<?php echo urlencode('Duration') ?>&ordertype=<?php echo $course_outline->Duration->ReverseSort() ?>">Duration<?php if ($course_outline->Duration->getSort() == "ASC") { ?><img src="images/sortup.gif" width="10" height="9" border="0"><?php } elseif ($course_outline->Duration->getSort() == "DESC") { ?><img src="images/sortdown.gif" width="10" height="9" border="0"><?php } ?></a>
<?php } ?>
		</td>
<?php if ($course_outline->Export == "") { ?>
<td nowrap>&nbsp;</td>
<td nowrap>&nbsp;</td>
<td nowrap>&nbsp;</td>
<td nowrap>&nbsp;</td>
<?php } ?>
	</tr>
<?php
if (defined("EW_EXPORT_ALL") && $course_outline->Export <> "") {
	$nStopRec = $nTotalRecs;
} else {
	$nStopRec = $nStartRec + $nDisplayRecs - 1; // Set the last record to display
}
$nRecCount = $nStartRec - 1;
if (!$rs->EOF) {
	$rs->MoveFirst();
	if (!$course_outline->SelectLimit) $rs->Move($nStartRec - 1); // Move to first record directly
}
$RowCnt = 0;
while (!$rs->EOF && $nRecCount < $nStopRec) {
	$nRecCount++;
	if (intval($nRecCount) >= intval($nStartRec)) {
		$RowCnt++;

	// Init row class and style
	$course_outline->CssClass = "ewTableRow";
	$course_outline->CssStyle = "";

	// Init row event
	$course_outline->RowClientEvents = "onmouseover='ew_MouseOver(this);' onmouseout='ew_MouseOut(this);' onclick='ew_Click(this);'";

	// Display alternate color for rows
	if ($RowCnt % 2 == 0) {
		$course_outline->CssClass = "ewTableAltRow";
	}
	LoadRowValues($rs); // Load row values
	$course_outline->RowType = EW_ROWTYPE_VIEW; // Render view
	RenderRow();
?>
	<!-- Table body -->
	<tr<?php echo $course_outline->DisplayAttributes() ?>>
		<!-- course_outline_id -->
		<td<?php echo $course_outline->course_outline_id->CellAttributes() ?>>
<div<?php echo $course_outline->course_outline_id->ViewAttributes() ?>><?php echo $course_outline->course_outline_id->ViewValue ?></div>
</td>
		<!-- course_code -->
		<td<?php echo $course_outline->course_code->CellAttributes() ?>>
<div<?php echo $course_outline->course_code->ViewAttributes() ?>><?php echo $course_outline->course_code->ViewValue ?></div>
</td>
		<!-- Title -->
		<td<?php echo $course_outline->Title->CellAttributes() ?>>
<div<?php echo $course_outline->Title->ViewAttributes() ?>><?php echo $course_outline->Title->ViewValue ?></div>
</td>
		<!-- Duration -->
		<td<?php echo $course_outline->Duration->CellAttributes() ?>>
<div<?php echo $course_outline->Duration->ViewAttributes() ?>><?php echo $course_outline->Duration->ViewValue ?></div>
</td>
<?php if ($course_outline->Export == "") { ?>
<td nowrap><span class="phpmaker">
<a href="<?php echo $course_outline->ViewUrl() ?>">View</a>
</span></td>
<td nowrap><span class="phpmaker">
<a href="<?php echo $course_outline->EditUrl() ?>">Edit</a>
</span></td>
<td nowrap><span class="phpmaker">
<a href="<?php echo $course_outline->CopyUrl() ?>">Copy</a>
</span></td>
<td nowrap><span class="phpmaker">
<a href="<?php echo $course_outline->DeleteUrl() ?>">Delete</a>
</span></td>
<?php } ?>
	</tr>
<?php
	}
	$rs->MoveNext();
}
?>
</table>
<?php if ($course_outline->Export == "") { ?>
<table>
	<tr><td><span class="phpmaker">
<a href="course_outlineadd.php">Add</a>&nbsp;&nbsp;
	</span></td></tr>
</table>
<?php } ?>
<?php } ?>
</form>
<?php

// Close recordset and connection
if ($rs) $rs->Close();
?>
<?php if ($course_outline->Export == "") { ?>
<form action="course_outlinelist.php" name="ewpagerform" id="ewpagerform">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td nowrap>
<?php if (!isset($Pager)) $Pager = new cPrevNextPager($nStartRec, $nDisplayRecs, $nTotalRecs) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker">Page&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="course_outlinelist.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="images/first.gif" alt="First" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/firstdisab.gif" alt="First" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="course_outlinelist.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="images/prev.gif" alt="Previous" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="images/prevdisab.gif" alt="Previous" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="course_outlinelist.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="images/next.gif" alt="Next" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/nextdisab.gif" alt="Next" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="course_outlinelist.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="images/last.gif" alt="Last" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="images/lastdisab.gif" alt="Last" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;of <?php echo $Pager->PageCount ?></span></td>
	</tr></table>
	<span class="phpmaker">Records <?php echo $Pager->FromIndex ?> to <?php echo $Pager->ToIndex ?> of <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($sSrchWhere == "0=101") { ?>
	<span class="phpmaker">Please enter search criteria</span>
	<?php } else { ?>
	<span class="phpmaker">No records found</span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<?php if ($course_outline->Export == "") { ?>
<?php } ?>
<?php if ($course_outline->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
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

// Set up Sort parameters based on Sort Links clicked
function SetUpSortOrder() {
	global $course_outline;

	// Check for an Order parameter
	if (@$_GET["order"] <> "") {
		$course_outline->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
		$course_outline->CurrentOrderType = @$_GET["ordertype"];

		// Field course_outline_id
		$course_outline->UpdateSort($course_outline->course_outline_id);

		// Field course_code
		$course_outline->UpdateSort($course_outline->course_code);

		// Field Title
		$course_outline->UpdateSort($course_outline->Title);

		// Field Duration
		$course_outline->UpdateSort($course_outline->Duration);
		$course_outline->setStartRecordNumber(1); // Reset start position
	}
	$sOrderBy = $course_outline->getSessionOrderBy(); // Get order by from Session
	if ($sOrderBy == "") {
		if ($course_outline->SqlOrderBy() <> "") {
			$sOrderBy = $course_outline->SqlOrderBy();
			$course_outline->setSessionOrderBy($sOrderBy);
		}
	}
}

// Reset command based on querystring parameter cmd=
// - RESET: reset search parameters
// - RESETALL: reset search & master/detail parameters
// - RESETSORT: reset sort parameters
function ResetCmd() {
	global $sDbMasterFilter, $sDbDetailFilter, $nStartRec, $sOrderBy;
	global $course_outline;

	// Get reset cmd
	if (@$_GET["cmd"] <> "") {
		$sCmd = $_GET["cmd"];

		// Reset Sort Criteria
		if (strtolower($sCmd) == "resetsort") {
			$sOrderBy = "";
			$course_outline->setSessionOrderBy($sOrderBy);
			$course_outline->course_outline_id->setSort("");
			$course_outline->course_code->setSort("");
			$course_outline->Title->setSort("");
			$course_outline->Duration->setSort("");
		}

		// Reset start position
		$nStartRec = 1;
		$course_outline->setStartRecordNumber($nStartRec);
	}
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
