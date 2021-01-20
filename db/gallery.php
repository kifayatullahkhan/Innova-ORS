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

mysql_select_db($database_conn, $conn);
$query_Rs_getGalleryList = "SELECT picture_filename, title_text, comments FROM pic_gallery ORDER BY pic_id DESC";
$Rs_getGalleryList = mysql_query($query_Rs_getGalleryList, $conn) or die(mysql_error());
$row_Rs_getGalleryList = mysql_fetch_assoc($Rs_getGalleryList);
$totalRows_Rs_getGalleryList = mysql_num_rows($Rs_getGalleryList);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

	<head profile="http://gmpg.org/xfn/11">

	<title>Picture Galary</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	
	<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.js"></script>
	<script src="http://dev.jquery.com/view/tags/ui/latest/ui/effects.core.js"></script>
	<script src="http://dev.jquery.com/view/tags/ui/latest/ui/effects.slide.js"></script>
	<script type="text/javascript" src="includes/supersized.2.0.js"></script>

    <script type="text/javascript" src="includes/pngfix/jquery.pngFix.js"></script> 
    <script type="text/javascript"> 
    $(document).ready(function(){ 
        $(document).pngFix(); 
    }); 
</script>
	<script type="text/javascript">  
		$(function(){
			$.fn.supersized.options = {  
				startwidth: 640,  
				startheight: 480,
				vertical_center: 1,
				slideshow: 1,
				navigation: 1,
				transition: 1, //0-None, 1-Fade, 2-slide top, 3-slide right, 4-slide bottom, 5-slide left
				pause_hover: 1,
				slide_counter: 1,
				slide_captions: 1,
				slide_interval: 5000  
			};
	        $('#supersize').supersized(); 
	    });
	</script>
	
	<style type="text/css">
		*{
			margin:0;
			padding:0;
		}
		a{
			color:#8FC2FF;
			text-decoration: none;
			outline: none;
		}
		a:hover{
			text-decoration: underline;
		}
		img{
			border:none;
		}
		body {
			overflow:hidden;/*Needed to eliminate scrollbars*/
			background:#000;
		}
		#content{
			margin:0px auto;
			height:100px;
			width:100%;
			bottom:5%;
			z-index: 3;
			background:#262626 no-repeat 90%;
			border-top:1px solid #000;
			border-bottom:1px solid #4F4F4F;
			position:absolute;
		}
		#contentframe{
			overflow: hidden;
			border-top:solid 1px #4F4F4F;
			border-bottom:1px solid #000;
			height: 100%;
			text-align:left;
			z-index: 3;
		}
		#slidecounter{
			float:left;
			color:#4F4F4F;
			font:50px "Helvetica Neue", Arial, sans-serif;
			font-weight:bold;
			margin:18px 20px;	
		}
		#slidecaption{
			overflow: hidden;
			float:left;
			color:#FFF;
			font:26px "Helvetica Neue", Arial, sans-serif;
			font-weight:bold;
			margin:33px 0;
		}
		/*Supersized Stamp*/
		.stamp{
			float: right;
			margin: 25px 20px 0 0;
		}
		/*Supersize Plugin Styles*/
		#navigation{
			background: url('images/gallery_images/navbg.gif') no-repeat;
			float: right;
			margin:22px 20px 0 0;
		}
		#loading {
			position: absolute;
			top: 49.5%; 
			left: 49.5%;
			z-index: 3;
			width: 24px; 
			height: 24px;
			text-indent: -999em;
			background-image: url(images/gallery_images/progress.gif);
		}
		#supersize{
			position:fixed;
		}
		#supersize img, #supersize a{
			height:100%;
			width:100%;
			position:absolute;
			z-index: 0;
		}
		#supersize .prevslide, #supersize .prevslide img{
			z-index: 1;
		}
		#supersize .activeslide, #supersize .activeslide img{
			z-index: 2;
		}
		
		
	</style>
</head>

<body>
<!--Loading display while images load-->
<div id="loading">&nbsp;</div>

<!--Slides-->
<div id="supersize">	
    <?php do { ?>
    <a href="/user_uploads/pic_gallery_images/<?php echo $row_Rs_getGalleryList['picture_filename']; ?>"><img src="/user_uploads/pic_gallery_images/<?php echo $row_Rs_getGalleryList['picture_filename']; ?>" title="<?php echo $row_Rs_getGalleryList['title_text']; ?>"/></a>
	<?php } while ($row_Rs_getGalleryList = mysql_fetch_assoc($Rs_getGalleryList)); ?>	
</div>

<!--Content area that hovers on top-->
<div id="content">
	<div id="contentframe">	
		<div id="slidecounter"><!--Slide counter-->
			<span class="slidenumber"></span>/<span class="totalslides"></span>
		</div>
		<div id="slidecaption"><!--Slide captions displayed here--></div>
		<!--Logo-->
		<a href="/" class="stamp"><img src="images/gallery_images/zorkif_logo.png"/></a>
		<!--Navigation-->
  <div id="navigation">
			<a href="#" id="prevslide"><img src="images/gallery_images/back_dull.gif"/></a><a href="#" id="pauseplay"><img src="images/gallery_images/pause_dull.gif"/></a><a href="#" id="nextslide"><img src="images/gallery_images/forward_dull.gif"/></a>
		</div>
		
	</div>
</div>

</body>
</html>
<?php
mysql_free_result($Rs_getGalleryList);
?>
