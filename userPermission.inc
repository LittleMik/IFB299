<?php    
	if (!isset($_SESSION['isUser']))   {    
		header('Location: login.php?location='.urlencode($_SERVER['REQUEST_URI']));    
		exit();  
	}  
?> 