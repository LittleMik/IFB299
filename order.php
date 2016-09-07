<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION['loggedIn']))
    {
      header("Location:Login.php");
    }
?>
<html>
<head>
    <title>On The Spot Package Delivery | Package Details</title>
    <!-- <link rel="stylesheet" type="text/css" href="css/style.css"> -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<header id="header">

    <h1 id="logo"><a href="">On The Spot</a></h1>

</header>

<body>
  <?php
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
        "state"=>checkState($_POST['state'])
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

        $user = $_SESSION['user'];

        $order = new Order($user->userID, $_POST['description'], $_POST['totalWeight'], $_POST['signature'], $_POST['priority'], $_POST['pickupAddress'], $_POST['pickupTime'], $_POST['deliveryAddress'], $_POST['recipientName'], $_POST['recipientPhone']);

        $order->saveToDatabase();
      }
    }
  ?>
   <!-- Columns:
orderID int(255) AI PK
userID int(255) PK
orderStatus varchar(255)
description varchar(140)
totalWeight int(4)
signature tinyint(1)
deliveryPriority varchar(255)
pickUpAddress varchar(255)
pickUptime timestamp
deliveryAddress varchar(255)
recipientName varchar(255)
recipientphoneNo int(16)-->
    <div class="container">
        <h2>Order Details</h2>
        <form>

            <!--Order Description-->
            <div class="form-group">
                <label for="comment">Description:</label>
                <textarea class="form-control" rows="5" id="comment"></textarea>*max 140 characters
            </div>

            <!--Order Weight-->
            <div class="form-group">
                <label for="weight">Weight:</label>
                <input type="number" class="form-control" id="weight" name="totalWeight" placeholder="Weight in KGs">KGs
            </div>

            <!--Signature Required-->
            <div class="form-group">
                <label>Require Signature Upon Delivery?</label>
                <label class="radio-inline"><input type="radio" name="optradio">Yes</label>
                <label class="radio-inline"><input type="radio" name="optradio">No</label>
            </div>

            <!--Priority (Order Type)-->
            <div class="form-group">
                <label>Delivery Priority</label>
                <div class="radio">
                    <label><input type="radio" name="optradio">Express (1-2 Business Days)</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="optradio">Standard (5-7 Business Days)</label>
                </div>
            </div>

            <h3>Pick Up</h3>

            <!--Pickup Time-->
            <div class="form-group">
                <label for="pickupTime">Pickup Time:</label>
                <input type="datetime-local" class="form-control" id="pickupTime" name="pickupTime"
                <?php
                  date_default_timezone_set('Australia/Brisbane');
                  $dateMin = date('Y-m-d TH:i:s a');
                  echo "min='".$dateMin."'";

                  $date = date_create($dateMin);
                  date_modify($date,"+14 days");
                  $dateMax = date_format($date, "Y-m-d TH:i:s a");
                  echo " max='".$dateMax."'";
                ?>>
            </div>

            <!--Pickup Address-->
            <div class="form-group">
                <label>Pickup Address:</label>
                <label class="radio-inline"><input type="radio" name="optradio">Your Address</label>
                <label class="radio-inline"><input type="radio" name="optradio">Other</label>
                <label>Other address:</label>
                <input type="text" class="form-control" id="pickupAddress" name="pickupAddress">
            </div>

            <h3>Recipient Details</h3>
            <!--Fullname of Recipient-->
            <div class="form-group">
                <label for="email">Recipient Name:</label>
                <input type="email" class="form-control" id="recipientName" placeholder="Enter Recipient Name" name="recipientName" maxlength="255" pattern="^[\w]{2,255}(?:\s[\w]{2,255})*(?!=\W)$" required>
            </div>

            <!--Recipient's Phone Number-->
            <div class="form-group">
                <label for="email">Recipient Phone Number:</label>
                <input type="tel" class="form-control" id="email" placeholder="Enter Phone Number" name="recipientPhone" maxlength="16" pattern="^(?:\(\+?[0-9]{2}\))?(?:[0-9]{6,10}|[0-9]{3,4}(?:(?:\s[0-9]{3,4}){1,2}))$" required>
            </div>

            <h3>Delivery</h3>

            <!--Delivery Address-->
            <div class="form-group">
                <label for="deliveryAddress">Delivery Address:</label>
                <input type="deliveryAddress" class="form-control" id="deliveryAddress" placeholder="Enter Delivery Address" name="deliveryAddress" maxlength="255" pattern="^[0-9]{1,5},?\s\w{2,64}\s\w{2,64},?\s\w{2,64}$" required>
            </div>

            <!--Delivery PostCode-->
            <div class="form-group">
                <label for="email">Postcode:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Postcode" name="deliveryPostCode" pattern="^[0-9]{4}$">
            </div>

            <!--Delivery State-->
            <div class="form-group">
                <label for="state">State:</label>
                <select class="form-control" id="state" name="deliveryState">
                    <option value="" disabled selected>- Select State -</option>
                    <option>QLD</option>
                    <option>NSW</option>
                    <option>ACT</option>
                    <option>VIC</option>
                    <option>SA</option>
                    <option>WA</option>
                    <option>NT</option>
                </select>
            </div>

            <button type="submit" class="btn btn-default">Submit</button>

        </form>
    </div>

</body>
</html>
