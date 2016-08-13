 <?php
	function displayRatingSmall($rating){
		//Initilise Constant.
		$maxRating = 5;		
		
		//Create table data cell
		//Create a number of full stars equal to the rating argument.
		$i = 1;
		while($i <= $rating){
			$i++;
			echo '<i class="fa fa-star"></i>';
		}
		
		//Fill remaining stars with empty stars.
		$i = 1;
		while($i <= ($maxRating-$rating)){
			$i++;
			echo '<i class="fa fa-star-o"></i>';
		}
	}
    
    function displayRatingLarge($rating){
		//Initilise Constant.
		$maxRating = 5;		
		
		//Create table data cell
		//Create a number of full stars equal to the rating argument.
		$i = 1;
		while($i <= $rating){
			$i++;
			echo '<i class="fa fa-star checked-star"></i>';
		}
		
		//Fill remaining stars with empty stars.
		$i = 1;
		while($i <= ($maxRating-$rating)){
			$i++;
			echo '<i class="fa fa-star-o"></i>';
		}
	}
    
    function averageRating($numReviews){
        $totalScore = 0;
        //if there
        if($numReviews<1){
            $numReviews=1;
            $totalScore = 'No Reviews';
        }
        foreach($reviewQuery as $reviewData){
            $totalScore += $reviewData['Rating'];
        }
        $averageScore = round($totalScore/$numReviews);
        //Execute the query again, so the reviews can also use it.
    }
 ?>
 
 
 