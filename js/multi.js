// Define your locations: HTML content for the info window, latitude, longitude
var geoLocIndex = 0;

var searchResults = new Array(); 
var currentResult = -1;
var cRArrayPos = 0;

var currentResNo = document.getElementById("currentResNo");
var totalResNo = document.getElementById("totalResNo");

var infoName = document.getElementById("infoName");
var infoProduce = document.getElementById("infoProduce");
var infoAddress = document.getElementById("infoAddress");
var infoPhone = document.getElementById("infoPhone");
var infoImg =document.getElementById("infoImg");

var width = (window.innerWidth > 0) ? window.innerWidth : screen.width;

//LOCATIONS ON MAP ["NAME",LONG,LAT,INDEX]
/*KEY:
[0] = Event name
[1] = Latitude
[2] = Longitude
[3] = Subcategory of Event
[4] = Address IRL
[5] = Web address
[6] = Contact Detail #1
[7] = Image reference
[8] = Postcode*/

var locations = [
["Miami Beach",-28.0688388,153.4359327,15,0,"Dairy","Address1","5555 5551","img1.jpg","3218"],
["Burleigh Beach",-28.1004271,153.4315744,1,"Eggs/Poultry","Address2","5555 5552","img2.jpg","3200"],
["Robina Town Centre",-28.073426,153.378338,2,"Fish","Address3","5555 5553","img3.jpg","3201"],
["Varsity Lakes",-28.0878976,153.4094645,3,"Root Vegetables","Address4","5555 5554","img4.png","3202"],
["Bond University",-28.073093,153.416638,4,"Green Vegetables","Address5","5555 5555","img5.jpg","3203"],
["Surfers Paradise",-27.999746,153.4224425,5,"Grains/Bread","Address6","5555 5556","img1.jpg","3204"],
["Mermaid Beach",-28.048262,153.4369071,6,"Fruit","Address7","5555 5557","img2.jpg","3205"]
];
    
// Setup the different icons
var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';


//MAP STYLE
var customMapStyles = [
    {
        "featureType": "administrative",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "water",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "transit",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "landscape",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road.local",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "stylers": [
            {
                "color": "#5f94ff"
            },
            {
                "lightness": 26
            },
            {
                "gamma": 5.86
            }
        ]
    },
    {},
    {
        "featureType": "road.highway",
        "stylers": [
            {
                "weight": 0.6
            },
            {
                "saturation": -85
            },
            {
                "lightness": 61
            }
        ]
    },
    {
        "featureType": "road"
    },
    {},
    {
        "featureType": "landscape",
        "stylers": [
            {
                "hue": "#0066ff"
            },
            {
                "saturation": 74
            },
            {
                "lightness": 100
            }
        ]
    }
];

//LOCATION MAP ICONS
/*var icons = [
	iconURLPrefix + 'red-dot.png',
    iconURLPrefix + 'orange-dot.png',
	iconURLPrefix + 'yellow-dot.png',
	iconURLPrefix + 'pink-dot.png',
	iconURLPrefix + 'purple-dot.png',
	iconURLPrefix + 'blue-dot.png',
	iconURLPrefix + 'green-dot.png'
]*/

var icons = [
    'icons/icon1.png',
    'icons/icon2.png',
    'icons/icon3.png',
    'icons/icon4.png',
    'icons/icon5.png',
    'icons/icon1.png',
    'icons/icon2.png',
    'icons/icon3.png',
    'icons/icon4.png',
]

var icons_length = icons.length;
    
var map = new google.maps.Map(document.getElementById('map'), {
	zoom: 10,
    center: new google.maps.LatLng(-27.9869398,153.3237028),
      mapTypeId: google.maps.MapTypeId.ROADMAP,
      styles: customMapStyles,
      mapTypeControl: false,
      streetViewControl: false,
      panControl: false,
      disableDefaultUI: true,
      zoomControlOptions: {
         position: google.maps.ControlPosition.LEFT_BOTTOM
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
	if(locations[i][3] == 0) iconCounter = 0;
	else if (locations[i][3] == 1) iconCounter = 1;
	else if (locations[i][3] == 2) iconCounter = 2;
	else if (locations[i][3] == 3) iconCounter = 3;
	else if (locations[i][3] == 4) iconCounter = 4;
	else if (locations[i][3] == 5) iconCounter = 5;
	else if (locations[i][3] == 6) iconCounter = 6;
	else if (locations[i][3] == 7) iconCounter = 7;
	
	marker = new google.maps.Marker({
    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
    map: map,
    icon : icons[iconCounter],
});

markers.push(marker);
	//SET INFO SHOWN WHEN ICON IS CLICKED
      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]+" - "+locations[i][4]);
          infowindow.open(map, marker);
        }
      })(marker, i));
      google.maps.event.addListener(marker, "click", function (event) {
            var latitude = parseFloat(this.position.lat().toFixed(2));
            var longitude = parseFloat(this.position.lng().toFixed(2));
            //alert(latitude + typeof(latitude) + ", " + longitude + typeof(longitude));
            document.getElementById('infoPanel').style.display = "block";
            //CURRENTLY NOT WORKING
            for(var n=0;n<locations.length;n++){
                //if(latitude == locations[n][2].toFixed(2)){ //THIS IS THE LINE WITH THE PROBLEM, CAN'T SATISFY CONDITION
                    //CLEAR INFO PANEL
                    infoName.innerHTML = "";
                    infoProduce.innerHTML = "Produce: ";
                    infoAddress.innerHTML = "Address: ";
                    infoPhone.innerHTML = "Ph: ";
                    //SET INFO PANEL OUTPUT
                    infoName.innerHTML += locations[n][0];
                    infoProduce.innerHTML += locations[n][4];
                    infoAddress.innerHTML += locations[n][5];
                    infoPhone.innerHTML += locations[n][6];
                    //SET IMAGE
                    infoImg.src = "";
                    infoImg.src = "img/" + locations[n][7];
                //}
            }
      });
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

