<?php
include_once 'sqlFunctions.php';
/*******************************************************************************
*Name: parseNewEventAndAddToDB
*Discription: This method parses array of data about an Event an adds it to the database
*input: array of data about the EVENT
*output: event ID
* Author: Amit Eitan
* Date: 20/5/2010 22:19
********************************************************************************/
function parseNewEventAndAddToDB($_data)
	{		
		//EVENT NAME


		//GET THE NEW EVENT ID
		//$sql = "SELECT * FROM event WHERE name = '".$_data['event_name']."' ORDER BY eid DESC limit 0,1";
		//$result = executeQuary($sql);
		//$grab = mysql_fetch_assoc($result);
		//$eventID = $grab['eid'];
		
		do 
		{
		$eventID = rand(1231,41923);
		$sql = "SELECT * FROM event WHERE eid = ".$eventID;
		}
		while (mysql_num_rows(executeQuary($sql))!=0);
		
		$sql = "INSERT INTO event (eid,name, details)";
		$sql = $sql. "VALUES ('".$eventID."','" . $_data['event_name'] . "','".$_data['event_description'] ."')"; 
		
		executeQuary($sql);
			
		addNewPersonToEvent($eventID,$_data[event_manager]);
		
		//TODO add the edit all check box to database
		
		//UPDATE ITEM LIST
		$moreItems = 1;
		$itemNumber = 1;
		$dataElement = "";
		
		while ($moreItems)
		{
			$sql = "INSERT INTO items (eid,name, qty,details) VALUES ('".$eventID."'";
 			
			//ITEM
			$dataElement = "item_" . $itemNumber;

			$sqlValues = ",'".$_data[$dataElement]."'";
			
			//AMOUNT			

			$dataElement = "amount_" . $itemNumber;
			
			$sqlValues =$sqlValues. ",'".$_data[$dataElement]."'";
			
			//DETAILES

			$dataElement = "details_" . $itemNumber;

			$sqlValues =$sqlValues. ",'".$_data[$dataElement]."'";
			
			//Check if more Items Exsists
			$itemNumber++;
			$dataElement = "item_" . $itemNumber;
			if (!isset($_data[$dataElement]))
			{
				$moreItems = 0;	
			}
			$sql = $sql.$sqlValues.")";
			
			
			executeQuary($sql);
		}
		return $eventID;
	}
	
