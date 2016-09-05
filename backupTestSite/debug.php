<?php
	if (isset($_POST['yourEmail']))
	{
		require 'verifyPassword.php';
		if (checkPassword($_POST['yourEmail'], $_POST['yourPassword'])){
			session_start(); $_SESSION['isAdmin'] = true;
            echo 'You Are logged in!';
			/*header("Location: http://{$_SERVER['HTTP_HOST']}/Webcode/index.php");
			exit();*/
		}else{echo 'password is incorrect';}
	}
?>