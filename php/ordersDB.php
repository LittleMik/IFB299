<?php

  //Retrieve Dependancies
  require_once 'orders.php';

  /**
  * Search Order
  * Args: $email, $customerName, $priority, $status,
  * $pickupTime
  * Returns PDO Statement
  */
  function searchOrder($email, $customerName, $priority, $status, $pickupTime)
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
    if(!empty($customerName))
    {
      $whereConditions[] = " LOWER(CONCAT_WS(' ', users.firstName, users.lastName)) LIKE CONCAT(LOWER(:customerName),'%')";
      $filters["customerName"] = $customerName;
    }
    if(!empty($priority))
    {
      $whereConditions[] = " orders.deliveryPriority LIKE :priority";
      $filters["priority"] = $priority;
    }

    //Set SQL Where Statement According to Filters
    if(!empty($whereConditions))
    {
      $where = implode(' AND ', $whereConditions);
    }else{
      //Set Empty Where Statement (Accepts all values)
      $where = " users.email LIKE '%'";
    }

    try{
      //Set Query
      $query = "SELECT orders.*, users.firstName, users.lastName, users.email
      FROM orders
      LEFT JOIN users
      ON orders.userID = users.userID
      WHERE $where
      ORDER BY orders.orderID ASC, orders.deliveryPriority DESC";

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
  * Output Results of Orders Search
  * Args: PDO Statment ResultSet $stmt
  * Echos order results into table
  */
  function displayOrders($stmt)
  {
    //Output Orders Table
    echo '<table class="table table-striped table-condensed table-responsive">
		<thead>
          <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Order Overview</th>
            <th>Pickup</th>
            <th>Delivery</th>
            <th>Status</th>
            <th>More Details...</th>
          </tr>
        </thead>
      <tbody>';

    //Output each result row as a single order
    foreach($stmt as $order)
    {
      echo "
        <tr>
          <td>{$order['orderID']}</td>
          <td>
            <p>{$order['firstName']} {$order['lastName']}</p>
            <p>{$order['email']}</p>
          </td>
          <td>
            <p>Desc: {$order['description']}</p>
            <p>Weight: {$order['totalWeight']}KG</p>
            <p>Type: {$order['deliveryPriority']}</p>
          </td>
          <td>
            <p>Time: {$order['pickUptime']}</p>
            <p>Address: {$order['pickUpAddress']}</p>
          </td>
          <td>
            <p>Recipient: {$order['recipientName']}</p>
            <p>Recipient Phone: {$order['recipientPhone']}</p>
            <p>Address: {$order['deliveryAddress']}</p>
          </td>
          <td>{$order['orderStatus']}</td>
          <td><a href='view-order.php?orderID={$order['orderID']}'>View</a>";

      //Verify User Permission to Edit Orders
      require_once 'php/permissions.php';

      if(isset($_SESSION['role']))
      {
        if(checkPermission($_SESSION['role'], 'edit-order.php') === true)
        {
          echo "<a href='order-information.php?orderID={$order['orderID']}'>Edit</a>";
        }
      }

      echo "
          </td>
        </tr>
      ";
    }

    //Close table tag
    echo "
      </tbody>
    </table>";
  }

  /**
  * Get Order
  * Args: orderID
  * Returns Array containing order information retrieved from the database
  */
  function getOrder($orderID)
  {
    require 'pdo.inc';

    if(!empty($orderID))
    {

      $where = " orders.orderID = :orderID";

      try{
        //Set Query
        $query = "SELECT orders.*, users.firstName, users.lastName, users.email
        FROM orders
        LEFT JOIN users
        ON orders.userID = users.userID
        WHERE $where
        ORDER BY orders.orderID ASC, orders.deliveryPriority DESC";

        $stmt = $pdo->prepare($query);

        //Bind OrderID value
        $stmt->bindValue(':orderID', $orderID);

        //Run Query
        $stmt->execute();

        //Return OrderInfo Array
        $order = $stmt->fetch();

        return $order;

      } catch (PDOException $e){
        echo $e->getMessage();
      }
    }
  }

  /**
  * Get Packages for Order
  * Args: Integer $orderID
  * Returns PDO Statement
  */
  function getPackages($orderID)
  {
    //Get PDO
    require 'pdo.inc';

    try{

      $where = " orderID = :orderID";

      //Set Query
      $query = "SELECT *
      FROM packages
      WHERE $where
      ORDER BY packageID ASC";

      $stmt = $pdo->prepare($query);

      //Bind orderID value
      $stmt->bindValue(':orderID', $orderID);

      //Run Query
      $stmt->execute();

      //Return Statement
      return $stmt;

    } catch (PDOException $e){
      echo $e->getMessage();
    }
  }

  function displayPackages($order, $stmtPackages)
  {
    //Output Order Info
    echo '
    <h3>Order</h3>
    <table class="table table-striped table-condensed table-responsive">
		<thead>
          <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Description</th>
            <th>Pickup</th>
            <th>Delivery</th>
            <th>Recipient</th>
            <th>Status</th>
            <th> </th>
          </tr>
    </thead>';

    echo "
    <tbody>
      <tr>
        <td>{$order['orderID']}</td>
        <td>
          <p>{$order['firstName']} {$order['lastName']}</p>
          <p>{$order['email']}</p>
        </td>
        <td>
          <p>Desc: {$order['description']}</p>
          <p>Total Weight: {$order['totalWeight']}KG</p>
          <p>Type: {$order['deliveryPriority']}</p>";
      if($order['signature'] === '1')
      {
        echo "<p>Signature Required</p>";
      }
    echo "
        </td>
        <td>
          <p>Preferred Time: {$order['pickUptime']}</p>
          <p>Address: {$order['pickUpAddress']}</p>
        </td>
        <td>
          <p>Preferred Time: {$order['deliveryTime']}</p>
          <p>Address: {$order['deliveryAddress']}</p>
        </td>
        <td>
          <p>Name: {$order['recipientName']}</p>
          <p>Phone: {$order['recipientPhone']}</p>
        </td>
        <td>{$order['orderStatus']}</td>";

    //Verify User Permission to Edit Orders
    require_once 'php/permissions.php';

    if(isset($_SESSION['role']))
    {
      if(checkPermission($_SESSION['role'], 'order-information.php') === true)
      {
        echo "
          <td>
            <a href='order-information.php?orderID={$order['orderID']}'>Edit</a>
          </td>";
      }
    }

    echo "
      </tr>
    </tbody>
    </table>";

    //Output Orders Table
    echo '
    <h3>Packages</h3>
    <table class="table table-striped table-condensed table-responsive">
		<thead>
          <tr>
            <th>ID</th>
            <th>Status</th>
            <th>Weight</th>
            <th>Time: PickedUp</th>
            <th>Time: Stored</th>
            <th>Time: Delivery</th>
            <th>Time: Delivered</th>
          </tr>
        </thead>
      <tbody>';

      //Check if packages are present in query results
      if(empty($stmtPackages))
      {
        echo "
        <tr><h3>No packages can be found for this order...</h3></tr>
        </tbody>";
      }else
      {
        //Output each result row as a single order
        foreach($stmtPackages as $package)
        {
          echo "
            <tr>
              <td>{$package['packageID']}</td>
              <td>{$package['packageStatus']}</td>
              <td>{$package['packageWeight']}KG</td>
              <td>
                <p>Time: {$package['pickupTime']}</p>
              </td>
              <td>
                <p>Time: {$package['stored']}</p>
              </td>
              <td>
                <p>Time: {$package['delivery']}</p>
              </td>
              <td>
                <p>Time: {$package['delivered']}</p>
              </td>";

          //Verify User Permission to Edit Orders
          require_once 'php/permissions.php';

          if(isset($_SESSION['role']))
          {
            if(checkPermission($_SESSION['role'], 'package-information.php') === true)
            {
              echo "
                <td>
                  <a href='package-information.php?packageID={$package['packageID']}'>Edit</a>
                </td>
              </tr>";
            }
          }

          //Close Cell and Row tags
          echo "
              </td>
            </tr>
          ";
      }
    }

    //Close Table Tags
    echo "
    </tbody>
    </table>
    </div>";

  }
?>
