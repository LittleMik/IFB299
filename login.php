<?php require 'includes/head.inc' ?>

	<!--
     <div class="container">

      <!-- Static old navbar --
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">On The Spot</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#">My Account</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Orders <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Tracking</a></li>
                  <li><a href="#">History</a></li>
                </ul>
                <li><a href="#">Contact</a></li>
              </li>
            </ul>
          </div><!--/.nav-collapse --
        </div><!--/.container-fluid --
      </nav> -->

      <!-- Main component for a primary marketing message or call to action -->
<!--      <div class="jumbotron">
        <h1>Navbar example</h1>
        <p>This example is a quick exercise to illustrate how the default, static navbar and fixed to top navbar work. It includes the responsive CSS and HTML, so it also adapts to your viewport and device.</p>
        <p>
          <a class="btn btn-lg btn-primary" href="../../components/#navbar" role="button">View navbar docs &raquo;</a>
        </p>
      </div>
-->

    <!--</div> <!-- /container -->

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
