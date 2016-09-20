<?php

  //Retrieve Dependancies
  require_once 'orders.php';

  /**
  * Search Order
  * Args: $email, $customerName, $priority, $status,
  * $pickupTime
  * Queries database for orders matching given filters
  */
  function searchOrder($email, $customerName, $priority, $status, $pickupTime, $orderID)
  {
    //Get PDO
    require_once 'pdo.inc';

    //Identify Search Filters
    $whereConditions = array();
    $filters = array();

    if(!empty($orderID))
    {
      $where = " orders.orderID == :orderID";
    }else{
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
    }

    try{
      //Set Query
      $query = "SELECT orders.*, users.firstName, users.lastName, users.email
      FROM orders
      LEFT JOIN users
      ON orders.userID=users.userID
      WHERE $where
      ORDER BY orders.orderID ASC, orders.deliveryPriority DESC";

      $stmt = $pdo->prepare($query);

      if(empty($orderID))
      {
        //Apply Search Filter Values to Query
        foreach($filters as $filter => $filterVar)
        {
          $stmt->bindValue($filter, $filterVar);
        }
      }else{
        $stmt->bindValue(':email', $orderID);
      }

      //Run Query
      $stmt->execute();

      //Output Results Table
      displayOrders($stmt);

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
    echo '<table>
          <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Order Overview</th>
            <th>Pickup</th>
            <th>Delivery</th>
            <th>Status</th>
            <th>More Details...</th>
      </tr>';

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
            <p>Desc:{$order['description']}</p>
            <p>Weight:{$order['totalWeight']}KG</p>
            <p>Type:{$order['deliveryPriority']}</p>
          </td>
          <td>
            <p>Time:{$order['pickUptime']}</p>
            <p>Address:{$order['pickUpAddress']}</p>
          </td>
          <td>
            <p>Recipient:{$order['recipientName']}</p>
            <p>Recipient Phone:{$order['recipientPhone']}</p>
            <p>Address:{$order['deliveryAddress']}</p>
          </td>
          <td>{$order['orderStatus']}</td>
          <td><a href='view-order.php?orderID={$order['orderID']}'>View</a></td>
        </tr>
      ";
    }

    //Close table tag
    echo "</table>";
  }

  /**
  * Get Packages for Order
  * Args: Integer $orderID
  * Queries database for packages of particular order
  */
  function getPackages($orderID)
  {
    //Get PDO
    require_once 'pdo.inc';

    try{
      //Set Query
      $query = "SELECT packages.*, orders.*
      FROM packages
      LEFT JOIN orders
      ON packages.orderID=orders.orderID
      ORDER BY packages.packageID ASC";

      $stmt = $pdo->prepare($query);

      //Run Query
      $stmt->execute();

      //Output Results Table
      displayPackages($stmt);

    } catch (PDOException $e){
      echo $e->getMessage();
    }
  }

  function outputPackages($stmt)
  {

  }
?>
