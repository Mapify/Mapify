// Define your locations: HTML content for the info window, latitude, longitude
var geoLocIndex = 0;
var locName = "";
var locName2 = "";

    
// Setup the different icons
var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';
    
var icons = [
	/*iconURLPrefix + 'red-dot.png',
    iconURLPrefix + 'orange-dot.png',
	iconURLPrefix + 'yellow-dot.png',
	iconURLPrefix + 'pink-dot.png',
	iconURLPrefix + 'purple-dot.png',
	iconURLPrefix + 'blue-dot.png',
	iconURLPrefix + 'green-dot.png'*/
	//heatmap icons
	'img/mapIcon1-1.png',
    'img/mapIcon1-2.png',
	'img/mapIcon1-3.png',
	'img/mapIcon1-4.png',
	'img/mapIcon1-5.png',
	'img/mapIcon1-6.png',
	'img/mapIcon1-7.png'
]

var icons_length = icons.length;

var map = new google.maps.Map(document.getElementById('map'), {
	zoom: 10,
    center: new google.maps.LatLng(-26.4425664,133.2813229),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      styles: customMapStyles,
      mapTypeControl: false,
      streetViewControl: false,
      panControl: false,
      zoomControlOptions: {
         position: google.maps.ControlPosition.LEFT_CENTER
      }
    });

var infowindow = new google.maps.InfoWindow({
	maxWidth: 400
});

var marker;
var markers = new Array();
    
var iconCounter = 0;
    
// Add the markers and infowindows to the map
for (var i = 0; i < locations.length; i++) {  
	if(locations[i][3] < 3) iconCounter = 0;
	else if (locations[i][3] <4) iconCounter = 1;
	else if (locations[i][3] <5) iconCounter = 2;
	else if (locations[i][3] <6) iconCounter = 3;
	else if (locations[i][3] <7) iconCounter = 4;
	else if (locations[i][3] <8) iconCounter = 5;
	else if (locations[i][3] >=8) iconCounter = 6;
	
	marker = new google.maps.Marker({
    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
    map: map,
    icon : icons[iconCounter],
});

markers.push(marker);

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][3].toFixed(2)+" "+locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }

AutoCenter();

function AutoCenter() {
 //  Create a new viewpoint bound
 var bounds = new google.maps.LatLngBounds();
 //  Go through each...
 $.each(markers, function (index, marker) {
 bounds.extend(marker.position);
  });
 //  Fit these bounds to the map
 map.fitBounds(bounds);
}   

function findLocation(){
	for(var i=0;i<locations.length;i++){
		//search array for mathing string + then get matching lat/long
		//var re = document.getElementById('searchbar').value;
		locName = document.getElementById('search').value;
		locName = locName.substring(0, locName.indexOf('(') - 1);
		if(locations[i][0].search(locName) != -1){
			geoLocIndex = i;
			//map.panTo(new GLatLng(geoLocLat,geoLocLong));
			var latLng = new google.maps.LatLng(locations[i][1], locations[i][2]); //Makes a latlng
      		map.panTo(latLng); //Make map global
      		map.setZoom(12); 
		}
	}
	outputSubHeader1.innerHTML = locName;
}

function setLocName2(){
		locName2 = document.getElementById('search2').value;
		locName2 = locName2.substring(0, locName2.indexOf('(') - 1);
		outputSubHeader2.innerHTML = locName2;
}