function checkSearchType(){
    var searchType = document.getElementById("searchType");
    var searchTypeValue = searchType.options[searchType.selectedIndex].value;
    if(searchTypeValue == "Name"){
        findLocationByName();
    }
    else if(searchTypeValue == "Postcode"){
        findLocationByPostcode();
    }
    else if(searchTypeValue == "Address"){
        findLocationByAddress();
    }
}

//FIND LOCATION BY NAME
function findLocationByName(){
    //CLEAR RESULTS ARRAY
    while(searchResults.length > 0) {
        searchResults.pop();
    }
    //FIND RESULTS AND PUSH TO ARRAY
    for(var i=0;i<locations.length;i++){
		//search array for matching string + then get matching lat/long
		//var re = document.getElementById('searchbar').value;
		var re = document.getElementById('testSearch').value.toLowerCase();
		//re = re.substring(0, re.indexOf('(') - 1);
		if(locations[i][0].toLowerCase().search(re) != -1){
			searchResults.push(i);
        }
	}
    cRArrayPos = 0;
    currentResult = searchResults[cRArrayPos];
    totalResNo.innerHTML = searchResults.length;
    if(searchResults.length){
        document.getElementById('infoPanel').style.display = "block";
        document.getElementById('resultsPanel').style.display = "block";
        document.getElementById('noResultsBtn').style.display = "none";
        displayResult();
    }
    else{
        noResultsFound();
    }
}

//FIND LOCATION BY POSTCODE
function findLocationByPostcode(){
    //CLEAR RESULTS ARRAY
    while(searchResults.length > 0) {
        searchResults.pop();
    }
    //FIND NEW RESULTS AND PUSH TO ARRAY
    for(var i=0;i<locations.length;i++){
        //search array for matching string + then get matching lat/long
        //var re = document.getElementById('searchbar').value;
        var re = document.getElementById('testSearch').value;
        //re = re.substring(0, re.indexOf('(') - 1);
        if(locations[i][8].search(re) != -1){
            searchResults.push(i);
        }
    }
    cRArrayPos = 0;
    currentResult = searchResults[cRArrayPos];
    totalResNo.innerHTML = searchResults.length;
    if(searchResults.length){
        document.getElementById('infoPanel').style.display = "block";
        document.getElementById('resultsPanel').style.display = "block";
        document.getElementById('noResultsBtn').style.display = "none";
        displayResult();
    }
    else{
        noResultsFound();
    }  
}

//DISPLAY SEARCH RESULTS ON MAP
function displayResult(){
    currentResult = searchResults[cRArrayPos];
    var i = currentResult;
    //SHOW FIRST INSTANCE ON MAP
    geoLocIndex = i;
    //map.panTo(new GLatLng(geoLocLat,geoLocLong));
    var latLng = new google.maps.LatLng(locations[i][1], locations[i][2]); //Makes a latlng
    map.panTo(latLng); //Make map global
    map.setZoom(14); 
    //CLEAR INFO PANEL
    infoName.innerHTML = "";
    infoProduce.innerHTML = "Produce: ";
    infoAddress.innerHTML = "Address: ";
    infoPhone.innerHTML = "Ph: ";
    //SET INFO PANEL OUTPUT
    infoName.innerHTML += locations[i][0];
    infoProduce.innerHTML += locations[i][4];
    infoAddress.innerHTML += locations[i][5];
    infoPhone.innerHTML += locations[i][6];
    //SET IMAGE
    infoImg.src = "";
    infoImg.src = "img/" + locations[i][7];
    //UPDATE CURRENT DISPLAYED RESULT NO OUT OF TOTAL
    currentResNo.innerHTML = cRArrayPos + 1;

}

function nextResult(){
    cRArrayPos++;
    if(cRArrayPos>searchResults.length-1){
        cRArrayPos = 0;
    }
    displayResult();
}

function prevResult(){
    cRArrayPos--;
    if(cRArrayPos<0){
        cRArrayPos = searchResults.length-1;
    }
    displayResult();
}

function noResultsFound(){
    document.getElementById('noResultsBtn').innerHTML = "No results found for '" + document.getElementById('testSearch').value + "'.";
    document.getElementById('noResultsBtn').style.display = "block";
    currentResNo.innerHTML = 0;
}

function toggleCalendar(){
    if(document.getElementById('calendarRow').style.display == 'block'){
        document.getElementById('calendarRow').style.display = 'none';
    }
    else{
        document.getElementById('calendarRow').style.display = 'block';
    }
}

function toggleLeftNav(){
    leftNav = document.getElementById('leftNavPanel');
    if(leftNav.className.indexOf("active") == -1){
        leftNav.className += " active";
    }
    else{
        var str = leftNav.className;
        str = str.substring(0, str.length - 6);
        leftNav.className = str;
    }
}

function toggleRightNav(){
    rightNav = document.getElementById('rightNavPanel');
    if(rightNav.className.indexOf("active") == -1){
        rightNav.className += " active";
    }
    else{
        var str = rightNav.className;
        str = str.substring(0, str.length - 6);
        rightNav.className = str;
    }
}

$('#searchForm').submit(function () {
    checkSearchType();
    return false;
});

document.addEventListener('keydown', function(event) {
    if(event.keyCode == 37) {
        prevResult();
    }
    else if(event.keyCode == 39) {
        nextResult();
    }
});
