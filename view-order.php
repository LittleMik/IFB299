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
						echo '
							<h3>Order</h3>
							<table class="table table-striped table-condensed table-responsive">
							<thead>
								<tr>
									<th>ID</th>
									<th>Customer</th>
									<th>Description</th>
									<th>Pickup</th>
									<th>Delivery</th>
									<th>Recipient</th>
									<th>Status</th>
									<th> </th>
								</tr>
							</thead>
							<tbody>';

						//Display Order
						require_once 'php/orders.php';
						$order = new Order();
						$order->getOrder($_GET['orderID']);
						$order->displayOrder();

						//Close Table Tags
						echo "</tbody></table>";

						//Output Packages Table
						echo '
							<h3>Packages</h3>
							<table class="table table-striped table-condensed table-responsive">
								<thead>
									<tr>
										<th>ID</th>
										<th>Description</th>
										<th>Weight</th>
									</tr>
								</thead>
								<tbody>';

						//Display Packages
						require_once 'php/packages.php';
						$packages = $order->getPackages();

						//Check if packages are present
						if(empty($packages))
						{
							echo "<tr><td colspan='3'><h4>No packages can be found for this order...</h4></td></tr>";
						}
							else
						{
							foreach($packages as $package)
							{
								//Output Each Package as a Row
								$package->displayPackage();
							}
						}

						//Close Table Tags
						echo '</tbody></table>';

						//Verify User Permission to View Payments
						require_once 'php/permissions.php';
						if(checkPermission($_SESSION['role'], 'payments-view') === true)
						{
							require_once 'php/paymentsDB.php';
							displayPayment(getPayment($_GET['orderID']));
						}

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
