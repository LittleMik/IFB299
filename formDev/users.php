<?php

/**
 *
 */
class User
{

	private $id;
	private $email;
	private $password;
	private $salt;
	private $role;
	private $firstname;
	private $lastname;
	private $phone;
	private $address;
	private $postcode;
	private $state;

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
			$this->firstname = $args[0]->firstname;
			$this->lastname = $args[0]->lastname;
			$this->phone = $args[0]->phone;
			$this->address = $args[0]->address;
			$this->postcode = $args[0]->postcode;
			$this->state = $args[0]->state;

		}else{
			//Construct User from scratch

			//Set user defined fields
			$this->email = $args[0];
			$this->password = $args[1];
			$this->firstname = $args[2];
			$this->lastname = $args[3];
			$this->phone = $args[4];
			$this->address = $args[5];
			$this->postcode = $args[6];
			$this->state = $args[7];

			//Generate Salt
			$this->salt = uniqid(mt_rand(), true);

			//Set User to Customer by default
			$this->role = $roles[0];
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
		require_once 'pdo.inc';
		//need to implement
	}
}

?>
