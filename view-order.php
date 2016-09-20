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

<?php
  if($_SERVER["REQUEST_METHOD"] === "GET")
  {
    //Get Dependancies
    require_once 'php/formValidation.php';


  }
  if($_SERVER["REQUEST_METHOD"] === "POST")
  {




    /*
    I can see a chronologically ordered list of deliveries that are assigned to me.
  I can click to find specific information on the delivery, including where I am going to, what time I am expected, and any notes the customer added in the order.
  I can click to find specific information on the customer
  */
}
?>

<?php require 'includes/header.inc' ?>

<section id="filter-order">
  <div class="container">
    <form method="POST" class="form-order-lookup">
    	<h2 class="form-order-lookup">Orders</h2>
    	<div id="error"></div>
    	<label for="inputEmail" class="sr-only">Customer's Email address</label>
    	<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" autofocus>

			<label for="inputCustomerName">Recipient Name:</label>
			<input type="text" class="form-control" id="inputCustomerName" placeholder="Customer Name" name="customerName" maxlength="255" pattern="^[\w]{2,255}(?:\s[\w]{2,255})*(?!=\W)$">

			<label>Order Priority</label>
			<div class="radio">
				<label><input type="radio" name="priority" value="Express">Express</label>
			</div>
			<div class="radio">
				<label><input type="radio" name="priority" value="Standard">Standard</label>
      </div>
      <div class="radio">
				<label><input type="radio" name="priority" value="" checked="checked">All</label>
      </div>

      <label for="inputStatus" class="sr-only">Order Status</label>
      <select class="form-control" id="inputStatus" name="status">
				<option value="" selected="">- Select Status -</option>
				<option>Ordered</option>
				<option>Picking Up</option>
				<option>Picked Up</option>
				<option>Storing</option>
				<option>Delivering</option>
				<option>Delivered</option>
			</select>

      <label for="pickupTime">Pickup Time</label>
			<input type="datetime-local" class="form-control" id="pickupTime" name="pickupTime">

      <button type="submit" class="btn btn-default">Search</button>

    </form>


    <?php
      if($_SERVER["REQUEST_METHOD"] === "POST")
      {
        $errors = array();
        $formValid = true;

        //Get Dependancies
        require_once 'php/formValidation.php';

        //PHP Field Validation
        $errors = array();

        /*
          Check for Set Search Filters and Validate
          their respective input values
        */
        if(isset($_POST['email']) && !empty($_POST['email']))
        {
          $errors["email"] = checkEmail($_POST['email']);
        }
        if(isset($_POST['customerName']) && !empty($_POST['customerName']))
        {
          $errors["customerName"] = checkFullName($_POST['customerName']);
        }
        if(isset($_POST['status']) && !empty($_POST['status']))
        {
          $errors["status"] = checkStatus($_POST['status']);
        }
        if(isset($_POST['priority']) && !empty($_POST['priority']))
        {
          $errors["priority"] = checkPriority($_POST['priority']);
        }
        if(isset($_POST['pickupTime']) && !empty($_POST['pickupTime']))
        {
          $errors["pickupTime"] = checkTime($_POST['pickupTime']);
        }

        //Check for presence of errors and output
        foreach($errors as $field => $valid)
        {
        	if($valid === false)
        	{
        	  $formValid = false;
        	  echo "Invalid " . $field . " detected<br />";
        	}
        }

        if($formValid)
        {
          require_once 'php/ordersDB.php';
          searchOrder($_POST['email'], $_POST['customerName'], $_POST['priority'], $_POST['status'], $_POST['pickupTime']);
        }
      }else if($_SERVER["REQUEST_METHOD"] === "GET"){

        //Check Order ID is present and valid
        if(isset($_GET['orderID']) && !empty($_GET['orderID']))
        {
          //Validate orderID
          require_once 'php/formValidation.php';
          if(checkIntID($_GET['orderID']))
          {
            //Run Query and Output Results
            require_once 'php/ordersDB.php';
            searchOrder($_POST['email'], $_POST['customerName'], $_POST['priority'], $_POST['status'], $_POST['pickupTime'], $_GET['orderID']);
            getPackages($_GET['orderID']);

          }else{
            //Output Error
            echo "Invalid orderID detected<br />";

          }
        }
      }
     ?>
  </div>
</section>
<?php require 'includes/footer.inc' ?>
