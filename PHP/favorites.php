<?
$message = "";
session_start();
if (isset($_SESSION['userid'])) {
    if (isset($_POST['remove'])) {
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
            
            
                
            
            
                $userID = $_SESSION['userid'];
                $movieID = $_POST['remove'];
            
                $query = "DELETE FROM watchlist WHERE userid = '$userID' AND movieid = '$movieID'";
                $result = mysqli_query($link, $query) or die('Error querying database.');
    }
}

?>




<html>
    <head>
        <title>Favorites</title>
        <style>
            * {
                padding: 0;
                margin: 0;
            }
            body {
                background-color: #e0e0e0;
                padding-top: 370px;
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
                
                font-family: Arial, Helvetica, sans-serif;
            }
            .favorite a.remove {
                font-family: "Comic Sans MS", cursive, sans-serif;
                text-decoration: none;
                font-size: 22px;
                line-height: 40px;
                text-decoration: none;
                color: black;
                display: inline-block;
                padding: 0px 5px;
                margin-right: 20px;
                cursor: pointer;
            }
            .favorite .title {
                color: black;
                text-decoration: none;
                font-size: 34px;
                line-height: 40px;
            }
        </style>
    </head>
    <body>
        <div id="header">
            <a href="movie.php">Movie Lookup</a>
            <a href="find.php">Find Movies</a>
            <a href="stats.php">Statistics Tool</a>
            <a href="favorites.php" class="active">Favorites</a>
            <? session_start(); if (isset($_SESSION['userid'])) { ?>
            <a href="logout.php" style="float: right;">Log Out</a>
            <? } else { ?>
            <a href="login.php" style="float: right;">Sign In</a>
            <? } ?>
            
            
            
            
            
        </div>
        <div id="header2">
            Favorites
        </div>
        
        <center>
            
            
            <?
            
            if (isset($_SESSION['userid'])) {
	       $userID  = $_SESSION['userid']; 
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
                
                $query = "SELECT N.title AS name, W.movieid AS id FROM watchlist W INNER JOIN names N ON W.movieid = N.id WHERE W.userid = '$userID'";
                $result = mysqli_query($link, $query) or die('Error querying database.');
      
      
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        if (strlen($message) > 0) $message .= ", ";
			$message .= $row['name'];           
 ?>
            
                
                <div class="favorite">
                    <form method="post">
                        <input type="hidden" name="remove" id="remove" value="<? echo urlencode($row['id']); ?>">
                        <a class="remove" onclick="this.parentNode.submit();">X</a>
                    <a class="title" href="movie.php?title=<? echo urlencode($row['name']); ?>"><? echo $row['name']; ?></a>
                    </form>
                </div>
            
        <?      
                    }
                }
            } else { ?>
                <h2><i>You must be logged in to use the watchlist</i></h2>
        <?  } ?>
<form method="post">
<input type="number" id="number" name="number" placeholder="1234567890">
<input type="submit" value="Send Watchlist As Text Message">
</form>
<?
include('tools.php');
if (isset($_POST['number'])) {
$number = $_POST['number'];
sendText($number,$message);

}
?>












        </center>
    </body>
</html>
