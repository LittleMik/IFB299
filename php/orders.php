<?php
	// ======================================== Order Class ======================================== //
	/**
	*	Order Class
	*
	*	Contains details for orders and functionality to send and retrieve
	* order relevant information from the MySQL databse
	*
	*	@author Michael Smallcombe & Greg Mills
	*/
	// ============================================================================================= //
	class Order
	{

		private $orderID;
		private $userID;
		private $status;
		private $description;
		private $signature;
		private $priority;

		private $pickupDetails;

		private $deliveryDetails;

		private $recipientName;
		private $recipientPhone;

		// ==================== Constructor ==================== //
		/**
		 * Constructor
		 *
		 * Precondition: Argument must be either user table row
		 * or a verified set of client order information
		 *
		 */
		function __construct()
		{
			//Construct Order according to the arguments provided
			if(func_num_args() !== 0)
			{
				//Import Status
				require_once 'status.php';

				//Get Args
				$args = func_get_args();

				//Construct NEW Order
				//Order Details
				$this->orderID = $args[0];
				$this->userID = $args[1];
				$this->status = $args[2];
				$this->description = $args[3];
				$this->signature = $args[4];
				$this->priority = $args[5];

				//Pickup Details
				$this->pickupDetails = array(
					'address' => $args[6],
					'postcode' => $args[7],
					'state' => $args[8],
					'time' => $args[9]
				);

				//Delivery Details
				$this->deliveryDetails = array(
					'address' => $args[10],
					'postcode' => $args[11],
					'state' => $args[12],
					'time' => $args[13]
				);

				//Recipient
				$this->recipientName = $args[14];
				$this->recipientPhone = $args[15];

				//Set Default Status
				$this->status = Status::Ordered;
			}
		}

		// ==================== Getters ==================== //
		/**
		* Get ID
		* Returns integer order's ID
		*
		* @return (integer) Contains the order's ID
		*/
		function getID()
		{
			return $this->orderID;
		}
		/**
		* Get UserID
		* Returns integer of userID assigned to the order
		*
		* @return (integer) Contains the user's ID
		*/
		function getUserID()
		{
			return $this->userID;
		}
		/**
		* Get Status
		* Returns the order's current status
		*
		* @return (integer) Contains the order's status
		*/
		function getStatus()
		{
			return $this->status;
		}
		/**
		* Get Description
		* Returns order's description
		*
		* @return (String) Contains the order's description
		*/
		function getDescription()
		{
			return $this->description;
		}
		/**
		* Get Signature
		* Returns order's signature required property
		*
		* @return (integer) Used as a binary value to indicate the order's signature requirement
		*/
		function getSignature()
		{
			return $this->signature;
		}
		/**
		* Get Priority
		* Returns order's priority type
		*
		* @return (String) Contains the order's priority type
		*/
		function getPriority()
		{
			return $this->priority;
		}
		/**
		* Get Pickup Details
		* Returns array containing order's pickup details
		*
		* @return (array) Contains the order's pickup information
		*/
		function getPickup()
		{
			return $this->pickupDetails;
		}
		/**
		*	Get Delivery Details
		*	Returns array containing order's delivery details
		*
		* @return (array) Contains the order's delivery information
		*/
		function getDelivery()
		{
			return $this->deliveryDetails;
		}
		/**
		*	Get Recipient
		*	Returns orders's recipient name
		*
		* @return (String) Contains the order's recipient name
		*/
		function getRecipient()
		{
			return $this->recipientName;
		}
		/**
		*	Get Recipient Phone
		*	Returns order's recipient phone number
		*
		* @return (String) Contains the order recipient's phone number
		*/
		function getRecipientPhone()
		{
			return $this->recipientPhone;
		}

		// ==================== Database Functions ==================== //
		/**
		* Create Order
		*	Creates a new entry in the Orders table for the given order
		*
		*/
		function createOrder()
		{
			//Create new database connection
			require_once 'database.php';
			$db = new Database();

			//Set Insert Query
			$queryOrders = "INSERT INTO orders (
			userID,
			orderStatus,
			description,
			signature,
			deliveryPriority,
			pickupAddress,
			pickupPostcode,
			pickupState,
			pickupTime,
			deliveryAddress,
			deliveryPostcode,
			deliveryState,
			deliveryTime,
			recipientName,
			recipientPhone)

			VALUES (
				:userID,
				:orderStatus,
				:description,
				:signature,
				:deliveryPriority,
				:pickupAddress,
				:pickupPostcode,
				:pickupState,
				:pickupTime,
				:deliveryAddress,
				:deliveryPostcode,
				:deliveryState,
				:deliveryTime,
				:recipientName,
				:recipientPhone);";

			//Populate Parameters List
			$parametersOrders = array(
				':userID' => $this->userID,
				':orderStatus' => $this->status,
				':description' => $this->description,
				':signature' => $this->signature,
				':deliveryPriority' => $this->priority,
				':pickupAddress' => $this->pickupDetails['address'],
				':pickupPostcode' => $this->pickupDetails['postcode'],
				':pickupState' => $this->pickupDetails['state'],
				':pickupTime' => $this->pickupDetails['time'],
				':deliveryAddress' => $this->deliveryDetails['address'],
				':deliveryPostcode' => $this->deliveryDetails['postcode'],
				':deliveryState' => $this->deliveryDetails['state'],
				':deliveryTime' => $this->deliveryDetails['time'],
				':recipientName' => $this->recipientName,
				':recipientPhone' => $this->recipientPhone
			);

			//Run Insert Statment for Orders
			$db->update_statement($queryOrders, $parametersOrders);

			//Get ID of new row
			$lastID = $db->__get('lastID');

			//Get time
			date_default_timezone_set('Australia/Brisbane');

			$time = date('Y-m-d H:i:s');
			$timestamp = str_replace(' ', 'T', $time);

			//Add new entry to milestones database
			$queryMilestones = "INSERT into milestones (
					orderID,
					orderTime
				)
				VALUES (
					:orderID,
					:orderTime
				);";

			$parametersMilestones = array(
				':orderID' => $lastID,
				':orderTime' => $timestamp,
			);

			//Run Insert Statment for Milestones
			$db->update_statement($queryMilestones, $parametersMilestones);

			//Destroy Database Connection
			$db->destroy_pdo();
			unset($db);

			//Return ID
			return $lastID;
		}

		/**
		* Edit Order
		*	Updates Orders table entry for the corresponding orderID
		*
		*/
		function editOrder()
		{
			//Create new database connection
			require_once 'database.php';
			$db = new Database();

			//Set Update Query
			$query = "UPDATE orders
				SET userID = :userID,
				description = :description,
				signature = :signature,
				deliveryPriority = :deliveryPriority,
				pickupAddress = :pickupAddress,
				pickupPostcode = :pickupPostcode,
				pickupState = :pickupState,
				pickupTime = :pickupTime,
				deliveryAddress = :deliveryAddress,
				deliveryPostcode = :deliveryPostcode,
				deliveryState = :deliveryState,
				deliveryTime = :deliveryTime,
				recipientName = :recipientName,
				recipientPhone = :recipientPhone
				WHERE orderID = :orderID;";

			//Populate Parameters List
			$parameters = array(
				':userID' => $this->userID,
				':description' => $this->description,
				':signature' => $this->signature,
				':deliveryPriority' => $this->priority,
				':pickupAddress' => $this->pickupDetails['address'],
				':pickupPostcode' => $this->pickupDetails['postcode'],
				':pickupState' => $this->pickupDetails['state'],
				':pickupTime' => $this->pickupDetails['time'],
				':deliveryAddress' => $this->deliveryDetails['address'],
				':deliveryPostcode' => $this->deliveryDetails['postcode'],
				':deliveryState' => $this->deliveryDetails['state'],
				':deliveryTime' => $this->deliveryDetails['time'],
				':recipientName' => $this->recipientName,
				':recipientPhone' => $this->recipientPhone,
				':orderID' => $this->orderID
			);

			//Run Update Statment
			$db->update_statement($query, $parameters);

			//Get ID of updated row
			$lastID = $db->__get('lastID');

			//Destroy Database Connection
			$db->destroy_pdo();
			unset($db);

			//Return ID
			return $lastID;
		}

		/**
		* Update the Order's Status
		* Updates the order object's status to the database and
		* sends a notification of the change to the order's creator
		*
		* @param (integer) $status New order Status
		*/
		function updateStatus($status)
		{
			//Create new database connection
			require_once 'database.php';
			$db = new Database();

			//Set Update Query
			$query = "UPDATE orders
				SET orderStatus = :orderStatus
				WHERE orderID = :orderID;";

			$parameters = array(
				':orderStatus' => $status,
				':orderID' => $this->orderID
			);

			//Run Update Statment
			$db->update_statement($query, $parameters);

			//Get time
			date_default_timezone_set('Australia/Brisbane');

			$time = date('Y-m-d H:i:s');
			$timestamp = str_replace(' ', 'T', $time);

			//Add new entry to milestones database

			//Set Query and Parameters
			$queryMilestones = "";
			$parametersMilestones[':orderID'] = $this->orderID;

			//Adjust the query and parameters according to status
			require_once 'status.php';
			switch ($status)
			{
				case Status::Ordered:
					//Set Query
					$queryMilestones = "UPDATE milestones SET orderTime = :orderTime WHERE orderID = :orderID";
					//Add Parameters to list
					$parametersMilestones[':orderTime'] = $timestamp;
					break;
				case Status::PickingUp:
					//Set Query
					$queryMilestones = "UPDATE milestones SET pickingupTime = :pickingupTime WHERE orderID = :orderID";
					//Add Parameters to list
					$parametersMilestones[':pickingupTime'] = $timestamp;
					break;
				case Status::PickedUp:
					//Set Query
					$queryMilestones = "UPDATE milestones SET pickedupTime = :pickedupTime WHERE orderID = :orderID";
					//Add Parameters to list
					$parametersMilestones[':pickedupTime'] = $timestamp;
					break;
				case Status::Storing:
					//Set Query
					$queryMilestones = "UPDATE milestones SET storingTime = :storingTime WHERE orderID = :orderID";
					//Add Parameters to list
					$parametersMilestones[':storingTime'] = $timestamp;
					break;
				case Status::Delivering:
					//Set Query
					$queryMilestones = "UPDATE milestones SET deliveringTime = :deliveringTime WHERE orderID = :orderID";
					//Add Parameters to list
					$parametersMilestones[':deliveringTime'] = $timestamp;
					break;
				case Status::Delivered:
					//Set Query
					$queryMilestones = "UPDATE milestones SET deliveredTime = :deliveredTime WHERE orderID = :orderID";
					//Add Parameters to list
					$parametersMilestones[':deliveredTime'] = $timestamp;
					break;
				default:
					echo "<script>('Invalid order status');</script>";
			}

			//Run Update Statment for Milestones
			$db->update_statement($queryMilestones, $parametersMilestones);

			//Destroy Database Connection
			$db->destroy_pdo();
			unset($db);

			//Get User
			require_once 'users.php';
			$user = new User();
			$user->getUser($this->userID);

			//Send user an email of the status update
			require_once 'notifications.php';
			milestoneUpdate($user->getEmail(), $user->getFirstName(), $status, $this->getDescription(), $this->getID());
		}

		/**
		* Get Order from Database
		* Assigns order object variables with values from the database
		* according to the orderID provided
		*
		* @param (integer) $orderID Order's ID number
		*/
		function getOrder($orderID)
		{
			//Create new database connection
			require_once 'database.php';
			$db = new Database();

			//Set Select Query
			$query = "SELECT DISTINCT *
			FROM orders
			WHERE orders.orderID = :orderID";

			//Set Parameters
			$parameters = array(
				":orderID" => $orderID
			);

			//Get Order from Database
			$stmt = $db->select_statement($query, $parameters);

			$order = $stmt->fetch();

			//Assign Order Values according to results
			$this->orderID = $orderID;
			$this->userID = $order['userID'];
			$this->status = $order['orderStatus'];
			$this->description = $order['description'];
			$this->signature = $order['signature'];
			$this->priority = $order['deliveryPriority'];

			$this->pickupDetails = array(
				'address' => $order['pickupAddress'],
				'postcode' => $order['pickupPostcode'],
				'state' => $order['pickupState'],
				'time' => $order['pickupTime']
			);

			$this->deliveryDetails = array(
				'address' => $order['deliveryAddress'],
				'postcode' => $order['deliveryPostcode'],
				'state' => $order['deliveryState'],
				'time' => $order['deliveryTime']
			);

			$this->recipientName = $order['recipientName'];
			$this->recipientPhone = $order['recipientPhone'];

			//Destroy Database Connection
			$db->destroy_pdo();
			unset($db);
		}

		/**
		* Get Packagaes
		* Returns an array containing all the packages for the order
		*
		* @return (array) Array of packages
		*/
		function getPackages()
		{
			//Import Packages Class
			require_once 'packages.php';

			//Create new database connection
			require_once 'database.php';
			$db = new Database();

			//Set Select Query
			$query = "SELECT *
			FROM packages
			WHERE orderID = :orderID
			ORDER BY packageID ASC";

			//Set Parameter
			$parameters = array(
				':orderID' => $this->orderID
			);

			//Get Packages from Database
			$stmt = $db->select_statement($query, $parameters);

			//Output each result as a package and add to packages array
			$packages = array();
			foreach($stmt as $package)
			{
				array_push($packages, new Package($package['packageID'], $this->orderID, $package['packageWeight'], $package['packageDescription']));
			}

			//Destroy Database Connection
			$db->destroy_pdo();
			unset($db);

			//Return Array pf Packages
			return $packages;
		}

		// ==================== Display/Output Functions ==================== //
		/**
		* Display Order
		* Outputs the Order in a table row
		*
		*/
		function displayOrder()
		{
			//Get Status Name
			require_once 'status.php';
			$orderStatus = Status::getStatusName($this->status);

			//Get Order's User details
			require_once 'users.php';
			$user = new User();
			$user->getUser($this->userID);

			//Output Order as Table Row
			echo "
				<tr>
					<td>{$this->orderID}</td>
					<td>
						<p>{$user->getFirstName()} {$user->getLastName()}</p>
						<p>{$user->getEmail()}</p>
					</td>
					<td>
						<p>Desc: {$this->description}</p>
						<p>Type: {$this->priority}</p>";
			if($this->signature === '1')
			{
				echo "<p>Signature Required</p>";
			}
			echo "
					</td>
					<td>
						<p>Preferred Time: {$this->pickupDetails['time']}</p>
						<p>Address: {$this->pickupDetails['address']}</p>
						<p>State: {$this->pickupDetails['state']}</p>
						<p>Postcode: {$this->pickupDetails['postcode']}</p>
					</td>
					<td>
						<p>Preferred Time: {$this->deliveryDetails['time']}</p>
						<p>Address: {$this->deliveryDetails['address']}</p>
						<p>State: {$this->deliveryDetails['state']}</p>
						<p>Postcode: {$this->deliveryDetails['postcode']}</p>
					</td>
					<td>
						<p>Name: {$this->recipientName}</p>
						<p>Phone: {$this->recipientPhone}</p>
					</td>
					<td>{$orderStatus}</td>";

			//Verify User Permission to Edit Orders
			require_once 'php/permissions.php';

			if(isset($_SESSION['role']))
			{
				if(checkPermission($_SESSION['role'], 'edit-order.php') === true)
				{
					echo "
						<td>
							<a href='edit-order.php?orderID={$this->orderID}'>Edit</a>
						</td>";
				}
			}

			//Close Row Tag
			echo "</tr>";
		}
	}
?>
