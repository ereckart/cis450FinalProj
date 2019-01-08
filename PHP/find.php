<html>
    <head>
        <title>Movie Lookup</title>
        <style>
            * {
                padding: 0;
                margin: 0;
            }
            body {
                background-color: #e0e0e0;
            }
            #header {
                background-color: white;
                position: absolute;
                top: 0;
                left: 0;
                width: 100vw;
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
            
            #search_bar_container #main_input {
                width: calc(95vw - 210px);
                max-width: 400px;
                font: 20px arial,sans-serif;
                line-height: 54px;
                height: 54px !important;
                padding: 5px 15px;
                margin-top: 70px;
                transition: 0.5s all;
                border: 0px;
            }
            #search_bar_container #dropdown {
                width: 200px;
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
           * {
               padding: 0;
               margin: 0;
           }
           body {
               background-color: #e0e0e0;
               padding-top: 300px;
           }
           #header {
               background-color: white;
               position: absolute;
               top: 0;
               left: 0;
               width: 100vw;
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
           #header2 {
               position: absolute;
               top: 60px;
               left: 0;
               background-image: URL('pic6.jpg');
               height: 70px;
               font-weight: 700;
               width: 100vw;
               font-size: 70px;
               color: white;
               background-position: 40% 50%;
               background-size: cover;
               padding: 115px 0;
               text-align: center;
               font-family: "Comic Sans MS", cursive, sans-serif
           }
           .favorite {
               width: 100vw;
               margin-top: 10px;
               border-radius: 4px;
               border: 1px solid black;
               max-width: 600px;
               text-align: left;
               background-color: white;
	       padding-left: 18px;
               font-family: Arial, Helvetica, sans-serif;
           }



  
 
   
    
     
      
       
        
         
           .favorite .title {
               color: black;
               text-decoration: none;
               font-size: 34px;
               line-height: 40px;
}
        </style>
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <script>
            function loadAnswer() {
                document.getElementById('results').innerHTML = '<div class="loader"></div>';
                document.getElementById('main_input').style.marginTop = '100px';
                var what = document.getElementById('main_input').value;
                $.ajax({
                    url: "https://dreamacinc.com/CIS550/findQuery.php",
                    type:'GET',
                    data: 'what='+what,
                }).done(function(data) { // data what is sent back by the php page
                    document.getElementById('results').innerHTML = data;
                });
            }
        </script>
    </head>
    <body>
        <div id="header">
            <a href="movie.php">Movie Lookup</a>
            <a href="find.php" class="active">Find Movies</a>
            <a href="stats.php">Statistics Tool</a>
            <a href="favorites.php">Favorites</a>
            <? session_start(); if (isset($_SESSION['userid'])) { ?>
            <a href="logout.php" style="float: right;">Log Out</a>
            <? } else { ?>
            <a href="login.php" style="float: right;">Sign In</a>
            <? } ?>
        </div>
        <div id="search_bar_container">
            <nobr><input type="text" id="main_input" placeholder="Search for">
                <select id="dropdown">
                    <option>by Actor</option>
                    <option>by Director</option>
                    <option>by Producer</option>
                    <option>by Genre</option>
                </select>
                <input type="button" value="Search" class="search" onclick="loadAnswer()"></nobr>
        </div>
        <div id="results"></div>
    </body>
<?

try {
$value =(int)$_GET['actor'];
$actorName = $_GET['name'];
$mng = new MongoDB\Driver\Manager("mongodb://cis450group:password@ds135486.mlab.com:35486/movies");
$filter = ['cast.id' => $value];
$options = ['projection' => ['movie_id' => 1]];
$query = new MongoDB\Driver\Query($filter, $options);
$rows = $mng->executeQuery('movies.cast', $query); // $mongo contains the connection object to MongoDB
                echo "<center>";
                if(isset($_GET['actor']))
                echo "<h1> Actor/Actress: " . $actorName . "</h1>";
foreach($rows as $r){
   $movID =  $r->movie_id;
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

               $query = "SELECT title FROM names WHERE id = '$movID'";
               $result = mysqli_query($link, $query) or die('Error querying database.');
		
	
               if (mysqli_num_rows($result) > 0) {
                   // output data of each row
                   while($row = mysqli_fetch_assoc($result)) {
           ?>


               <div class="favorite">
                   <a class="title" href="movie.php?title=<? echo urlencode($row['title']); ?>"><? echo $row['title']; ?></a> 
               </div>

       <?
                   }
               }

}
        echo "</center>";

} catch (MongoDB\Driver\Exception\Exception $e) {

$filename = basename(__FILE__);

echo "The $filename script has experienced an error.\n";
echo "It failed with the following exception:\n";

echo "Exception:", $e->getMessage(), "\n";
echo "In file:", $e->getFile(), "\n";
echo "On line:", $e->getLine(), "\n";
}
?>
<?
try {
$value =(int)$_GET['genre'];
$genreName = $_GET['name'];
//$mng = new MongoDB\Driver\Manager("mongodb://cis450group:password@ds135486.mlab.com:35486/movies");
$filter1 = ['genres.id' => $value];
$options1 = ['projection' => ['id' => 1]];
$query1 = new MongoDB\Driver\Query($filter1, $options1);
$rows1 = $mng->executeQuery('movies.genres', $query1); // $mongo contains the connection object to MongoDB
                echo "<center>";
                if(isset($_GET['genre']))
                echo "<h1> Genre: " . $genreName . "</h1>";
foreach($rows1 as $r1){
    $movID = $r1->id;
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

               $query = "SELECT title FROM names WHERE id = '$movID'";
               $result = mysqli_query($link, $query) or die('Error querying database.');


               if (mysqli_num_rows($result) > 0) {
                   // output data of each row
                   while($row = mysqli_fetch_assoc($result)) {
           ?>


               <div class="favorite">
                   <a class="title" href="movie.php?title=<? echo urlencode($row['title']); ?>"><? echo $row['title']; ?></a>
               </div>

       <?
                   }
               }
}
                echo "<center>";
} catch (MongoDB\Driver\Exception\Exception $e) {

$filename = basename(__FILE__);

echo "The $filename script has experienced an error.\n";
echo "It failed with the following exception:\n";

echo "Exception:", $e->getMessage(), "\n";
echo "In file:", $e->getFile(), "\n";
echo "On line:", $e->getLine(), "\n";
}

?>


</html>
