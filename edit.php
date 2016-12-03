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
<title>Deleted</title>
</head>
<body>
<h1>Edit a Row</h1>	


<?php
	
	//this query can handle basically any single column update since it require the POST to contain not only the
	//values to change, but the name of the column and database as well
	
	$query = "UPDATE " . $_POST['database'] . " SET " . $_POST['column'] . " = ? WHERE id = ?";
	
	if(!($stmt = $mysqli->prepare($query))){
		echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
	}
	//check whether we are changing an id or a string
	if(is_numeric($_POST['value'])) {
		
		if(!($stmt->bind_param("ii", $_POST['value'], $_POST['id']))){
			echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
		}
		
	} else {
		
		if(!($stmt->bind_param("si", $_POST['value'], $_POST['id']))){
			echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
		}
		
	}
	
	if(!$stmt->execute()){
		echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
	} else {
        echo "Updated " . $stmt->affected_rows . " rows to " . $_POST['database'] . ".";
    }

	
?>

<h3><a href="MovieDatabase.php">Return Home</a></h3>

</body>