function addNewItemsToEvent($_NEW_ITEMS_ARRAY,$EID)
{
	// Fields per each item
	// item_# name
	// amount_# wanted amount default value is 1
	// details_# details
	
	//UPDATE ITEM LIST
		
		$ITEM_KEYS = array_keys($_NEW_ITEMS_ARRAY);
		$FIELDS_PER_ITEM = 3;
		/* CALCULATE NUMBER OF ITEMS TO PROCESS*/
		$ITEMS_TO_PROCESS = count($_NEW_ITEMS_ARRAY);
		$ITEMS_TO_PROCESS = $ITEMS_TO_PROCESS/$FIELDS_PER_ITEM;   //6 fields per item 
		
		for ($i = 0; $i<$ITEMS_TO_PROCESS; $i++)
		{
			$itemName		 		= $_NEW_ITEMS_ARRAY[$ITEM_KEYS[$i*$FIELDS_PER_ITEM + 0]];
			$itemNeededQuantety		= $_NEW_ITEMS_ARRAY[$ITEM_KEYS[$i*$FIELDS_PER_ITEM + 1]];
			$itemDetails        	= $_NEW_ITEMS_ARRAY[$ITEM_KEYS[$i*$FIELDS_PER_ITEM + 2]];
			$sql = "INSERT INTO items (eid,name, qty,details) VALUES ('".$EID."','".$itemName."','".$itemNeededQuantety."','".$itemDetails."')";
			executeQuary($sql);
		}
}
/********************************************************************************
*Name: updateEventDetails
*Discription: 
*input: 
*output: 
* Author: Amit Eitan
* Date: 23/5/2010 18:42
********************************************************************************/
function parseEventUpdate($_EVENT_UPDATE_ARRAY)
{
	$parseToArray = "NONE";
	
	foreach ($_EVENT_UPDATE_ARRAY as $key => $value) 
	{
		if ($key == "EID" )
    	{
    		$parseToArray = "EVENT_DETAILS";
    		$EID = $value;
    	}
    	
		if ($key == "EXISTING_ITEMS")
    	{
    		$parseToArray = "EXISTING_ITEMS";
    	}
		if ($key == "NEW_ITEMS")
    	{
    		$parseToArray = "NEW_ITEMS";
    	}
    	
		if ($key == "END_OF_ITEMS")
    	{
    		$parseToArray = "NONE";
    	}
    	    	
    	switch ($parseToArray)
    	{
    		case "EVENT_DETAILS":
    								$EXISTING_ITEMS[$key]= $value;
    								break;
    		case "EXISTING_ITEMS":						
    								$EXISTING_ITEMS[$key]= $value;
    								break;
    		case "NEW_ITEMS":
    								$NEW_ITEMS[$key]= $value;
    								break;
    		
    	}
	}
	//ADD NEW ITEMS IF EXISTS
	if (isset($NEW_ITEMS[NEW_ITEMS]))
	{
		unset($NEW_ITEMS['NEW_ITEMS']);//REMOVE GUIDE ARRAY KEYS AND VALUES
		addNewItemsToEvent($NEW_ITEMS,$EID);
	}
		
	//UPDATE event details and items
	if (isset($EXISTING_ITEMS[EXISTING_ITEMS]))
	{
		unset($EXISTING_ITEMS['EXISTING_ITEMS']);//REMOVE GUIDE ARRAY KEYS AND VALUES
		updateEventDetails($EXISTING_ITEMS);
	}
	

}
/********************************************************************************
*Name: updateEventDetails
*Discription: This function updates the event details and the details about items allready in the data base
*input: 
*output: 
* Author: Amit Eitan
* Date: 23/5/2010 18:42
********************************************************************************/
function updateEventDetails($_ITEMS)
{	
	
//DEBUG PRINT_R

	
	$eventName 			= $_ITEMS['EVENT_NAME'];
	$eventDescription 	= $_ITEMS['EVENT_DESCRIPTION'];
	$EID 				= $_ITEMS[EID];
	unset($_ITEMS['EVENT_NAME']);
	unset($_ITEMS['EVENT_DESCRIPTION']);
	unset($_ITEMS[EID]);
	
//	echo "<div dir='ltr'>";
//	echo "<BR>";
//	echo "_ITEMS<br>";
//	print_r($_ITEMS);
//	echo "</div>";
	
	
	
	
	
//	echo "<div dir='ltr'>";
//	echo "<BR>";
//	echo "ITEM_KEYS<br>";
////	
//	print_r($ITEM_KEYS);
//	echo "<hr>";
////	$pices = explode("_",$ITEM_KEYS[0]);
////	echo $pices[2];
//	echo "</div>";

	$ITEM_KEYS = array_keys($_ITEMS);
	$ITEMS_TO_PROCESS = count($ITEM_KEYS);
	$FIELDS_PER_ITEM = 4;
	/* FILEDS PER ITEM
	0 [ITEM_NAME_#]  	
	2 [NEEDED_QTY_#]
	1 [ACTUAL_QTY_#]   
	3 [ITEM_DETAILS_#]  
	*/
	$sql = "";
	for ($i = 0; $i<$ITEMS_TO_PROCESS; $i+=$FIELDS_PER_ITEM)
	{
	//0 [ITEM_NAME_#]
		$nameKey = explode("_",$ITEM_KEYS[$i]); //
		$itemID = $nameKey[2];	
		if (!isset($_ITEMS['DELETE_ITEM_'.$itemID]))
		{
			$FIELDS_PER_ITEM = 4;
			$itemName		 		= $_ITEMS['ITEM_NAME_'.$itemID];
			$itemNeededQuantety		= $_ITEMS['NEEDED_QTY_'.$itemID];
			$itemActualQuantety 	= $_ITEMS['ACTUAL_QTY_'.$itemID];
			$itemDetails			= $_ITEMS['ITEM_DETAILS_'.$itemID];
			$sql = "UPDATE items SET name='".$itemName."' , qty=".$itemNeededQuantety.", details = '".$itemDetails."' WHERE iid=".$itemID." and eid=".$EID.";";			
		}
		else
		{
			$FIELDS_PER_ITEM = 5;
			$sql = "DELETE FROM items WHERE iid=".$itemID." and eid=".$EID.";";			
			executeQuary($sql);
			$sql = "DELETE FROM peopleitems WHERE iid=".$itemID;
			executeQuary($sql);
		}
		executeQuary($sql);			
	}
	
		
    //UPDATE EVENT DETAILS
	//eid, name, details
	$sql = "UPDATE event SET name='".$eventName."', details='".$eventDescription."' WHERE eid=".$EID.";";
	executeQuary($sql);


}

