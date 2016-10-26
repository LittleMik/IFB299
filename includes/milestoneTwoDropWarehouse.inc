<!--Process Payment-->
<?php
	if($_SERVER["REQUEST_METHOD"] === "POST")
	{
        $order = new Order();
        $order->getOrder($_GET['orderID']);
        $order->updateStatus(Status::Storing);
        $ID = $order->getID();
        $status = (Status::Storing);
        header("Location: driver.php?orderID={$ID}&orderStatus={$status}");
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