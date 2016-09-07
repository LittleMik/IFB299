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
		if(is_int($args[0]))
		{
			//Construct User from db table row
			$this->id = $args[0]->id;
			$this->email = $args[0]->email;
			$this->salt = $args[0]->salt;
			$this->role = $args[0]->role;
			$this->firstName = $args[0]->firstName;
			$this->lastName = $args[0]->lastName;
			$this->phone = $args[0]->phone;
			$this->address = $args[0]->address;
			$this->postCode = $args[0]->postCode;
			$this->state = $args[0]->state;

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
