<?php 
	$correctAccess = false;
	if (isset($_SERVER['HTTP_REFERER']))
	{
		if ($_SERVER['HTTP_REFERER'] == "http://www.mimavima.com/")
		{
			$correctAccess = true;
		}
	}
	if (!$correctAccess)
	{
		$location = "Location: http://www.mimavima.com/";
		header( $location);
	}
	require_once   'strings.php';
	  require_once   'phpFunctions/miMaviMaFunctions.php';
	session_start();
	session_unset();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html dir="<?php echo $siteDir?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1255">
<script language="javascript" src="scripts/scripts.js"  type="text/javascript"></script>
<STYLE type="text/css">@import url("style/mainstyle.css");</STYLE>
<title><?php echo $siteTitle?></title>
</head>
<body class="">
<?php 
//	DEBUG PRINT_R
//		echo "<div dir='ltr'>";
//		echo "POST<BR>";
//		print_r($_POST);
//		echo "<hR>";
//		echo "GET<BR>";
//		print_r($_GET);
//		echo "<hR>";
//		echo "SESSION id= ". session_id()."<br>";
//		print_r($_SESSION);
//		echo "<hR>";
//		echo "</div>";
?>
			<!-- Information -->
				<div id="siteInformation" class="dataFrame">
				Under construction
	 			</div>
</body>
</html>