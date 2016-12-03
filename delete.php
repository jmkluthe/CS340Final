<?php
    ini_set('display_errors', 'On');
    //replace credentials as necessary
    $mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'kluthej-db', 'bgT8kbH3894HObbo', 'kluthej-db');
    if($mysqli->connect_errno) {
       echo 'Error connecting to database: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Deleted</title>
</head>
<body>
<h1>Delete Row</h1>	
	
<?php


	$db = $_POST['database'];
	$id = $_POST['id'];

    if(!($stmt = $mysqli->prepare("DELETE FROM " . $db ." WHERE id=(?)"))){
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    }
    if(!($stmt->bind_param("i", $id))){
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->execute()){
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    } else {
        echo "Deleted " . $stmt->affected_rows . " rows to Award.";
    }
?>

<h3><a href="MovieDatabase.php">Return Home</a></h3>

</body>