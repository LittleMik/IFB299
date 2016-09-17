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
if($_SERVER["REQUEST_METHOD"] === "POST")
{


  $errors = array();
  $formValid = true;

  //Get Dependancies
  require_once 'php/formValidation.php';

  //PHP Field Validation
  $errors = array(

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

  /*
  I can see a chronologically ordered list of deliveries that are assigned to me.
I can click to find specific information on the delivery, including where I am going to, what time I am expected, and any notes the customer added in the order.
I can click to find specific information on the customer
*/
  //Complete Registration Process
  if($formValid)
  {
	if(isset($_POST['email']))
	{
	  $query = "SELECT *
	  FROM Orders ord, Users u
	  WHERE ord.userID == u.userID
	  AND u.email LIKE :email";

	  $stmt = $pdo->prepare($query);

	  $stmt->bindValue(':email', $_POST['email']);

	}else if(isset($_POST['email']) && isset($_POST['']))
	{
	  $query = "SELECT *
	  FROM Orders ord, Users u
	  WHERE ord.userID == u.userID
	  AND u.email LIKE :email
	  AND ord.orderStatus == :status";

	  $stmt = $pdo->prepare($query);

	  $stmt->bindValue(':email', $_POST['email']);
	  $stmt->bindValue(':status', $_POST['status']);
	}
  }
}
?>

<?php require 'includes/header.inc' ?>

<section id="view-order">
<div class="container">
  <form method="POST" class="form-order-lookup">
	<h2 class="form-order-lookup">Orders</h2>
	<div id="error"></div>
	<label for="inputEmail" class="sr-only">Customer's Email address</label>
	<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" autofocus>

  </form>

</div> <!-- /container -->
</section>

<?php require 'includes/footer.inc' ?>
