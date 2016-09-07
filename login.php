<!DOCTYPE html>
<html class="skrollr skrollr-desktop">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="stylesheet" href="css/style.css">

    <title>On the Spot Package Delivery | Login</title>
    <!-- Sign in-->
    <link href="bootstrap-3.3.7/docs/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-3.3.7/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="bootstrap-3.3.7/docs/examples/signin/signin.css" rel="stylesheet">
    <script src="bootstrap-3.3.7/docs/assets/js/ie-emulation-modes-warning.js"></script>
    <!-- Sign in-->
    
    
<!--Nav-->
   <link href="bootstrap-3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap-3.3.7/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bootstrap-3.3.7/docs/examples/navbar/navbar.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="bootstrap-3.3.7/docs/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="bootstrap-3.3.7/docs/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
        
<!--Nav-->
    </head>
  
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
	
	<!--Handle login-->
	<?php
		session_start();
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$email = $_POST['yourEmail'];
			require 'php/verifyPassword.php';
			if (checkPassword($_POST['yourEmail'], $_POST['yourPassword'])){
				$_SESSION['isUser'] = true;

				//Get Firstname
				try{
					require 'php/pdo.inc';
					$getInfoQuery = $pdo->prepare('SELECT firstName, userID FROM users   
										WHERE email = :email limit 1');
					$getInfoQuery->bindValue(':email',$_POST['yourEmail']);
					$getInfoQuery->execute();

					$userInfo = $getInfoQuery->fetch();
					$_SESSION['firstname'] = $userInfo['firstName'];
					$_SESSION['userID'] = $userInfo['userID'];
				} catch (PDOException $e){
					echo $e->getMessage(); 
				}
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

	<?php include'header.inc'?>
	
	<section id="login">
	  <div class="container">

		<form method="POST" class="form-signin">
		  <h2 class="form-signin-heading">Log in</h2>
		  <div id="error"></div>
		  <label for="inputEmail" class="sr-only">Email address</label>
		  <input type="email" name="yourEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
		  
		  <label for="inputPassword" class="sr-only">Password</label>
		  <input type="password" name="yourPassword" id="inputPassword" class="form-control" placeholder="Password" required>
		  
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
