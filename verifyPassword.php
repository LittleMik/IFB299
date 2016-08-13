<?php
    //check the password
	function checkPassword($email, $password){
		require 'pdo.inc';
		$checkQuery = $pdo->prepare('SELECT * FROM members   
								WHERE Email = :email and
								Password = SHA2(CONCAT(:password, Salt), 0) ');
		$checkQuery->bindValue(':email',$email);
		$checkQuery->bindValue(':password',$password);
		$checkQuery->execute();
		if($checkQuery->rowCount() > 0){
			return true;
		}else{return false;}
	}
	
?>