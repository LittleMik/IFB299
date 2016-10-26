<?php

	//Retrieve Dependancies
	require_once 'orders.php';

	/**
	* Search Order
	* Args: $email, $customerName, $priority, $status,
	* $pickupTime
	* Returns PDO Statement
	*/
	function searchOrder($email, $customerName, $priority, $status, $pickupTime, $driverID)
	{
		//Get PDO
		require 'pdo.inc';

		//Identify Search Filters
		$whereConditions = array();
		$filters = array();


		//Check which filters are set
		if(!empty($email))
		{
			$whereConditions[] = " LOWER(users.email) LIKE CONCAT(LOWER(:email),'%')";
			$filters["email"] = $email;
		}
		if(!empty($customerName))
		{
			$whereConditions[] = " LOWER(CONCAT_WS(' ', users.firstName, users.lastName)) LIKE CONCAT(LOWER(:customerName),'%')";
			$filters["customerName"] = $customerName;
		}
		if(!empty($priority))
		{
			$whereConditions[] = " orders.deliveryPriority LIKE :priority";
			$filters["priority"] = $priority;
		}

		if(!empty($driverID))
		{
			$whereConditions[] = " orders.driverID LIKE :driverID";
			$filters["driverID"] = $driverID;
		}

		//Set SQL Where Statement According to Filters
		if(!empty($whereConditions))
		{
			$where = implode(' AND ', $whereConditions);
		}else{
			//Set Empty Where Statement (Accepts all values)
			$where = " users.email LIKE '%'";
		}

		try{
			//Set Query
			$query = "SELECT orders.*, users.firstName, users.lastName, users.email
			FROM orders
			LEFT JOIN users
			ON orders.userID = users.userID
			WHERE $where
			ORDER BY orders.orderID ASC, orders.deliveryPriority DESC";

			$stmt = $pdo->prepare($query);

			//Apply Search Filter Values to Query
			foreach($filters as $filter => $filterVar)
			{
				$stmt->bindValue($filter, $filterVar);
			}

			//Run Query
			$stmt->execute();

			//Return PDO Statmenet
			return $stmt;

		} catch (PDOException $e){
			echo $e->getMessage();
		}
	}

	/**
	* Output Results of Orders Search
	* Args: PDO Statment ResultSet $stmt
	* Echos order results into table
	*/
	function displayOrders($stmt)
	{
		//Output Orders Table
		echo '<table class="table table-striped table-condensed table-responsive">
		<thead>
					<tr>
						<th>ID</th>
						<th>Customer</th>
						<th>Order Overview</th>
						<th>Pickup</th>
						<th>Delivery</th>
						<th>Status</th>
						<th>Options...</th>
					</tr>
				</thead>
			<tbody>';

		//Output each result row as a single order
		foreach($stmt as $order)
		{
			require_once 'php/status.php';
			$orderStatus = Status::getStatusName($order['orderStatus']);
			$assignedDriver = "Not Yet Assigned.";
			if (isset($order['driverID'])){
				require_once 'php/users.php';
				$user = new User();
				$user->getUser($order['driverID']);
				$firstName = $user->getFirstName();
				$lastName = $user->getLastName();
				$assignedDriver = "{$firstName} {$lastName}";
			}
			
			echo "
				<tr>
					<td>{$order['orderID']}</td>
					<td>
						<p>{$order['firstName']} {$order['lastName']}</p>
						<p>{$order['email']}</p>
					</td>
					<td>
						<p>Desc: {$order['description']}</p>
						<p>Type: {$order['deliveryPriority']}</p>
						<p>Assigned Driver: {$assignedDriver}</p>
					</td>
					<td>
						<p>Preferred Time: {$order['pickupTime']}</p>
						<p>Address: {$order['pickupAddress']}</p>
						<p>Postcode: {$order['pickupPostcode']}</p>
						<p>State: {$order['pickupState']}</p>
					</td>
					<td>
						<p>Preferred Time: {$order['deliveryTime']}</p>
						<p>Recipient: {$order['recipientName']}</p>
						<p>Recipient Phone: {$order['recipientPhone']}</p>
						<p>Address: {$order['deliveryAddress']}</p>
						<p>Postcode: {$order['deliveryPostcode']}</p>
						<p>State: {$order['deliveryState']}</p>
					</td>
					<td>{$orderStatus}</td>";
					

			//Verify User Permission to Edit Orders
			require_once 'php/permissions.php';

			if(isset($_SESSION['role']))
			{
				if(checkPermission($_SESSION['role'], 'edit-order.php') === true)
				{
					echo "<td>
							<p><a class='btn btn-info' href='edit-order.php?orderID={$order['orderID']}'>Edit</a></p>
							<p><a class='btn btn-info' href='driver.php?orderID={$order['orderID']}&orderStatus={$order['orderStatus']}'>Update Order Status</a></p>
							<p><a class='btn btn-info' href='view-order.php?orderID={$order['orderID']}'>View</a></p>
							<p><a class='btn btn-info' href='assign-driver.php?orderID={$order['orderID']}'>Assign Driver</a></p>
						</td>";
				} else if(checkPermission($_SESSION['role'], 'driver-ui') === true) {
					echo "<td>
							<p><a class='btn btn-info' href='driver.php?orderID={$order['orderID']}&orderStatus={$order['orderStatus']}'>Update Status</a></p>
							<p><a class='btn btn-info' href='view-order.php?orderID={$order['orderID']}'>View</a></p>
						</td>";
				} else {
					echo "<td>
							<p><a class='btn btn-info' href='view-order.php?orderID={$order['orderID']}'>View</a></p>
						</td>";
				}
			}

			echo "

				</tr>
			";
		}

		//Close table tag
		echo "
			</tbody>
		</table>";
	}

	//Display inputs for the packages in the order.
	function displayPackageInputs($packages)
	{
		//Output Inputs for Each Package in Packages array
		foreach($packages as $package)
		{
			echo '
			<!--Packages
				Code for adding extra packages is in customJavascript.hs
			-->
			<div class="input_fields_wrap">
				<div>
					<div class="form-group">
						<label for="comment">Package Description:</label>
						<input value = "'.$package->getDescription().'"type="text" class="form-control" id="package-description" maxlength="50" name="packageDescription[]" required></textarea>*max 50 characters
					</div>
					<div class="form-group">
						<label for="weight">Package Weight:</label>
						<input value="'.$package->getWeight().'" type="text" class="form-control" id="package-weight" maxlength="50" name="weight[]" required></textarea>*max 50 characters
					</div>
					<input type="hidden" name="hiddenPackageID[]" value="'.$package->getID().'">
				</div>
			</div>
			';
		}
	}

	function updateStatus($orderID, $status)
	{
		//Get PDO
		require 'pdo.inc';

		try{
			// Prepare Query
			$stmt = $pdo->prepare(
			"UPDATE orders
			SET orderStatus = :orderStatus
			WHERE orderID = :orderID;"
			);

			//Bind values
			$stmt->bindValue(':orderStatus', $status);
			$stmt->bindValue(':orderID', $orderID);

			//Run Query
			$result = $stmt->execute();

			//Close connection
			$stmt = null;
			//Destroy PDO Object
			$pdo = null;

			//Return Result of Statement
			return $result;

		} catch (PDOException $e){
			echo $e->getMessage();
		}
	}
?>
