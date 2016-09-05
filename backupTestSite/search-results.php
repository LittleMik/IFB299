<!-- Get Query Data -->
<?php
    session_start();
    /* Acquire all the relevant search results */
    require 'pdo.inc';
    
    try{
        $tableDataQuery = 'SELECT ID, WifiName, Address, Suburb, Latitude, Longitude, 
                            
                            /*Determines distance between two coordinates.
                            found at: https://www.marketingtechb log.com/calculate-distance/*/
                            TRUNCATE((((acos(sin((:lat1a*pi()/180)) * sin((`Latitude`*pi()/180))+cos((:lat1b*pi()/180)) * cos((`Latitude`*pi()/180)) * cos(((:lon1- `Longitude`)*pi()/180))))*180/pi())*60*1.1515*1.609344),2)
                            AS "Distance",
                            
                            /*Determine average rating*/
                            CASE WHEN ROUND(AVG(COALESCE(reviews.Rating))) IS NOT NULL
                                THEN ROUND(AVG(COALESCE(reviews.Rating)))
                                ELSE 0
                            END AS Rating

                            FROM items LEFT JOIN reviews
                                ON reviews.ItemID = items.ID

                            WHERE WiFiName LIKE :name
                            AND Suburb Like :suburb
                            GROUP BY WifiName
                            HAVING (Distance < :distance1 
                                OR :distance2 = 0)
                                AND :minRating <= Rating';
                            
        //Order by correct sort
        if($_GET['sort']=='name'){
            $tableDataQuery .= " ORDER BY WifiName";
        }else if($_GET['sort']=='suburb'){
            $tableDataQuery .= " ORDER BY Suburb";
        }else if($_GET['sort']=='distance'){
            $tableDataQuery .= " ORDER BY Distance";
        }else if($_GET['sort']=='rating'){
            $tableDataQuery .= " ORDER BY Rating DESC";
        }

        $tableData=$pdo->prepare($tableDataQuery);


        //If the user input a name, check for matches to that
        if($_GET['name'] != ""){
            $tableData->bindValue(':name', '%'.$_GET['name'].'%');
        //otherwise check for all matches
        } else {
            $tableData->bindValue(':name', '%');
        }
        //If the user selected a suburb check for that
        if($_GET['suburb'] != ""){
            $tableData->bindValue(':suburb', '%'.$_GET['suburb'].'%');
        //otherwise check for all matches
        } else {
            $tableData->bindValue(':suburb', '%');
        }
        //Bind the users minium search distance, set it to zero if not set
        if($_GET['maxDistance'] != ""){
            $tableData->bindValue(':distance1', $_GET['maxDistance']);
            $tableData->bindValue(':distance2', $_GET['maxDistance']);
        //otherwise set to zero
        } else {
            $tableData->bindValue(':distance1', '0');
            $tableData->bindValue(':distance2', '0');
        }
        
        //Bind the minimum rating value to the query
        //If the user input a rating, change the query binding to that
        if(isset($_GET['minRating'])){
            $tableData->bindValue(':minRating', $_GET['minRating']);
        //otherwise set to 0
        } else {
            $tableData->bindValue(':minRating', 0);
        }
        
        //Bind the latitudes and longitudes
        $tableData->bindValue(':lat1a', $_GET['userLat']);
        $tableData->bindValue(':lat1b', $_GET['userLat']);
        $tableData->bindValue(':lon1', $_GET['userLon']);
        //Execute the statement
        $tableData->execute();
        
        /*Get latitudes and put in array ready to be converted to javascript*/
        $latitudes = $tableData->fetchAll(PDO::FETCH_COLUMN, 4);
        $tableData->execute();
        /*Get longitudes and put in array ready to be converted to javascript*/
        $longitudes = $tableData->fetchAll(PDO::FETCH_COLUMN, 5);
        $tableData->execute();
        /*Get names and put in array ready to be converted to javascript*/
        $names = $tableData->fetchAll(PDO::FETCH_COLUMN, 1);
        $tableData->execute();
        //Get all ID's and put in array to be converted to javascript*/
        $IDs = $tableData->fetchAll(PDO::FETCH_COLUMN, 0);
        $tableData->execute();
    }catch(PDOException $e){
        echo $e->getMessage();
    }
?>

