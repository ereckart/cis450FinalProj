<?
session_start();
session_unset();
session_destroy();
header('Location: http://cis550-env.us-east-2.elasticbeanstalk.com/movie.php');

?>
