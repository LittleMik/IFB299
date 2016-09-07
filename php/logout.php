<?php
	session_start();   
	unset($_SESSION['isUser']);
    unset($_SESSION['firstname']);
    unset($_SESSION['userID']);
	header('Location: ../index.php');
	exit();
?>