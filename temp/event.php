<!DOCTYPE html>
<html lang="en" dir=<?php echo $documentDirection?>>
<head>
	 
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1255">
	 
	<title><?php echo $title?></title>
	<!-- JQUARY -->
	<?php //$httpString = "http://"?>
	<?php $httpString = ""?>
	<link type="text/css" href="<?php echo $httpString; echo base_url()?>css/le-frog/jquery-ui-1.8.17.custom.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo $httpString; echo base_url()?>css/missing_items/jquery-ui-1.8.20.custom.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo $httpString;  echo base_url()?>css/mimavima.css" rel="stylesheet" />	
	<script type="text/javascript" src="<?php  echo $httpString;  echo base_url()?>js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="<?php echo $httpString;  echo base_url()?>js/jquery-ui-1.8.17.custom.min.js"></script>
	<script type="text/javascript" src="<?php  echo $httpString; echo base_url()?>js/event.js"></script>

</head>
<body class="MAIN">
	<div id="container">
		<div id="container_eventDetailsAndLogo">
			<div id="container_eventlogo">
				<img src="<?php  echo $httpString; echo base_url()?>images/red_riding_event_logo.png">
			</div>
			<div id="container_eventDetail">
				<!-- Event name -->
				<div>
					<?php echo $eventNameLabel?>
					<span id="event_name"></span>
				</div>
				
				<!-- Event details -->
				<div>
					<?php echo $eventDescriptionLabel ?>
					<span id="event_description"></span>
				</div>
				<!-- Event Date -->
				<div>
					<?php echo $eventDateLabel ?>
					<span id="event_date"></span>
				</div>
			</div>
			<div id="container_eventAtendees">
				<select id="eventAttendeesList">
					<option value="NO_ONE"><?php echo $selectYourSelfFromComboBoxLabel ?></option>
				</select>
			</div>
		</div>
		
		<div id="container_body">
			<div id="item_list" >

			</div>
		
		</div>
		
		<script>

		
		
		function getAttendeesWhoBringItem(event){
			var iid = event.target.id.split('_')[1];
			$.getJSON('<?php echo $httpString; echo site_url("event/getAttendeesWhoBringItem"); echo "/"?>' + iid, function(data) {
				if (data['NO_USERS'] != "NO_USERS")
				{
				
				//Create table
				var userList = $('#itemDetails_'+iid).find('div').eq(1); //Create the table in the second div of the item
				userList.empty();
				userList.addClass('users-list');
				userList.append("<table id=table_"+iid+">");
				var usersTable =  $('#table_'+iid);
				usersTable.addClass('ui-widget ui-widget-content center');
				usersTable.append("<thead>").find('thead').append('<tr>').find('tr').addClass('ui-widget-header').append("<th>" + "NAME").append("<th>" + "details").append("<th>" + "quantety");

				
				 $.each(data, function(key, val) {				
					usersTable.append("<tr id=row_"+iid+"_"+ val['pid'] +">");
					 var userRow = $('#row_'+iid+"_"+val['pid']);
					 userRow.append("<td>"+val['name']+"</td>");
					 userRow.append("<td>"+val['details']+"</td>");
					 userRow.append("<td>"+val['qty']+"</td>");
					 //Update quanteties
					 $.getJSON('<?php echo $httpString; echo site_url("event/getItemQuantities"); echo "/"?>' + iid, function(data) {
						 var actualQtySpan = $('#itemHeader_'+iid).find('span').eq(1);
						 var qtySpan = $('#itemHeader_'+iid).find('span').eq(2);
						 qtySpan.empty();
						 qtySpan.append(data['qty']);
						 actualQtySpan.empty();
						
						 actualQtySpan.html(data['actualQty']);
						 if (data['qty'] > data['actualQty'])
						 {
							 $('#itemHeader_'+iid).css({"background":'none',"background-color":'red'});
						 }
						 
	

					 });
					 
				  });

					} //end of case when there are users
					else //No users - only update quanteties
					{
						 $.getJSON('<?php echo $httpString; echo site_url("event/getItemQuantities"); echo "/"?>' + iid, function(data) {
							 var actualQtySpan = $('#itemHeader_'+iid).find('span').eq(1);
							 var qtySpan = $('#itemHeader_'+iid).find('span').eq(2);
							 qtySpan.empty();
							 qtySpan.append(data['qty']);
							 actualQtySpan.empty();
							 actualQtySpan.html(data['actualQty']);
						 });
						
					}
				
				});
				
			} 
		

		//Load data using ajax after the rest of the page finished loading
			$(window).load(function(){	

					$.get('<?php echo $httpString; echo site_url("event/getEventDetails")?>',function(data) {
						var dataArray = decodeToArray(data);
						 jQuery.each(dataArray, function(key, value) {
							 $('#event_'+key).append(value);
							   
						 });
					});
				
					
					  //Load event itemns
					
							$.get('<?php echo $httpString; echo site_url("event/getEventItems")?>',function(data) {	
							data = decodeToArray(data);			  
						  $.each(data, function(key, val) {
							  $('#item_list').append('<h3 id=itemHeader_'+ val['iid']+'>'); //Generate header 
							  $('#itemHeader_'+ val['iid']).append(val['name'] + "  <span> 0</span>/<span>"+val['qty']+"</span>");	//Add data to header
							  $('#item_list').append('<div id=itemDetails_'+ val['iid']+'>');	//Generate body
							  //Add item detail div
							  $('#itemDetails_'+ val['iid']).append('<div class="item-description" id=itemDec_'+ val['iid']+'>'+"<span><?php echo $itemDetailsLabel ?> </span><span>" + val['details'] + "</span>"); 
							  //Attendees bringing item div
							  $('#itemDetails_'+ val['iid']).append('<div>');
								//Get this items qttys
								var iid = val['iid'];					
								 $.getJSON('<?php echo $httpString; echo site_url("event/getItemQuantities"); echo "/"?>' + iid, function(itemQty) {
									 var actualQtySpan = $('#itemHeader_'+iid).find('span').eq(1);
									 var qtySpan = $('#itemHeader_'+iid).find('span').eq(2);
									 qtySpan.empty();
									 qtySpan.append(itemQty['qty']);
									 actualQtySpan.empty();
									 actualQtySpan.html(itemQty['actualQty']);
									 if (itemQty['qty'] > itemQty['actualQty'])
									 {
										 $('#itemHeader_'+iid).css({"background":'none',"background-color":'red'});
									 }
									 
								 });	  
									//end of Get this items qttys
								 
							  //End of item
						  });
						  
						  $('#item_list').accordion({
								  collapsible: true,
								  autoHeight: false
						  }); //Make the list to an accordion
						  $('#item_list').find('h3').click();
						  $('.ui-accordion-header').click(getAttendeesWhoBringItem);
						  
						});
					//Load event attendees
					 $( "#eventAttendeesList" ).hide();
					 $('#eventAttendeesList').load('<?php echo $httpString; echo site_url("event/getEventAttendess")?>');
					 $( "#eventAttendeesList" ).combobox();
					  
						$( "#toggle" ).click(function() {
							$( "#eventAttendeesList" ).toggle();
						});
						
					 /*
					  $.getJSON('<?php //echo $httpString; echo site_url("event/getEventAttendess")?>', function(data) {
						  $('#eventAttendeesList').append(data);
						
						  $.each(data, function(key, val) {
							  $('#eventAttendeesList').append('<option  id=container_eventAtendeesList'+val['pid']+' value="'+val['pid']+'">' + val['fname'] + '</option>');
						  });
						  
						  $( "#eventAttendeesList" ).combobox();
						  
							$( "#toggle" ).click(function() {
								$( "#eventAttendeesList" ).toggle();
							});
						});
						*/
					

			});
		</script>
		<div id="container_footer">
			<p>האתר נמצא תמיד תחת פיתוח ונשמח לשמוע הצעות</p>
			<ul>
				<li>About us</li>
				<li>Privecy</li>
			</ul>
			<div id="container_copyright">
				Copyright 2010 - 2012 Amit Eitan | All Rights Reserved
			</div>
			<p class="footer" dir="ltr">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
		</div>
	</div>
</body>
</html>