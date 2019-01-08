<script>
window.onload = function(e){ 
showInputs();
}
</script>
<?

        if (isset($_GET)) {
            $query = $_GET['query'];
        } else {
            $query = 0;
        }

            ?>

<html>
    <head>
        <title>Statistics Tool</title>
        <style>
            * {
                padding: 0;
                margin: 0;
            }
            body {
                background-colo: #e0e0e0;
                padding-top: 350px;
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
                min-height: 204px;
                padding-bottom: 20px;
                position: absolute;
                top: 60px;
                left: 0px;
                background-image: URL('pic5.jpg');
                background-size: cover ;
                background-position: 50% 50%;
            }
            
            #search_bar_container #main_input,
            #search_bar_container .sub_input {
                width: calc(95vw - 10px);
                max-width: 600px;
                font: 20px arial,sans-serif;
                line-height: 54px;
                height: 54px;
                padding: 5px 15px;
                margin-top: 70px;
                transition: 0.5s all;
                border: 0px;
            }
            #search_bar_container .sub_input {
                margin-top: 5px;
                transition: 1s all;
                height: 0px;
                padding: 0px 15px;
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
            td, th {
                padding: 4px 8px;
                border-bottom: 1px solid #666;
            }
            table {
                border-collapse: collapse;
            }
        </style>

    </head>
    <body>
        <div id="header">
            <a href="movie.php">Movie Lookup</a>
            <a href="find.php">Find Movies</a>
            <a href="stats.php" class="active">Statistics Tool</a>
            <a href="favorites.php">Favorites</a>
                        <? session_start(); if (isset($_SESSION['userid'])) { ?>
            <a href="logout.php" style="float: right;">Log Out</a>
            <? } else { ?>
            <a href="login.php" style="float: right;">Sign In</a>
            <? } ?>
        </div>
        <script>
            function showInputs() {
                document.getElementById('input1').value = "";
                document.getElementById('input2').value = "";
                
                
                var inputVal = document.getElementById('main_input').value;
                
                if (inputVal < 4 || inputVal >= 6) {
                    document.getElementById('input1').placeholder = '';
                    document.getElementById('input2').placeholder = '';
                    document.getElementById('input1').style.height = '0';
                    document.getElementById('input2').style.height = '0';
                } else {
                    document.getElementById('input1').placeholder = 'Rating (Low)';
                    document.getElementById('input2').placeholder = 'Rating (High)';
                    document.getElementById('input1').style.height = '54px';
                    document.getElementById('input2').style.height = '54px';
                }
                
            }
        </script>
        <div id="search_bar_container">
            <form method="get">
            <nobr>
                <select onload="showInputs();" name="query" option="query" onchange="showInputs()" id="main_input" placeholder="Movie Title" required>
                    <option style="display: none;" value="">Please select a statistic to lookup</option>
                    <option value="1" <? if ($query == 1) echo "selected"; ?>>Highest buget for a film per year</option>
                    <option value="2" <? if ($query == 2) echo "selected"; ?>>Average box-office sales by rating</option>
                    <option value="3" <? if ($query == 3) echo "selected"; ?>>Maximum box-office sales by rating</option>
                    <option value="4" <? if ($query == 4) echo "selected"; ?>>Average box-office sales by range of rating</option>
                    <option value="5" <? if ($query == 5) echo "selected"; ?>>Maximum box-office sales by range of rating</option>
                    <option value="6" <? if ($query == 6) echo "selected"; ?>>Average box-office by month</option>
                    <option value="7" <? if ($query == 7) echo "selected"; ?>>Max box-office by month</option>
                </select>
                <input type="submit" value="Search" class="search" ></nobr><br>
                <input type="text" id="input1" name="input1" class="sub_input" value="<? echo $_GET['input1']; ?>">
                <input type="text" id="input2" name="input2" class="sub_input" value="<? echo $_GET['input2']; ?>">
                </form>
        </div>
        <center>
        
        <?

        if (isset($_GET)) {
            $dbhost = 'tester.ca4um1hva9qk.us-east-1.rds.amazonaws.com';
            $dbport = '3306';
                $dbname = 'tester';
            $charset = 'utf8' ;
            $username = 'cis450test';
            $password = 'password';
            
            $link = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);
            
            if (mysqli_connect_errno()) {
                echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
                    
            $value1 = 0;
            $value2 = 10;
            $value1 = $_GET['input1'];
            $value2 = $_GET['input2'];
            
            if ($_GET['query'] == "1") {
                // Highest buget for a film per year
                $query = "SELECT movies.Movie, movies.BudgetM, movies.ReleaseYear
FROM movies, (SELECT MAX(BudgetM) AS MAX_BUDG, ReleaseYear
              FROM movies
              GROUP BY ReleaseYear) AS t
WHERE t.MAX_BUDG = movies.BudgetM AND t.ReleaseYear = movies.ReleaseYear
ORDER BY movies.ReleaseYear DESC";
                $result = mysqli_query($link, $query) or die('Error querying database.');
                if (mysqli_num_rows($result) > 0) {
                    echo "<h2>Highest buget for a film per year</h2>";
                    echo "<table><tr><th>Year</th><th>Budget (Million USD)</th><th>Title</th></tr>";
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>".$row['ReleaseYear']."</td><td>".round($row['BudgetM'],2)."</td><td>".$row['Movie']."</td></tr>";
                    }
                    echo "</table>";
                }
            } else if ($_GET['query'] == "2") {
                //Average box-office statistics by rating
                $query = "SELECT AVG(movies.DomesticGrossM) AS AVE_DOM, AVG(movies.WorldwideGrossM) AS AVE_WW, ratings.vote_average
FROM movies, ratings, names
WHERE movies.Movie = names.Title AND names.ID = ratings.ID
GROUP BY ratings.vote_average
ORDER BY ratings.vote_average DESC;";
                $result = mysqli_query($link, $query) or die('Error querying database.');
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    echo "<h2>Average box-office statistics by rating</h2>";
                    echo "<table><tr><th>Rating</th><th>Domestic Average<bOAr>(Million USD)</th><th>Global Average<br>(Million USD)</th></tr>";
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td style='text-align: right;'>".$row['vote_average']."</td><td style='text-align: right;'>".number_format ($row['AVE_DOM'],2)."</td><td>".number_format ($row['AVE_WW'],2)."</td></tr>";
                    }
                    echo "</table>";
                }
            } else if ($_GET['query'] == "3") {
                //Maximum box-office statistics by rating
                $query = "SELECT MAX(movies.DomesticGrossM) AS AVE_DOM, MAX(movies.WorldwideGrossM) AS AVE_WW, ratings.vote_average
FROM movies, ratings, names
WHERE movies.Movie = names.Title AND names.ID = ratings.ID
GROUP BY ratings.vote_average
ORDER BY ratings.vote_average DESC;";
                $result = mysqli_query($link, $query) or die('Error querying database.');
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    echo "<h2>Maximum box-office statistics by rating</h2>";
                    echo "<table><tr><th>Rating</th><th>Domestic Maximum<br>(Million USD)</th><th>Global Maximum<br>(Million USD)</th></tr>";
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>".$row['vote_average']."</td><td style='text-align: right;'>".number_format ($row['AVE_DOM'],2)."</td><td style='text-align: right;'>".number_format ($row['AVE_WW'],2)."</td></tr>";
                    }
                    echo "</table>";
                }
            } else if ($_GET['query'] == "4") {
                //Average box-office statistics by range of rating
                $query = "SELECT AVG(movies.DomesticGrossM) AS AVE_DOM, AVG(movies.WorldwideGrossM) AS AVE_WW
FROM movies, ratings, names
WHERE movies.Movie = names.Title AND names.ID = ratings.ID AND ratings.vote_average >= '$value1' AND ratings.vote_average <= '$value2'";
                $result = mysqli_query($link, $query) or die('Error querying database.');
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    echo "<h2>Average box-office statistics by range of rating</h2>";
                    if ($value1 != $value2) {
                        echo "<h3>Between $value1 and $value2</h3><br><br>";
                    } else {
                        echo "<h3>When rating is $value2</h3><br><br>";
                    }
                    
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<h3>Domestic Average: $".number_format($row['AVE_DOM'],2)." Million (USD)</h3><br><br>";
                        echo "<h3>Global Average: $".number_format($row['AVE_WW'],2)." Million (USD)</h3><br><br>";
                    }
                }
            } else if ($_GET['query'] == "5") {
                //Average box-office statistics by range of rating
                $query = "SELECT ratings.vote_average, MAX(movies.DomesticGrossM) AS MAX_DOM, MAX(movies.WorldwideGrossM) AS MAX_WW, movies.Movie, movies.ReleaseYear
FROM movies, ratings, names
WHERE movies.Movie = names.Title AND names.ID = ratings.ID AND ratings.vote_average >= '$value1' AND ratings.vote_average <= '$value2'";
                $result = mysqli_query($link, $query) or die('Error querying database.');
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    echo "<h2>Maximum box-office statistics by range of rating</h2>";
                    if ($value1 != $value2) {
                        echo "<h3>Between $value1 and $value2</h3><br><br>";
                    } else {
                        echo "<h3>When rating is $value2</h3><br><br>";
                    }
                    
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<h3>Domestic maximum: $".number_format($row['MAX_DOM'],2)." Million (USD)</h3><br><br>";
                        echo "<h3>Global maximum: $".number_format($row['MAX_WW'],2)." Million (USD)</h3><br><br>";
                    }
                }
            } else if ($_GET['query'] == "6") {
                //Average box-office by month
                $query = "SELECT AVG(DomesticGrossM) AS AVE_DOM, AVG(WorldwideGrossM) AS AVE_WW, Month
FROM movies 
GROUP BY Month
ORDER BY AVE_DOM, AVE_WW DESC";
                $result = mysqli_query($link, $query) or die('Error querying database.');
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    echo "<h2>Average box-office sales by month</h2>";
                    echo "<table><tr><th>Rating</th><th>Domestic Average<br>(Million USD)</th><th>Global Average<br>(Million USD)</th></tr>";
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>".$row['Month']."</td><td style='text-align: right;'>".number_format ($row['AVE_DOM'],2)."</td><td style='text-align: right;'>".number_format ($row['AVE_WW'],2)."</td></tr>";
                    }
                    echo "</table>";
                }
            } else if ($_GET['query'] == "7") {
                $query = "SELECT MAX(DomesticGrossM) AS AVE_DOM, MAX(WorldwideGrossM) AS AVE_WW, Month, movies.Movie, movies.ReleaseYear
FROM movies 
GROUP BY Month
ORDER BY AVE_DOM DESC";
                $result = mysqli_query($link, $query) or die('Error querying database.');
                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    echo "<h2>Maximum box-office sales by month</h2>";
                    echo "<table><tr><th>Rating</th><th>Domestic Average<br>(Million USD)</th><th>Global Average<br>(Million USD)</th><th>Title</th><th>Year</th></tr>";
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>".$row['Month']."</td><td style='text-align: right;'>".number_format ($row['AVE_DOM'],2)."</td><td style='text-align: right;'>".number_format ($row['AVE_WW'],2)."</td><td>".$row['Movie']."</td><td>".$row['ReleaseYear']."</td></tr>";
                    }
                }
            }
        }
        
        ?>
        
        
        
        </center>
    </body>
</html>
