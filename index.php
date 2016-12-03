<?php
	
	ini_set('display_errors', 'On');

	//replace credentials as necessary
	$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'kluthej-db', 'bgT8kbH3894HObbo', 'kluthej-db');
	if($mysqli->connect_errno) {
		echo 'Error connecting to database: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
	}
	
	//this apparently has to be on a different page or the information gets added to the database
	//every time the page is refreshed
	if(isset($_POST['submit'])) {
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

 <!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Movies Database</title>
	</head>
	<body>
		<h1>Hello! Welcome to the movies database!</h1>
	
		<h2>People</h2>
		<table>
			<tr>
				<th>Name</th>
				<th>DOB</th>
				<th># of Movies</th>
			</tr>		

<?php
	
	$sqlstr = 'SELECT first_name, last_name, dob, COUNT(movie_id) FROM Person INNER JOIN'
	. ' Movie_to_Person ON Person.id = Movie_to_Person.person_id GROUP BY Person.id';
	
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
		echo '<tr><td>' . $fname . ' ' . $lname . '</td><td>' . $dob . '</td><td>' . $movies . '</td></tr>';
	}
	
	$stmnt->close();
	
?>
		</table>
		<!-- the action on this form needs to go to a different page -->
		<form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
			<fieldset>
				<legend>Add a Person</legend>
				<input type="hidden" name="database" value="Person" />
				<p>First Name: <input type="text" name="FirstName" /></p>
				<p>Last Name: <input type="text" name="LastName" /></p>
				<p>Date of Birth: <input type="date" name="Date" /></p>
				<p><input type="submit" name="submit" /></p>
			</fieldset>
		</form>
				
		<h2>Movies</h2>
		<table>
			<tr>
				<th>Title</th>
				<th># of Awards</th>
				<th>Company</th>
				<th>Genre</th>
			</tr>		

<?php
	
	$sqlstr = 'SELECT M.title, COUNT(MA.award_id), C.name, G.name FROM Movie M INNER JOIN' 
	. ' Movie_to_Award MA ON M.id = MA.movie_id INNER JOIN' 
	. ' Company C ON M.company_id = C.id INNER JOIN' 
	. ' Genre G ON M.genre_id = G.id GROUP BY M.id';
	
	if(!($stmnt = $mysqli->prepare($sqlstr))) {
		echo 'Prepare failed: ' . $stmnt->errno . ' ' . $stmnt->error;
	}
	
	if(!$stmnt->execute()) {
		echo 'Execute failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
	}
	
	if(!$stmnt->bind_result($title, $awards, $company, $genre)) {
		echo 'Bind failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
	}
	
	while($stmnt->fetch()) {
		echo '<tr><td>' . $title . '</td><td>' . $awards . '</td><td>' . $company . '</td><td>' . $genre . '</td></tr>';
	}
	
	$stmnt->close();
	
?>
		</table>
		
		<h2>Companies</h2>
		<table>
			<tr>
				<th>Name</th>
				<th># of Movies</th>
			</tr>		

<?php
	
	$sqlstr = 'SELECT name, COUNT(Movie.id) FROM Company INNER JOIN' 
	. ' Movie ON Company.id = Movie.company_id GROUP BY Company.id';
	
	if(!($stmnt = $mysqli->prepare($sqlstr))) {
		echo 'Prepare failed: ' . $stmnt->errno . ' ' . $stmnt->error;
	}
	
	if(!$stmnt->execute()) {
		echo 'Execute failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
	}
	
	if(!$stmnt->bind_result($name, $movies)) {
		echo 'Bind failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
	}
	
	while($stmnt->fetch()) {
		echo '<tr><td>' . $name . '</td><td>' . $movies . '</td></tr>';
	}
	
	$stmnt->close();
	
?>
		</table>
		
		<h2>Genres</h2>
		<table>
			<tr>
				<th>Name</th>
				<th># of Movies</th>
			</tr>		

<?php
	
	$sqlstr = 'SELECT name, COUNT(Movie.id) FROM Genre INNER JOIN' 
	. ' Movie ON Genre.id = Movie.genre_id GROUP BY Genre.id';
	
	if(!($stmnt = $mysqli->prepare($sqlstr))) {
		echo 'Prepare failed: ' . $stmnt->errno . ' ' . $stmnt->error;
	}
	
	if(!$stmnt->execute()) {
		echo 'Execute failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
	}
	
	if(!$stmnt->bind_result($name, $movies)) {
		echo 'Bind failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
	}
	
	while($stmnt->fetch()) {
		echo '<tr><td>' . $name . '</td><td>' . $movies . '</td></tr>';
	}
	
	$stmnt->close();
	
?>
		</table>
		
		<h2>Awards</h2>
		<table>
			<tr>
				<th>Name</th>
				<th># of Movies</th>
			</tr>		

<?php
	
	$sqlstr = 'SELECT name, COUNT(Movie.id) FROM Company INNER JOIN' 
	. ' Movie ON Company.id = Movie.company_id GROUP BY Company.id';
	
	if(!($stmnt = $mysqli->prepare($sqlstr))) {
		echo 'Prepare failed: ' . $stmnt->errno . ' ' . $stmnt->error;
	}
	
	if(!$stmnt->execute()) {
		echo 'Execute failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
	}
	
	if(!$stmnt->bind_result($name, $movies)) {
		echo 'Bind failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
	}
	
	while($stmnt->fetch()) {
		echo '<tr><td>' . $name . '</td><td>' . $movies . '</td></tr>';
	}
	
	$stmnt->close();
	
?>
		</table>
		
  </body>
</html>
