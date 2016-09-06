<?php

/**
 *
 */
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

	var $roles = array("Customer", "Driver", "Co-ordinator", "Manager", "Admin");

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
			$this->phone = $args[4];
			$this->address = $args[5];
			$this->postCode = $args[6];
			$this->state = $args[7];

			//Generate Salt
			$this->salt = uniqid(mt_rand(), true);

			//Set User to Customer by default
			$this->role = "Customer";
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
