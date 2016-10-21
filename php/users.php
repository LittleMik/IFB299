<?php
	// ======================================== User Class ======================================== //
	/**
	*	User Class
	*
	*	Contains details for users and functionality to send and retrieve
	* user relevant information from the MySQL databse
	*
	*	@author Michael Smallcombe & Greg Mills
	*/
	// ============================================================================================= //
	class User
	{

		public $id;
		public $email;
		public $password;
		public $salt;
		public $role;
		public $firstName;
		public $lastName;
		public $phone;
		public $address;
		public $postcode;
		public $state;

		// ==================== Constructor ==================== //
		/**
		 * Constructor
		 * Precondition: Argument must be either user table row
		 * or a verified set of client registration information
		 *
		 */
		function __construct()
		{
			//Construct User according to the arguments provided
			if(func_num_args() === 9)
			{
				$args = func_get_args();

				//Construct NEW User
				$this->id = $args[0];
				$this->email = $args[1];
				$this->firstName = $args[2];
				$this->lastName = $args[3];
				$this->phone = $args[4];
				$this->role = $args[5];
				$this->address = $args[6];
				$this->postcode = $args[7];
				$this->state = $args[8];
			}
		}

		// ==================== Getters ==================== //
		/**
		* Get ID
		* Returns integer user's ID
		*
		* @return (integer) Contains the user's ID
		*/
		function getID()
		{
			return $this->id;
		}
		/**
		* Get Email
		* Returns the email of the user
		*
		* @return (String) Contains the user's email
		*/
		function getEmail()
		{
			return $this->email;
		}
		/**
		* Get First Name
		* Returns the firstname of the user
		*
		* @return (String) Contains the user's firstname
		*/
		function getFirstName()
		{
			return $this->firstName;
		}
		/**
		* Get Last Name
		* Returns the lastname of the user
		*
		* @return (String) Contains the user's lastname
		*/
		function getLastName()
		{
			return $this->lastName;
		}
		/**
		* Get Phone
		* Returns the phone number of the user
		*
		* @return (String) Contains the user's phone number
		*/
		function getPhone()
		{
			return $this->phone;
		}
		/**
		* Get Role
		* Returns the role of the user
		*
		* @return (integer) Contains the user's role
		*/
		function getRole()
		{
			return $this->role;
		}
		/**
		* Get Role Name
		* Returns the role name of the user
		*
		* @return (String) Contains the user's role name
		*/
		function getRoleName()
		{
			require_once 'status.php';
			return getStatusName($this->role);
		}
		/**
		* Get Address
		* Returns the address of the user
		*
		* @return (String) Contains the user's address
		*/
		function getAddress()
		{
			return $this->address;
		}
		/**
		* Get Postcode
		* Returns the postcode of the user's address
		*
		* @return (integer) Contains the user's postcode
		*/
		function getPostcode()
		{
			return $this->postcode;
		}
		/**
		* Get State
		* Returns the state of the user's address
		*
		* @return (String) Contains the user's state
		*/
		function getState()
		{
			return $this->state;
		}

		// ==================== Database Functions ==================== //
		/**
		* Create Customer Account
		*	Creates a new customer account
		*
		*/
		function createCustomerAccount($password)
		{
			//Create new database connection
			require_once 'database.php';
			$db = new Database();

			//Generate Salt
			$this->salt = uniqid(mt_rand(), true);

			//Set Customer Role
			require_once 'php/roles.php';
			$this->role = Roles::Customer;

			//Set Users Query
			$queryUsers = "INSERT INTO users (
				email,
				password,
				salt,
				firstName,
				lastName,
				phoneNumber,
				address,
				postcode,
				state)

				VALUES (
					:email,
					SHA2(CONCAT(:password, :salt), 0),
					:salt,
					:firstName,
					:lastName,
					:phoneNumber,
					:address,
					:postcode,
					:state);";

			//Bind query parameter with it's given variable
			$parametersUsers = array(
				':email' => $this->email,
				':password' => $this->password,
				':salt' => $this->salt,
				':firstName' => $this->firstName,
				':lastName' => $this->lastName,
				':phoneNumber' => $this->phoneNumber,
				':address' => $this->address,
				':postcode' => $this->postcode,
				':state' => $this->state
			);

			//Run Update Statment
			$db->update_statement($queryUsers, $parametersUsers);

			//Set Roles Query
			$queryRoles = "INSERT INTO roles (
				userID,
				role)

				SELECT userID, 0
				FROM users
				WHERE email = :email";

			//Bind query parameter with it's given variable
			$parametersRoles = array(
				':email' => $this->email
			);

			//Run Update Statment
			$db->update_statement($queryRoles, $parametersRoles);

			//Destroy Database Connection
			$db->destroy_pdo();
			unset($db);
		}
		/**
		* Create Staff Account
		*	Creates a new staff account
		*
		*/
		function createStaffAccount($password)
		{
			//Create new database connection
			require_once 'database.php';
			$db = new Database();

			//Generate Salt
			$this->salt = uniqid(mt_rand(), true);

			//Set Users Query
			$queryUsers = "INSERT INTO users (
				email,
				password,
				salt,
				firstName,
				lastName,
				phoneNumber,
				address,
				postcode,
				state)

				VALUES (
					:email,
					SHA2(CONCAT(:password, :salt), 0),
					:salt,
					:firstName,
					:lastName,
					:phoneNumber,
					:address,
					:postcode,
					:state)";

				//Populate Users Parameters List
				$parametersUsers = array(
					':email' => $this->email,
					':password' => $this->password,
					':salt' => $this->salt,
					':firstName' => $this->firstName,
					':lastName' => $this->lastName,
					':phoneNumber' => $this->phone,
					':address' => $this->address,
					':postcode' => $this->postcode,
					':state' => $this->state
				);

				//Run Update Statment for Users table
				$db->update_statement($queryUsers, $parametersUsers);

				//Set Roles Query
				$queryRoles = "INSERT INTO roles (
					userID,
					role)

					SELECT userID, :role
					FROM users
					WHERE email = :email";

				//Populate Roles Parameters List
				$parametersRoles = array(
					':role' => $this->role,
					':email' => $this->email
				);

				//Run Update Statment for Roles table
				$db->update_statement($query, $parameters);

				//Destroy Database Connection
				$db->destroy_pdo();
				unset($db);
		}
		/**
		* Update User Account
		*	Updates the Users table entry for the given userID
		*
		*/
		function updateUser()
		{
			//Create new database connection
			require_once 'database.php';
			$db = new Database();

			//Set Update Query
			$query = "UPDATE users
			SET email = :email,
			firstName = :firstName,
			lastName = :lastName,
			phoneNumber = :phoneNumber,
			address = :address,
			postcode = :postcode,
			state = :state
			WHERE userID = :userID;";

			//Populate Parameters List
			$parameters = array(
				':email' => $this->email,
				':firstName' => $this->firstName,
				':lastName' => $this->lastName,
				':phoneNumber' => $this->phoneNumber,
				':address' => $this->address,
				':postcode' => $this->postcode,
				':state' => $this->state,
				':userID' => $this->userID
			);

			//Run Update Statment
			$db->update_statement($query, $parameters);

			//Destroy Database Connection
			$db->destroy_pdo();
			unset($db);
		}
	}
?>
