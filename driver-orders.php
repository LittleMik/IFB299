<?php require 'includes/head.inc' ?>

<?php
  //Verify User Permission to View Page
  require_once 'php/permissions.php';
  require_once 'php/roles.php';

  if(isset($_SESSION['role']))
  {
    if(checkPermission($_SESSION['role'], 'driver-ui') === false)
    {
	  echo '<script> alert('.$_SERVER['PHP_SELF'].');</script>';
      //Insufficient Role, Redirect User to Forbidden Error Page
      header("Location:login.php");
    }
  }else{
    //Error: User not logged in
    header("Location:login.php");
  }
?>

<?php require 'includes/header.inc' ?>

<!-- push content below header flag image-->
<div class="pusher"></div>
<!-- Display orders assigned to driver-->
<div class="container">
    <?php
        require_once 'php/output.php';
				require_once 'php/search.php';
        outputResultOrders(searchAssignedOrder("", "", "", "", "", $_SESSION['ID']));
    ?>
</div>
<?php require 'includes/footer.inc' ?>
