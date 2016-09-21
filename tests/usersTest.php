<?php

  require_once("./php/users.php");

  class UsersTest extends \PHPUnit_Framework_TestCase
  {
    /**
    * Test Permission Checking
    * @dataProvider providerConstructorUser
    */
    public function testConstructorUser($email, $firstName, $lastName, $phone, $address, $postCode, $state)
    {
      $user = new User(null, $email, $firstName, $lastName, $phone, $address, $postCode, $state);

      var_dump($user->email);
      var_dump($user->firstName);
      var_dump($user->lastName);
      var_dump($phone);
      var_dump($address);
      var_dump($postCode);
      var_dump($state);

      $this->assertEquals($email, $user->email);
      $this->assertEquals($firstName, $user->firstName);
      $this->assertEquals($lastName, $user->lastName);
      $this->assertEquals($phone, $user->phone);
      $this->assertEquals($address, $user->address);
      $this->assertEquals($postCode, $user->postCode);
      $this->assertEquals($state, $user->state);
    }
    /**
    * Check Permission DataProvider
    */
    public static function providerConstructorUser()
    {
      return array(
        //Create Staff Account
        array(
          "bob@email.com",
          "Bob","Marley",
          "(07)3129 1290",
          "15 Herp Street, Derp",
          "postCode" => "4001",
          "QLD"
        ),
        array(
          "email" => "bob@email.com",
          "firstName" => "Bob",
          "lastName" => "Marley",
          "phone" => "(07)3129 1290",
          "address" => "15 Herp Street, Derp",
          "postCode" => "4001",
          "state" => "QLD"
          ),
        array(
          "email" => "bob@email.com",
          "firstName" => "Bob",
          "lastName" => "Marley",
          "phone" => "(07)3129 1290",
          "address" => "15 Herp Street, Derp",
          "postCode" => "4001",
          "state" => "QLD"
          ),
        array(
          "email" => "bob@email.com",
          "firstName" => "Bob",
          "lastName" => "Marley",
          "phone" => "(07)3129 1290",
          "address" => "15 Herp Street, Derp",
          "postCode" => "4001",
          "state" => "QLD"
        ),
      );
  }
}

?>
