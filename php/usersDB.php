<?php

  require_once 'users.php';

  function login($email)
  {
    require 'pdo.inc';
    try
    {
      $stmt = $pdo->prepare(
        "SELECT userID, email, firstName, lastName, phoneNumber, address, postcode, state FROM users WHERE email = :email limit 1"
      );

      $stmt->bindValue(':email', $email);

      $stmt->execute();

      $userInfo = $stmt->fetch();

      require_once 'php/users.php';

      $user = new User(
        $userInfo['userID'],
        $userInfo['email'],
        $userInfo['firstName'],
        $userInfo['lastName'],
        $userInfo['phoneNumber'],
		getRole($userInfo['userID']),
        $userInfo['address'],
        $userInfo['postcode'],
        $userInfo['state']
      );

      $_SESSION['login'] = true;
      $_SESSION['firstname'] = $userInfo['firstName'];
      $_SESSION['user'] = serialize($user);
      $_SESSION['role'] = getRole($userInfo['userID']);

    } catch (PDOException $e){

      echo $e->getMessage();

      unset($_SESSION['login']);
      unset($_SESSION['firstname']);
      unset($_SESSION['user']);
      unset($_SESSION['role']);

    }
  }
  
  function loginWithID($userID)
  {
    require 'pdo.inc';
    try
    {
      $stmt = $pdo->prepare(
        "SELECT userID, email, firstName, lastName, phoneNumber, address, postcode, state FROM users WHERE userID = :userID limit 1"
      );

      $stmt->bindValue(':userID', $userID);

      $stmt->execute();

      $userInfo = $stmt->fetch();

      require_once 'php/users.php';

      $user = new User(
        $userInfo['userID'],
        $userInfo['email'],
        $userInfo['firstName'],
        $userInfo['lastName'],
        $userInfo['phoneNumber'],
		getRole($userInfo['userID']),
        $userInfo['address'],
        $userInfo['postcode'],
        $userInfo['state']
      );

      $_SESSION['login'] = true;
      $_SESSION['firstname'] = $userInfo['firstName'];
      $_SESSION['user'] = serialize($user);
      $_SESSION['role'] = getRole($userInfo['userID']);

    } catch (PDOException $e){

      echo $e->getMessage();

      unset($_SESSION['login']);
      unset($_SESSION['firstname']);
      unset($_SESSION['user']);
      unset($_SESSION['role']);

    }
  }

  function getRole($userID)
  {
    try
    {
      require 'pdo.inc';
      $stmt = $pdo->prepare(
        "SELECT * FROM roles WHERE userID = :userID limit 1"
      );

      $stmt->bindValue(':userID', $userID);
      $stmt->execute();

      $result = $stmt->fetch();

      return $result['role'];
      
    } catch (PDOException $e){
      echo $e->getMessage();
      return 0;
    }
  }

  function verifyPassword($email, $password)
  {
    require_once 'pdo.inc';
		try
    {

			$checkQuery = $pdo->prepare(
				'SELECT * FROM users
				WHERE email = :email
				AND password = SHA2(CONCAT(:password, salt), 0) '
			);

			$checkQuery->bindValue(':email',$email);
			$checkQuery->bindValue(':password',$password);
			$checkQuery->execute();

			if($checkQuery->rowCount() > 0){
				return true;
			}else{return false;}

		} catch(PDOException $e){

			//Output Error
			echo $e->getMessage();
			echo '<p>'.$e.'</p>';

		}
  }

  

  function updateRole($user)
  {
    require_once 'pdo.inc';
    try {

    } catch (PDOException $e) {

      //Output Error
      echo $e->getMessage();
			echo '<p>'.$e.'</p>';

    }


  }
?>