<script>
    var latitudes = [<?php echo '"'.implode('","', $latitudes).'"' ?>];
    var longitudes = [<?php echo '"'.implode('","', $longitudes).'"' ?>];
    var names = [<?php echo '"'.implode('","', $names).'"' ?>];
    var ids = [<?php echo '"'.implode('","', $IDs).'"' ?>];
    
    window.onload = function() { searchInitialize(latitudes,longitudes,names,ids,"googleMap"); }
</script>

<!DOCTYPE html>
<html>
<head>
    <title>Wifi Hotspots</title>
    
    <meta name="author" content="Greg Mills">
    <meta name="description" content="A collation of reviews about Wifi Hotspots">
    <meta name="keywords" content="Wifi Review, CAB230, Web Design">
    
    <link href="main.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript" src="location.js"></script>
    <script type="text/javascript" src="code.js"></script>
</head>
<body>
<div class="wrapper">
    
    <?php include 'header.inc' ?>
    
	
	<div class = "content">
        <div class="panel info">
            <form class="center" id="search-page-form" action="search-results.php" method="get">
                <div class="seperate">
                    <input id ="" placeholder="Name of Wifi..." type="text" name="name" />
                    <span>&nbsp:&nbsp</span>

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
                    <span>&nbsp;</span>
                    <label for "min-rating">Minium Rating: </label>
                    
                    <select id="min-rating" name="minRating">
                        <option selected="selected" value="">Any</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>

                    <input type="hidden" ID="userLatitude" name="userLat" value="">
                    <input type="hidden" ID="userLongitude" name="userLon" value="">
                    <input type="hidden" name="sort" value="name">
                    <input type="hidden" name="maxDistance" value="">

                    <span>&nbsp&nbsp</span>
                    <input class="small-button" type="submit" value="&#128270">

                </div>
            </form>
        </div>
        <div class="panel">
            <div id="googleMap" class="search-map"></div>
        </div>
        <div class="panel">
            <table id="search-table" class = "center">
                <tr>
                    <th colspan="4"><div class="status"></div><h2 class="align-text-center">Search Results</h2></th>
                </tr>
                <?php
                    /*Display all the relevant search results*/
                    require 'display-rating.inc';
                    /*If maxDistance was not given, ignore it*/
                    $ignoreDistance = False;
                    if($_GET['maxDistance']==""){
                        $ignoreDistance = True;
                    }
                    echo "
                    <tr>
                        <th><a href=\"search-results.php?name={$_GET['name']}&suburb={$_GET['suburb']}&userLat={$_GET['userLat']}&userLon={$_GET['userLon']}&sort=name&maxDistance={$_GET['maxDistance']}\"><i class=\"fa fa-sort\" aria-hidden=\"true\"></i>Name</a></th>

                        <th><a href=\"search-results.php?name={$_GET['name']}&suburb={$_GET['suburb']}&userLat={$_GET['userLat']}&userLon={$_GET['userLon']}&sort=suburb&maxDistance={$_GET['maxDistance']}\"><i class=\"fa fa-sort\" aria-hidden=\"true\"></i>Suburb</a></th>

                        <th><a href=\"search-results.php?name={$_GET['name']}&suburb={$_GET['suburb']}&userLat={$_GET['userLat']}&userLon={$_GET['userLon']}&sort=distance&maxDistance={$_GET['maxDistance']}\"><i class=\"fa fa-sort\" aria-hidden=\"true\"></i>Distance</a></th>

                        <th><a href=\"search-results.php?name={$_GET['name']}&suburb={$_GET['suburb']}&userLat={$_GET['userLat']}&userLon={$_GET['userLon']}&sort=rating&maxDistance={$_GET['maxDistance']}\"><i class=\"fa fa-sort\" aria-hidden=\"true\"></i>Average Rating</a></th>
                    </tr>";


                    foreach($tableData as $tableRow){
                        echo '
                        <tr>
                            <td>
                                <a href=\'individual-page.php?wifi=',$tableRow['ID'],'\'>', $tableRow['WifiName'],'</a>
                            </td>
                            <td>', 
                                $tableRow['Suburb'],'
                            </td>
                            <td>', 
                                $tableRow['Distance'],' km', '
                            </td>
                            <td>'; 
                                if($tableRow['Rating']!=0){
                                    displayRatingSmall($tableRow['Rating']);
                                }else {
                                    echo 'No Reviews';
                                }
                            echo'
                            </td>
                        </tr>';
                        
                    }
                ?>
            </table>
        </div>
	</div>
    
   <?php include 'footer.inc'?>
    
</div>
    
</body>

</html>