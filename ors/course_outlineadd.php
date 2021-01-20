<?php
define("EW_PAGE_ID", "add", TRUE); // Page ID
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

// Load key values from QueryString
$bCopy = TRUE;
if (@$_GET["course_outline_id"] != "") {
  $course_outline->course_outline_id->setQueryStringValue($_GET["course_outline_id"]);
} else {
  $bCopy = FALSE;
}

// Create form object
$objForm = new cFormObj();

// Process form if post back
if (@$_POST["a_add"] <> "") {
  $course_outline->CurrentAction = $_POST["a_add"]; // Get form action
  LoadFormValues(); // Load form values
} else { // Not post back
  if ($bCopy) {
    $course_outline->CurrentAction = "C"; // Copy Record
  } else {
    $course_outline->CurrentAction = "I"; // Display Blank Record
    LoadDefaultValues(); // Load default values
  }
}

// Perform action based on action code
switch ($course_outline->CurrentAction) {
  case "I": // Blank record, no action required
		break;
  case "C": // Copy an existing record
   if (!LoadRow()) { // Load record based on key
      $_SESSION[EW_SESSION_MESSAGE] = "No records found"; // No record found
      Page_Terminate($course_outline->getReturnUrl()); // Clean up and return
    }
		break;
  case "A": // ' Add new record
		$course_outline->SendEmail = TRUE; // Send email on add success
    if (AddRow()) { // Add successful
      $_SESSION[EW_SESSION_MESSAGE] = "Add New Record Successful"; // Set up success message
      Page_Terminate($course_outline->KeyUrl($course_outline->getReturnUrl())); // Clean up and return
    } else {
      RestoreFormValues(); // Add failed, restore form values
    }
}

// Render row based on row type
$course_outline->RowType = EW_ROWTYPE_ADD;  // Render add type
RenderRow();
?>
<?php include "header.php" ?>
<script type="text/javascript">
<!--
var EW_PAGE_ID = "add"; // Page id

//-->
</script>
<script type="text/javascript">
<!--

function ew_ValidateForm(fobj) {
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var i, elm, aelm, infix;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	for (i=0; i<rowcnt; i++) {
		infix = (fobj.key_count) ? String(i+1) : "";
		elm = fobj.elements["x" + infix + "_course_code"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - course code"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_Title"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - Title"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_Details"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - Details"))
				return false;
		}
		elm = fobj.elements["x" + infix + "_Duration"];
		if (elm && !ew_HasValue(elm)) {
			if (!ew_OnError(elm, "Please enter required field - Duration"))
				return false;
		}
	}
	return true;
}

//-->
</script>
<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
<script type="text/javascript">
<!--
_width_multiplier = 16;
_height_multiplier = 60;
var ew_DHTMLEditors = [];

function ew_UpdateTextArea() {
	if (typeof ew_DHTMLEditors != 'undefined' &&
		typeof FCKeditorAPI != 'undefined') {			
			var inst;			
			for (inst in FCKeditorAPI.__Instances)
				FCKeditorAPI.__Instances[inst].UpdateLinkedField();
	}
}

//-->
</script>
<script type="text/javascript">
<!--

// js for Popup Calendar
//-->

</script>
<script type="text/javascript">
<!--
var ew_MultiPagePage = "Page"; // multi-page Page Text
var ew_MultiPageOf = "of"; // multi-page Of Text
var ew_MultiPagePrev = "Prev"; // multi-page Prev Text
var ew_MultiPageNext = "Next"; // multi-page Next Text

//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<p><span class="phpmaker">Add to TABLE: course outline<br><br><a href="<?php echo $course_outline->getReturnUrl() ?>">Go Back</a></span></p>
<?php
if (@$_SESSION[EW_SESSION_MESSAGE] <> "") { // Mesasge in Session, display
?>
<p><span class="ewmsg"><?php echo $_SESSION[EW_SESSION_MESSAGE] ?></span></p>
<?php
  $_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
}
?>
<form name="fcourse_outlineadd" id="fcourse_outlineadd" action="course_outlineadd.php" method="post">
<p>
<input type="hidden" name="a_add" id="a_add" value="A">
<table class="ewTable">
  <tr class="ewTableRow">
    <td class="ewTableHeader">course code<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $course_outline->course_code->CellAttributes() ?>><span id="cb_x_course_code">
