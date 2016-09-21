<?php require 'includes/head.inc' ?>

<?php
  //Verify User Permission to View Page
  require_once 'php/permissions.php';

  if(isset($_SESSION['role']))
  {
    if(checkPermission($_SESSION['role'], 'edit-order.php') === false)
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
	require_once 'php/ordersDB.php';
	require_once 'php/usersDB.php';
	$orderObject = getOrderObject(htmlspecialchars($_GET["orderID"]));
	$userObject = getUserObjectFromID($orderObject->userID);

	if($_SERVER["REQUEST_METHOD"] === "POST")
	{

	  $errors = array();
	  $formValid = true;

	  //Get Dependancies
	  require_once 'php/formValidation.php';

	  //PHP Field Validation
	  $errors = array(
		"description"=>checkDescription($_POST['description']),
		"totalWeight"=>checkWeight($_POST['totalWeight']),
		"signature"=>checkSet($_POST['signature']),
		"priority"=>checkSet($_POST['priority']),
		"pickupAddress"=>checkAddress($_POST['pickupAddress']),
		"pickupTime"=>checkTime($_POST['pickupTime']),
		"deliveryAddress"=>checkAddress($_POST['deliveryAddress']),
		"deliveryState"=>checkState($_POST['deliveryState']),
		"recipientName"=>checkFullName($_POST['recipientName']),
		"recipientPhone"=>checkPhone($_POST['recipientPhone']),
	  );

	  //Check for presence of errors and output
	  foreach($errors as $field => $valid)
	  {
		if($valid === false)
		{
		  $formValid = false;
		  echo $_POST[$field] . "<br />";
		  echo "Invalid " . $field . " detected<br />";
		}
	  }

	  //Complete Registration Process
	  if($formValid)
	  {
		require_once 'php/orders.php';
		require_once 'php/users.php';


		$user = unserialize($_SESSION['user']);

		$order = new Order($user->id, $_POST['description'], $_POST['totalWeight'], $_POST['signature'], $_POST['priority'], $_POST['pickupAddress'], $_POST['pickupTime'], $_POST['deliveryAddress'], $_POST['recipientName'], $_POST['recipientPhone']);

		$order->createCustomerOrder();

		//Redirect Script
				echo "
					<script>
						alert('Order Created');
						window.location.href = 'index.php';
					</script>";
	  }
	}
?>

<?php require 'includes/header.inc' ?>

<div class="container">
	<h2>Order Details</h2>
	<form method="post" autocomplete="on" onsubmit="return validate(this)" action="<?php echo "https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];?>">
		<!--Customer Email-->
		<div class="form-group">
			<label for="inputEmail" class="sr-only">Customer email address</label>
			<input value="<?php echo $userObject->email ?>" type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
		</div>
		
		<!--Order Description-->
		<div class="form-group">
			<label for="comment">Description:</label>
			<textarea class="form-control" rows="5" id="comment" maxlength="140" name="description"><?php echo $orderObject->description ?></textarea>*max 140 characters
		</div>

		<!--Signature Required-->
		<div class="form-group">
			<label>Require Signature Upon Delivery?</label>
			<?php 
				if($orderObject->signature == 1){
					echo '
						<label class="radio-inline"><input type="radio" name="signature" value="1" checked="checked">Yes</label>
						label class="radio-inline"><input type="radio" name="signature" value="0">No</label>
					';
				} else {
					echo '
						<label class="radio-inline"><input type="radio" name="signature" value="1">Yes</label>
						label class="radio-inline"><input type="radio" name="signature" checked="checked" value="0">No</label>
					';
				}
			?>
			
		</div>

		<!--Priority (Order Type)-->
		<div class="form-group">
			<label>Delivery Priority</label>
			<?php 
				if($orderObject->signature == "Express"){
					echo '
						<div class="radio">
							<label><input type="radio" name="priority" checked="checked" value="Express">Express (1-2 Business Days)</label>
						</div>
						<div class="radio">
							<label><input type="radio" name="priority" value="Standard">Standard (5-7 Business Days)</label>
						</div>
					';
				} else {
					echo '
						<div class="radio">
							<label><input type="radio" name="priority" value="Express">Express (1-2 Business Days)</label>
						</div>
						<div class="radio">
							<label><input type="radio" name="priority" value="Standard" checked="checked">Standard (5-7 Business Days)</label>
						</div>
					';
				}
			?>
			
		</div>

		<h3>Pick Up</h3>

		<!--Pickup Time-->
		<div class="form-group">
			<label for="pickupTime">Pickup Time:</label>
			<input value="<?php echo str_replace(' ', 'T', $orderObject->pickupTime); ?>" type="datetime-local" value= class="form-control" id="pickupTime" name="pickupTime"
			<?php
			  date_default_timezone_set('Australia/Brisbane');
			  $dateMin = date('Y-m-d TH:i:s a');
			  echo "min='".$dateMin."'";

			  $date = date_create($dateMin);
			  date_modify($date,"+1 year");
			  $dateMax = date_format($date, "Y-m-d TH:i:s a");
			  echo " max='".$dateMax."'";
			?>>
		</div>

		<!--Pickup Address-->
		<div class="form-group">
			<label>Pickup Address:</label>
			<label class="radio-inline"><input type="radio" onclick="getAddress('pickupAddress');" name="otherPickupAddress">Your Address</label>
			<label class="radio-inline"><input type="radio" name="otherPickupAddress" checked="checked">Other</label>
			<input value="<?php echo $orderObject->pickupAddress ?>" type="text" class="form-control" id="pickupAddress" name="pickupAddress">
		</div>

		<h3>Recipient Details</h3>
		<!--Fullname of Recipient-->
		<div class="form-group">
			<label for="recipientName">Recipient Name:</label>
			<input value="<?php echo $orderObject->recipientName ?>" type="text" class="form-control" id="recipientName" placeholder="Enter Recipient Name" name="recipientName" maxlength="255" pattern="^[\w]{2,255}(?:\s[\w]{2,255})*(?!=\W)$" required>
		</div>

		<!--Recipient's Phone Number-->
		<div class="form-group">
			<label for="recipientPhone">Recipient Phone Number:</label>
			<input value="<?php echo $orderObject->recipientPhone ?>" type="tel" class="form-control" id="recipientPhone" placeholder="Enter Phone Number" name="recipientPhone" maxlength="16" pattern="^(?:\(\+?[0-9]{2}\))?(?:[0-9]{6,10}|[0-9]{3,4}(?:(?:\s[0-9]{3,4}){1,2}))$" required>
		</div>

		<h3>Delivery</h3>

		<!--Delivery Address-->
		<div class="form-group">
			<label for="deliveryAddress">Delivery Address:</label>
			<input value="<?php echo $orderObject->deliveryAddress ?>" type="text" class="form-control" id="deliveryAddress" placeholder="Enter Delivery Address" name="deliveryAddress" maxlength="255" pattern="^[0-9]{1,5},?\s\w{2,64}\s\w{2,64},?\s\w{2,64}$" required>
		</div>

		<!--Delivery PostCode-->
		<div class="form-group">
			<label for="email">Postcode:</label>
			<input value="<?php echo $orderObject->deliveryPostcode ?>" type="number" class="form-control" id="email" placeholder="Enter Postcode" name="deliveryPostCode" pattern="^[0-9]{4}$">
		</div>

		<!--Delivery State-->
		<div class="form-group">
			<label for="state">State:</label>
			<?php echo $orderObject->deliveryState ?>
			<select class="form-control" id="state" name="deliveryState">
				<option value="" disabled selected>- Select State -</option>
				<option <?php $selected = ($orderObject->deliveryState == "QLD") ?  'selected' :  ''; echo $selected;?>>QLD</option>
				<option <?php $selected = ($orderObject->deliveryState == "NSW") ?  'selected' :  ''; echo $selected;?>>NSW</option>
				<option <?php $selected = ($orderObject->deliveryState == "ACT") ?  'selected' :  ''; echo $selected;?>>ACT</option>
				<option <?php $selected = ($orderObject->deliveryState == "VIC") ?  'selected' :  ''; echo $selected;?>>VIC</option>
				<option <?php $selected = ($orderObject->deliveryState == "SA") ?  'selected' :  ''; echo $selected;?>>SA</option>
				<option <?php $selected = ($orderObject->deliveryState == "WA") ?  'selected' :  ''; echo $selected;?>>WA</option>
				<option <?php $selected = ($orderObject->deliveryState == "NT") ?  'selected' :  ''; echo $selected;?>>NT</option>
			</select>
		</div>

		<button type="submit" class="btn btn-default">Submit</button>

	</form>
</div>

<?php require 'includes/footer.inc' ?>