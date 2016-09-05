<?php
  require_once 'pdo.inc';
  require_once 'user.php';

  function login()
  {
    //TO DO
  }

  function createUser($user)
  {
    try
    {
      // Prepare Query
      $stmt = $pdo->prepare(
        "INSERT INTO users (email, password, salt, role, firstName, lastName, phoneNumber, streetAddress, postCode, state) VALUES (:email, SHA2(CONCAT(:password), :salt), 0), :salt, :firstname, :lastname, :phone, :address, :postCode, :state"
      );

      //Bind query parameter with it's given variable
      $stmt->bind_param(':email', $user->email);
      $stmt->bind_param(':password', $user->password);
      $stmt->bind_param(':salt', $user->salt);
      $stmt->bind_param(':firstName', $user->firstName);
      $stmt->bind_param(':lastName', $user->lastName);
      $stmt->bind_param(':phone', $user->phone);
      $stmt->bind_param(':address', $user->address);
      $stmt->bind_param(':postCode', $user->postCode);
      $stmt->bind_param(':state', $user->state);

      //Run query
      $stmt->execute();

      //Close connection
      $stmt->close();
      $pdo->close();

    }catch(PDOException $e){

			//Output Error
			echo $e->getMessage();
			echo '<p>'.$e.'</p>';

		}
  }
 ?>
