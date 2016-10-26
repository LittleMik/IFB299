<?php require 'includes/head.inc' ?>

<?php
	//Verify User Permission to View Page
	require_once 'php/permissions.php';
	if(isset($_SESSION['role']))
	{
		if(checkPermission($_SESSION['role'], 'edit-order.php') === false)
		{
			echo '<script> alert('.$_SERVER['PHP_SELF'].');</script>';
			//Insufficient Role, Redirect User to Forbidden Error Page
			header("Location:login.php");
		}
	}else{
		//Error: User not logged in
		header("Location:login.php");
	}

	//Check Order ID is present and valid
	if(isset($_GET['orderID']) && !empty($_GET['orderID']))
	{
		//Validate orderID
		require_once 'php/formValidation.php';
		if(checkIntID($_GET['orderID']))
		{
			//Retrieve Order
			require_once 'php/orders.php';
			$order = new Order();
			$order->getOrder($_GET['orderID']);

			//Set Delivered Status
			require_once 'php/status.php';
			$order->updateStatus(Status::Delivered);

			//Redirect Back to Orders Menu
			header("Location:view-order.php");

		}
	}
?>
