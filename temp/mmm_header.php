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
//		$location = "Location: http://www.mimavima.com/";
//		header( $location);
	}
	
session_start();
	if (isset($_POST[COMMAND]) && !(isset($_POST[CANCEL_BUTTON])))
	{
		switch ($_POST[COMMAND])
		{
			case "NEW_USER":			//Add new user to event
										$_SESSION[PID] = addNewPersonToEvent($_SESSION[EID],$_POST["fname"],$_POST["lname"]);
										$_SESSION[selectedName] = $_POST["fname"];
										$_POST[selectedName] = $_SESSION[selectedName];
										break;		
			case "UPDATE_PERSON_ITEMS": //Update selected person items
										unset($_POST[COMMAND]);
										addMyItemsToDataBase($_POST);
										$_SESSION[selectedName] = $noOneSelectedLabel;
										break;
			case "UPDATE_EVENT":		//Update event details
										unset($_POST[COMMAND]);
										parseEventUpdate($_POST);
										break;
		}
	}
?>


	<!-- LOGO -->
	<div class="LOGO"> 
 
	<a href="http://www.mimavima.com">

	<img class="LOGO" src="img/logo.png" alt="Mi Mavi Ma Logo"/>
	<br>
 
	</a>

		
	</div>
	
			<TABLE>
				<!--  EXSISTING USER FROM LIST -->
				<?php 
					$sql = "SELECT * FROM people WHERE eid = ".$_SESSION['EID'];
					//$sql = " ORDER BY fname ASC";
					$peopleInEvenResultSet = executeQuary($sql);
				?>
				<TR>
					<TD>בחר את עצמך מהרשימה</TD>
					<TD>
						<FORM method=post action="mmm_displayInformation.php" target="INFORMATION_IFRAME" name="USER_SELECTION" id="USER_SELECTION">
						<input type="hidden" name="COMMAND" id="COMMAND" value="SELECT_USER">
						<SELECT name="selectedName" id="selectedName" onchange="USER_SELECTION.submit()">
							  <option value="<?php echo $noOneSelectedLabel ?>"><?php echo $noOneSelectedLabel ?></option>
							  <?php 
							  while ($currentPerson = mysql_fetch_array($peopleInEvenResultSet))
							  {
							  	$optionString = $currentPerson[fname];
							  	if (isset($_SESSION[selectedName]))
							  	{
							  		if ($_SESSION[selectedName] == $optionString)
							  		{
							  			$selectedOption = "SELECTED";
							  		}
							  		else
							  		{
							  			$selectedOption = "";
							  		}
							  	}
							  ?>							
							  <option <?php echo $selectedOption?> value="<?php echo $optionString?>"><?php echo $optionString?></option>
							  <?php 
							  }
							  ?>
						</SELECT>
						</FORM>
					</TD>
					
				</TR>
				<!--  ADD NEW USER -->
				
				
				<TR>
					<TD>אם אתה לא מופיע הרשם כעת</TD>
					<TD>
						<FORM  method="post" action="main.php?EID=<?echo $_SESSION[EID]?>"  name="NEW_USER" id="NEW_USER">
							<input type="hidden" name="COMMAND" id="COMMAND" value="NEW_USER">
							<INPUT type="text" name="fname" id="fname">
							<button type="submit" name="nameFields" id="nameFields" value=""><?php echo $userSelectOrSubmitButton?></button>
						</FORM>
					</TD>
				</TR>
				
		</TABLE>