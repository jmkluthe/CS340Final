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
<h1>Add Row</h1>	


<?php
	
	
	if($_POST['database'] == 'Person') {

		if(!($stmt = $mysqli->prepare("INSERT INTO Person(first_name, last_name, dob) VALUES (?, ?, ?)"))){
			echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
		}
		if(!($stmt->bind_param("sss", $_POST['FirstName'], $_POST['LastName'], $_POST['DOB']))){
			echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
		}
		
	} else if($_POST['database'] == 'Movie') {
		
		if(!($stmt = $mysqli->prepare("INSERT INTO Movie(title, company_id, genre_id) VALUES (?, ?, ?)"))){
			echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
		}
		if(!($stmt->bind_param("sii", $_POST['MovieTitle'], $_POST['Company'], $_POST['Genre']))){
			echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
		}
		
	} else if($_POST['database'] == 'Company') {
		
		if(!($stmt = $mysqli->prepare("INSERT INTO Company(name) VALUES (?)"))){
			echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
		}
		if(!($stmt->bind_param("s", $_POST['CompanyName']))){
			echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
		}
		
	} else if($_POST['database'] == 'Genre') {
		
	    if(!($stmt = $mysqli->prepare("INSERT INTO Genre(name) VALUES (?)"))){
			echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
		}
		if(!($stmt->bind_param("s", $_POST['GenreType']))){
			echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
		}
		
	} else if($_POST['database'] == 'Award') {

		if(!($stmt = $mysqli->prepare("INSERT INTO  Award(name) VALUES (?)"))){
			echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
		}
		if(!($stmt->bind_param("s", $_POST['AwardName']))){
			echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
		}
	
	} else if($_POST['database'] == 'Movie_to_Person') {

		if(!($stmt = $mysqli->prepare("INSERT INTO  Movie_to_Person(movie_id, person_id, job_role) VALUES (?,?,?)"))){
			echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
		}
		if(!($stmt->bind_param("iis", $_POST['Movie'], $_POST['Person'], $_POST['job_role']))){
			echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
		}
	
	} else if($_POST['database'] == 'Movie_to_Award') {
	
		if(!($stmt = $mysqli->prepare("INSERT INTO  Movie_to_Award(movie_id, award_id) VALUES (?,?)"))){
			echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
		}
		if(!($stmt->bind_param("ii", $_POST['Movie'], $_POST['Award']))){
			echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
		}
	
	}
	
	
	if(!$stmt->execute()){
		echo "Execute failed: "  . $stmt->errno . " " . $stmt->error;
	} else {
        echo "Added " . $stmt->affected_rows . " rows to " . $_POST['database'] . ".";
    }

	
?>

<h3><a href="MovieDatabase.php">Return Home</a></h3>

</body>