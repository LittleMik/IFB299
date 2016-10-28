<!--Process Payment-->
<?php
	if($_SERVER["REQUEST_METHOD"] === "POST")
	{
        $order = new Order();
        $order->getOrder($_GET['orderID']);
        $order->updateStatus(Status::Storing);
        $ID = $order->getID();
        $status = (Status::Storing);

        //Get updated (if they were updated) values and redirect to next step of driver UI
        $newStatus = $order->getStatus();
        $orderID = $order->getID();
        //Redirect Script
        echo "<script>window.location = 'driver.php?orderID={$orderID}&orderStatus={$newStatus}';</script>";
	}
?>

<!--Payment Form-->
<div class="container containerDriver">
	<div class= "texts2">
	    <h2>Store</h2>
        <p>
            When the packages in this order have been stored in the warehouse, press the below button:
        </p>
    </div>
    


	<form method="post">
		
		<button type="submit" class="btn1btn-default">Stored in Warehouse</button>

	</form>
</div>