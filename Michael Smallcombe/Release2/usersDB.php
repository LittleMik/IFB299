<?php

  require_once 'users.php';

	//Login with email
	function login($email)
	{
		$user = new User();
		$user->getUserByEmail($email);

		$_SESSION['login'] = true;
		$_SESSION['firstname'] = $user->firstName;
		$_SESSION['user'] = serialize($user);
		$_SESSION['role'] = $user->role;
    $_SESSION['ID'] = $user->getID();
	}

	function loginWithID($userID)
	{
		$user = new User();
		$user->getUser($userID);

		$_SESSION['login'] = true;
		$_SESSION['firstname'] = $user->firstName;
		$_SESSION['user'] = serialize($user);
		$_SESSION['role'] = $user->role;
	}

  function searchUsers($email, $name, $role)
  {
    //Get PDO
    require 'pdo.inc';

    //Identify Search Filters
    $whereConditions = array();
    $filters = array();

    //Check which filters are set
    if(!empty($email))
    {
      $whereConditions[] = " LOWER(users.email) LIKE CONCAT(LOWER(:email),'%')";
      $filters["email"] = $email;
    }
    if(!empty($name))
    {
      $whereConditions[] = " LOWER(CONCAT_WS(' ', users.firstName, users.lastName)) LIKE CONCAT(LOWER(:name),'%')";
      $filters["name"] = $name;
    }
    if(!empty($role))
    {
      $whereConditions[] = " roles.role LIKE :role";
      $filters["role"] = $role;
    }

    //Set SQL Where Statement According to Filters
    if(!empty($whereConditions))
    {
      $where = implode(' AND ', $whereConditions);
    }else{
      //Set Empty Where Statement (Accepts all values)
      $where = " users.userID LIKE '%'";
    }

    try{
      //Set Query
      $query = "SELECT DISTINCT users.*, roles.role
      FROM users
      LEFT JOIN roles
      ON users.userID=roles.userID
      WHERE $where
      ORDER BY users.userID ASC, roles.role DESC";

      $stmt = $pdo->prepare($query);

      //Apply Search Filter Values to Query
      foreach($filters as $filter => $filterVar)
      {
        $stmt->bindValue($filter, $filterVar);
      }

      //Run Query
      $stmt->execute();

      //Return PDO Statmenet
      return $stmt;

    } catch (PDOException $e){
      echo $e->getMessage();
    }
  }


  /**
  * Output Results of Users Search
  * Args: PDO Statment ResultSet $stmt
  * Echos user results into table
  */
  function displayUsers($stmt)
  {
    require_once 'php/roles.php';
    //Output Orders Table
    echo '<table class="table table-striped table-condensed table-responsive">
		<thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Role</th>
            <th>Contact Details</th>
            <th>Address</th>
            <th> </th>
          </tr>
        </thead>
      <tbody>';

    //Output each result row as a single order
    foreach($stmt as $user)
    {
      $roleTitle = getRoleName($user['role']);
      echo "
        <tr>
          <td>{$user['userID']}</td>
          <td>
            <p>{$user['firstName']} {$user['lastName']}</p>
          </td>
          <td>{$roleTitle}</td>
          <td>
            <p>Phone: {$user['phoneNumber']}</p>
            <p>Email: {$user['email']}</p>
          </td>
          <td>
            <p>Address: {$user['address']}</p>
            <p>PostCode: {$user['postcode']}</p>
            <p>State: {$user['state']}</p>
          </td>";

      //Verify User Permission to Edit Orders
      require_once 'php/permissions.php';

      //Output Edit Button if role permission requirements are met
      if(isset($_SESSION['role']))
      {
        if(checkPermission($_SESSION['role'], 'edit-accounts.php') === true)
        {
          echo "
          <td>
            <a href='edit-user.php?userID={$user['userID']}'>Edit</a>
          </td>";
        }
      }

      //Close Row Tag
      echo "</tr>";

    }

    //Close table tag
    echo "
      </tbody>
    </table>";
  }

  /**
  * Verify User Password against Email
  * Args: $email, $password
  * Returns true if row found matching arguments
  */
  function verifyPassword($email, $password)
  {
    require_once 'pdo.inc';
		try
    {

      //Prepare verification query
			$checkQuery = $pdo->prepare(
				'SELECT * FROM users
				WHERE email = :email
				AND password = SHA2(CONCAT(:password, salt), 0) '
			);

      //Bind verified email and password input values
			$checkQuery->bindValue(':email',$email);
			$checkQuery->bindValue(':password',$password);

      //Run Query
			$checkQuery->execute();

      //If rows are found, the results therefore match an existing account
			if($checkQuery->rowCount() > 0){
				return true;
			}else{return false;}

		} catch(PDOException $e){

			//Output Error
			echo $e->getMessage();
			echo '<p>'.$e.'</p>';

		}
  }


?>