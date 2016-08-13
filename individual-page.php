<!doctype html>
<html>
<head>
    <title>Wifi Hotspots</title>
    
    <meta name="author" content="Greg Mills">
    <meta name="description" content="A collation of reviews about Wifi Hotspots">
    <meta name="keywords" content="Wifi Review, CAB230, Web Design">
    
    <link href="main.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <script type="text/javascript" src="code.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <?php
        session_start();
        if(isset($_POST['submitReview'])){
            //Ensure user is logged in
            require 'userPermission.inc';
            //get the pdo object
            require 'pdo.inc';

            //Insert data from the review form into the database.
            try{
                $sendReviewQuery = $pdo->prepare('
                INSERT INTO reviews (UserID, ItemID, Date, ReviewTitle, ReviewText, Rating)
                VALUES (:userid, :itemid, now(), :reviewtitle, :reviewtext, :rating)');

                $sendReviewQuery->execute(array(
                    ':userid'=>$_SESSION['name'],
                    ':itemid'=>$_POST['itemID'],
                    ':reviewtitle'=>$_POST['reviewTitle'],
                    ':reviewtext'=>$_POST['reviewText'],
                    ':rating'=>$_POST['reviewRating']
                ));
            }catch(PDOException $e){
                echo $e->getMessage(); 
            }
        }

        require 'pdo.inc';
        //Get info for this item.
        try{
            $wifiQuery=$pdo->prepare('SELECT WifiName, Address, Suburb, Latitude, Longitude
                                    FROM items
                                    WHERE ID = :thisID LIMIT 1');
            //Get the info for the right wifi item.
            $wifiQuery->bindValue(':thisID', $_GET['wifi']);
            //Execute the statement
            $wifiQuery->execute();
            $wifiData = $wifiQuery->fetch();
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        //Get info from reviews
        try{
            $reviewQuery=$pdo->prepare('
            SELECT reviews.UserID, ItemID, Date, ReviewTitle, ReviewText, Rating, Firstname, Lastname
            FROM reviews, members
            WHERE ItemID = :currentItem AND 
                  reviews.UserID = members.UserID
            ORDER BY Date');
            //Execute the statement
            $reviewQuery->execute(array(":currentItem"=>$_GET['wifi']));
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        $totalScore = 0;
        $numReviews = $reviewQuery->rowCount();
        //if there are no reviews, display 'no reviews'
        if($numReviews<1){
            $numReviews=1;
            $totalScore = 'No Reviews';
        }
        foreach($reviewQuery as $reviewData){
            $totalScore += $reviewData['Rating'];
        }
        $averageScore = round($totalScore/$numReviews);

        echo "<script>
                window.onload = function var1() {
                    initialize({$wifiData['Latitude']}, {$wifiData['Longitude']}, 'googleMap');
                };
            </script>"
    ?>
    <?php require'display-rating.inc';?>
</head>
<body>
    <div class="wrapper">

        <?php include 'header.inc'?>

        <div itemscope itemtype="http://schema.org/Place" class="content">
            <!--General Information and 'leave review button'-->
            <div class="col-two-third">
                <?php
                    //Display Wifi Information
                    if(($wifiQuery->rowCount())==1){
                        echo '<div class="info panel">
                                <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                                    <meta itemprop="ratingValue" content="',$averageScore,'">
                                    <meta itemprop="reviewCount" content="',$numReviews,'">
                                </div>
                                <h2 class="align-text-center"><span itemprop="name">',$wifiData['WifiName'],'</span></h2>
                                <p>Average Rating = ', displayRatingLarge($averageScore), '</p>
                                <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                    <p>Address: <span itemprop="streetAddress">', $wifiData['Address'],'</span></p>
                                    <p>Suburb: <span itemprop="addressLocality">',$wifiData['Suburb'],'</span>,</p>
                                </div>
                                <div itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates">
                                    <meta itemprop="latitude" content="',$wifiData['Latitude'],'" />
                                    <meta itemprop="longitude" content="',$wifiData['Longitude'],'" />
                                </div>
                              </div>
                              <div class="panel">
                                <div id="googleMap" class="individualMap"></div>
                              </div>';
                    }else{
                        header ("Location: error-page.php");
                        exit();
                    }
                ?>  
                    <!--The review Section. Here users can post reviews on wifi sites-->  
                    <div class="panel review-panel">
                        <form class = "review-form center" action="" method="post">
                            <h1 class="align-text-center">Leave Review</h1>

                            <input id ="review-title" placeholder="Review Title" type="text" name="reviewTitle"/>
                            <br><br>
                            <textarea placeholder="Write your review here." name="reviewText"></textarea>

                            <div class = "star-rating center">
                                <input class="star star-5" id="star-5" type="radio" name="reviewRating" value="5">
                                <label class="star star-5" for="star-5"></label>
                                <input class="star star-4" id="star-4" type="radio" name="reviewRating" value="4">
                                <label class="star star-4" for="star-4"></label>
                                <input class="star star-3" id="star-3" type="radio" name="reviewRating" value="3" checked="checked">
                                <label class="star star-3" for="star-3"></label>
                                <input class="star star-2" id="star-2" type="radio" name="reviewRating" value="2">
                                <label class="star star-2" for="star-2"></label>
                                <input class="star star-1" id="star-1" type="radio" name="reviewRating" value="1">
                                <label class="star star-1" for="star-1"></label>
                            </div>
                    <?php 
                        //send the id of the wifi when this form is submitted.
                        echo '<input type="hidden" name="itemID" value="',$_GET['wifi'],'">';
                    ?>
                        <p></p>

                        <div class="review-button center">
                            <button name="submitReview" id="review-button-inner" href="#" class="button" type="submit"><span>&#10004</span>Submit</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-third">
            <?php
            //Execute the query again, so the reviews can also use it.
            $reviewQuery->execute(array(":currentItem"=>$_GET['wifi'])); 
            //display all the reviews
            foreach($reviewQuery as $reviewData){
                echo '

                <div>
                    <div itemprop="review" itemscope itemtype="http://schema.org/Review" class = "panel info">
                        <p>
                            ',displayRatingSmall($reviewData['Rating']),'
                        </p>
                        <h3 itemprop="name">',$reviewData['ReviewTitle'],'</h3>
                        <p itemprop="description">',$reviewData['ReviewText'],'</p>
                        <p>-<span itemprop="author">',$reviewData['Firstname'],' ',$reviewData['Lastname'],'</span></p>
                        <p>Submitted on: <span itemprop="datePublished">',$reviewData['Date'],'</span></p>
                        <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                          <meta itemprop="ratingValue" content = "',$reviewData['Rating'],'">
                        </div>
                        <meta itemReviewed="',$wifiData['WifiName'],'">
                    </div>
                </div>';
            }
            ?>
            </div> 
        </div>

        <?php include 'footer.inc'?>

    </div>
    
</body>
</html>