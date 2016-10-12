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
	* Output Payment information for Order
	* Args: PDO Statment ResultSet $stmt
	* Echos payment result into table
	*/
	function displayPayment($stmt)
	{
		if($stmt->rowCount() == 0)
		{
			if(isset($_SESSION['role']))
			{
				if(checkPermission($_SESSION['role'], 'payments-add') === true)
				{
					echo "<a href='payment.php?orderID={$_GET['orderID']}' class='btn1btn-default'>Add Payment</a>";
				}
			}
		}else{
			//Fetch Payment
			$payment = $stmt->fetch();

			//Output Payment Results
			echo '
				<h3>Payment</h3>
				<table class="table table-striped table-condensed table-responsive">
					<thead>
						<tr>
							<th>Payment ID</th>
							<th>Customer</th>
							<th>Type</th>
							<th>Date</th>
							<th>Amount</th>
						</tr>
					</thead>';

			//Output each result row as a single order
			echo "
				<tbody>
					<tr>
						<td>{$payment['paymentID']}</td>
						<td>
							<p>{$payment['firstName']} {$payment['lastName']}</p>
						</td>
						<td>{$payment['paymentType']}</td>
						<td>{$payment['paymentDate']}</td>
						<td>{$payment['paymentAmount']}</td>
					</tr>
				</tbody>";

			//Close table tag
			echo "</table>";
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
