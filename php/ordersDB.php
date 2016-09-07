<?php

  require_once 'orders.php';

  function getOrder()
  {
    require_once 'pdo.inc';


    //TO DO
  }

  function createOrders($order)
  {
    require_once 'pdo.inc';
    try
    {

      // Prepare Query
      $stmt = $pdo->prepare(
        "INSERT INTO orders (userID, orderStatus, description, totalWeight, signature, deliveryPriority, pickupAddress, pickupTime, deliveryAddress, recipientName, recipientPhone) VALUES (:userID, :orderStatus, :description, :totalWeight, :signature, :deliveryPriority, :pickupAddress, :pickupTime, :deliveryAddress, :recipientName, :recipientPhone)"
      );

      //Bind query parameter with it's given variable
      $stmt->bindParam(':userID', $order->userID);
      $stmt->bindParam(':orderStatus', $order->status);
      $stmt->bindParam(':description', $order->description);
      $stmt->bindParam(':totalWeight', $order->totalWeight);
      $stmt->bindParam(':signature', $order->signature);
      $stmt->bindParam(':deliveryPriority', $order->priority);
      $stmt->bindParam(':pickupAddress', $order->pickupAddress);
      $stmt->bindParam(':pickupTime', $order->pickupTime);
      $stmt->bindParam(':deliveryAddress', $order->deliveryAddress);
      $stmt->bindParam(':recipientName', $order->deliveryAddress);
      $stmt->bindParam(':recipientPhone', $order->deliveryAddress);

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
