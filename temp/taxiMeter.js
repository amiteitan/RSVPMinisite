function getFare(response,status)
{
	var steps = response.routes[0].legs[0].steps;
	var distanceVal = response.routes[0].legs[0].distance.value;
	var durationVal = response.routes[0].legs[0].duration.value;
	steps = 0;
	//var durationVal = $("#duration").val();
	//var distanceVal = $("#distance").val();
	var siteUrl = "http://www.mimavima.com/taxiMeter/index.php/welcome/calculateFare";
	//var siteUrl = "http://localhost/taxiMeter/index.php/welcome/calculateFare";
	$.post(siteUrl, { duration: durationVal, distance: distanceVal , legs: steps},
			   function(data) {
					var obj = jQuery.parseJSON( data );
					$("#calculatedPrice").html(obj.fare);
					//alert(obj.fare);
			     
			   });
}

$(document).ready(function() {

	/* Google maps*/
	

	
	/*Local initializations*/
	// disable ajax nav
	  $.mobile.ajaxLinksEnabled = false;
	  
	$("a").attr("data-role","button").click(getDirections);
	
	$('#resultsPage').live("pageshow", function() {
		initialize(); 
		getDirections();
	});
	
	
});

/*Google maps*/
var map;
var geocoder;
var bounds = new google.maps.LatLngBounds();
var markersArray = [];

var destinationIcon = "https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=D|FF0000|000000";
var originIcon = "https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000";

function initialize() {
	
	 var myOptions = {
	          zoom: 6,
	          mapTypeId: google.maps.MapTypeId.ROADMAP
	        };
	        map = new google.maps.Map(document.getElementById('map'),
	            myOptions);
	        
	// Try HTML5 geolocation
    if(navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = new google.maps.LatLng(position.coords.latitude,
                                         position.coords.longitude);

        var infowindow = new google.maps.InfoWindow({
          map: map,
          position: pos,
          content: 'אתה כאן'
        });

        map.setCenter(pos);
      }, function() {
        handleNoGeolocation(true);
      });
    } else {
      // Browser doesn't support Geolocation
      handleNoGeolocation(false);
    }
}

function handleNoGeolocation(errorFlag) {
    if (errorFlag) {
      var content = 'Error: The Geolocation service failed.';
    } else {
      var content = 'Error: Your browser doesn\'t support geolocation.';
    }

    var options = {
      map: map,
      position: new google.maps.LatLng(60, 105),
      content: content
    };

    var infowindow = new google.maps.InfoWindow(options);
    map.setCenter(options.position);
  }


function getDirections() {
	 var directionsService = new google.maps.DirectionsService();
     var directionsDisplay = new google.maps.DirectionsRenderer();

     var map = new google.maps.Map(document.getElementById('map'), {
       zoom:7,
       mapTypeId: google.maps.MapTypeId.ROADMAP
     });

     directionsDisplay.setMap(map);
     $("#panel").html("");
     directionsDisplay.setPanel(document.getElementById('panel'));
     
     var originAddress = $("#startAddress").val();
     var destinationsAddress = $("#destinationAddress").val();
  // Try HTML5 geolocation
     if(navigator.geolocation) {
       navigator.geolocation.getCurrentPosition(function(position) {
         pos = new google.maps.LatLng(position.coords.latitude,
                                          position.coords.longitude);

         var request = {
        	       origin: pos, 
        	       destination: destinationsAddress,
        	       travelMode: google.maps.DirectionsTravelMode.DRIVING
        	     };

        	     directionsService.route(request, function(response, status) {
        	    	 
        	       if (status == google.maps.DirectionsStatus.OK) {
        	    	 getFare(response, status)
        	         directionsDisplay.setDirections(response);
        	       }
        	     });
      });
     }
}



function callback(response, status) {

}


