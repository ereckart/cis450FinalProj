<html>
    <head>
        <title><? if (isset($_GET['title'])) echo $_GET['title']." - "; ?>Movie Tool</title>
        <style>
            * {
                padding: 0;
                margin: 0;
            }
            html {
                overflow-x: hidden;
            }
            body {
                background-color: white;
                padding: 300px 10vw;
            }
            #header {
                background-color: white;
                position: absolute;
                top: 0;
                left: 0;
                width: calc(100vw - 20px);
                height: 60px;
            }
            #header a {
                display: inline-block;
                padding: 19px 16px;
                font: 22px arial,sans-serif;
                line-height: 22px;
                height: 22px !important;
                color: black;
                text-decoration: none;
            }
            
            #header a.active {
                padding: 19px 16px 15px 16px;
                border-bottom: 4px solid #dd0000;
            }
            #search_bar_container {
                text-align: center;
                width: 100vw;
                height: 204px;
                position: absolute;
                top: 60px;
                left: 0px;
                background-image: URL('pic5.jpg');
                background-size: cover ;
                background-position: 50% 50%;
            }
            
            #search_bar_container #title {
                width: calc(95vw - 10px);
                max-width: 600px;
                font: 20px arial,sans-serif;
                line-height: 54px;
                height: 54px !important;
                padding: 5px 15px;
                margin-top: 70px;
                transition: 0.5s all;
                border: 0px;
            }
            #search_bar_container .search {
                line-height: 54px;
                height: 54px !important;
                font: 20px arial,sans-serif;
                padding: 5px;
                border-radius: 4px;
                border: 0;
                width: 200px;
                height: 54px;
                transition: 0.5s all;
            }
            #results {
                
            }
            #results a {
                color: purple;
                text-decoration: none;
            }
            #movie_poster {
                background-size: contain;
                background-repeat: no-repeat;
                height: 300px;
                width: 300px;
                float: left;
                margin-bottom: 20px;
            }
            #favorite_button {
                float: right;
                outline: none;
                transition: 0.5s all;
                cursor: pointer;
                font-size: 14px;
                padding: 10px 30px;
                line-height: 14px;
                color: black;
                background-color: white;
                border: 1px solid white;
                cursor: pointer;
                text-align: center;
                border-radius: 3px;
                box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
            }
            
            #favorite_button:hover {
                //border: 1px solid red;
                //color: red;
            }
            #favorite_button.fav {
                border: 1px solid red;
                color: red;
            }
            #favorite_button.fav:hover {
                //border: 1px solid white;
                //color: black;
            }
            #cast_outer {
                clear: both;
                width: 100%;
                height: auto;
                overflow-x: auto;
                overflow-y: hidden;
                padding: 5px 20px 10px 5px;
            }
            
            #cast_outer a {
                text-align: left;
                display: inline-block;
                padding: 20px 40px 20px 20px;
                font-weight: 500px;
                border-radius: 3px;
                box-shadow: 0 5px 10px rgba(0,0,0,0.16), 0 5px 10px rgba(0,0,0,0.23);
                margin: 10px;
            }
            
            #cast_outer a span {
                color: grey;
                font-weight: 300px;
            }
            .stat {
                text-align: left;
                padding: 10px;
                width: calc(50% - 30px);
                display: inline-block;
                font-size: 18px;
                font-weight: 500px;
                margin: 5px;
                background-color: white;
                border-radius: 3px;
                box-shadow: 0 5px 10px rgba(0,0,0,0.16), 0 5px 10px rgba(0,0,0,0.23);
                border: 1px solid black;
            }
            .stat span {
                float: right;
                font-weight: 300px;
            }
        </style>
        
    </head>
    <body>
        <div id="header">
            <a href="movie.php" class="active">Movie Lookup</a>
            <a href="find.php">Find Movies</a>
            <a href="stats.php">Statistics Tool</a>
            <a href="favorites.php">Favorites</a>
            <? session_start(); if (isset($_SESSION['userid'])) { ?>
            <a href="logout.php" style="float: right;">Log Out</a>
            <? } else { ?>
            <a href="login.php" style="float: right;">Sign In</a>
            <? } ?>
        </div>
        <div id="search_bar_container">
            <form method="get">
            <nobr><input type="text" id="title" name="title" placeholder="Movie Title" value="<? echo $_GET['title']; ?>">
                <input type="submit" value="Search" class="search" onclick="loadAnswer()"></nobr></form>
        </div>
        <div id="results">
            
            
            
            <?
            
            // -----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            if (isset($_GET['title'])) {
                $dbhost = 'tester.ca4um1hva9qk.us-east-1.rds.amazonaws.com';
                $dbport = '3306';
                $dbname = 'tester';
                $charset = 'utf8' ;
                $username = 'cis450test';
                $password = 'password';
                
                $link = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);
                
                if (mysqli_connect_errno())
                {
                    echo "Failed to connect to MySQL: " . mysqli_connect_error();
                }
            
            
                
            
            
            
                $title = $_GET['title'];
            
                $query = "SELECT * FROM  `names` WHERE `title` LIKE '%$title%' ORDER BY LENGTH(title) ASC  LIMIT 1";
                $result = mysqli_query($link, $query) or die('Error querying database.');
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        $movie_title = $row['title'];
                        $movieID = $row['id'];
                    }
                }
            }
            if (isset($movieID)) {

                
                
                $query = "SELECT * FROM  `info` WHERE `id` = '$movieID'";
                $result = mysqli_query($link, $query) or die('Error querying database.');
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        $website = $row['homepage'];
                        $overview = $row['overview'];
                        $runtimeMinutes = $row['runtime'];
                        $tagline = $row['tagline'];
                    }
                }
                
                $query = "SELECT * FROM  `ratings` WHERE `id` = '$movieID'";
                $result = mysqli_query($link, $query) or die('Error querying database.');
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        $rating = "<b>".$row['vote_average']."</b> /10";
                    }
                }
                
                
                $query = "SELECT * FROM  `movies` WHERE `Movie` LIKE '%$title%' LIMIT 1";
                $result = mysqli_query($link, $query) or die('Error querying database.');
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        $title_for_image = $row['Movie'];
                        $release = $row['Month']." ".$row['Day'].", ".$row['ReleaseYear'];
                        $format = 2;
                        $budget = number_format($row['BudgetM']*1000000, $format);
                        $domestic = number_format($row['DomesticGrossM']*1000000, $format);
                        $global = number_format($row['WorldwideGrossM']*1000000, $format);
                    }
                }
                
                $query = "SELECT * FROM watchlist WHERE movieid = '$movieID'";
                $result = mysqli_query($link, $query) or die('Error querying database.');
                $watchlist_count = mysqli_num_rows($result);
                
                session_start();
                $userid = $_SESSION['userid'];
                $query = "SELECT * FROM watchlist WHERE userid = '$userid' AND movieid = '$movieID'";
                $result = mysqli_query($link, $query) or die('Error querying database.');
                if (mysqli_num_rows($result) > 0) { $watchlist_text = "Remove From Watchlist"; } else { $watchlist_text = "Add to Watchlist"; }
                
                
                try {

$mng = new MongoDB\Driver\Manager("mongodb://cis450group:password@ds135486.mlab.com:35486/movies");
//$collection = (new MongoDB\Client)->movies->crew;

$filter =  ['movie_id' => (int)$movieID,
            'crew.job' => 'Director'];
//$filter = ['crew.name' => "Christopher Nolan"];
$options = ['projection' => ['crew' => 1]];
$query = new MongoDB\Driver\Query($filter, $options);
$rows = $mng->executeQuery('movies.crew', $query); // $mongo contains the connection object to MongoDB
foreach($rows as $r){
   $cast = $r->crew;
   for ($i=0; $i < count($cast); $i++){
          if(strcmp($cast[$i]->job, "Director") == 0){
         $director = $cast[$i]->name;
  }
}
}

} catch (MongoDB\Driver\Exception\Exception $e) {

$filename = basename(__FILE__);

echo "The $filename script has experienced an error.\n";
echo "It failed with the following exception:\n";

echo "Exception:", $e->getMessage(), "\n";
echo "In file:", $e->getFile(), "\n";
echo "On line:", $e->getLine(), "\n";
}
                
             
              $query = "SELECT * FROM `images` WHERE `Movie` = '$title_for_image'";
