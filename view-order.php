<?php require 'includes/head.inc' ?>

<?php
  //Verify User Permission to View Page
  require_once 'php/permissions.php';

  if(isset($_SESSION['role']))
  {
    if(checkPermission($_SESSION['role'], $_SERVER['PHP_SELF']) === false)
    {
      //Insufficient Role, Redirect User to Forbidden Error Page
      header("Location:403.php");
    }
  }else{
    //Error: User not logged in
    header("Location:login.php");
  }
?>

<body>
  <?php
    if($_SERVER["REQUEST_METHOD"] === "POST")
    {

      $errors = array();
      $formValid = true;

      //Get Dependancies
      require_once 'php/formValidation.php';

      //PHP Field Validation
      $errors = array(

      );

      //Check for presence of errors and output
      foreach($errors as $field => $valid)
      {
        if($valid === false)
        {
          $formValid = false;
          echo $_POST[$field] . "<br />";
          echo "Invalid " . $field . " detected<br />";
        }
      }

      //Complete Registration Process
      if($formValid)
      {
        require_once 'php/orders.php';
        require_once 'php/users.php';

        $user = unserialize($_SESSION['user']);
      }
    }
  ?>

	<?php include 'includes/header.inc' ?>
