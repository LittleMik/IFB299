function getLocation() {
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(returnLocation);
	} else {
		alert("Geolocation is not supported by this browser.");
	}
}

function returnLocation(position) {
    lat = position.coords.latitude;
    lon = position.coords.longitude;
    document.getElementById('userLatitude').value = lat;
    document.getElementById('userLongitude').value = lon;
    document.getElementById('userLatitude2').value = lat;
    document.getElementById('userLongitude2').value = lon;
}