<?php

  /**
   *
   */
class Order{

  	public $orderID;
  	public $userID;
  	public $status;
  	public $description;
  	public $totalWeight;
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
			$this->totalWeight = $args[0]->totalWeight;
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
		$this->totalWeight = $args[2];
		$this->signature = $args[3];
		$this->priority = $args[4];
		$this->pickupAddress = $args[5];
		$this->pickupTime = $args[6];
		$this->deliveryAddress = $args[7];
		$this->recipientName = $args[8];
		$this->recipientPhone = $args[9];

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
			"INSERT INTO orders (userID, orderStatus, description, totalWeight, signature, deliveryPriority, pickupAddress, pickupTime, deliveryAddress, recipientName, recipientPhone) VALUES (:userID, :orderStatus, :description, :totalWeight, :signature, :deliveryPriority, :pickupAddress, :pickupTime, :deliveryAddress, :recipientName, :recipientPhone)"
		);

		//Bind query parameter with it's given variable
		$stmt->bindParam(':userID', $this->userID);
		$stmt->bindParam(':orderStatus', $this->status);
		$stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':totalWeight', $this->totalWeight);
		$stmt->bindParam(':signature', $this->signature);
		$stmt->bindParam(':deliveryPriority', $this->priority);
		$stmt->bindParam(':pickupAddress', $this->pickupAddress);
		$stmt->bindParam(':pickupTime', $this->pickupTime);
		$stmt->bindParam(':deliveryAddress', $this->deliveryAddress);
		$stmt->bindParam(':recipientName', $this->recipientName);
		$stmt->bindParam(':recipientPhone', $this->recipientPhone);

		//Run query
		$stmt->execute();

		//Close connection
		$stmt = null;
		//Destroy PDO Object
		$pdo = null;

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
			"INSERT INTO orders (userID, orderStatus, description, totalWeight, signature, deliveryPriority, pickupAddress, pickupTime, deliveryAddress, recipientName, recipientPhone) VALUES (:userID, :orderStatus, :description, :totalWeight, :signature, :deliveryPriority, :pickupAddress, :pickupTime, :deliveryAddress, :recipientName, :recipientPhone)"
		);

		//Bind query parameter with it's given variable
		$stmt->bindParam(':userID', $this->userID);
		$stmt->bindParam(':orderStatus', $this->status);
		$stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':totalWeight', $this->totalWeight);
		$stmt->bindParam(':signature', $this->signature);
		$stmt->bindParam(':deliveryPriority', $this->priority);
		$stmt->bindParam(':pickupAddress', $this->pickupAddress);
		$stmt->bindParam(':pickupTime', $this->pickupTime);
		$stmt->bindParam(':deliveryAddress', $this->deliveryAddress);
		$stmt->bindParam(':recipientName', $this->recipientName);
		$stmt->bindParam(':recipientPhone', $this->recipientPhone);

		//Run query
		$stmt->execute();

		//Close connection
		$stmt = null;
		//Destroy PDO Object
		$pdo = null;

		}catch(PDOException $e){
			//Output Error
			echo $e->getMessage();
			echo '<p>'.$e.'</p>';
		}
	}
}
?>
