<?php
    //check the password
	function checkPassword($email, $password){
		
		require 'php/pdo.inc';
		try {
			$checkQuery = $pdo->prepare('SELECT * FROM users   
									WHERE email = :email 
									and password = SHA2(CONCAT(:password, salt), 0) ');
			$checkQuery->bindValue(':email',$email);
			//$checkQuery->bindValue(':password',$password);
			$checkQuery->execute();
			echo $email. " and ";//.$password;
			if($checkQuery->rowCount() > 0){
				return true;
			}else{return false;}
		} catch(PDOException $e){
			//Output Error
			echo $e->getMessage();
			echo '<p>'.$e.'</p>';
		}
	}
?>