$result = mysqli_query($link, $query) or die('Error querying database.');
if (mysqli_num_rows($result) > 0) {
// output data of each row
while($row = mysqli_fetch_assoc($result)) {
$posterURL = 'https://'.$row['Link'];
}
}
 
            ?>
            <style>
                
            #movie_poster {
                    background-image: URL('<? echo $posterURL; ?>');
                }
            </style>
            
            
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
            <script>
                function addToFavorite() {
                    document.getElementById('favorite_button').innerHTML = "<b>Adding Movie.....</b>";
                    $.ajax({
                        url: "http://cis550-env.us-east-2.elasticbeanstalk.com/addToWatchList.php",
                        type:'GET',
                        data: 'movieid=<? echo $movieID; ?>',
                    }).done(function(data) { // data what is sent back by the php page
                        if (data == 'Added') {
                            document.getElementById('favorite_button').innerHTML = "<b>Remove from Watchlist</b>";
                        } else if (data == 'Removed') {
                            document.getElementById('favorite_button').innerHTML = "<b>Add to Watchlist</b>";
                        } else {
                            alert('You must sign in to use the Watchlist feature!');
                            document.getElementById('favorite_button').innerHTML = "<b>Add to Watchlist</b>";
                        }
                    });
                }
            </script>
            <div id="movie_poster" style="">
            </div>
                <h1><a href="movie.php?title=<? echo urlencode($movie_title); ?>"><? echo $movie_title; ?></a> 
                <? if (strlen($website) > 0) { ?>
                <a href="<? echo $website; ?>" target="_blank" style="font-size: 10px;">WEBSITE</a>
                <? } ?>
                <button id="favorite_button" onclick="addToFavorite();"><b><? echo $watchlist_text; ?></b></button></h1>
                <br>
                <h3>Directed by: <a href="find.php?director=<? echo urlencode($director); ?>"><? echo $director ?></a></h3><br>
                <h3>Released: <? echo $release; ?></h3><br>
                <i><? echo $tagline; ?></i><br>
                <? if (strlen($runtimeMinutes) > 0) { ?>
                <br>Runtime: <? echo $runtimeMinutes." minutes";  }?>
                <br>Watchlist count: <? echo $watchlist_count; ?>
                <br><br>
               
              <?

