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
					echo "<a href='payment.php?orderID={$_GET['orderID']}' class='btnbtn-default'>Add Payment</a>";
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
?>
