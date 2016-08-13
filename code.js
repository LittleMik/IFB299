function initialize(lat, long, mapID) {
    var wifiLocation = new google.maps.LatLng(lat, long);
    var mapProp = {
        center: wifiLocation,
        zoom: 5,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    var map= new google.maps.Map(document.getElementById(mapID), mapProp);
    
    var marker=new google.maps.Marker({position:wifiLocation});
    google.maps.event.addDomListener(window, 'load', initialize);
    marker.setMap(map);
    map.setZoom(14);
}

function searchInitialize(lat, lon, names, ids, mapID) {
   //make map invisible if no values found
    if(lat[0]==""){
        document.getElementById('googleMap').style.display = "none";
    } 
    
    window.map = new google.maps.Map(document.getElementById('googleMap'), {
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var bounds = new google.maps.LatLngBounds();

    for (i = 0; i < lat.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat[i], lon[i]),
            map: map
        });

        bounds.extend(marker.position);

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infowindow.setContent("<a href = individual-page.php?wifi="+ids[i]+">"+names[i]+"</a>");
                infowindow.open(map, marker);
            }
        })(marker, i));
    }

    map.fitBounds(bounds);
}

function loadScript() {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&' + 'callback=initialize';
    document.body.appendChild(script);
}
    

/*Code from http://stackoverflow.com/questions/9142527/can-you-require-two-form-fields-to-match-with-html5
, it was far more elegant than the checker that was created in the validation workshop*/
function check(input) {
    if (input.value != document.getElementById('password').value) {
        input.setCustomValidity('Password Must be Matching.');
    } else {
        // input is valid -- reset the error message
        input.setCustomValidity('');
    }
}
    
