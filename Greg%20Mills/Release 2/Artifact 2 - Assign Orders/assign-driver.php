<?php require 'includes/head.inc' ?>

<?php
	//Verify User Permission to View Page
	require_once 'php/permissions.php';
	if(isset($_SESSION['role']))
	{
		if(checkPermission($_SESSION['role'], 'assign-driver') === false)
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

<?php
	if($_SERVER["REQUEST_METHOD"] === "POST")
	{
        //Get Order
        require_once 'php/orders.php';
        $order = new Order();
        $order->getOrder($_GET['orderID']);
        //Update the driver with new driver
        $order->updateDriver($_POST['driverChoice']);
        header("Location:view-order.php?orderID={$_GET['orderID']}");
	}
?>

<!--Header-->
<?php require 'includes/header.inc' ?>

<!--Assign Driver Form-->
<div class="container containerDriver">
	<div class= "texts2">
	<h2>Payment</h2>
	</div>

	<form method="post">

		<div class= "texts">
		<h3>Assign Driver to Order:</h3>
		</div>

		<div class= "texts">
		    <h3>Choose Driver:</h3>
		</div>

		<div class="form-group1">
			<!--Driver-->
			<select class="form-control" id="driverChoice" name="driverChoice" required>
				<option value="" disabled selected>- NONE -</option>
                <?php
                    //Get all users with driver roles, and display them as options
                    require_once 'php/usersDB.php';
                    require_once 'php/roles.php';
                    $stmt = searchUsers("", "", Roles::Driver);
                    foreach($stmt as $user){
                        echo "
                            <option value={$user['userID']}>{$user['firstName']} {$user['lastName']}</option>
                        ";
                    }
                ?>
			</select>
		</div>

		<button type="submit" class="btn1btn-default">Assign</button>

	</form>
</div>

<!--Footer-->
<?php require 'includes/footer.inc' ?>
