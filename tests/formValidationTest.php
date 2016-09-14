<?php

  require_once("./php/formValidation.php");

  class ValidationTest extends \PHPUnit_Framework_TestCase
  {
    /**
    * Test Email Verification
    * @dataProvider providerCheckEmail
    */
    public function testCheckEmailEquals($email, $expectedResult)
    {
      $result = checkEmail($email);

      var_dump($email);
      var_dump($expectedResult);
      var_dump($result);

      $this->assertEquals($expectedResult, $result);
    }

    public static function providerCheckEmail()
    {
        return array(
          array("email@example.com", true),
          array("firstname.lastname@example.com", true),
          array("email@subdomain.example.com", true),
          array("firstname+lastname@example.com", true),
          array("1234567890@example.com", true),
          array("email@example-one.com", true),
          array("______@example.com", true),
          array("email@example.co.jp", true),
          array("firstname-lastname@example.com", true),
          array("plainaddress", false),
          array("#@%^%#$@#$@#.com", false),
          array("@example.com", false),
          array("Joe Smith <email@example.com>", false),
          array("email.example.com", false),
          array("email@example@example.com", false),
          array(".email@example.com", false),
          array("email.@example.com", false),
          array("email..email@example.com", false),
          array("あいうえお@example.com", false),
          array("email@example.com (Joe Smith)", false),
          array("email@example", false),
          array("email@-example.com", false),
          array("email@111.222.333.44444", false),
          array("email@example..com", false),
          array("Abc..123@example.com", false)
        );
    }


    /**
    * Test Password Verification
    * @dataProvider providerCheckPassword
    */
    public function testCheckPassword($password, $expectedResult)
    {
      $result = checkPassword($password);

      var_dump($password);
      var_dump($expectedResult);
      var_dump($result);

      $this->assertEquals($expectedResult, $result);
    }

    public static function providerCheckPassword()
    {
        return array(
          array("test1234", true),
          array("891@ADW)A", true),
          array("IAWmAWidAAWDW9", true),
          array("password", false)
        );
    }

    /**
    * Test Name Verification
    * @dataProvider providerCheckName
    */
    public function testCheckName($name, $expectedResult)
    {
      $result = checkName($name);

      var_dump($name);
      var_dump($expectedResult);
      var_dump($result);

      $this->assertEquals($expectedResult, $result);
    }

    public static function providerCheckName()
    {
        return array(
          array("Michael", true),
          array("Somethingreallylongandunusual", true),
          array("El Mucho", false),
          array("A", false)
        );
    }

    /**
    * Test FullName Verification
    * @dataProvider providerCheckFullName
    */
    public function testCheckFullName($name, $expectedResult)
    {
      $result = checkFullName($name);

      var_dump($name);
      var_dump($expectedResult);
      var_dump($result);

      $this->assertEquals($expectedResult, $result);
    }

    public static function providerCheckFullName()
    {
        return array(
          array("Michael Smallcombe", true),
          array("Something Very Long And Unusual", true),
          array("El Mucho", true),
          array("C", false)
        );
    }

    /**
    * Test Phone Verification
    * @dataProvider providerCheckPhone
    */
    public function testCheckPhone($phone, $expectedResult)
    {
      $result = checkPhone($phone);

      var_dump($phone);
      var_dump($expectedResult);
      var_dump($result);

      $this->assertEquals($expectedResult, $result);
    }

    public static function providerCheckPhone()
    {
        return array(
          array("3020 2902", true),
          array("(03)3291 2891", true),
          array("32912891", true),
          array("0429 109 091", true),
          array("0429109091", true),
          array("(+61)423 109 189", true),
          array("(+61)423109189", true),
          array("39", false)
        );
    }

    /**
    * Test Address Verification
    * @dataProvider providerCheckAddress
    */
    public function testCheckAddress($address, $expectedResult)
    {
      $result = checkAddress($address);

      var_dump($address);
      var_dump($expectedResult);
      var_dump($result);

      $this->assertEquals($expectedResult, $result);
    }

    public static function providerCheckAddress()
    {
        return array(
          array("20 Maple Street, Somewhere", true),
          array("12 As Dr, Near", true),
          array("1231 Derp St, Merp", true),
          array("1231 Derp St Merp", true),
          array("1231, Derp St Merp", true),
          array("1231, Derp St, Merp", true),
          array("0429 109 091", false),
          array("", false)
        );
    }

    /**
    * Test Post Verification
    * @dataProvider providerCheckPost
    */
    public function testCheckPost($postCode, $expectedResult)
    {
      $result = checkPost($postCode);

      var_dump($postCode);
      var_dump($expectedResult);
      var_dump($result);

      $this->assertEquals($expectedResult, $result);
    }

    public static function providerCheckPost()
    {
        return array(
          array("1409", true),
          array("1209", true),
          array("4000", true),
          array("9999", true),
          array("39", false),
          array("29999", false),
          array("1 2", false),
          array("A2222", false),
          array("", false)
        );
    }

    /**
    * Test State Verification
    * @dataProvider providerCheckState
    */
    public function testCheckState($state, $expectedResult)
    {
      $result = checkState($state);

      var_dump($state);
      var_dump($expectedResult);
      var_dump($result);

      $this->assertEquals($expectedResult, $result);
    }

    public static function providerCheckState()
    {
        return array(
          array("QLD", true),
          array("NSW", true),
          array("VIC", true),
          array("NT", true),
          array("ACT", true),
          array("TAS", true),
          array("SA", true),
          array("WA", true),
          array("DERP", false),
          array("W A", false),
          array("", false)
        );
    }

    /**
    * Test Matching
    * @dataProvider providerCheckMatch
    */
    public function testCheckMatch($item1, $item2, $expectedResult)
    {
      $result = checkMatch($item1, $item2);

      var_dump($item1);
      var_dump($item2);
      var_dump($expectedResult);
      var_dump($result);

      $this->assertEquals($expectedResult, $result);
    }

    public static function providerCheckMatch()
    {
        return array(
          array("somethingRandom", "somethingRandom", true),
          array(12929,12929, true),
          array("MERP", "MERP", true),
          array(true, true, true),
          array("291, Something", "291, Something", true),
          array("", "", true),
          array("SoMETHING2019Mo@CoMpleX213", "SoMETHING2019Mo@CoMpleX213", true),
          array("Derp", "Herp", false),
          array(12, 14, false),
          array("12", "15", false),
          array("Something random", "Something else", false),
          array(true, false, false),
          array("", " ", false)
        );
    }


    /**
    * Test Weight Verification
    * @dataProvider providerCheckWeight
    */
    public function testCheckWeight($weight, $expectedResult)
    {
      $result = checkWeight($weight);

      var_dump($weight);
      var_dump($expectedResult);
      var_dump($result);

      $this->assertEquals($expectedResult, $result);
    }

    public static function providerCheckWeight()
    {
        return array(
          array("123", true),
          array("14", true),
          array("1231", true),
          array(14, true),
          array("1", true),
          array("19", true),
          array("22222", false),
          array(0, false),
          array("0", false),
          array("not a weight", false),
          array("", false)
        );
    }
  }
