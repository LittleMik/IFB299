<?php
  if($_SERVER["REQUEST_METHOD"] === "POST")
  {

	$errors = array();
	$formValid = true;

	//Get Dependancies
	require_once 'formValidation.php';

	//PHP Field Validation
	if(empty($_POST['address']) && empty($_POST['postCode']) && empty($_POST['state']))
	{
	  $errors = array(
		"email"=>checkEmail($_POST['email']),
		"password"=>true,//"password"=>checkPassword($_POST['password']),   Password checking is too strict I think.
		"confpassword"=>checkMatch($_POST['password'], $_POST['confpassword']),
		"firstName"=>checkName($_POST['firstName']),
		"lastName"=>checkName($_POST['lastName']),
		"phone"=>checkPhone($_POST['phone'])
	  );
	  //Set state to empty string for user object
	  $_POST['state'] = "";
	} else {
	  $errors = array(
		"email"=>checkEmail($_POST['email']),
		"password"=>true,//"password"=>checkPassword($_POST['password']),   Password checking is too strict I think.
		"confpassword"=>checkMatch($_POST['password'], $_POST['confpassword']),
		"firstName"=>checkName($_POST['firstName']),
		"lastName"=>checkName($_POST['lastName']),
		"phone"=>checkPhone($_POST['phone']),
		"address"=>checkAddress($_POST['address']),
		"postCode"=>checkPost($_POST['postCode']),
		"state"=>checkState($_POST['state'])
	  );
	}

	//Check for presence of errors and output
	foreach($errors as $field => $valid)
	{
	  if($valid === false)
	  {
		$formValid = false;
		echo $_POST[$field] . "<br />";
		echo "Invalid " . $field . " detected<br />";
	  }
	}

	//Complete Registration Process
	if($formValid)
	{
		require_once 'users.php';
		//note the initial 0 is for the id. This will get replaced unless
		$user = new User($_POST['ID'], $_POST['email'], $_POST['password'], $_POST['firstName'], $_POST['lastName'], $_POST['role'], $_POST['phone'], $_POST['address'], $_POST['postCode'], $_POST['state']);

		$user->saveToDatabase();

    //Redirect Script
    echo "
      <script>
        alert('Account Created');
        window.location.href = 'index.php';
      </script>";
  }
}
?>
