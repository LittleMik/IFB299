<!DOCTYPE html>
<html>
<head>
    <title>On The Spot Package Delivery | Create an Account</title>
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



<!-- "email"=>checkEmail($_POST['email']),
      "password"=>checkPassword($_POST['password']),
      "confpassword"=>checkMatch($_POST['password'], $_POST['confpassword']),
      "firstName"=>checkName($_POST['firstName']),
      "lastName"=>checkName($_POST['lastName']),
      "phone"=>checkPhone($_POST['phone']),
      "address"=>checkAddress($_POST['address']),
      "postCode"=>checkPost($_POST['postCode']),
      "state"=>checkState($_POST['state']) -->


<body>
    <?php
      if($_SERVER["REQUEST_METHOD"] === "POST")
      {

        $errors = array();
        $formValid = true;

        //Get Dependancies
        require_once 'php/formValidation.php';

        //PHP Field Validation
        if(empty($_POST['address']) && empty($_POST['postCode']) && empty($_POST['state']))
        {
          $errors = array(
            "email"=>checkEmail($_POST['email']),
            "password"=>checkPassword($_POST['password']),
            "confpassword"=>checkMatch($_POST['password'], $_POST['confpassword']),
            "firstName"=>checkName($_POST['firstName']),
            "lastName"=>checkName($_POST['lastName']),
            "phone"=>checkPhone($_POST['phone'])
          );
          //Set state to empty string for user object
          $_POST['state'] = "";
        } else {
          $errors = array(
            "email"=>checkEmail($_POST['email']),
            "password"=>checkPassword($_POST['password']),
            "confpassword"=>checkMatch($_POST['password'], $_POST['confpassword']),
            "firstName"=>checkName($_POST['firstName']),
            "lastName"=>checkName($_POST['lastName']),
            "phone"=>checkPhone($_POST['phone']),
            "address"=>checkAddress($_POST['address']),
            "postCode"=>checkPost($_POST['postCode']),
            "state"=>checkState($_POST['state'])
          );
        }

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
          require_once 'php/users.php';
          
          $user = new User($_POST['email'], $_POST['password'], $_POST['firstName'], $_POST['lastName'], $_POST['phone'], $_POST['address'], $_POST['postCode'], $_POST['state']);

          $user->saveToDatabase();
        }
      }
    ?>

    <div class="container">
        <h2>Create an Account</h2>

        <form method="post" autocomplete="on" onsubmit="return validate(this)" action="<?php echo "https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];?>">
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Email Address" name="email" maxlength="255" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input id="password" class="form-control" placeholder="Password" type="password" name="password" maxlength="255" pattern="(?=.*[a-zA-Z])(?=.*\d).{8,255}" required>

                <label for="confirmPassword">Confirm Password:</label>
                <input id="confirmPassword" class="form-control" placeholder="Confirm Password" type="password" name="confpassword" oninput="check(this);" pattern="(?=.*[a-zA-Z])(?=.*\d).{8,255}" required>
            </div>

            <h3>Personal Details</h3>

            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" class="form-control" id="firstName" name="firstName" maxlength="255" pattern="^\w{2,255}(?!=\W)$" required>

                <label for="lastName">Last Name:</label>
                <input type="text" class="form-control" id="lastName" name="lastName" maxlength="255" pattern="^\w{2,255}(?!=\W)$" required>
            </div>

            <h3>Phone Number</h3>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" class="form-control" id="phone" placeholder="Enter Phone Number" name="phone"  maxlength="16" pattern="^(?:\(\+?[0-9]{2}\))?(?:[0-9]{6,10}|[0-9]{3,4}(?:(?:\s[0-9]{3,4}){1,2}))$" required>
            </div>

            <h3>Address</h3>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" placeholder="Enter Address" name="address" maxlength="255" pattern="^[0-9]{1,5},?\s\w{2,64}\s\w{2,64},?\s\w{2,64}$">

                <label for="postCode">Postcode:</label>
                <input type="number" size="4" class="form-control" id="postCode" placeholder="Enter Postcode" name="postCode" pattern="^[0-9]{4}$">
            </div>

            <div class="form-group">
                <label for="state">State:</label>
                <select class="form-control" id="state" name="state">
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
