<!--Process Payment-->
<?php
	if($_SERVER["REQUEST_METHOD"] === "POST")
	{
        $order = new Order();
        $order->getOrder($_GET['orderID']);
        $order->updateStatus(Status::Delivered);
        $ID = $order->getID();
        $status = (Status::Delivered);
        header("Location: driver.php?orderID={$ID}&orderStatus={$status}");
	}
?>

<!--Payment Form-->
<div class="container containerDriver">
	<div class= "texts2">
	    <h2>Delivered</h2>
        <p>
            When the packages in this order have been delivered to the recipient, and signed/not signed for press the below button:
        </p>
    </div>
    


	<form method="post">
        <?php
            $order = new Order();
            $order->getOrder($_GET['orderID']);
            $signature = $order->getSignature();

            if($signature == 0){
                echo '<div class="form-group">
                        <h3>Signature is required.</h3>
                        <label>Did Recipient Sign?</label>
                        <label class="radio-inline"><input type="radio" name="signature" value="1">Yes</label>
                        <label class="radio-inline"><input type="radio" name="signature" value="0" checked="checked">No</label>
                    </div>';
            } else {
                echo '<h3>No Signature is Required for this Order</h3>';
            }
        ?>
        <!--Signature Required-->
		
		
		<button type="submit" class="btn1btn-default">Successfully Delivered</button>

	</form>
</div>