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
			$this->email = $args[0];
			$this->password = $args[1];
			$this->firstName = $args[2];
			$this->lastName = $args[3];
			$this->role = $args[4];
			$this->phone = $args[5];
			$this->address = $args[6];
			$this->postCode = $args[7];
			$this->state = $args[8];

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
		require_once 'usersDB.php';
		createUser($this);
	}
}

?>
