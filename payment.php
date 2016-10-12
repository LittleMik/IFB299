<?php require 'includes/head.inc' ?>

<?php
	//Verify User Permission to View Page
	require_once 'php/permissions.php';

	if(isset($_SESSION['role']))
	{
		if(checkPermission($_SESSION['role'], 'payments-add') === false)
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

		$errors = array();
		$formValid = true;

		//Get Dependancies
		require_once 'php/formValidation.php';

		//PHP Field Validation
		$errors = array(
			"orderID"=>checkIntID($_GET['orderID']),
			"email"=>checkEmail($_POST['email']),
			"type"=>checkPaymentType($_POST['type']),
			"date"=>checkTime($_POST['date']),
			"amount"=>checkPaymentAmount($_POST['amount'])
		);

		//Check for presence of errors and output
		foreach($errors as $field => $valid)
		{
			if($valid === false)
			{
				$formValid = false;
				echo "<script>alert('Sorry...it seems something went wrong with your entry. [Error:Invalid {$field}]');</script>";
			}
		}

		//Payment Form Valid
		if($formValid)
		{
			//Get UserID
			require_once 'php/usersDB.php';
			$userID = getID($_POST['email']);

			require_once 'php/paymentsDB.php';

			//Add Payment to DB
			if(addPayment($_GET['orderID'], $userID, $_POST['type'], $_POST['date'], $_POST['amount']))
			{
				//Redirect Script
				header("Location: ../view-order.php?orderID={$_GET['orderID']}");
			}else{
				echo "<script>alert('Sorry...it seems something went wrong with the database. [Error:Rejected Entry]');</script>";
			}
		}
	}
?>

<!--Header-->
<?php require 'includes/header.inc' ?>
<img id="im" src="images/background1.png" alt="Banner"> </img>
<!--Payment Form-->
<div class="container2">
	<div class= "texts2">
	<h2>Payment</h2>
	</div>

	<form method="post" autocomplete="on" onsubmit="return validate(this)">

		<div class= "texts">
		<h3>Customer</h3>
		</div>

		<div class="form-group1">
			<label for="email">Customer Email:</label>
			<input type="email" class="form-control" id="email" placeholder="Enter Email Address" name="email" maxlength="255" required>
		</div>

		<div class= "texts">
		<h3>Payment Information</h3>
		</div>

		<div class="form-group1">
			<!--Payment Method-->
			<label for="paymentType">Payment Method:</label>
			<select class="form-control" id="paymentType" name="type" required>
				<option value="" disabled selected>- Select Payment Method -</option>
				<option>Cash</option>
				<option>Check</option>
				<option>Bank Deposit</option>
			</select>

			<!--Payment Date-->
			<label for="pickupTime">Date:</label>
			<input type="datetime-local" class="form-control" id="paymentDate" name="date" required
			<?php
				date_default_timezone_set('Australia/Brisbane');
				$date = date('Y-m-d TH:i:s a');
				echo "placeholder='{$date}'";
				$dateMin = date_create($date);
				date_modify($dateMin,"-6 months");
				$dateMinString = date_format($dateMin, "Y-m-d TH:i:s a");
				echo "min='".$dateMinString."'";

				$dateMax = date_create($date);
				date_modify($dateMax,"+1 year");
				$dateMaxString = date_format($dateMax, "Y-m-d TH:i:s a");
				echo " max='".$dateMaxString."'";
			?>>

			<!--Payment Amount-->
			<label for="paymentAmount">Amount: ($AUD)</label>
			<input type="number" size="12" class="form-control" id="paymentAmount" placeholder="0.00" name="amount" step="0.01" required>

		</div>

		<button type="submit" class="btn1btn-default">Submit</button>

	</form>
</div>

<!--Footer-->
<?php require 'includes/footer.inc' ?>
