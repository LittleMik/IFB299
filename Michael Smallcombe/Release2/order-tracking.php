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
			require_once 'php/output.php';
			require_once 'php/search.php';
			require_once 'php/users.php';
			require_once 'php/status.php';

			$user = unserialize($_SESSION['user']);

			outputResultOrders(searchOrder($user->getEmail(), "", "", "", "", ""));
			
		?>
	</div>
</section>

<?php require 'includes/footer.inc' ?>
