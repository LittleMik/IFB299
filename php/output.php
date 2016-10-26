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
?>