/********************************************************************************
*Name: getPeopleBringingItem
*Discription: This method returns a list of people and items that also have the
*				same item as $IID like the person with the input $PID
*input: event id, person ID
*output: list of people pringing the item
* Author: Amit Eitan
* Date: 23/5/2010 18:42
********************************************************************************/
function getPeopleBringingItem($IID,$PID)
{
	$sql = "SELECT i.pid ,i.iid , p.fname ,i.qty ,i.details FROM peopleitems i, people p WHERE i.iid = ".$IID." and i.pid = p.pid";
	
	$peopleWithItemResultSet = executeQuary($sql);
	
	$peopleWithItem[0][name] =""; //details for the current user connected
	$peopleWithItem[0][qty] = 0;
	$peopleWithItem[0][details] = "";
	$personNumber = 1;
	$totalQty = 0;
	while ($currentPerson = mysql_fetch_array($peopleWithItemResultSet))
	{
		if ($currentPerson[pid] != $PID)
		{
		$peopleWithItem[$personNumber][name] = $currentPerson[fname];
		$peopleWithItem[$personNumber][qty] = $currentPerson[qty];
		$totalQty += $currentPerson[qty];
		$peopleWithItem[$personNumber][details] = $currentPerson[details];
		$personNumber++;	
		}
		else //The current user details is stored in the first place
		{
		$peopleWithItem[0][name] = $currentPerson[fname];
		$peopleWithItem[0][qty] = $currentPerson[qty];
		$totalQty += $currentPerson[qty];
		$peopleWithItem[0][details] = $currentPerson[details];	
		}
	}
	$peopleWithItem[totalQty] = $totalQty;
	return  $peopleWithItem;

}
/********************************************************************************
*Name: addMyItemsToDataBase
*Discription: This method updates items the user is takeing for a specific event at the database
*input: event id, first name, last name
*output: personID
* Author: Amit Eitan
* Date: 23/5/2010 18:42
********************************************************************************/
function addMyItemsToDataBase($_ITEMS)
{

	//print_r($_ITEMS);
	
	$EID = $_ITEMS[EID]; //Event ID
	$PID = $_ITEMS[PID];	//Person ID
	
	//Get rid of all the unneccery fields in the array
	unset($_ITEMS[EXISTING_ITEMS ]);
	unset($_ITEMS[EID]);
	unset($_ITEMS[PID]);
	unset($_ITEMS[NEW_ITEMS]);
	unset($_ITEMS[END_OF_ITEMS]);
	unset($_ITEMS[EDIT_EVENT]);
	unset($_ITEMS[UPDATE_BUTTON]);
	
	$FIELDS_PER_ITEM = 4;
	/* CALCULATE NUMBER OF ITEMS TO PROCESS*/
	$ITEM_KEYS = array_keys($_ITEMS);
	$ITEMS_TO_PROCESS = count($_ITEMS);
	$ITEMS_TO_PROCESS = $ITEMS_TO_PROCESS/$FIELDS_PER_ITEM;   //4 fields per item 
	/* 
	0 ACTUAL_QTY_#
	1 NEEDED_QTY_#
	2 MY_QTY_#
	3 DETAILES_#
	*/

	for ($i = 0; $i<$ITEMS_TO_PROCESS; $i++)
	{
		$itemActualQuantety 	= $_ITEMS[$ITEM_KEYS[$i*$FIELDS_PER_ITEM + 0]];
		$itemNeededQuantety 	= $_ITEMS[$ITEM_KEYS[$i*$FIELDS_PER_ITEM + 1]];
		$qtyItakeFromItem 		= $_ITEMS[$ITEM_KEYS[$i*$FIELDS_PER_ITEM + 2]];
		$myItemsDetails 		= $_ITEMS[$ITEM_KEYS[$i*$FIELDS_PER_ITEM + 3]];
		$IID =  substr($ITEM_KEYS[$i*$FIELDS_PER_ITEM],11,strlen($ITEM_KEYS[$i*$FIELDS_PER_ITEM]));
		if ($qtyItakeFromItem == 0)
		{
			$sql = "DELETE FROM peopleitems WHERE pid=".$PID." and iid='".$IID."'";
			executeQuary($sql);
		}
		else
		{
			$sql = "INSERT INTO peopleitems (pid,iid,qty,details) VALUES (".$PID.",".$IID.",".$qtyItakeFromItem.",'".$myItemsDetails."') ON DUPLICATE KEY UPDATE qty=".$qtyItakeFromItem." ,details='".$myItemsDetails."'";
			executeQuary($sql);
		}
	}
}
/*******************************************************************************
*Name: addNewPersonToEvent
*Discription: This method adds a new person to the database
*input: event id, first name, last name
*output: personID
* Author: Amit Eitan
* Date: 23/5/2010 18:42
********************************************************************************/
function addNewPersonToEvent($eid,$fname)
{
		if ($fname=="")
			return false;
		
		$sql = "SELECT * FROM people WHERE eid = ".$eid." and fname = '".$fname. "'";
		$personResoltSet = executeQuary($sql);
		$currentPerson = mysql_fetch_assoc($personResoltSet);
		
		if (mysql_num_rows($personResoltSet)== 0)
		{
			$sql = "INSERT INTO people (eid,fname,lname) VALUES ('".$eid."','".$fname."','".$lname."')";
		 	executeQuary($sql);
		 	return addNewPersonToEvent($eid,$fname);
		 	
		}
		else 
		{
			return $currentPerson[pid];
		}
		
}
function getPersonID($eid,$fname)
{
		if ($fname=="")
			return false;
		
		$sql = "SELECT * FROM people WHERE eid = ".$eid." and fname = '".$fname. "'";
		$personResoltSet = executeQuary($sql);
		
		if (mysql_num_rows($personResoltSet)== 0)
		{
		 	retrun -1;	
		}
		else 
		{
			$currentPerson = mysql_fetch_assoc($personResoltSet);
			return $currentPerson[pid];
		}	
}
/********************************************************************************
*Name: eventExists
*Discription: This method checks if an event is stored in the database
*input: event id
*output: true if event exsists in the database
* Author: Amit Eitan
* Date: 24/11/2010 22:46
********************************************************************************/
function eventExists($EID)
{
	$retValue = false;
	if ($EID !="")
	{
		$sql = "SELECT * FROM event WHERE eid =".$EID;
		$events = executeQuary($sql);
		if ($events!=false) //check if executeQuary was done succesfully
		{
			if (mysql_num_rows($events)>0) //if there are any rows (there allways should be only one) then the event exsists
			{	
				$retValue = true;
			}
		}
	}
	return $retValue;
}
