<header>
	
	<div class = "container-fluid">
		<div class="nav navbar-nav navbar-right">
			<?php     
				if (isset($_SESSION['isUser']))   {  

					echo '
						<li><a href="php/logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>  
						<li><a href="">Hello ', $_SESSION['firstname'], '!</a></li>
					';
				} else {
					echo '
						<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>  
						<li><a href="create-account.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
					';
				}
			?> 
		</div>
	</div>
	
	<div class="container">
		<img id="hero" src="images/icon4.png" alt="hero"/>
	</div>

	<div class="container">

	<!-- Static navbar -->
	<nav class="navbar navbar-default">
		<div class="container-fluid">
		  <div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			  <span class="sr-only">Toggle navigation</span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			  <span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">On The Spot</a>
		  </div>
		  <div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
			  <li class="active"><a href="index.php">Home</a></li>
			  <li><a href="login.php">My Account</a></li>
			  <li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">My Orders <span class="caret"></span></a>
				<ul class="dropdown-menu">
				  <li><a href="#">Tracking</a></li>
				  <li><a href="#">History</a></li>
				</ul>
				<li><a href="create-staff-account.php">Create Staff Account</a></li>
				<li><a href="#">Contact</a></li>
			  </li>
			</ul>
		  </div><!--/.nav-collapse -->
		</div><!--/.container-fluid -->
	</nav>
</header>