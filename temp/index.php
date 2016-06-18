<?php require_once   'strings.php';
	  require_once   'phpFunctions/miMaviMaFunctions.php';
	session_start();
	session_unset();
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html dir="<?php echo $siteDir?>">
<head>

<!-- Google plus header start -->
<script type="text/javascript" src="https://apis.google.com/js/plusone.js">
  {lang: 'iw'}
</script>
<!-- Google plus header end -->

<META NAME="keywords" CONTENT="miMavima, events, social, who brings what?"> 
<META NAME="description" CONTENT="arrange communal events. easy and free. arrange events where the participates bring the needed stuff"> 
<meta http-equiv="Content-Type" content="text/html; charset=windows-1255">
<meta property="og:title" content="מי מביא מה" />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://www.mimavima.com" />
<meta property="og:image" content="http://www.mimavima.com/img/logo.png" />
<meta property="og:site_name" content="מי מביא מה" />
<meta property="fb:admins" content="100002436675607" />
<script language="javascript" src="scripts/scripts.js"  type="text/javascript"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
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

			  jQuery(document).ready(function(){
				  $('#contact').contactable({
				   subject: 'A Feeback Message'
				  });
				 });
				 				
 		 </script>
</head>
<body class="MAIN_PAGE">
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
		<table class="MAIN_TABLE">
		<!-- Header -->
		<thead>
		<tr class="MAIN_TABLE_HEADER_ROW">
			<td colspan="3">
				<!-- Header -->
					<!-- LOGO -->
					<div class="LOGO"> 
				<!-- 
					<a href="http://www.mimavima.com">
				 -->
					<img class="LOGO" src="img/logo.png" alt="Mi Mavi Ma Logo"/>
					
				<!-- 
					</a>
				 -->
						
					</div>
					<table>
				<TR>
					<TD>למעבר לאירוע קיים הכנס את מספרו כעת</TD>
					<TD>
						<FORM  method="post" action="main.php" name="EXISTING_EVENT" id="EXISTING_EVENT">
							<INPUT type="text" name="EID" id="EID">
							<button type="submit" name="EID_BUTTON" id="EID_BUTTON" value=""><?php echo $exsistingEventButtonLabel?></button>
						</FORM>
					</TD>
					<td>
						<!-- +1 button start -->
							<g:plusone></g:plusone>
						<!-- +1 button end -->
						<!-- facebook like start -->
						<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=239302439426736&amp;xfbml=1"></script><fb:like href="www.mimavima.com" send="true" layout="button_count" width="450" show_faces="false" action="recommend" font=""></fb:like>
						
						
						<!-- facebook like end -->							
					
					</td>
				</TR>
				</table>
			</td>
		</tr>
		
		</thead>
		<!-- Main -->
		<tbody>
		<tr class="MAIN_TABLE_BODY_ROW">
			<!-- Menu -->
			<td  class="MAIN_TABLE_BODY_ROW_MENU">
					תפריט
			<ul>
				<li>
					<FORM  method="post" action="newEvent.php" target="INFORMATION_IFRAME" name="NEW_EVENT" id="NEW_EVENT">
						<!-- OPEN EVENT FOR EDITING -->
						<a href="javascript:linkSubmit('NEW_EVENT','OPEN_EVENT_FOR_EDITING',1);enableNameSelection()" >צור אירוע חדש</a>
					</FORM>
				</li>
			</ul>
			</td>
			<!-- Information -->
			<td class="MAIN_TABLE_BODY_ROW_INFORMATION">
	 			<div id="dataFrame" class="dataFrame">
				
				 
	 			<IFRAME src ="mmm_infoLandingPage.php" width="100%" height="700px" name="INFORMATION_IFRAME" id="INFORMATION_IFRAME"> </IFRAME>
 				
	 			</div>
					<!-- FOOTER -->
				<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=239302439426736&amp;xfbml=1"></script><fb:like href="www.mimavima.com" send="true" width="450" show_faces="false" font=""></fb:like>	
				<div id="footer" class="ui-corner-all">
					<ul id="navlist">
						<li><a href="mmm_infoLandingPage.php" target="INFORMATION_IFRAME">Home</a></li>
						<li><a href="mmm_about.php" target="INFORMATION_IFRAME">About</a></li>
						<li><a href="mmm_termsAndPrivacy.php" target="INFORMATION_IFRAME">Terms & privacy</a></li>
					
					</ul>
				Copyright 2011 <a href="mailto:support@mimavima.com">Amit Eitan</a> | All Rights Reserved <!-- - Developed using HTML5 & CSS3 --> 
				</div>
			
			</td>
			
		</tr>
		</tbody>

	
	</table>
	
		
	
<?php

?>
</body>
</html>