try {

$mng = new MongoDB\Driver\Manager("mongodb://cis450group:password@ds135486.mlab.com:35486/movies");
$filter = ['id' => (int)$movieID];
$options = ['projection' => ['genres' => 1]];
$query = new MongoDB\Driver\Query($filter, $options);
$rows = $mng->executeQuery('movies.genres', $query); // $mongo contains the connection object to MongoDB
foreach($rows as $r){
   $gs = $r->genres; 
     for ($i=0; $i < count($gs); $i++){
         echo  "<a href='find.php?genre=";
         echo urlencode($gs[$i]->id);
         echo "&name=";
         echo urlencode($gs[$i]->name);
	 echo "'>".$gs[$i]->name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>";
}

}
} catch (MongoDB\Driver\Exception\Exception $e) {

$filename = basename(__FILE__);

echo "The $filename script has experienced an error.\n";
echo "It failed with the following exception:\n";

echo "Exception:", $e->getMessage(), "\n";
echo "In file:", $e->getFile(), "\n";
echo "On line:", $e->getLine(), "\n";
}

?>

              
              
                <br>
                <p style="border: 0px solid black; padding: 10px; margin: 30px; border-radius: 3px; clear: both; font-size: 22px;"><? echo $overview; ?></p>
                <br><hr style="clear: both;"><br><br>
                <center><h3>CAST</h3></center>
            <div id="cast_outer">   
                    <nobr>
                    
