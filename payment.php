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
			//"date"=>checkTime($_POST['date']),
			"amount"=>checkPaymentAmount($_POST['amount'])
		);

		//Check for presence of errors and output
		foreach($errors as $field => $valid)
		{
			if($valid === false)
			{
				$formValid = false;
				echo "<script>alert('Sorry...it seems something went wrong with your entry.) [Error:Invalid {$field}]');</script>";
			}
		}
		//Payment Form Valid
		if($formValid)
		{
			//Get Order
			require_once 'php/orders.php';
			$order = new Order();
			$order->getOrder($_GET['orderID']);

			//Add Payment to DB
			echo "<script>alert('Adding payment. [Error:Rejected Entry]');</script>";
			require_once 'php/paymentsDB.php';
			if(addPayment($_GET['orderID'], $order->getUserID(), $_POST['type'], $_POST['date'], $_POST['amount']))
			{
				require_once 'php/status.php';
				$order->updateStatus(Status::PickedUp);

				//Redirect Script
				//header("Location:view-order.php?orderID={$_GET['orderID']}");
			}else{
				echo "<script>alert('Sorry...it seems something went wrong with the database.) [Error:Rejected Entry]');</script>";
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
			<?php
				//Get UserID
				require_once 'php/orders.php';
				$order = new Order();
				$order->getOrder($_GET['orderID']);
				$userID = $order->getUserID();

				//Output User's Email
				require_once 'php/users.php';
				$user = new User();
				$user->getUser($userID);
				$user->getEmail();
			?>
			<input type="email" class="form-control" id="email" value="<?php echo $user->getEmail(); ?>" name="email" maxlength="255" required readonly>
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

			<?php
				date_default_timezone_set('Australia/Brisbane');

				//Set Min Datetime
				$dateMin = date('Y-m-d H:i:s');
				$dateString = str_replace(' ', 'T', $dateMin);

				//Set Max DateTime
				$dateMax = date_create($dateMin);
				date_modify($dateMax,"+3 months");
				$dateMaxString = str_replace(' ', 'T', date_format($dateMax, "Y-m-d H:i:s"));

				//Hide Date Editing if permission not available
				$type = (checkPermission($_SESSION['role'], 'payments-edit') === true ? "datetime-local" : "hidden");

				echo "
					<!--Payment Date-->
					<label for='date'>Date:</label>
					<input type='{$type}' class='form-control' id='paymentDate' name='date' value='{$dateString}' min='{$dateString}' max='{$dateMaxString}' required>";
			?>

			<!--Payment Amount-->
			<label for="paymentAmount">Amount: ($AUD)</label>
			<input type="number" size="12" class="form-control" id="paymentAmount" placeholder="0.00" name="amount" step="0.01" required>

		</div>

		<button type="submit" class="btn1btn-default">Submit</button>

	</form>
</div>

<!--Footer-->
<?php require 'includes/footer.inc' ?>
