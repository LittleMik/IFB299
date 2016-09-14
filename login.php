<?php require 'includes/head.inc' ?>

	<body>
	<!--the header, see the file for the code-->
	<?php include 'includes/header.inc' ?>

	<!--Handle login-->
	<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){

			$email = $_POST['email'];
			$password = $_POST['password'];

			require 'php/usersDB.php';
			
			if (verifyPassword($email, $password)){

				//Login and set session variables
				login($email);

				//Redirect Script
				echo "
					<script>
						window.location.href = 'index.php';
					</script>";

			}else{
				echo'
				<script>
					window.onload = function var1() {
						document.getElementById(\'error\').innerHTML = \'Your username or password is incorrect!\';
					};
				</script>';
			}
		}
	?>

	<section id="login">
	  <div class="container">
		<form method="POST" class="form-signin">
		  <h2 class="form-signin-heading">Log in</h2>
		  <div id="error"></div>
		  <label for="inputEmail" class="sr-only">Email address</label>
		  <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>

		  <label for="inputPassword" class="sr-only">Password</label>
		  <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>

		  <div class="checkbox">
			<label>
			  <input type="checkbox" value="remember-me"> Remember me
			</label>

		  </div>
		  <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
		  <br>
		</form>

		 <a href="create-account.php">Create an account?</a> | <a href"">Forgotten Password?</a>

	  </div> <!-- /container -->
	</section>


  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="bootstrap-3.3.7/docs/assets/js/ie10-viewport-bug-workaround.js"></script>

  <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="bootstrap-3.3.7/docs/assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="bootstrap-3.3.7/docs/dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="bootstrap-3.3.7/docs/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
