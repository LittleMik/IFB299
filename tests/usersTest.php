<?php

  require_once("./php/users.php");

  class UsersTest extends \PHPUnit_Framework_TestCase
  {
    /**
    * Test User Constructor
    * @dataProvider providerConstructorUser
    */
    public function testConstructorUser($email, $firstName, $lastName, $phone, $role, $address, $postcode, $state)
    {
      $id = null;

      $user = new User($id, $email, $firstName, $lastName, $phone, $role, $address, $postcode, $state);

      var_dump($user->getEmail());
      var_dump($user->getFirstName());
      var_dump($user->getLastName());
      var_dump($user->getPhone());
      var_dump($user->getAddress());
      var_dump($user->getPostcode());
      var_dump($user->getState());

      $this->assertEquals($email, $user->getEmail());
      $this->assertEquals($firstName, $user->getFirstName());
      $this->assertEquals($lastName, $user->getLastName());
      $this->assertEquals($phone, $user->getPhone());
      $this->assertEquals($address, $user->getAddress());
      $this->assertEquals($postcode, $user->getPostcode());
      $this->assertEquals($state, $user->getState());
    }
    /**
    * Test User Constructor DataProvider
    */
    public static function providerConstructorUser()
    {
      return array(
        //Create Staff Account
        array(
          "bob@email.com",
          "Bob","Marley",
          "(07)3129 1290",
          "0",
          "15 Herp Street, Derp",
          "4001",
          "QLD"
        ),
        array(
          "misha@rip.com",
          "Misha",
          "TheD00D",
          "3129 1290",
          "4",
          "52 Merp Drive, Derp",
          "3234",
          "VIC"
          ),
        array(
          "herp@email.com",
          "Herp",
          "Derp",
          "0429 123 123",
          "3",
          "15 Herp Street, Derp",
          "2342",
          "NSW"
        ),
      );
  }
}

?>