<select id="x_course_code" name="x_course_code"<?php echo $course_outline->course_code->EditAttributes() ?>>
<!--option value="">Please Select</option-->
<?php
if (is_array($course_outline->course_code->EditValue)) {
	$arwrk = $course_outline->course_code->EditValue;
	$rowswrk = count($arwrk);
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($course_outline->course_code->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected" : "";	
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
<?php if ($arwrk[$rowcntwrk][2] <> "") { ?>
<?php echo ew_ValueSeparator($rowcntwrk) ?><?php echo $arwrk[$rowcntwrk][2] ?>
<?php } ?>
</option>
<?php
			}
}
?>
</select>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Title<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $course_outline->Title->CellAttributes() ?>><span id="cb_x_Title">
<input type="text" name="x_Title" id="x_Title" title="" size="30" maxlength="150" value="<?php echo $course_outline->Title->EditValue ?>"<?php echo $course_outline->Title->EditAttributes() ?>>
</span></td>
  </tr>
  <tr class="ewTableRow">
    <td class="ewTableHeader">Details<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $course_outline->Details->CellAttributes() ?>><span id="cb_x_Details">
<textarea name="x_Details" id="x_Details" cols="40" rows="8"<?php echo $course_outline->Details->EditAttributes() ?>><?php echo $course_outline->Details->EditValue ?></textarea>
<script type="text/javascript">
<!--
var editor = new ew_DHTMLEditor("x_Details");
editor.create = function() {
	var sBasePath = 'fckeditor/';
	var oFCKeditor = new FCKeditor('x_Details', 40*_width_multiplier, 8*_height_multiplier);
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;
-->
</script>
</span></td>
  </tr>
  <tr class="ewTableAltRow">
    <td class="ewTableHeader">Duration<span class='ewmsg'>&nbsp;*</span></td>
    <td<?php echo $course_outline->Duration->CellAttributes() ?>><span id="cb_x_Duration">
<input type="text" name="x_Duration" id="x_Duration" title="" size="30" maxlength="150" value="<?php echo $course_outline->Duration->EditValue ?>"<?php echo $course_outline->Duration->EditAttributes() ?>>
</span></td>
  </tr>
</table>
<p>
<input type="button" name="btnAction" id="btnAction" value="    Add    " onClick="ew_SubmitForm(this.form);">
</form>
<script type="text/javascript">
<!--
ew_CreateEditor();  // Create DHTML editor(s)

//-->
</script>
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

// Load default values
function LoadDefaultValues() {
	global $course_outline;
}
?>
<?php

// Load form values
function LoadFormValues() {

	// Load from form
	global $objForm, $course_outline;
	$course_outline->course_code->setFormValue($objForm->GetValue("x_course_code"));
	$course_outline->Title->setFormValue($objForm->GetValue("x_Title"));
	$course_outline->Details->setFormValue($objForm->GetValue("x_Details"));
	$course_outline->Duration->setFormValue($objForm->GetValue("x_Duration"));
}

// Restore form values
function RestoreFormValues() {
	global $course_outline;
	$course_outline->course_code->CurrentValue = $course_outline->course_code->FormValue;
	$course_outline->Title->CurrentValue = $course_outline->Title->FormValue;
	$course_outline->Details->CurrentValue = $course_outline->Details->FormValue;
	$course_outline->Duration->CurrentValue = $course_outline->Duration->FormValue;
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
	// course_code

	$course_outline->course_code->CellCssStyle = "";
	$course_outline->course_code->CellCssClass = "";

	// Title
	$course_outline->Title->CellCssStyle = "";
	$course_outline->Title->CellCssClass = "";

	// Details
	$course_outline->Details->CellCssStyle = "";
	$course_outline->Details->CellCssClass = "";

	// Duration
	$course_outline->Duration->CellCssStyle = "";
	$course_outline->Duration->CellCssClass = "";
	if ($course_outline->RowType == EW_ROWTYPE_VIEW) { // View row
	} elseif ($course_outline->RowType == EW_ROWTYPE_ADD) { // Add row

		// course_code
		$course_outline->course_code->EditCustomAttributes = "";
		$sSqlWrk = "SELECT `course_code`, `course_code`, `name` FROM `courses`";
		$sSqlWrk .= " ORDER BY `name` Asc";
		$rswrk = $conn->Execute($sSqlWrk);
		$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
		if ($rswrk) $rswrk->Close();
		array_unshift($arwrk, array("", "Please Select", ""));
		$course_outline->course_code->EditValue = $arwrk;

		// Title
		$course_outline->Title->EditCustomAttributes = "";
		$course_outline->Title->EditValue = ew_HtmlEncode($course_outline->Title->CurrentValue);

		// Details
		$course_outline->Details->EditCustomAttributes = "";
		$course_outline->Details->EditValue = ew_HtmlEncode($course_outline->Details->CurrentValue);

		// Duration
		$course_outline->Duration->EditCustomAttributes = "";
		$course_outline->Duration->EditValue = ew_HtmlEncode($course_outline->Duration->CurrentValue);
	} elseif ($course_outline->RowType == EW_ROWTYPE_EDIT) { // Edit row
	} elseif ($course_outline->RowType == EW_ROWTYPE_SEARCH) { // Search row
	}

	// Call Row Rendered event
	$course_outline->Row_Rendered();
}
?>
<?php

// Add record
function AddRow() {
	global $conn, $Security, $course_outline;

	// Check for duplicate key
	$bCheckKey = TRUE;
	$sFilter = $course_outline->SqlKeyFilter();
	if (trim(strval($course_outline->course_outline_id->CurrentValue)) == "") {
		$bCheckKey = FALSE;
	} else {
		$sFilter = str_replace("@course_outline_id@", ew_AdjustSql($course_outline->course_outline_id->CurrentValue), $sFilter); // Replace key value
	}
	if (!is_numeric($course_outline->course_outline_id->CurrentValue)) {
		$bCheckKey = FALSE;
	}
	if ($bCheckKey) {
		$rsChk = $course_outline->LoadRs($sFilter);
		if ($rsChk && !$rsChk->EOF) {
			$_SESSION[EW_SESSION_MESSAGE] = "Duplicate value for primary key";
			$rsChk->Close();
			return FALSE;
		}
	}
	if ($course_outline->course_code->CurrentValue <> "") { // Check field with unique index
		$sFilter = "(`course_code` = '" . ew_AdjustSql($course_outline->course_code->CurrentValue) . "')";
		$rsChk = $course_outline->LoadRs($sFilter);
		if ($rsChk && !$rsChk->EOF) {
			$_SESSION[EW_SESSION_MESSAGE] = "Duplicate value for index or primary key -- `course_code`, value = " . $course_outline->course_code->CurrentValue;
			$rsChk->Close();
			return FALSE;
		}
	}
	$rsnew = array();

	// Field course_code
	$course_outline->course_code->SetDbValueDef($course_outline->course_code->CurrentValue, "");
	$rsnew['course_code'] =& $course_outline->course_code->DbValue;

	// Field Title
	$course_outline->Title->SetDbValueDef($course_outline->Title->CurrentValue, "");
	$rsnew['Title'] =& $course_outline->Title->DbValue;

	// Field Details
	$course_outline->Details->SetDbValueDef($course_outline->Details->CurrentValue, "");
	$rsnew['Details'] =& $course_outline->Details->DbValue;

	// Field Duration
	$course_outline->Duration->SetDbValueDef($course_outline->Duration->CurrentValue, "");
	$rsnew['Duration'] =& $course_outline->Duration->DbValue;

	// Call Row Inserting event
	$bInsertRow = $course_outline->Row_Inserting($rsnew);
	if ($bInsertRow) {
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$AddRow = $conn->Execute($course_outline->InsertSQL($rsnew));
		$conn->raiseErrorFn = '';
	} else {
		if ($course_outline->CancelMessage <> "") {
			$_SESSION[EW_SESSION_MESSAGE] = $course_outline->CancelMessage;
			$course_outline->CancelMessage = "";
		} else {
			$_SESSION[EW_SESSION_MESSAGE] = "Insert cancelled";
		}
		$AddRow = FALSE;
	}
	if ($AddRow) {
		$course_outline->course_outline_id->setDbValue($conn->Insert_ID());
		$rsnew['course_outline_id'] =& $course_outline->course_outline_id->DbValue;

		// Call Row Inserted event
		$course_outline->Row_Inserted($rsnew);
	}
	return $AddRow;
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
