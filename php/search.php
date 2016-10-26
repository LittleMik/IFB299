<?php
	/**
	* Search Order
	* Args: $email, $customerName, $priority, $status,
	* $pickupTime
	* Returns PDO Statement
	*/
	function searchOrder($email, $customerName, $priority, $status, $pickupTime)
	{
		//Create new database connection
		require_once 'database.php';
		$db = new Database();

		//Identify Search Filters
		$whereConditions = array();
		$parameters = array();

		//Check which filters are set
		if(!empty($email))
		{
			$whereConditions[] = " LOWER(users.email) LIKE CONCAT(LOWER(:email),'%')";
			$parameters["email"] = $email;
		}
		if(!empty($customerName))
		{
			$whereConditions[] = " LOWER(CONCAT_WS(' ', users.firstName, users.lastName)) LIKE CONCAT(LOWER(:customerName),'%')";
			$parameters["customerName"] = $customerName;
		}
		if(!empty($priority))
		{
			$whereConditions[] = " orders.deliveryPriority LIKE :priority";
			$parameters["priority"] = $priority;
		}

		//Set SQL Where Statement According to Filters
		if(!empty($whereConditions))
		{
			$where = implode(' AND ', $whereConditions);
		}else{
			//Set Empty Where Statement (Accepts all values)
			$where = " users.email LIKE '%'";
		}

		//Set Query
		$query = "SELECT orders.*, users.firstName, users.lastName, users.email
		FROM orders
		LEFT JOIN users
		ON orders.userID = users.userID
		WHERE {$where}
		ORDER BY orders.orderID ASC, orders.deliveryPriority DESC";

		//Get Order from Database
		$stmt = $db->select_statement($query, $parameters);

		//Destroy Database Connection
		$db->destroy_pdo();
		unset($db);

		//Return Results
		return $stmt;
	}

	/**
	* Search Assigned Order
	* Args: $email, $customerName, $priority, $status,
	* $pickupTime
	* Returns PDO Statement
	*/
	function searchAssignedOrder($driverID, $email, $customerName, $priority, $status, $pickupTime)
	{
		//Create new database connection
		require_once 'database.php';
		$db = new Database();

		//Identify Search Filters
		$whereConditions = array();
		$parameters = array();

		//Check which filters are set
		if(!empty($email))
		{
			$whereConditions[] = " LOWER(users.email) LIKE CONCAT(LOWER(:email),'%')";
			$parameters["email"] = $email;
		}
		if(!empty($customerName))
		{
			$whereConditions[] = " LOWER(CONCAT_WS(' ', users.firstName, users.lastName)) LIKE CONCAT(LOWER(:customerName),'%')";
			$parameters["customerName"] = $customerName;
		}
		if(!empty($priority))
		{
			$whereConditions[] = " orders.deliveryPriority LIKE :priority";
			$parameters["priority"] = $priority;
		}

		//Set SQL Where Statement According to Filters
		if(!empty($whereConditions))
		{
			$where = implode(' AND ', $whereConditions);
		}else{
			//Set Empty Where Statement (Accepts all values)
			$where = " users.email LIKE '%'";
		}

		//Set Query
		$query = "SELECT orders.*, users.firstName, users.lastName, users.email
		FROM orders
		LEFT JOIN users
		ON orders.userID = users.userID
		WHERE {$where}
		ORDER BY orders.orderID ASC, orders.deliveryPriority DESC";

		//Get Order from Database
		$stmt = $db->select_statement($query, $parameters);

		//Destroy Database Connection
		$db->destroy_pdo();
		unset($db);

		//Return Results
		return $stmt;
	}
?>
