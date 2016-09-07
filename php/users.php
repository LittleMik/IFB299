<?php

/**
 * Class for User related functionality
 */
class User
{

	//User Variables
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

	/**
	 * Constructor
	 * Precondition: Argument must be either user table row
	 * or a verified set of client registration information
	 */
	function __construct()
	{
		# code...
		//Construct User according to the arguments provided
		$args = func_get_args();
		$numArgs = func_num_args();
		if($numArgs === 8)
		{

			//Construct User from db table row
			$this->id = $args[0];
			$this->email = $args[1];
			$this->firstName = $args[2];
			$this->lastName = $args[3];
			$this->phone = $args[4];
			$this->address = $args[5];
			$this->postcode = $args[6];
			$this->state = $args[7];

		}else{
			//Construct User from scratch
			//Set user defined fields
			$this->id = $args[0];
			$this->email = $args[1];
			$this->password = $args[2];
			$this->firstName = $args[3];
			$this->lastName = $args[4];
			$this->role = $args[5];
			$this->phone = $args[6];
			$this->address = $args[7];
			$this->postCode = $args[8];
			$this->state = $args[9];

			//Generate Salt
			$this->salt = uniqid(mt_rand(), true);

		}
	}

	//Reloads User Details
	function getFromDatabase($email)
	{
		require_once 'pdo.inc';
		//need to implement
	}

	//Saves User to Database
	function saveToDatabase()
	{
		//If the user already has an id (i.e. is being modified) run the update user function otherwise create a user
		require_once 'usersDB.php';
		if($this->id != ""){
			updateUser($this);
		} else {
			createUser($this);
		}
		
		
	}
}

?>
