function calcularRecorrido(){
	
	var rendererOptions = {
	draggable: true
	};
	var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);;
	var directionsService = new google.maps.DirectionsService();
	var map;
	 
	var puebla = new google.maps.LatLng(-34.921157, -57.954590);
	 
	function initialize() {
	 
		var mapOptions = {
		zoom: 7,
		center: puebla,
		panControl: false,
		zoomControl: false,
		scaleControl: false
		};
		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		directionsDisplay.setMap(map);
		 
	/*	google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
		computeTotalDistance(directionsDisplay.getDirections());
		});*/
		 
		calcRoute();
	}
 
	function calcRoute() {
 
		

		var origen = $('#latitud2').val(); origen+=', '; origen+= $('#longitud2').val();
		var destino = $('#latitud').val(); destino+=', '; destino+= $('#longitud').val();

		var request = {
		origin: origen,
		destination: destino,

		travelMode: google.maps.TravelMode.DRIVING
		};
		directionsService.route(request, function(response, status) {
		if (status == google.maps.DirectionsStatus.OK) {
		directionsDisplay.setDirections(response);
		}
		});
	}
 
	google.maps.event.addDomListener(window, 'load', initialize);
	
	
}
