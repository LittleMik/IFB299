<?php

  require_once 'users.php';

  function login()
  {
    require_once 'pdo.inc';


    //TO DO
  }

  function verifyPassword($email, $password)
  {
    require_once 'pdo.inc';

    // Prepare Query
    $stmt = $pdo->prepare(
      "SELECT * FROM users WHERE email = :email and	password = SHA2(CONCAT(:password, Salt), 0)"
    );

    $stmt->bindParam(':email', $email);
    $stmt->bindParam('')
  }

  function createUser($user)
  {
    require_once 'pdo.inc';
    try
    {
      // Prepare Query
      $stmt = $pdo->prepare(
        "INSERT INTO users (email, password, salt, firstName, lastName, phoneNumber, address, postcode, state) VALUES (:email, SHA2(CONCAT(:password, :salt), 0), :salt, :firstName, :lastName, :phoneNumber, :address, :postcode, :state)"
      );

      //Bind query parameter with it's given variable
      $stmt->bindParam(':email', $user->email);
      $stmt->bindParam(':password', $user->password);
      $stmt->bindParam(':salt', $user->salt);
      $stmt->bindParam(':firstName', $user->firstName);
      $stmt->bindParam(':lastName', $user->lastName);
      $stmt->bindParam(':phoneNumber', $user->phone);
      $stmt->bindParam(':address', $user->address);
      $stmt->bindParam(':postcode', $user->postCode);
      $stmt->bindParam(':state', $user->state);

      //Run query
      $stmt->execute();

      //Close connection
      $stmt = null;
      //Destroy PDO Object
      $pdo = null;

    }catch(PDOException $e){

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
