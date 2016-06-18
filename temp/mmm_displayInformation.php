<?php 
	
	$correctAccess = false;
	if (isset($_SERVER['HTTP_REFERER']))
	{
		if ($_SERVER['HTTP_REFERER'] == "http://www.mimavima.com/main.php")
		{
			$correctAccess = true;
		}
		if (isset($_GET['EID']))
		{
			if ($_SERVER['HTTP_REFERER'] == ("http://www.mimavima.com/main.php?EID=".$_GET[EID]))
			{
				$correctAccess = true;
			
			}
		}
	}
	if (!$correctAccess)
	{
		$location = "Location: http://www.mimavima.com/";
		//header( $location);
	}
session_start();

include_once 'strings.php';
include_once 'phpFunctions//miMaviMaFunctions.php';


	if (isset($_SESSION["EID"]))
	{
	if (eventExists($_SESSION[EID]) == false)//NO SUCH EVENT GO BACK TO INDEX
		{
			$location = "Location: http://www.mimavima.com/index.php?ERR=".$_GET[EID];
			header( $location);
			echo "<HR> THIS EVENT DOES NOT EXSIST<HR>";
		}
	    
	//echo "<HR> I AM HERE 1<HR>";
	//$_SESSION[PID] = -1;
	//$_SESSION[selectedName] = $noOneSelectedLabel; 
	}
	else //if no event id in session
	{
			$location = "Location: http://www.mimavima.com/mmm_error.php?ERR=XXX";
			header( $location);
			echo "<HR> NO EVENT IN SESSION <HR>";
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
</head>
<body>

	<?php
//DEBUG PRINT_R
//	echo "<div dir='ltr'>";
//	echo "<BR>";
//	echo "POST<br>";
//	
//	print_r($_POST);
//	echo "</div>";
		
//	echo "<hR>";
//	echo "GET<br>";
//	print_r($_GET);
//	echo "<hR>";
//	echo "SESSION id= ". session_id()."<br>";
//	print_r($_SESSION);
//	echo "<hR>";

	
	//The event id should be set in the $_SESSION[EID] by the main window	
	if (isset($_POST[COMMAND]) && !(isset($_POST[CANCEL_BUTTON])))
	{
		switch ($_POST[COMMAND])
		{
			case "UPDATE_PERSON_ITEMS": //Update selected person items
										unset($_POST[COMMAND]);
										addMyItemsToDataBase($_POST);
										//$_SESSION[selectedName] = $noOneSelectedLabel;
										break;
			case "UPDATE_EVENT":		//Update event details
										unset($_POST[COMMAND]);
										parseEventUpdate($_POST);
										break;
			case "OPEN_EVENT_FOR_EDITING": //Open the event in editable mode
										$_SESSION[PID] = -1;
										$_SESSION[selectedName] = $noOneSelectedLabel;
										$_POST[selectedName] = $noOneSelectedLabel;
										$editEvent = true;
										break;
			case "NEW_USER":			//Add new user to event
										$_SESSION[PID] = addNewPersonToEvent($_SESSION[EID],$_POST["fname"],$_POST["lname"]);
										$_SESSION[selectedName] = $_POST["fname"];
										$_POST[selectedName] = $_SESSION[selectedName];
										break;
			case "SELECT_USER":			//Load selected user
										if ($_POST[selectedName] == $noOneSelectedLabel)//If this is a general view
										{
											$_SESSION[PID] = -1;
											$_SESSION[selectedName] = $noOneSelectedLabel;
										}
										else	//Load the current viewr prespective
										{
											$_SESSION[PID] = getPersonID($_SESSION[EID],$_POST[selectedName]);
											$_SESSION[selectedName] = $_POST[selectedName];
										}
										break;
		};
	}


	?>	
	<!--  USER SELECT  was moved to the header -->
	<!--  EDIT EVENT   was  moved to the menu -->

	<!--  Items Display -->   
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     
	<?php 
	
	$sql = "SELECT * FROM event WHERE eid=".$_SESSION[EID];
	$eventRecord = executeQuary($sql);
	$eventDetails = mysql_fetch_assoc($eventRecord);
		
	?>
	<FORM action="main.php?EID=<?echo $_SESSION[EID]?>" target="_top" method="post">
	<?php 
	if ($editEvent == true)
		{ 
		?>
		<input type="hidden" name="COMMAND" id="COMMAND" value="UPDATE_EVENT">
		<?php
		}
	else
		{
		?>
		<input type="hidden" name="COMMAND" id="COMMAND" value="UPDATE_PERSON_ITEMS">
		<?php 
		} 
	?>
	
	<INPUT type="hidden" name="PID" value="<?php echo $_SESSION[PID]?>"> <?php // SELECTED PERSON ID?>
	<INPUT type="hidden" name="EID" value="<?php echo $_SESSION[EID]?>"> <?php // EVENT ID?>
	<div class="BASIC_INSTRUCTIONS">
	בחרו עצמכם מהרשימה למעלה כדי להתחיל ולהביא פריטים לאירוע - שימו לב שאם הרשימה ארוכה צריך לגלול למטה
	</div>
	<TABLE>
		<TR>
			<TD><h3><?php echo $eventNameLable?>:</h3></TD>
			<TD>
				<?php 
				if ($editEvent == true)
				{
				?>
				<INPUT type = "text" id='EVENT_NAME' name = 'EVENT_NAME' value ="<?php echo $eventDetails[name]?>">
				<?php  
				}
				else
				{
					?>
					<h3>
					<?php 
					echo $eventDetails[name];	
					?>
					</h3>
					<?php 					
				}
				?>
			</TD>
		</TR>
		<TR>
			<TD><h3><?php echo $eventDescriptionLable?>:</h3></TD>
			<TD>
			<?php 
			if ($editEvent == true)
				{
				?>
				<textarea id='EVENT_DESCRIPTION' name = 'EVENT_DESCRIPTION'><?php echo $eventDetails[details]?></textarea>
				<?php  
				}
				else
				{
					?>
					<h3>
					<?php 
					echo $eventDetails[details];
					?>
					</h3>
					<?php 				
				}
				?>
			 
			</TD>
		</TR>
	</TABLE>
	<!-- ITEMS TO BRING -->
	<!-- TITLE -->
	<?php echo $whatItemsToBringLabel?><BR>
	<!-- THE ITEM LIST -->
	<?php 
 	$sql = "SELECT i.iid, i.eid ,i.name,i.details,i.qty FROM items i ,event e WHERE i.eid = ".$_SESSION[EID]." and i.eid = e.eid";
	$itemsInEvenResultSet = executeQuary($sql);
	?>
	
	<DIV class="ITEM_DISPLAY">
	<TABLE class="ITEM_DISPLAY" name="EVENT_ITEM_AND_USERS_TABLE" id="EVENT_ITEM_AND_USERS_TABLE">
	<TR class="ITEM_LIST_TITLE">
			<TH class="ITEM_DETAILS" colspan="3">
				פריט
			</TH>
			<TH class="ITEM_DETAILS">
				כמות מבוקשת
			</TH>
			<TH class="ITEM_DETAILS">
				כמות קיימת
			</TH>
			<TH class="ITEM_DETAILS">
				תאור
			</TH>
			<?php 
			if ($editEvent == true)
			{
				?>
				<TH class="ITEM_DETAILS">
				מחק
				</TH>
				<?php  
			}
			?>
		</TR>
	<!-- USED TO HELP SEPERATE EXSISTING ITEMS FROM EVENT DETAILS-->
	<INPUT type="hidden" name="EXISTING_ITEMS" value="EXISTING_ITEMS">
	<?php 
	//Do for all items in the event
	while ($currentItem = mysql_fetch_array($itemsInEvenResultSet))
    {
    	$peopleWithItem = getPeopleBringingItem($currentItem[iid],$_SESSION[PID]);
    	$missingQty =  $currentItem[qty] - $peopleWithItem[totalQty];
    	if ($missingQty > 0)
    	{
    		$className = "ITEM_DETAILS_MISSING";
    	}
    	else
    	{
    		$className = "ITEM_DETAILS";
    	}
    	
    	?>
		<!-- General Row -->
		
		<TR CLASS="<?php echo $className?>" id="ROW_<?php echo $currentItem[iid]?>">
			<!-- ITEM NAME -->
			
			<TD  CLASS="ITEM_DETAILS" colspan="3"> 
			<?php
			if ($editEvent == true)
			{
				?>
				<INPUT type = "text" id='ITEM_NAME_<?php echo $currentItem[iid]?>' name = 'ITEM_NAME_<?php echo $currentItem[iid]?>' value ="<?php echo $currentItem[name]?>">
				<?php  
			}
			else
			{
				echo $currentItem[name];
			}
			?>
	    	
			</TD>
			
			<!-- Missing -->
				<?php 
				if ($missingQty<0)
				{
					$missingQty = 0;
				}
				?>			
			<!-- Needed Quantety  -->
			<TD  CLASS="ITEM_DETAILS">
				<!--  EDITABLE -->
				<?php 
				if ($editEvent == true)
				{
				?>
				<TABLE>
					<TR>
						<TD><A href="javascript:updateNeededQty('<?php echo $currentItem[iid]?>','+1')"><IMG src="img/Button+.gif"></A></TD>
						<TD>
							<DIV id="NEEDED_QTY_LABEL_<?php echo $currentItem[iid]?>"><?php echo $currentItem[qty]?></DIV>
							<INPUT type="hidden" id="NEEDED_QTY_<?php echo $currentItem[iid]?>" name = "NEEDED_QTY_<?php echo $currentItem[iid]?>" value=<?php echo $currentItem[qty]?>>
						</TD>
						<TD><A href="javascript:updateNeededQty('<?php echo $currentItem[iid]?>','-1')"><IMG src="img/Button-.gif"></A></TD>
					</TR>
				</TABLE>
				<!--  /EDITABLE -->
				<?php 
				}
				else
				{
				?>
				<DIV id="NEEDED_QTY_LABEL_<?php echo $currentItem[iid]?>"><?php echo $currentItem[qty]?></DIV>
				<INPUT type="hidden" id="NEEDED_QTY_<?php echo $currentItem[iid]?>" name = "NEEDED_QTY_<?php echo $currentItem[iid]?>" value=0>
				<?php 
				}
				?>
			</TD>
			<!-- Actual Quantety -->
			<TD  CLASS="ITEM_DETAILS">
				<DIV id="ACTUAL_QTY_LABEL_<?php echo $currentItem[iid]?>"><?php echo $peopleWithItem[totalQty]?></DIV>
				<INPUT type="hidden" id="ACTUAL_QTY_<?php echo $currentItem[iid]?>" name = "ACTUAL_QTY_<?php echo $currentItem[iid]?>" value=0>
			</TD>
			<!-- Description -->
			<TD  CLASS="ITEM_DETAILS">
			
			<?php
			if ($editEvent == true)
			{
				?>
				<INPUT type = "text" id='ITEM_DETAILS_<?php echo $currentItem[iid]?>' name = 'ITEM_DETAILS_<?php echo $currentItem[iid]?>' value ="<?php echo $currentItem[details]?>">
				<?php  
			}
			else
			{
				echo $currentItem[details];
			}
			?>
			</TD>
			<?php 
			if ($editEvent == true)
			{
				?>
				<TD class="ITEM_DETAILS">
					<input type = checkbox value="delete" name="DELETE_ITEM_<?php echo $currentItem['iid']?>" id="DELETE_ITEM_<?php echo $currentItem['iid']?>"></input>
				</TD>
				<?php  
			}
			?>
			
		</TR>
		<!-- End of General Row -->
		
		<!--  CURRENT SELECTED USER ROW -->
		<?php
		if ($_SESSION[selectedName]!=$noOneSelectedLabel) 
		{?>
		<TR CLASS="USER_ITEM">
					<TD></TD>	
			<TD colspan="3" CLASS="USER_ITEM">
				<?php echo $_SESSION[selectedName]." ".$bringsLabel?>
			</TD>
			<TD CLASS="USER_ITEM">
				<TABLE>
					<TR>
						<TD><A href="javascript:updateItem('<?php echo $currentItem[iid]?>','+1')"><IMG src="img/Button+.gif"></A></TD>
						<TD>
							<DIV id="MY_QTY_LABEL_<?php echo $currentItem[iid]?>"><?php echo $peopleWithItem[0][qty]?></DIV>
							<INPUT type="hidden" id="MY_QTY_<?php echo $currentItem[iid]?>" name = "MY_QTY_<?php echo $currentItem[iid]?>" value=<?php echo $peopleWithItem[0][qty]?>>
						</TD>
						<TD><A href="javascript:updateItem('<?php echo $currentItem[iid]?>','-1')"><IMG src="img/Button-.gif"></A></TD>
					</TR>
				</TABLE>
			</TD>
			<TD CLASS="USER_ITEM"> 
				<INPUT type="text" id="DETAILES_<?php echo $currentItem[iid]?>" name="DETAILES_<?php echo $currentItem[iid]?>" value="<?php echo $peopleWithItem[0][details]?>">
			</TD>
			<?php 
			if ($editEvent == true)
			{
				?>
				<TD class="USER_ITEM">
				</TD>
				<?php  
			}
			?>
		</TR>
		<?php }?>
		<!-- END OF CURRENT SELECTED USER ROW -->
		
		<!-- Other People-->
		<?php 
		$iterations = count ($peopleWithItem) - 1;
		
		for ($i = 1; $i<$iterations; $i++)
		{
		?>
		<TR>
			<TD colspan="2"></TD>
			<TD colspan="2">
				<?php echo $peopleWithItem[$i][name]?>
			</TD>
			<TD>
				<?php echo $peopleWithItem[$i][qty]?>
			</TD>
			<TD> 
				<?php echo $peopleWithItem[$i][details]?>
			</TD>
			<?php 
			if ($editEvent == true)
			{
				?>
				<TD>
				</TD>
				<?php  
			}
			?>			
		</TR>
		
		<!-- End of other people -->
		<?php
		}
    }//END OF WHILE
    
	?>
	<!-- USED TO HELP SEPERATE NEW ITEMS FROM EXSISTING ITEMS -->
	<tr>
	<td colspan="6" class="USER_ITEM">
	<INPUT type="hidden" id="" name="NEW_ITEMS" value="NEW_ITEMS">
	</td>
	</tr>
	</TABLE>
	

	
	</DIV> <!-- ITEM DISPLAY -->
	<INPUT type="hidden" name="END_OF_ITEMS" value="END_OF_ITEMS">
	<INPUT type="hidden" name="EDIT_EVENT" value="<?php echo $editEvent?>">
	<?php //ADDING ITEMS WHILE IN EDIT EVENT MODE 
	if ($editEvent == true)
		{ 
		?>
		<INPUT type="button" value="<?php echo $addItemButtonLabel?>" onclick="addRowToItemAndUsersTable('EVENT_ITEM_AND_USERS_TABLE')"><BR>
		<?php
		}
	?>
	<?php 
	if ($_SESSION[selectedName]!=$noOneSelectedLabel || $editEvent==1) 
		{?>
	<input type="submit" id="updateButton" name="UPDATE_BUTTON" value="<?php echo $updateEventOK?>">
	<input type="submit" id="updateButton" name="CANCEL_BUTTON" value="<?php echo $updateEventCANCEL?>">
	
	<?php }?>
	</FORM>
	<BR>
	לינק ישיר לאירוע לשיתוף עם חברים:<br>
	<a href="main.php?EID=<?php echo $_SESSION[EID]?>" target="_PARENT">http:\\www.mimavima.com\main.php?EID=<?php echo $_SESSION[EID]?> </a>

</body>
</html>
