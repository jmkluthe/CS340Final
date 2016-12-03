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
    
    //get movies
    $query = 'SELECT DISTINCT M.title FROM Movie_to_Person MP INNER JOIN'
    . ' Movie M ON MP.movie_id = M.id WHERE MP.person_id=' . $_GET['id'];
    
    if(!($substmnt = $mysqli->prepare($query))) {
        echo 'Prepare failed: ' . $substmnt->errno . ' ' . $substmnt->error;
    }
    
    if(!$substmnt->execute()) {
        echo 'Execute failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }
    
    if(!$substmnt->bind_result($movie)) {
        echo 'Bind failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }
    
    $movielist = array();
    
    while($substmnt->fetch()) {
        array_push($movielist, $movie);
    }
    
    $substmnt->close();
    
    //get job/role
    $query = 'SELECT MP.job_role, M.title FROM Movie_to_Person MP INNER JOIN'
    . ' Movie M ON MP.movie_id = M.id WHERE MP.person_id=' . $_GET['id'];
    
    if(!($substmnt = $mysqli->prepare($query))) {
        echo 'Prepare failed: ' . $substmnt->errno . ' ' . $substmnt->error;
    }
    
    if(!$substmnt->execute()) {
        echo 'Execute failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }
    
    if(!$substmnt->bind_result($jobrole, $title)) {
        echo 'Bind failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }
    
    $personlist = array();
    
    while($substmnt->fetch()) {
        array_push($personlist, $jobrole . ': ' . $title);
    }
    
    $substmnt->close();
    
    //get other details
    $sqlstr = 'SELECT P.first_name, P.last_name, P.dob, COUNT(DISTINCT MP.movie_id) FROM Person P LEFT JOIN'
    . ' Movie_to_Person MP ON P.id = MP.person_id WHERE P.id=' . $_GET['id'] . ' GROUP BY P.id';
    
    if(!($stmnt = $mysqli->prepare($sqlstr))) {
        echo 'Prepare failed: ' . $stmnt->errno . ' ' . $stmnt->error;
    }
    
    if(!$stmnt->execute()) {
        echo 'Execute failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }
    
    if(!$stmnt->bind_result($fname, $lname, $dob, $movies)) {
        echo 'Bind failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }
    
    while($stmnt->fetch()) {
        echo '<h1>Details for ' . $fname . ' ' . $lname . '</h1>';
        echo '<h3>Date Of Birth: ' . $dob .  '</h3>';
        echo '<h3>Movies: ' . $movies .  '</h3>';
        echo '<ul>';
        for($x = 0; $x < count($movielist); $x++) {
            echo '<li>' . $movielist[$x] . '</li>';
        }
        echo '</ul>';
        echo '<h3>Job Roles: ' . count($personlist) . '</h3>';
        echo '<ul>';
        for($x = 0; $x < count($personlist); $x++) {
            echo '<li>' . $personlist[$x] . '</li>';
        }
        echo '</ul>';
    }
    
    $stmnt->close();
    
?>

<!-- add a movie -->
<div>
<form method="post" action="add.php">
<fieldset>
<legend>Attach a Movie to the Person</legend>
<p>Movie:
<select name="Movie">
<?php
    if(!($stmt = $mysqli->prepare("SELECT id, title FROM Movie"))){
        echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->execute()){
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->bind_result($id, $title)){
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    while ($stmt->fetch()){
        echo '<option value=" ' .$id . ' "> ' . $title . '</option>\n';
    }
    $stmt->close();
    ?>

</select>
</p>
<p>Job Title: <input type="text" name="job_role" /></p>
<?php
    echo "<input type='hidden' name='Person' value=" . $_GET['id'] . " />";
?>
<input type='hidden' name='database' value='Movie_to_Person' />
<p><input type="submit" /></p>
</fieldset>
</form>
</div>

<!-- edit actor name -->
<div>
<form method="post" action="edit.php">
<fieldset>
<legend>Update First Name</legend>
<p>First Name: <input type="text" name="value" /></p>
<input type='hidden' name='column' value='first_name' />
<input type='hidden' name='database' value='Person' />
<?php
    echo "<input type='hidden' name='id' value=" . $_GET['id'] . " />";
    ?>
<p><input type="submit" /></p>
</fieldset>
</form>

<form method="post" action="edit.php">
<fieldset>
<legend>Update Last Name</legend>
<p>Last Name: <input type="text" name="value" /></p>
<input type='hidden' name='column' value='last_name' />
<input type='hidden' name='database' value='Person' />
<?php
    echo "<input type='hidden' name='id' value=" . $_GET['id'] . " />";
    ?>
<p><input type="submit" /></p>
</fieldset>
</form>
</div>


<h3><a href="MovieDatabase.php">Return Home</a></h3>

</body>
