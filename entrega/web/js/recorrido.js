function calcularRecorrido(){
/*
 *	MIT License
 *
 *	Copyright (c) 2014-2016 Cristian O. Giambruni, Ezequiel F. Gómez
 *
 *	Permission is hereby granted, free of charge, to any person obtaining a copy
 *	of this software and associated documentation files (the "Software"), to deal
 *	in the Software without restriction, including without limitation the rights
 *	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *	copies of the Software, and to permit persons to whom the Software is
 *	furnished to do so, subject to the following conditions:
 *
 *	The above copyright notice and this permission notice shall be included in all
 *	copies or substantial portions of the Software.
 *
 *	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 *	SOFTWARE.
 */	
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
