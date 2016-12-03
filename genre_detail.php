<?php
    
    ini_set('display_errors', 'On');
    //replace credentials as necessary
    $mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'kluthej-db', 'bgT8kbH3894HObbo', 'kluthej-db');
	//$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'seimsa-db', 'F9FHl9bn32cHFvJE', 'seimsa-db');
    if($mysqli->connect_errno) {
        echo 'Error connecting to database: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }
    ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Movies Database</title>
<link rel="stylesheet" href="stylesheet.css" type="text/css">
</head>
<body>

<?php
    
    //get genre
    $query = 'SELECT G.name FROM Genre G WHERE G.id=' . $_GET['id'];
    
    if(!($substmnt = $mysqli->prepare($query))) {
        echo 'Prepare failed: ' . $substmnt->errno . ' ' . $substmnt->error;
    }
    
    if(!$substmnt->execute()) {
        echo 'Execute failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }
    
    if(!$substmnt->bind_result($genre)) {
        echo 'Bind failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }
    
    $genrelist = array();
    
    while($substmnt->fetch()) {
        array_push($genrelist, $genre);
    }
    
    $substmnt->close();
    
    //get movies
    $query = 'SELECT G.name, M.title FROM Genre G INNER JOIN'
    . ' Movie M ON G.id = M.genre_id WHERE G.id=' . $_GET['id'];
    
    if(!($substmnt = $mysqli->prepare($query))) {
        echo 'Prepare failed: ' . $substmnt->errno . ' ' . $substmnt->error;
    }
    
    if(!$substmnt->execute()) {
        echo 'Execute failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }
    
    if(!$substmnt->bind_result($genre, $title)) {
        echo 'Bind failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }
    
    $movielist = array();
    
    while($substmnt->fetch()) {
        array_push($movielist, $genre . ': ' . $title);
    }
    
    $substmnt->close();
    
    //get other details
    $sqlstr = 'SELECT G.name, M.title, COUNT(M.id) FROM Genre G INNER JOIN'
    . ' Movie M ON G.id = M.genre_id WHERE G.id=' . $_GET['id'];
    
    if(!($stmnt = $mysqli->prepare($sqlstr))) {
        echo 'Prepare failed: ' . $stmnt->errno . ' ' . $stmnt->error;
    }
    
    if(!$stmnt->execute()) {
        echo 'Execute failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }
    
    if(!$stmnt->bind_result($name, $title, $movies)) {
        echo 'Bind failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }
    
    while($stmnt->fetch()) {
        echo '<h1>Details for ' . $genre . '</h1>';
        echo '<h3>Movies: ' . $movies .  '</h3>';
        echo '<ul>';
        for($x = 0; $x < count($movielist); $x++) {
            echo '<li>' . $movielist[$x] . '</li>';
        }
        echo '</ul>';
    }
    
    $stmnt->close();
    
    ?>


<!-- edit genre name -->
<div>
<form method="post" action="edit.php">
<fieldset>
<legend>Edit Genre Name</legend>
<p>Update Name: <input type="text" name="value" /></p>
<input type='hidden' name='column' value='name' />
<input type='hidden' name='database' value='Genre' />
<?php
    echo "<input type='hidden' name='id' value=" . $_GET['id'] . " />";
    ?>
<p><input type="submit" /></p>
</fieldset>
</form>
</div>


<h3><a href="MovieDatabase.php">Return Home</a></h3>

</body>
