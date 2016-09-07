<?php
    //check the password
	function checkPassword($email, $password){
		require 'php/pdo.inc';
		$checkQuery = $pdo->prepare('SELECT * FROM users   
								WHERE email = :email and
								password = SHA2(CONCAT(:password, Salt), 0) ');
		$checkQuery->bindValue(':email',$email);
		$checkQuery->bindValue(':password',$password);
		$checkQuery->execute();
		if($checkQuery->rowCount() > 0){
			return true;
		}else{return false;}
	}
	
?>