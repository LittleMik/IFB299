<?php require 'includes/head.inc' ?>

<?php
	//Verify User Permission to View Page
	require_once 'php/permissions.php';

	if(isset($_SESSION['role']))
	{
		if(checkPermission($_SESSION['role'], 'view-order.php') === false)
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
<section id="filter-order">
	<div class="container">
		<?php
			require 'php/searchOrder.php'
		?>
		<?php
			if($_SERVER["REQUEST_METHOD"] === "GET"){

				echo '</div>
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

						//Retrieve Payment Information
						require_once 'php/paymentsDB.php';
						$payment = getPayment($_GET['orderID']);

						//Output All Order Relevant Information
						require_once 'php/output.php';
						outputOrderAll($order, $packages, $payment);
					}
						else
					{
						//Output Error
						echo "Invalid orderID detected<br />";
					}
				}
				echo '</div>';
			}
		?>
	</div>
</section>

<?php require 'includes/footer.inc' ?>
