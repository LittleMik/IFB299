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
        require 'php/pdo.inc';

        try{
      	  $query = "SELECT orders.*, users.firstName, users.lastName
          FROM orders
          LEFT JOIN users
          ON orders.userID=users.userID
          WHERE users.email LIKE :email";

      	  $stmt = $pdo->prepare($query);

      	  $stmt->bindValue(':email', $_POST['email']);
          $stmt->execute();

          //Output Table
          echo '
          <section id="view-order">
            <div class="container">
          		<table>
          			<tr>
          				<th>ID</th>
          				<th>Customer</th>
          				<th>Order Overview</th>
                  <th>Pickup</th>
                  <th>Delivery</th>
                  <th>Status</th>
                  <th>More Details...</th>
      			</tr>';
          foreach($stmt as $order)
          {
            echo "
              <tr>
                <td>{$order['orderID']}</td>
                <td>{$order['firstName']} {$order['lastName']}</td>
                <td>
                  <p>Desc:{$order['description']}</p>
                  <p>Weight:{$order['totalWeight']}KG</p>
                  <p>Type:{$order['deliveryPriority']}</p>
                </td>
                <td>
                  <p>Time:{$order['pickUptime']}</p>
                  <p>Address:{$order['pickUpAddress']}</p>
                </td>
                <td>
                  <p>Recipient:{$order['recipientName']}</p>
                  <p>Recipient Phone:{$order['recipientPhone']}</p>
                  <p>Address:{$order['deliveryAddress']}</p>
                </td>
                <td>{$order['orderStatus']}</td>
                <td><a href='view-order.php?orderID={$order['orderID']}'>View</a></td>
              </tr>
            ";
          }
          echo "
              </table>
            </div>
          </section>";
          $orders = $stmt->fetch();
        } catch (PDOException $e){
          echo $e->getMessage();
        }


    	}/*else if(isset($_POST['email']) && isset($_POST['']))
    	{
    	  $query = "SELECT *
    	  FROM Orders ord, Users u
    	  WHERE ord.userID == u.userID
    	  AND u.email LIKE :email
    	  AND ord.orderStatus == :status";

    	  $stmt = $pdo->prepare($query);

    	  $stmt->bindValue(':email', $_POST['email']);
    	  $stmt->bindValue(':status', $_POST['status']);
    	}*/
    }
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

    </form>

  </div>
</section>

<?php require 'includes/footer.inc' ?>