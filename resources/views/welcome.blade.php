<?php

use SKAgarwal\GoogleApi\PlacesApi;
use Illuminate\Support\Facades\Storage;

error_log("hello");
$googlePlaces = new PlacesApi('AIzaSyB9ayIX4awOPtN9t78B_OLQ_jROkBpcJ_E');
$response = $googlePlaces->placeAutocomplete('Restaurants');
$response1 = $googlePlaces->nearbySearch('16.79659461262182,96.15240933445489', '1000');
// Storage::disk('public')->put('restaurant.json', response()->json($response));
//   echo $response;
//   $json_output = json_decode($response1);
//   print_r($json_output);
//echo $response1;
//echo $_POST['latitude'] . ' , ' . $_POST['longitude']
if (isset($_GET['latitude'])) {
    echo $_GET['latitude'].' , '.$_GET['longitude'];
    exit;
}
?>

<div id="mapDiv" style="width: 100%; height: 400px"> </div>
<div id='response'></div>
<input id="latitude" name="latitude" type="text">
<input id="longitude" name="longitude" type="text">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyB9ayIX4awOPtN9t78B_OLQ_jROkBpcJ_E&callback=initMap" type="text/javascript"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
    window.onload = function() {
        var mapOptions = {
            center: new google.maps.LatLng(16.798307, 96.149612),
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var infoWindow = new google.maps.InfoWindow();
        var latlngbounds = new google.maps.LatLngBounds();

        //This will load your map with default location co-ordinates.
        var map = new google.maps.Map(document.getElementById("mapDiv"), mapOptions);

        //To capture click event.
        google.maps.event.addListener(map, 'click', function(e) {
            document.getElementById("latitude").value = e.latLng.lat();
            document.getElementById("longitude").value = e.latLng.lng();
            placeMarker(e.latLng, map);

            var placesURL = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=" + e.latLng.lat() + "," + e.latLng.lng() + "&radius=1000&type=restaurant&keyword=cruise&key=AIzaSyB9ayIX4awOPtN9t78B_OLQ_jROkBpcJ_E";

            console.log("The places url is " + placesURL);

        });
    }
    //Adding marker on click
    var marker;

    function placeMarker(location, map) {
        $.ajax({
                type: 'GET',
                data: {
                    latitude: location.lat(), 
                    longitude: location.lng()
                },
                success: function(response) {
                  $('#response').text('location : ' + response);
                }
            });
        if (marker) {
            marker.setPosition(location);
        } else {
            marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }
    }
</script>

