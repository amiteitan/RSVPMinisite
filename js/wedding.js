
$(document).bind('pageinit')
$(document).ready(function() {

	/* Google maps*/
	/*Local initializations*/
	// disable ajax nav
	
	var positionSeriveAvailable = true;

	    initialize(); 
		getDirections();
	  $('#mapPage').live("pageshow", function() {
		  $.mobile.ajaxLinksEnabled = false;
		  initialize(); 
		getDirections();
		$('#mapPage').trigger( 'updatelayout' );
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
          position: pos
          //content: 'אתה כאן'
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
    
    /*
    kmlAddress = "http://www.mimavima.com/wedding/images/wedding.kml";
    var ctaLayer = new google.maps.KmlLayer(kmlAddress);
    ctaLayer.setMap(map);
    */
    
    var myLatlng = new google.maps.LatLng(32.82092,34.973268);
    
    var options = {
      zoom: 12,
      map: map,
      position: myLatlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('map'),
    		options);
    var infowindow = new google.maps.InfoWindow(options);
    map.setCenter(options.position);
    var image3 = new google.maps.MarkerImage("http://www.mimavima.com/wedding/images/turtle-2.png", null, null, null, new google.maps.Size(32, 32));
    var image2 = new google.maps.MarkerImage("http://www.mimavima.com/wedding/images/cow-export.png", null, null, null, new google.maps.Size(32, 32));
    var image = new google.maps.MarkerImage("http://maps.google.com/mapfiles/kml/pushpin/pink-pushpin.png", null, null, null, new google.maps.Size(32, 32));
    var marker = new google.maps.Marker({
    	position: myLatlng,
        map: map,
        title:"נחל חוורים",
        icon :image,
    });
    /*
    var marker = new google.maps.Marker({
    	position: new google.maps.LatLng(32.448507,34.890862),
        map: map,
        title:"פרה",
        icon :image2,
    });
    
    var marker = new google.maps.Marker({
    	position: new google.maps.LatLng(32.454446,34.895496),
        map: map,
        title:"צב",
        icon :image3,
    });
    */
   
    
   
    
    
    
  }


function getDirections() {
	 var directionsService = new google.maps.DirectionsService();
     var directionsDisplay = new google.maps.DirectionsRenderer();

     var map = new google.maps.Map(document.getElementById('map'), {
       zoom:7,
       mapTypeId: google.maps.MapTypeId.ROADMAP
     });

     directionsDisplay.setMap(map);
     
     //$("#panel").html("");
     //directionsDisplay.setPanel(document.getElementById('panel'));
     
     

	  // Try HTML5 geolocation
	     if(navigator.geolocation) {
	       navigator.geolocation.getCurrentPosition(function(position) {
	         pos = new google.maps.LatLng(position.coords.latitude,
	                                          position.coords.longitude);
	         pos2 = new google.maps.LatLng(32.82092,34.973268);
	
	         var request = {
	        	       origin: pos, 
	        	       destination: pos2,
	        	       travelMode: google.maps.DirectionsTravelMode.DRIVING
	        	     };
	
	        	     directionsService.route(request, function(response, status) {
	        	    	 
	        	       if (status == google.maps.DirectionsStatus.OK) {
	        	    	 
	        	         directionsDisplay.setDirections(response);
	        	       }
	        	     });
	      });
	     }
	     else
	    	 {
	    	 	handleNoGeolocation(false);
	    	 }
     
}
/////One empty line under this comment
