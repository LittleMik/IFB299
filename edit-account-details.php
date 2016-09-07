
<?php require 'includes/head.inc' ?>

<?php
  if(!isset($_SESSION['login']))
  {
    header("Location:login.php");
  }
?>

<body>
	<?php require 'php/userCreation.php' ?>

    <?php
		require_once 'php/users.php';
		$thisUser = unserialize($_SESSION['user']);
		require 'php/userCreation.php'
	?>

	<?php include 'includes/header.inc' ?>

    <div class="container">
        <h2>Edit your Account</h2>

        <form method="post" autocomplete="on" onsubmit="return validate(this)" action="<?php echo "https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];?>">
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" class="form-control" id="email" value="<?php echo $thisUser->email ?>" name="email" maxlength="255" required>
            </div>

			<input type="hidden" id="ID" name="ID" value= "<?php echo $thisUser->id ?>" >

			<input type="hidden" id="password" name="password" value= "unknownPassword1" >

			<input type="hidden" id="confirmPassword" name="confpassword" value= "unknownPassword1" >

            <h3>Personal Details</h3>

            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" class="form-control" id="firstName" value="<?php echo $thisUser->firstName ?>" name="firstName" maxlength="255" pattern="^\w{2,255}(?!=\W)$" required>

                <label for="lastName">Last Name:</label>
                <input type="text" class="form-control" id="lastName" value="<?php echo $thisUser->lastName ?>" name="lastName" maxlength="255" pattern="^\w{2,255}(?!=\W)$" required>

				<input type="hidden" id="role" name="role" value="0">
            </div>

            <h3>Phone Number</h3>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" class="form-control" id="phone" value="<?php echo $thisUser->phone ?>" name="phone"  maxlength="16" pattern="^(?:\(\+?[0-9]{2}\))?(?:[0-9]{6,10}|[0-9]{3,4}(?:(?:\s[0-9]{3,4}){1,2}))$" required>
            </div>

            <h3>Address</h3>

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" <?php $attribute = ($thisUser->address == "") ? "placeholder = 'Enter Address'" : "value = '".$thisUser->address."'"; echo $attribute; ?> name="address" maxlength="255" pattern="^[0-9]{1,5},?\s\w{2,64}\s\w{2,64},?\s\w{2,64}$">

                <label for="postCode">Postcode:</label>
                <input type="number" size="4" class="form-control" id="postCode" <?php $attribute = ($thisUser->postcode == "") ? "placeholder = 'Enter Address'" : "value = '".$thisUser->postcode."'"; echo $attribute; ?> name="postCode" pattern="^[0-9]{4}$">
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

            <button type="submit" class="btn btn-default">Save and Submit</button>

        </form>
    </div>
</body>
</html>
