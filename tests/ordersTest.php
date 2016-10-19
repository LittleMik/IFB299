<?php

  require_once("./php/orders.php");

  class OrdersTest extends \PHPUnit_Framework_TestCase
  {
    /**
    * Test Order Constructor
    * @dataProvider providerConstructorOrder
    */
    public function testConstructorOrder($orderID, $userID, $status, $description, $signature, $priority, $pickupAddress, $pickupPostcode, $pickupState, $pickupTime, $deliveryAddress, $deliveryPostcode, $deliveryState, $deliveryTime, $recipientName, $recipientPhone)
    {
      $order = new Order($orderID, $userID, $status, $description, $signature, $priority, $pickupAddress, $pickupPostcode, $pickupState, $pickupTime, $deliveryAddress, $deliveryPostcode, $deliveryState, $deliveryTime, $recipientName, $recipientPhone);

      var_dump(get_object_vars($order));

      $this->assertEquals($orderID, $order->getID());
      $this->assertEquals($userID, $order->getUserID());

      $this->assertEquals($status, $order->getStatus());
      $this->assertEquals($description, $order->getDescription());
      $this->assertEquals($signature, $order->getSignature());
      $this->assertEquals($priority, $order->getPriority());

			$pickupDetails = $order->getPickup();
      $this->assertEquals($pickupAddress, $pickupDetails['address']);
      $this->assertEquals($pickupPostcode, $pickupDetails['postcode']);
      $this->assertEquals($pickupState, $pickupDetails['state']);
      $this->assertEquals($pickupTime, $pickupDetails['time']);

			$deliveryDetails = $order->getDelivery();
      $this->assertEquals($deliveryAddress, $deliveryDetails['address']);
      $this->assertEquals($deliveryPostcode, $deliveryDetails['postcode']);
      $this->assertEquals($deliveryState, $deliveryDetails['state']);
      $this->assertEquals($deliveryTime, $deliveryDetails['time']);

      $this->assertEquals($recipientName, $order->getRecipient());
      $this->assertEquals($recipientPhone, $order->getRecipientPhone());
    }
    /**
    * Test Order Constructor DataProvider
    */
    public static function providerConstructorOrder()
    {
			require_once './php/status.php';
      return array(
        //Create Staff Account
        array(
          "1",
      		"332",
          Status::Ordered,
          "Something Heavy",
          "1",
          "Express",

          "13 Somewhere Street, Someplace",
          "4201",
          "QLD",
          "2016-09-10 09:30:00",

          "29 AnotherPlace Street, SomewhereElse",
          "2920",
          "NSW",
          "2016-09-11 09:30:00",

          "Bob",
          "Darren"
        ),
        array(
          "13",
      		"423",
          Status::Ordered,
          "Something Else",
          "0",
          "Standard",

          "12 Merp Drive, AnotherPlace",
          "4001",
          "QLD",
          "2016-09-11 12:30:00",

          "31 Okay Street, Place",
          "1920",
          "VIC",
          "2016-09-14 09:30:00",

          "Merp",
          "Herp"
        ),
      );
  }
}

?>
