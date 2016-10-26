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
    if($_SERVER["REQUEST_METHOD"] === "GET"){

        echo '
        <div class="container">';

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
    }


require 'includes/milestoneOnePayment.inc';?>

<?php require 'includes/footer.inc' ?>