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
<h1>Add Row</h1>	


<?php
	
	
	if($_POST['database'] == 'Person') {
		$sqlstr = 'INSERT INTO ' . $_POST['database'] . '(first_name, last_name, dob) VALUES (?,?,?)';
		if(!($stmt = $mysqli->prepare($sqlstr))){
			echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
		}
		if(!($stmt->bind_param("sss", $_POST['FirstName'], $_POST['LastName'], $_POST['Date']))){
			echo "Bind failed: "  . $stmt->errno . " " . $stmt->error;
		}
		if(!$stmt->execute()){
			echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
		}
		$_POST = NULL;
	}

	
?>

<h3><a href="MovieDatabase.php">Return Home</a></h3>

</body>