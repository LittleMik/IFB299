<?php
	/**
	* Get Payment for Order
	* Args: Integer $orderID
	* Returns PDO Statement
	*/
	function getPayment($orderID)
	{
		//Get PDO
		require 'pdo.inc';

		try{
			//Set Query
			$query = "SELECT payments.*, users.firstName, users.lastName
			FROM payments
			LEFT JOIN users
			ON payments.userID = users.userID
			WHERE orderID = :orderID limit 1";

			$stmt = $pdo->prepare($query);

			//Bind orderID value
			$stmt->bindValue(':orderID', $orderID);

			//Run Query
			$stmt->execute();

			//Return Statement
			return $stmt;

		} catch (PDOException $e){
			echo $e->getMessage();
		}
	}
	
	/**
	* Add Payment to Payments table
	* Args: Integer $orderID, Integer $userID, String $type, DateTime $date,  $amount
	* Returns true if insertion successful, false if failed
	*/
	function addPayment($orderID, $userID, $type, $date, $amount)
	{
		require 'pdo.inc';
		try
		{
			// Prepare Query
			$stmt = $pdo->prepare(
			"INSERT INTO payments (orderID, userID, paymentType, paymentDate, paymentAmount)
			VALUES (:orderID, :userID, :paymentType, :paymentDate, :paymentAmount)");

			//Bind query parameter with it's given variable
			$stmt->bindParam(':orderID', $orderID);
			$stmt->bindParam(':userID', $userID);
			$stmt->bindParam(':paymentType', $type);
			$stmt->bindParam(':paymentDate', $date);
			$stmt->bindParam(':paymentAmount', $amount);

			//Run query
			$result = $stmt->execute();
			//Close connection
			$stmt = null;
			//Destroy PDO Object
			$pdo = null;

			return $result;

		}catch(PDOException $e){
			//Output Error
			echo $e->getMessage();
			echo '<p>'.$e.'</p>';
		}
	}
?>
