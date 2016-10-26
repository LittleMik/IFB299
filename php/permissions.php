<?php


  /**
  * Check Role requirement of the specific permission
  * return boolean - true if role minimum requirement
  *                - false if requirement not met or
  *                  permission not found in array
  */
  function checkPermission($role, $permission)
  {
    require_once 'roles.php';

    $permissions = array(
      'create-staff-account.php' => Roles::Manager,
      'view-order.php' => Roles::Driver,
	  	'edit-order.php' => Roles::Coordinator,
      'phone-order.php' => Roles::Coordinator,
      'edit-accounts.php' => Roles::Admin,
      'view-users.php' => Roles::Manager,
      'package-information.php' => Roles::Manager,
			'payments-view' => Roles::Driver,
			'payments-add' => Roles::Driver,
			'payments-edit' => Roles::Manager,
      'driver-ui' => Roles::Driver
    );

    if(array_key_exists($permission, $permissions))
    {
      if($role >= $permissions[$permission])
      {
        return true;
      }else{
        return false;
      }
    }else{
      return false;
    }
  }
?>
