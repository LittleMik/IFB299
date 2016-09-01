<!DOCTYPE html>
<html>
<head>
    <title>Wifi Hotspots</title>
    
    <meta name="author" content="Greg Mills">
    <meta name="description" content="A collation of reviews about Wifi Hotspots">
    <meta name="keywords" content="Wifi Review, CAB230, Web Design">
    
    <link href="main.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <script type="text/javascript" src="location.js"></script>
    <?php session_start(); ?>
</head>
    
<body class="index" onload="getLocation()">
<div class="wrapper">
    <?php include 'header.inc' ?>
    <div class="content">
        <div class="search-form">
            <form action="search-results.php" method="get">
                <div class="seperate">
                    <h1 class="align-text-center">The php version of this webserver is: <?php echo phpversion();?></h1>

                    <input id ="name-field-frontpage" placeholder="Name of Wifi..." type="text" name="name" />
                    <span>:</span>

                    <!--Get and display all possible suburbs in the suburb selector dropdown-->
                    <select id ="suburb-field-frontpage" name ="suburb">
                        <option selected="selected" value="">Suburb</option> 
                        <?php
                            require 'pdo.inc';
                            try{
                                $suburbList =$pdo->query('SELECT DISTINCT Suburb
                                                       FROM items
                                                       ORDER BY Suburb');
                            }catch(PDOException $e){
                                echo $e->getMessage(); 
                            }
                            foreach($suburbList as $suburb){
                                echo '<option value="',$suburb['Suburb'],'">',$suburb['Suburb'],'</option>';
                            }
                        ?>
                    </select>
                    
                    <div class = "star-rating center">
                        <input class="star star-5" id="star-5" type="radio" name="minRating" value="5">
                        <label class="star star-5" for="star-5"></label>
                        <input class="star star-4" id="star-4" type="radio" name="minRating" value="4">
                        <label class="star star-4" for="star-4"></label>
                        <input class="star star-3" id="star-3" type="radio" name="minRating" value="3">
                        <label class="star star-3" for="star-3"></label>
                        <input class="star star-2" id="star-2" type="radio" name="minRating" value="2">
                        <label class="star star-2" for="star-2"></label>
                        <input class="star star-1" id="star-1" type="radio" name="minRating" value="1">
                        <label class="star star-1" for="star-1"></label>
                    </div>

                    <h2 class="align-text-center" id="min-rating-label">Min Rating</h2>   

                    <input type="hidden" ID="userLatitude" name="userLat" value="">
                    <input type="hidden" ID="userLongitude" name="userLon" value="">
                    <input type="hidden" name="sort" value="name">
                    <input type="hidden" name="maxDistance" value="">

                    <div class="search-button center">
                        <button class="button" type="submit"><span>&#128270;</span>Search</button>
                    </div>
                </div>
            </form>
            <h1 class="align-text-center">or</h1>
            <form action="search-results.php" method="get">
                <input type="hidden" ID="userLatitude2" name="userLat" value="">
                <input type="hidden" ID="userLongitude2" name="userLon" value="">
                <input type="hidden" name="sort" value="distance">
                <input type="hidden" name="name" value="">
                <input type="hidden" name="suburb" value="">
                
                <div id="near-me-container" class="center">
                    <input id="near-me-input" type="number" name="maxDistance" placeholder="Distance From You">
                     &nbsp &nbsp
                    <button type=submit class= "small-button" id ="near-me-button">WiFi Near Me</button>
                </div>
            </form>
        </div>
        
        
    </div>

    <?php include 'footer.inc'?>
    
</div>
    
</body>

</html>