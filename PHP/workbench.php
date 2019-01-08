<?





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



      $query = "SELECT ReleaseYear AS RELYR, InternationalGross, Movie
                FROM movies
                WHERE ReleaseYear = 2012
                ORDER BY InternationalGross DESC"; 
      
      
      
      
      
      
      
      
      
      
      $result = mysqli_query($link, $query) or die('Error querying database.');
      
      
      
       
      
      if (mysqli_num_rows($result) > 0) {
         // output data of each row
         while($row = mysqli_fetch_assoc($result)) {
             print_r($row);
             echo "<br>";
         }
      }
      
?>