<?php
  abstract class Roles
  {
    const Customer = 0;
    const Driver = 1;
    const Coordinator = 2;
    const Manager = 3;
    const Admin = 4;
  }

  function getRoleName($role)
	{
    switch ($role){
			case Roles::Customer:
				return "Customer";
				break;
			case Roles::Driver:
				return "Driver";
				break;
			case Roles::Coordinator:
				return "Coordinator";
				break;
			case Roles::Manager:
				return "Manager";
				break;
			case Roles::Admin:
				return "Admin";
				break;
			default:
				return "Unknown Role";
		}
 	}
?>