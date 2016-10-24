<?php
	abstract class Status
	{
		const Ordered = 0;
		const PickingUp = 1;
		const PickedUp = 2;
		const Storing = 3;
		const Delivering = 4;
		const Delivered = 5;

		function getStatusName($statusID)
		{
			switch ($statusID) {
			case Status::Ordered:
					return "Ordered";
					break;
			case Status::PickingUp:
					return "Picking Up";
					break;
			case Status::PickedUp:
					return "Picked Up";
					break;
			case Status::Storing:
					return "Storing";
					break;
			case Status::Delivering:
					return "Delivering";
					break;
			case Status::Delivered:
					return "Delivered";
					break;
			}
		}
	}
?>
