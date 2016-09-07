<?php

  /**
   *
   */
  class Order
  {

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

    //Saves User to Database
  	function saveToDatabase()
  	{
  		require_once 'ordersDB.php';
  		createOrder($this);
  	}
  }
?>
