$(document).ready(function() {
	
	//UI 
	$('img').addClass('center_img');
	$('#container_buttons').addClass('center');
	$('#container_copyright').addClass('center');
	
	$('#dialog-form-createNewEvent>form').addClass('ui-dialog');
	$('#dialog-form-enterEventNumber').addClass('ui-dialog');
	
	//Helper functions
	var eventNumber = $( "#eventNumber" ),
	eventName = $( "#eventName" ),
	email = $('#email'),
	eventCreator = $('#eventCreator'),
	eventDate 	= $('#eventDate'),
	allFields = $( [] ).add( eventNumber ).add( eventName ).add( email ).add( eventCreator ),
	tips = $( ".validateTips" );

	function updateTips( t ) {
		tips
			.text( t )
			.addClass( "ui-state-highlight" );
		setTimeout(function() {
			tips.removeClass( "ui-state-highlight", 1500 );
		}, 500 );
	}
	
	function checkLength( o, n, min, max ) {
		if ( o.val().length > max || o.val().length < min ) {
			o.addClass( "ui-state-error" );
			updateTips( "Length of " + n + " must be between " +
				min + " and " + max + "." );
			return false;
		} else {
			return true;
		}
	}
	
	function checkRegexp( o, regexp, n ) {
		if ( !( regexp.test( o.val() ) ) ) {
			o.addClass( "ui-state-error" );
			updateTips( n );
			return false;
		} else {
			return true;
		}
	}
	//JquaryUI
	$('#container').addClass('ui-widget-content ui-corner-all');
	$('button').button();
	$( "#eventDate" ).datepicker();
	
//Existing event dialog
	$( "#dialog-form-enterEventNumber" ).dialog({
		autoOpen: false,
		height: 250,
		width: 400,
		modal: true,
		buttons: {
			"Go": function() {
				var bValid = true;
				allFields.removeClass( "ui-state-error" );
				bValid = bValid && checkLength( eventNumber, "eventNumber", 1, 16 );
				bValid = bValid && checkRegexp( eventNumber, /^([0-9])+$/, "Event number must be a number!" );

				if ( bValid ) {
					//If success
					$(this).find('form').submit();
				}
			},
			Cancel: function() {
				updateTips("");
				$( this ).dialog( "close" );
				
			}
		},
		close: function() {
			updateTips("");
			allFields.val("").removeClass( "ui-state-error" );
		}
	}); //end of dialog
//New event dialog
	var regExpNumberCharacters = /^(([0-9a-zA-Z ])|([\u05D0-\u05FF]))+$/; //characters and letters (hebrew and english)
	var regExpNumberCharactersSpaces = /^(([0-9a-zA-Z ])|([\u05D0-\u05FF]))+$/; //characters and letters (hebrew and english)
	// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
	var regExpEmail = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
	
	
	
	$( "#dialog-form-createNewEvent" ).dialog({
		autoOpen: false,
		height: 550,
		width: 400,
		modal: true,
		buttons: {
			"Create": function() {
				var bValid = true;
				allFields.removeClass( "ui-state-error" );
				//Event name [A-Za-z\u05D0-\u05FF][A-Za-z\u05D0-\u05FF0-9]*
				bValid = bValid && checkLength( eventName, "eventName", 1, 16 );
				bValid = bValid && checkRegexp( eventName, regExpNumberCharactersSpaces, "Event name must be a characters or numbers!" );
				bValid = bValid && checkLength( eventCreator, "eventCreator", 1, 16 );
				bValid = bValid && checkRegexp( eventCreator, regExpNumberCharactersSpaces, "Event creator must be a characters or numbers!" );
				
				
				if ( eventDate.val().length > 0)
				{
					bValid = bValid && true
				}
				else
				{
					bValid = false;
					updateTips("a date must be choosen");
				}
				
				
				if ( email.val().length > 0)
				{
					bValid = bValid && checkRegexp( email,regExpEmail , "eg. me@mimavima.com" );	
				}
				
					
				if ( bValid ) {
					//If success
					$( this ).dialog( "close" );
				}
			},
			Cancel: function() {
				updateTips("");
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			updateTips("");
			allFields.val( "" ).removeClass( "ui-state-error" );
		}
	}); //end of dialog
	
	
	//Events handlers
	//Buttons
	//Existing event
	$('#button_existingEvent').click(function(event) {
			$("#dialog-form-enterEventNumber").dialog( "open" );
	});
	//New event
	$('#button_newEvent').click(function(event) {
			$("#dialog-form-createNewEvent").dialog( "open" );
	});
});
