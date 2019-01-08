<?

session_start();

if (isset($_SESSION['userid'])) {
    $movieid = $_GET['movieid'];
    $userid = $_SESSION['userid'];
    
    

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
    
    $query = "SELECT * FROM watchlist WHERE userid = '$userid' AND movieid = '$movieid'";
    $result = mysqli_query($link, $query) or die('Error querying database.');
      
      
      
    if (mysqli_num_rows($result) > 0) {
        $query = "DELETE FROM watchlist WHERE userid = '$userid' AND movieid = '$movieid';";
        $result = mysqli_query($link, $query) or die('Error querying database.');
    
        echo "Removed";
    } else {
    
        $query = "INSERT INTO `watchlist` (`userid`, `movieid`) VALUES ( '$userid', '$movieid');";
        $result = mysqli_query($link, $query) or die('Error querying database.2');
    
        echo "Added";
    }
} else {
    echo "error";
}

?>