<?

try {

$mng = new MongoDB\Driver\Manager("mongodb://cis450group:password@ds135486.mlab.com:35486/movies");
$filter = ['movie_id' => (int)$movieID];
$options = ['projection' => ['cast' => 1]];
$query = new MongoDB\Driver\Query($filter, $options);
$rows = $mng->executeQuery('movies.cast', $query); // $mongo contains the connection object to MongoDB
foreach($rows as $r){
   $cast = $r->cast;
   for ($i=0; $i < count($cast); $i++){
         echo  "<a class='cast' href='find.php?actor=";
         echo urlencode($cast[$i]->id);
         echo "&name=";
         echo urlencode($cast[$i]->name); 
         echo "'>".$cast[$i]->name."<br><span>". $cast[$i]->character ."</span></a>"; 
}

}
} catch (MongoDB\Driver\Exception\Exception $e) {

$filename = basename(__FILE__);

echo "The $filename script has experienced an error.\n";
echo "It failed with the following exception:\n";

echo "Exception:", $e->getMessage(), "\n";
echo "In file:", $e->getFile(), "\n";
echo "On line:", $e->getLine(), "\n";
}

?>


		   
                   
                   
                   
                   
                   
                   
                   
                   
                   
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    
              
                    </nobr>
            </div>
                <br><br>
                <center><h3>PRODUCERS</h3></center>
                <div id="cast_outer">   
                        <nobr>
                        <?

try {

$mng = new MongoDB\Driver\Manager("mongodb://cis450group:password@ds135486.mlab.com:35486/movies");
$filter = ['movie_id' => (int)$movieID];
$options = ['projection' => ['crew' => 1]];
$query = new MongoDB\Driver\Query($filter, $options);
$rows = $mng->executeQuery('movies.crew', $query); // $mongo contains the connection object to MongoDB
foreach($rows as $r){
   $cast = $r->crew;
  
      for ($i=0; $i < count($cast); $i++){
          if(strcmp($cast[$i]->job, "Producer") == 0){
         echo  "<a class='cast' href='find.php?producer=";
         echo urlencode($cast[$i]->name);
         echo "'>".$cast[$i]->name."<br></a>";
}}

}
} catch (MongoDB\Driver\Exception\Exception $e) {

$filename = basename(__FILE__);

echo "The $filename script has experienced an error.\n";
echo "It failed with the following exception:\n";

echo "Exception:", $e->getMessage(), "\n";
echo "In file:", $e->getFile(), "\n";
echo "On line:", $e->getLine(), "\n";
}

?>
                       
                      
                     
                        </nobr>
                </div>
                <br><hr style="clear: both;"><br><br>
                    <center><h3>STATISTICS</h3><br>
                    <? if (strlen($budget) > 0) { ?>
                    <div class="stat">
                        <nobr>
                            <b>Budget</b>
                            <span><b>$<? echo $budget; ?></b> (USD)</span>
                        </nobr>
                    </div>
                    <? } if (strlen($domestic) > 0) { ?>
                    <div class="stat">
                        <nobr>
                            <b>Domestic Gross</b>
                            <span><b>$<? echo $domestic; ?></b> (USD)</span>
                        </nobr>
                    </div>
                    <? } if (strlen($global) > 0) { ?>
                    <div class="stat">
                        <nobr>
                            <b>Worldwide Gross</b>
                            <span><b>$<? echo $global; ?></b> (USD)</span>
                        </nobr>
                    </div>
                    <? } if (strlen($rating) > 0) { ?>
                    <div class="stat">
                        <nobr>
                            <b>Rating</b>
                            <span><? echo $rating; ?></span>
                        </nobr>
                    </div></center>
                    <? } ?>
            
            
            
            
            <?
            } else if (isset($_GET['title'])) {
                echo "<strong><i>Sorry, there is no movie in our database that matches the search.</i></strong>";
            }
            ?>
            
            
        </div>
    </body>
</html>
