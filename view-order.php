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
						//Run Query and Output Results
						require_once 'php/ordersDB.php';
						displayPackages(getOrder($_GET['orderID']), getPackages($_GET['orderID']));

						if(checkPermission($_SESSION['role'], 'payments-view') === true)
						{
							require_once 'php/paymentsDB.php';
							displayPayment(getPayment($_GET['orderID']));
						}
					}else{

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
