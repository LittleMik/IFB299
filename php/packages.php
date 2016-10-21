<?php
	// ======================================== Package Class ======================================== //
	/**
	*	Package Class
	*
	*	Contains details for packages and functionality to send and retrieve
	* package relevant information from the MySQL databse
	*
	*	@author Michael Smallcombe & Greg Mills
	*/
	// ============================================================================================= //
	class Package
	{

		public $packageID;
		public $orderID;
		public $weight;
		public $description;

		// ==================== Constructor ==================== //
		/**
		* Constructor
		*
		* Precondition: Argument must be array containing the package information.
		*
		*/
		function __construct()
		{
			//Construct Package according to the arguments provided
			if(func_num_args() !== 0)
			{
				$args = func_get_args();

				$this->packageID = $args[0];
				$this->orderID = $args[1];
				$this->weight = $args[2];
				$this->description = $args[3];
			}
		}

		// ==================== Getters ==================== //
		/**
		* Get ID
		* Returns integer containing the package's ID
		*
		* @return (integer) Contains the package's ID
		*/
		function getID()
		{
			return $this->packageID;
		}
		/**
		* Get OrderID
		* Returns integer containing the associated order's ID
		*
		* @return (integer) Contains the package's order ID
		*/
		function getOrderID()
		{
			return $this->orderID;
		}
		/**
		* Get Weight
		* Returns weight of the package
		*
		* @return (integer) Contains the package's weight
		*/
		function getWeight()
		{
			return $this->weight;
		}
		/**
		* Get Description
		* Returns the description of the package
		*
		* @return (String) Contains the package's description field
		*/
		function getDescription()
		{
			return $this->description;
		}

		// ==================== Database Functions ==================== //
		/**
		* Create Package
		*	Creates a new entry in the Package table for the given package
		*
		*/
		function createPackage()
		{
			//Create new database connection
			require_once 'database.php';
			$db = new Database();

			//Set Update Query
			$query = "INSERT INTO packages (
				orderID,
				packageWeight,
				packageDescription)

				VALUES (
					:orderID,
					:weight,
					:description);";

			//Set Parameters
			$parameter = array(
				':orderID' => $this->orderID,
				':weight' => $this->weight,
				':description' => $this->description
			);

			//Run Update Statment
			$db->update_statement($query, $parameters);

			//Destroy Database Connection
			$db->destroy_pdo();
			unset($db);
		}
		/**
		* Edit Package
		*	Updates Package table entry for the corresponding packageID
		*
		*/
		function editPackage()
		{
			//Create new database connection
			require_once 'database.php';
			$db = new Database();

			//Set Update Query
			$query = "UPDATE packages
				SET packageWeight = :weight,
				packageDescription = :description
				WHERE packageID = :packageID;";

			//Set Parameters
			$parameter = array(
				':weight' => $this->weight,
				':description' => $this->description,
				':packageID' => $this->packageID
			);

			//Run Update Statment
			$db->update_statement($query, $parameters);

			//Destroy Database Connection
			$db->destroy_pdo();
			unset($db);
		}
		
		// ==================== Display/Output Functions ==================== //
		/**
		* Display Package
		* Outputs the package in a table row
		*
		*/
		function displayPackage()
		{
			//Output Package in Row
			echo "
				<tr>
					<td>{$this->packageID}</td>
					<td>{$this->description}</td>
					<td>{$this->weight}KG</td>
				</tr>";
		}
	}
?>
