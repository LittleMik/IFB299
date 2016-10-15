<?php require 'includes/head.inc' ?>

<?php

	if(!isset($_SESSION['login']) || !isset($_SESSION['login']))
	{
		//Error: User not logged in
		header("Location:login.php");
	}
?>

<?php require 'includes/header.inc' ?>
<section id="filter-order">
	<div class="container">
		<?php
			require_once 'php/ordersDB.php';
			require_once 'php/users.php';
			require_once 'php/status.php';

			$user = unserialize($_SESSION['user']);
			//Check Status is set
			if(!isset($_POST['status']))
			{
				$status = "NOT ".Status::Delivered;
			}

			displayOrders(searchOrder($user->email, "", "", $status, ""));
		?>
	</div>
</section>

<?php require 'includes/footer.inc' ?>
