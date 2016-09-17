/*Ensure password & confirmation matches, input is confirmation field*/
function check(input) {
    if (input.value != document.getElementById('password').value) {
        input.setCustomValidity('Password Must be Matching.');
    } else {
        // input is valid -- reset the error message
        input.setCustomValidity('');
    }
}

//Load a php
function getAddress(inputID){
	$.ajax({
		url:'php/getAddress.php',
		complete: function (response) {
			$('#' + inputID).val(response.responseText);
		},
		error: function () {
			$('#' + inputID).html('Bummer: there was an error!');
		}
	});
	return false;
}
