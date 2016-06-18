<?php 
	session_start();
	include_once 'strings.php';
	include_once 'phpFunctions//miMaviMaFunctions.php';
	$EID = "notSet";
	if (isset($_GET['EID']))
	{
		$EID=$_GET['EID'];
		session_unset();	
	}
	if (isset($_POST['EID']))
	{
		$EID=$_POST['EID'];
		session_unset();
	}
	if (isset($_SESSION['EID']))
	{
		if ($_SESSION['EID'] != '')
		{
			if ($_SESSION['EID'] == 'notSet')
			{
				session_unset();
				session_destroy();
			}
			else
			{
				$EID=$_SESSION['EID'];
			}
		}
	}
	if ($EID == "notSet")
	{
		echo "BAHH";
	}
	else
	{
			if (eventExists($EID) == false)//NO SUCH EVENT GO BACK TO INDEX
			{
				$location = "Location: http://www.mimavima.com/index.php?ERR=".$EID;
				header( $location);
				echo "<HR> THIS EVENT DOES NOT EXSIST<HR>";
			}
			{
				//THe event exisits
				$_SESSION['MAIN_PAGE_LOADING'] = "MAIN_PAGE_LOADING";
			    $_SESSION['selectedName'] = $noOneSelectedLabel;
			    $_SESSION['EID'] = $EID;
			}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html dir="<?php echo $siteDir?>">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=windows-1255">
<meta property="og:title" content="מי מביא מה" />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://www.mimavima.com" />
<meta property="og:image" content="http://www.mimavima.com/img/logo.png" />
<meta property="og:site_name" content="מי מביא מה" />
<meta property="fb:admins" content="100002436675607" />

<script language="javascript" src="scripts/scripts.js" type="text/javascript"></script>
<STYLE type="text/css">@import url("style/mainstyle.css");</STYLE>

<title><?php echo $siteTitle?></title>
<!-- Google analitics -->
		<script type="text/javascript">

			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-21562447-1']);
			  _gaq.push(['_trackPageview']);
			
			  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  				})();
 		 </script>
</head>

<body class="MAIN_PAGE">

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
//		echo "EID = " . $EID;
//		echo "<hR>";
//		echo "</div>";
//		

	?>
<!--start contactable -->
<div id="my-contact-div"><!-- contactable html placeholder --></div>

<link rel="stylesheet" href="http://www.mimavima.com/js/feedback/contactable.css" type="text/css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://www.mimavima.com/js/feedback/jquery.contactable.js"></script>

<script>
	jQuery(function(){
		jQuery('#my-contact-div').contactable(
        {
            subject: 'feedback URL:'+location.href,
            url: 'mail.php',
            name: 'שם',
            email: 'דוא"ל',
            dropdownTitle: 'על מה רציתם לספר לנו?',
            dropdownOptions: ['כללי', 'תקלה באתר', 'הצעה לשיפור'],
            message : 'ההודעה',
            submit : 'שלח',
            recievedMsg : 'תודה על ההודעה נחזור אליכם בהקדם',
            notRecievedMsg : 'מצטערים אבל היתה תקלה וההודעה לא נשלחה, אנא נסו שוב',
            disclaimer: 'נשמח לשמוע כל מה שיש לכם לומר, אנו מעריכים כל הערה והארה והיא תעזור לנו להשתפר בגרסא הבאה',
            hideOnSubmit: true
        });
	});
</script>
<!--end contactable -->
	<table class="MAIN_TABLE">
		<!-- Header -->
		<thead>
		<tr class="MAIN_TABLE_HEADER_ROW">
			<td colspan="3">
				<?php include_once 'mmm_header.php';?>
			</td>
		</tr>
		</thead>
		<!-- Main -->
		<tbody>
		<tr class="MAIN_TABLE_BODY_ROW">
			<!-- Menu -->
			<td  class="MAIN_TABLE_BODY_ROW_MENU">
				<?php include_once 'mmm_displayMenu.php';?>
			</td>
			<!-- Information -->
			<td class="MAIN_TABLE_BODY_ROW_INFORMATION">
				<div id="dataFrame" class="dataFrame">
	 			<IFRAME src ="mmm_displayInformation.php?EID="<?php echo $_SESSION[EID]?>" width="100%" height="700px" name="INFORMATION_IFRAME" id="INFORMATION_IFRAME"> </IFRAME>
	 			</div>
				<!-- FOOTER -->
				<h1>תגובות:</h1><br/>
<!-- Pnyxe Start-->
<script type="text/javascript" language="javascript">
var zpbw_webWidgetArticleUrl = "http://www.mimavima.com/main.php?EID=<?php echo $_SESSION[EID]?>";
</script>
<span style="display:none;">***</span>
<script type="text/javascript" language="javascript" id="pnyxeDiscussItJs" src="http://www.pnyxe.com/PnyxeDiscussItJs.jsp"></script>
<script type="text/javascript" language="javascript" id="pnyxeDiscussItInitJs625937">try { var zpbw_webWidgetClientKey = "VE_NI3EBMOHcbNKlHyJ0cA"; var pnyxeDiscussIt = new PnyxeDiscussIt(); pnyxeDiscussIt.init("625937"); } catch (e) {}</script>
<noscript><a href="http://www.pnyxe.com/DiscussIt-comment-system?utm_source=wwcCodeSpanPromotion2" rel="nofollow">Professional Comment System</a></noscript>
<!-- Pnyxe End-->
				<div id="footer" class="ui-corner-all">
					<ul id="navlist">
						<li><a href="http://www.mimavima.com">חזרה לדף הראשי</a></li>
						<li><a href="#">About</a></li>
						<li><a href="mmm_termsAndPrivacy.php" target="_BLANK">Terms & Privacy</a></li>
					</ul>
				Copyright 2009 - 2012 <a href="mailto:support@mimavima.com">Amit Eitan</a> | All Rights Reserved <!-- - Developed using HTML5 & CSS3 --> 
				</div>
			</td>
		</tr>
		</tbody>

	
	</table>
</body>
</html>