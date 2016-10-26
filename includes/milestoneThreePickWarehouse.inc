<!--Process Payment-->
<?php
	if($_SERVER["REQUEST_METHOD"] === "POST")
	{
        $order = new Order();
        $order->getOrder($_GET['orderID']);
        $order->updateStatus(Status::Delivering);
        $ID = $order->getID();
        $status = (Status::Delivering);
        header("Location: driver.php?orderID={$ID}&orderStatus={$status}");
	}
?>

<!--Payment Form-->
<div class="container containerDriver">
	<div class= "texts2">
	    <h2>Pickup</h2>
        <p>
            When the packages in this order have been picked up from the warehouse, and you are now delivering to the order recipient, press the below button:
        </p>
    </div>
    
	<form method="post">
		<button type="submit" class="btn1btn-default">Taking to Recipient</button>
	</form>
</div>