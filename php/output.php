<?php
	// ======================================== Output Functions ======================================== //
	/**
	*	Output Functions
	*
	*	All functions for outputing database query information to tables
	*
	*	@author Michael Smallcombe & Greg Mills
	*/
	// ============================================================================================= //

	// ==================== Order Lookup ==================== //
	/**
	* Output Order All
	* Outputs all information relevant to a specific order to
	* a table
	*
	* @param (Order) $order Populated Order object
	* @param (array) $packages Array containg Package objects relevant to the orderID
	* @param (array) $payment Array containing payment information
	*/
	function outputOrderAll($order, $packages, $payment)
	{
		outputOrder($order);
		outputPackages($packages);
		outputPayment($payment);
	}

	/**
	* Output Order
	* Outputs information from an Order Object into a table
	*
	* @param (Order) $order Populated Order object
	*/
	function outputOrder($order)
	{
		//Orders Table
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
			</thead>
			<tbody>';

			//Output Order Row
			$order->displayOrder();

			//Close Order Table Tags
			echo "</tbody></table>";
	}

	/**
	* Output Orders
	* Outputs information from an Array of Order Objects into a table
	*
	* @param (Array) $orders Array of Order objects
	*/
	function outputOrders($orders)
	{
		//Orders Table
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
			</thead>
			<tbody>';

			foreach($orders as $order)
			{
				//Output Order Row
				$order->displayOrder();
			}

			//Close Order Table Tags
			echo "</tbody></table>";
	}

	/**
	* Output Packages
	* Outputs individual package details from
	* an array of packages to a table
	*
	* @param (array) $packages array containing Package objects
	*/
	function outputPackages($packages)
	{
		//Output Packages Table
		echo '
			<h3>Packages</h3>
			<table class="table table-striped table-condensed table-responsive">
				<thead>
					<tr>
						<th>ID</th>
						<th>Description</th>
						<th>Weight</th>
					</tr>
				</thead>
				<tbody>';

		//Display Packages
		//Check if packages are present
		if(empty($packages))
		{
			//Output No Packages Error
			echo "<tr><td colspan='3'><h4>No packages can be found for this order...</h4></td></tr>";
		}
			else
		{
			foreach($packages as $package)
			{
				//Output Each Package as a Row
				$package->displayPackage();
			}
		}

		//Close Packages Table Tags
		echo '</tbody></table>';
	}

	/**
	* Output Payment
	* Outputs payment details from an array to a table
	*
	* @param (array) $payment array containing payment information
	*/
	function outputPayment($stmt)
	{
		if($stmt->rowCount() == 0)
		{
			if(isset($_SESSION['role']))
			{
				if(checkPermission($_SESSION['role'], 'payments-add') === true)
				{
					echo "<a href='payment.php?orderID={$_GET['orderID']}' class='btn1btn-default'>Add Payment</a>";
				}
			}
		}else{
			//Fetch Payment
			$payment = $stmt->fetch();

			//Output Payment Results
			echo '
				<h3>Payment</h3>
				<table class="table table-striped table-condensed table-responsive">
					<thead>
						<tr>
							<th>Order ID</th>
							<th>Customer</th>
							<th>Type</th>
							<th>Date</th>
							<th>Amount</th>
						</tr>
					</thead>';

			//Output each result row as a single order
			echo "
				<tbody>
					<tr>
						<td>{$payment['orderID']}</td>
						<td>
							<p>{$payment['firstName']} {$payment['lastName']}</p>
						</td>
						<td>{$payment['paymentType']}</td>
						<td>{$payment['paymentDate']}</td>
						<td>{$payment['paymentAmount']}</td>
					</tr>
				</tbody>";

			//Close table tag
			echo "</table>";
		}
	}

	/**
	* Output Results of Orders Search
	* Outputs results from the orders search statment
	*
	* @param (PDOStatement) $stmt Results of the orders search query
	*/
	function outputResultOrders($stmt)
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
						<th>Options...</th>
					</tr>
				</thead>
			<tbody>';

		//Output each result row as a single order
		foreach($stmt as $order)
		{
			require_once 'php/status.php';
			$orderStatus = Status::getStatusName($order['orderStatus']);
			$assignedDriver = "Not Yet Assigned.";
			if (isset($order['driverID'])){
				require_once 'php/users.php';
				$user = new User();
				$user->getUser($order['driverID']);
				$firstName = $user->getFirstName();
				$lastName = $user->getLastName();
				$assignedDriver = "{$firstName} {$lastName}";
			}

			echo "
				<tr>
					<td>{$order['orderID']}</td>
					<td>
						<p>{$order['firstName']} {$order['lastName']}</p>
						<p>{$order['email']}</p>
					</td>
					<td>
						<p>Desc: {$order['description']}</p>
						<p>Type: {$order['deliveryPriority']}</p>
						<p>Assigned Driver: {$assignedDriver}</p>
					</td>
					<td>
						<p>Preferred Time: {$order['pickupTime']}</p>
						<p>Address: {$order['pickupAddress']}</p>
						<p>Postcode: {$order['pickupPostcode']}</p>
						<p>State: {$order['pickupState']}</p>
					</td>
					<td>
						<p>Preferred Time: {$order['deliveryTime']}</p>
						<p>Recipient: {$order['recipientName']}</p>
						<p>Recipient Phone: {$order['recipientPhone']}</p>
						<p>Address: {$order['deliveryAddress']}</p>
						<p>Postcode: {$order['deliveryPostcode']}</p>
						<p>State: {$order['deliveryState']}</p>
					</td>
					<td>{$orderStatus}</td>";


			//Verify User Permission to Edit Orders
			require_once 'php/permissions.php';

			if(isset($_SESSION['role']))
			{
				if(checkPermission($_SESSION['role'], 'edit-order.php') === true)
				{
					echo "<td>
							<p><a class='btn btn-info' href='edit-order.php?orderID={$order['orderID']}'>Edit</a></p>
							<p><a class='btn btn-info' href='driver.php?orderID={$order['orderID']}&orderStatus={$order['orderStatus']}'>Update Status</a></p>
							<p><a class='btn btn-info' href='view-order.php?orderID={$order['orderID']}'>View</a></p>
							<p><a class='btn btn-info' href='assign-driver.php?orderID={$order['orderID']}'>Assign Driver</a></p>
						</td>";
				} else if(checkPermission($_SESSION['role'], 'driver-ui') === true) {
					echo "<td>
							<p><a class='btn btn-info' href='driver.php?orderID={$order['orderID']}&orderStatus={$order['orderStatus']}'>Update Status</a></p>
							<p><a class='btn btn-info' href='view-order.php?orderID={$order['orderID']}'>View</a></p>
						</td>";
				} else {
					echo "<td>
							<p><a class='btn btn-info' href='view-order.php?orderID={$order['orderID']}'>View</a></p>
						</td>";
				}
			}

			echo "

				</tr>
			";
		}

		//Close table tag
		echo "
			</tbody>
		</table>";
	}

	/**
	* Output Package Inputs
	* Outputs packages input fields within an order
	*
	* @param (Array) $packages Array containing Package objects
	*/
	function outputPackageInputs($packages)
	{
		//Output Inputs for Each Package in Packages array
		foreach($packages as $package)
		{
			echo '
			<!--Packages
				Code for adding extra packages is in customJavascript.hs
			-->
			<div class="input_fields_wrap">
				<div>
					<div class="form-group">
						<label for="comment">Package Description:</label>
						<input value = "'.$package->getDescription().'"type="text" class="form-control" id="package-description" maxlength="50" name="packageDescription[]" required></textarea>*max 50 characters
					</div>
					<div class="form-group">
						<label for="weight">Package Weight:</label>
						<input value="'.$package->getWeight().'" type="text" class="form-control" id="package-weight" maxlength="50" name="weight[]" required></textarea>*max 50 characters
					</div>
					<input type="hidden" name="hiddenPackageID[]" value="'.$package->getID().'">
				</div>
			</div>
			';
		}
	}
?>
