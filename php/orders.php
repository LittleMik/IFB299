<?php

  /**
   *
   */
class Order{

  	public $orderID;
  	public $userID;
  	public $status;
  	public $description;
  	public $signature;
  	public $priority;
  	public $pickupAddress;
  	public $pickupTime;
  	public $deliveryAddress;
  	public $recipientName;
    public $recipientPhone;

    /**
  	 * Constructor
  	 * Precondition: Argument must be either user table row
  	 * or a verified set of client order information
  	 */
  	function __construct()
  	{
  		# code...
  		//Construct Order according to the arguments provided
  		$args = func_get_args();
      $numArgs = func_num_args();
  		if($numArgs === 12)
  		{
			//Construct Order from db table row
			$this->orderID = $args[0]->orderID;
			$this->userID = $args[0]->userID;
			$this->status = $args[0]->orderStatus;
			$this->description = $args[0]->description;
			$this->signature = $args[0]->signature;
			$this->priority = $args[0]->deliveryPriority;
			$this->pickupAddress = $args[0]->pickupAddress;
			$this->pickupTime = $args[0]->pickupTime;
			$this->deliveryAddress = $args[0]->deliveryAddress;
			$this->recipientName = $args[0]->recipientName;
			$this->recipientPhone = $args[0]->recipientPhone;

  		}else{

        //Construct Order from scratch

  		//Set user defined fields
        //$this->orderID = $args[0]->orderID;
		$this->userID = $args[0];
		$this->description = $args[1];
		$this->signature = $args[2];
		$this->priority = $args[3];
		$this->pickupAddress = $args[4];
		$this->pickupTime = $args[5];
		$this->deliveryAddress = $args[6];
		$this->recipientName = $args[7];
		$this->recipientPhone = $args[8];

        //Set Default Status
        $this->status = "Ordered";
  		}
  	}
	
	function createCustomerOrder()
    {
		require 'pdo.inc';
		try
		{
			// Prepare Query
			$stmt = $pdo->prepare(
			"INSERT INTO orders (userID, orderStatus, description, signature, deliveryPriority, pickupAddress, pickupTime, deliveryAddress, recipientName, recipientPhone) VALUES (:userID, :orderStatus, :description, :signature, :deliveryPriority, :pickupAddress, :pickupTime, :deliveryAddress, :recipientName, :recipientPhone)"
		);

		//Bind query parameter with it's given variable
		$stmt->bindParam(':userID', $this->userID);
		$stmt->bindParam(':orderStatus', $this->status);
		$stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':signature', $this->signature);
		$stmt->bindParam(':deliveryPriority', $this->priority);
		$stmt->bindParam(':pickupAddress', $this->pickupAddress);
		$stmt->bindParam(':pickupTime', $this->pickupTime);
		$stmt->bindParam(':deliveryAddress', $this->deliveryAddress);
		$stmt->bindParam(':recipientName', $this->recipientName);
		$stmt->bindParam(':recipientPhone', $this->recipientPhone);

		//Run query
		$stmt->execute();
		
		$last_id = $pdo->lastInsertId();

		//Close connection
		$stmt = null;
		//Destroy PDO Object
		$pdo = null;
		
		return $last_id;

		}catch(PDOException $e){
			//Output Error
			echo $e->getMessage();
			echo '<p>'.$e.'</p>';
		}
	}	
	
	function createPhoneOrder()
    {
		require 'pdo.inc';
		
		try
		{
			// Prepare Query
			$stmt = $pdo->prepare(
			"INSERT INTO orders (userID, orderStatus, description, signature, deliveryPriority, pickupAddress, pickupTime, deliveryAddress, recipientName, recipientPhone) VALUES (:userID, :orderStatus, :description, :signature, :deliveryPriority, :pickupAddress, :pickupTime, :deliveryAddress, :recipientName, :recipientPhone)"
		);

		//Bind query parameter with it's given variable
		$stmt->bindParam(':userID', $this->userID);
		$stmt->bindParam(':orderStatus', $this->status);
		$stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':signature', $this->signature);
		$stmt->bindParam(':deliveryPriority', $this->priority);
		$stmt->bindParam(':pickupAddress', $this->pickupAddress);
		$stmt->bindParam(':pickupTime', $this->pickupTime);
		$stmt->bindParam(':deliveryAddress', $this->deliveryAddress);
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
}
?>
