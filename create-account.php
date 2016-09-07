<?php require 'includes/head.inc' ?>

<body>
    <?php require 'includes/validate-and-create-account.inc' ?>

	<?php include 'includes/header.inc' ?>

    <div class="container">
        <h2>Create an Account</h2>

        <form method="post" autocomplete="on" onsubmit="return validate(this)" action="<?php echo "https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];?>">
            <input type="hidden" id="ID" name="ID" value="">
			
			<div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter Email Address" name="email" maxlength="255" required>
            </div>

            <div class="form-group">
                <label for="password">Password: (must be over 8 characters containing letter and numbers)</label>
				<!--Doesn't accept simple passwords pattern="(?=.*[a-zA-Z])(?=.*\d).{8,255}" -->
                <input id="password" class="form-control" placeholder="Password" type="password" name="password" maxlength="255" required>

                <label for="confirmPassword">Confirm Password:</label>
				<!--Doesn't accept simple passwords pattern="(?=.*[a-zA-Z])(?=.*\d).{8,255}" -->
                <input id="confirmPassword" class="form-control" placeholder="Confirm Password" type="password" name="confpassword" oninput="check(this);" required>
            </div>

            <h3>Personal Details</h3>

            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input type="text" class="form-control" id="firstName" name="firstName" maxlength="255" pattern="^\w{2,255}(?!=\W)$" required>

                <label for="lastName">Last Name:</label>
                <input type="text" class="form-control" id="lastName" name="lastName" maxlength="255" pattern="^\w{2,255}(?!=\W)$" required>

				<input type="hidden" id="role" name="role" value="0">
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
