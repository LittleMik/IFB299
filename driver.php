<?php require 'includes/head.inc' ?>

<?php
	//Verify User Permission to View Page
	require_once 'php/permissions.php';
	if(isset($_SESSION['role']))
	{
		if(checkPermission($_SESSION['role'], 'driver-ui') === false)
		{
			echo '<script> alert('.$_SERVER['PHP_SELF'].');</script>';
			//Insufficient Role, Redirect User to Forbidden Error Page
			header("Location:login.php");
		}
	}else{
		//Error: User not logged in
		header("Location:login.php");
	}
?>

<?php require 'includes/header.inc' ?>

<div class="pusher"></div>

<?php
    require_once 'php/status.php';
    if($_SERVER["REQUEST_METHOD"] === "GET"){
        $status = $_GET['orderStatus'];
        $driverHeading = "Unknown";
        switch ($status) {
			case Status::Ordered:
					$driverHeading = "Not Assigned";
					break;
			case Status::PickingUp:
					$driverHeading = "Picking Up";
					break;
			case Status::PickedUp:
					$driverHeading = "Taking to Warehouse";
					break;
			case Status::Storing:
					$driverHeading = "Picking up from Warehouse";
					break;
			case Status::Delivering:
					$driverHeading = "Taking to Recipient";
					break;
			case Status::Delivered:
					$driverHeading = "Order Completed";
					break;
        }
        echo "
        <div class='container'>
        <h1>Driver Interface: {$driverHeading}";

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

                //Retrieve Order's Packages
                $packages = $order->getPackages();

                //Output All Order Relevant Information
                require_once 'php/output.php';
                outputOrder($order);
                outputPackages($packages);

            }
                else
            {
                //Output Error
                echo "Invalid orderID detected<br />";
            }
        }
          
        echo '</div>';
    } else {
        echo 'URL does not contain the right information.';
    }


    switch ($status) {
			case Status::PickingUp:
                    require 'includes/milestoneOnePayment.inc';
					break;
			case Status::PickedUp:
					require 'includes/milestoneTwoDropWarehouse.inc';
					break;
			case Status::Storing:
					require 'includes/milestoneThreePickWarehouse.inc';
					break;
			case Status::Delivering:
					require 'includes/milestoneFourDeliver.inc';
					break;
            }
?>
    

<?php require 'includes/footer.inc' ?>