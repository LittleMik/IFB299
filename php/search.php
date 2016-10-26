<?php
	/**
	* Search Order
	* Searches the orders table according to the set parameters
	*
	* @param (String) $email order Customer's email
	* @param (String) $customerName Fullname of the order's customer
	* @param (String) $priority Standard or Express type
	* @param (integer) $status Order's status
	* @param (timestamp) $pickupTime PickupTime of the Order
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
	* Search Order
	* Searches the orders table according to the set parameters
	*
	* @param (integer) $driverID assigned driver ID for the order
	* @param (String) $email order Customer's email
	* @param (String) $customerName Fullname of the order's customer
	* @param (String) $priority Standard or Express type
	* @param (integer) $status Order's status
	* @param (timestamp) $pickupTime PickupTime of the Order
	*/
	function searchAssignedOrder($email, $customerName, $priority, $status, $pickupTime, $driverID)
	{
		//Create new database connection
		require_once 'database.php';
		$db = new Database();

		//Identify Search Filters

		//Set Default Where Condition and Bind Parameters
		$whereConditions[] = " orders.driverID = :driverID";
		$parameters[':driverID'] = $driverID;

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
