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
class Order{

		private $orderID;
		private $userID;
		private $status;
		private $description;
		private $signature;
		private $priority;

		private $pickupDetails;
		//remove individual pickup details
		private $pickupAddress;
		private $pickupPostcode;
		private $pickupState;
		private $pickupTime;

		private $deliveryDetails;
		//remove individual delivery details
		private $deliveryAddress;
		private $deliveryPostcode;
		private $deliveryState;
		private $deliveryTime;

		private $recipientName;
		private $recipientPhone;

		// ==================== Constructor ==================== //
		/**
		 * Constructor
		 * Precondition: Argument must be either user table row
		 * or a verified set of client order information
		 */
		function __construct()
		{
			//Construct Order according to the arguments provided
			$numArgs = func_num_args();

			if($numArgs !== 0)
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

				$this->pickupAddress = $args[6];
				$this->pickupPostcode = $args[7];
				$this->pickupState = $args[8];
				$this->pickupTime = $args[9];

				//Delivery Details
				$this->deliveryDetails = array(
					'address' => $args[10],
					'postcode' => $args[11],
					'state' => $args[12],
					'time' => $args[13]
				);

				$this->deliveryAddress = $args[10];
				$this->deliveryPostcode = $args[11];
				$this->deliveryState = $args[12];
				$this->deliveryTime = $args[13];

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
		*/
		function getID()
		{
			return $this->orderID;
		}
		/**
		* Get UserID
		* Returns integer of userID assigned to the order
		*/
		function getUserID()
		{
			return $this->userID;
		}
		/**
		* Get Status
		* Returns the order's current status
		*/
		function getStatus()
		{
			return $this->status;
		}
		/**
		* Get Description
		* Returns order's description
		*/
		function getDescription()
		{
			return $this->description;
		}
		/**
		* Get Signature
		* Returns order's signature required property
		*/
		function getSignature()
		{
			return $this->signature;
		}
		/**
		* Get Priority
		* Returns order's priority type
		*/
		function getPriority()
		{
			return $this->priority;
		}
		/**
		* Get Pickup Details
		* Returns array containing order's pickup details
		*/
		function getPickup()
		{
			return $this->pickupDetails;
		}
		/**
		*	Get Delivery Details
		*	Returns array containing order's delivery details
		*/
		function getDelivery()
		{
			return $this->deliveryDetails;
		}
		/**
		*	Get Recipient
		*	Returns orders's recipient name
		*/
		function getRecipient()
		{
			return $this->recipientName;
		}
		/*
		*	Get Recipient Phone
		*	Returns order's recipient phone number
		*/
		function getRecipientPhone()
		{
			return $this->recipientPhone;
		}

		// ==================== Database Functions ==================== //
		/*
		* Edit Order
		*	Updates Orders table entry for the corresponding orderID
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
				':pickupAddress' => $this->pickupAddress,
				':pickupPostcode' => $this->pickupPostcode,
				':pickupState' => $this->pickupState,
				':pickupTime' => $this->pickupTime,
				':deliveryAddress' => $this->deliveryAddress,
				':deliveryPostcode' => $this->deliveryPostcode,
				':deliveryState' => $this->deliveryState,
				':deliveryTime' => $this->deliveryTime,
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

			return $lastID;
		}

		/*
		* Create Order
		*	Creates a new entry in the Orders table for the given order
		*/
		function createOrder()
		{
			require 'pdo.inc';
			try
			{
				// Prepare Query
				$stmt = $pdo->prepare(
				"INSERT INTO orders (userID, orderStatus, description, signature,
				deliveryPriority, pickupAddress, pickupPostcode, pickupState,
				pickupTime, deliveryAddress, deliveryPostcode, deliveryState,
				deliveryTime, recipientName, recipientPhone)

				VALUES (:userID, :orderStatus, :description, :signature, :deliveryPriority,
				:pickupAddress, :pickupPostcode, :pickupState, :pickupTime, :deliveryAddress,
				:deliveryPostcode, :deliveryState, :deliveryTime, :recipientName, :recipientPhone
				)");

				//Bind query parameter with it's given variable
				$stmt->bindParam(':userID', $this->userID);
				$stmt->bindParam(':orderStatus', $this->status);
				$stmt->bindParam(':description', $this->description);
				$stmt->bindParam(':signature', $this->signature);
				$stmt->bindParam(':deliveryPriority', $this->priority);
				$stmt->bindParam(':pickupAddress', $this->pickupAddress);
				$stmt->bindParam(':pickupPostcode', $this->pickupPostcode);
				$stmt->bindParam(':pickupState', $this->pickupState);
				$stmt->bindParam(':pickupTime', $this->pickupTime);
				$stmt->bindParam(':deliveryAddress', $this->deliveryAddress);
				$stmt->bindParam(':deliveryPostcode', $this->deliveryPostcode);
				$stmt->bindParam(':deliveryState', $this->deliveryState);
				$stmt->bindParam(':deliveryTime', $this->deliveryTime);
				$stmt->bindParam(':recipientName', $this->recipientName);
				$stmt->bindParam(':recipientPhone', $this->recipientPhone);

				//Run query
				$stmt->execute();
				//get id of newly inserted row
				$last_id = $pdo->lastInsertId();

				//Close connection
				$stmt = null;
				//Destroy PDO Object
				$pdo = null;
				//Return id of newly inserted row
				return $last_id;

			}catch(PDOException $e){
				//Output Error
				echo $e->getMessage();
				echo '<p>'.$e.'</p>';
			}
		}

		//return an array containing all the package objects in this order
		function getPackages(){
			require_once 'ordersDB.php';
			//get a pdo statement containing all of the package info
			$stmtPackages = getPackages($this->orderID);
			//store all the info into package objects, and put them into an array
			$i = 0;
			foreach($stmtPackages as $package){
				$packages[$i] = new Package($package['packageID'], $package['packageWeight'], $package['packageDescription']);
				$i++;
			}

			return $packages;
		}
	}
?>
