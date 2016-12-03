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
	
	//get awards
	$query = 'SELECT A.name FROM Movie_to_Award MA INNER JOIN'
		. ' Award A ON MA.award_id = A.id WHERE MA.movie_id=' . $_GET['id'];
	
	if(!($substmnt = $mysqli->prepare($query))) {
		echo 'Prepare failed: ' . $substmnt->errno . ' ' . $substmnt->error;
	}

	if(!$substmnt->execute()) {
		echo 'Execute failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
	}
	
	if(!$substmnt->bind_result($award)) {
		echo 'Bind failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
	}
	
	$awardlist = array();
	
	while($substmnt->fetch()) {
		array_push($awardlist, $award);
	}
	
	$substmnt->close();
	
	//get actors
	$query = 'SELECT MP.job_role, P.first_name, P.last_name FROM Movie_to_Person MP INNER JOIN'
		. ' Person P ON MP.person_id = P.id WHERE MP.movie_id=' . $_GET['id'];
	
	if(!($substmnt = $mysqli->prepare($query))) {
		echo 'Prepare failed: ' . $substmnt->errno . ' ' . $substmnt->error;
	}

	if(!$substmnt->execute()) {
		echo 'Execute failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
	}
	
	if(!$substmnt->bind_result($jobrole, $fname, $lname)) {
		echo 'Bind failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
	}
	
	$personlist = array();
	
	while($substmnt->fetch()) {
		array_push($personlist, $jobrole . ': ' . $fname . ' ' . $lname);
	}
	
	$substmnt->close();
	
	//get other details
	$sqlstr = 'SELECT M.title, COUNT(MA.award_id), C.name, G.name FROM Movie M LEFT JOIN' 
	. ' Movie_to_Award MA ON M.id = MA.movie_id LEFT JOIN' 
	. ' Company C ON M.company_id = C.id LEFT JOIN' 
	. ' Genre G ON M.genre_id = G.id WHERE M.id=' . $_GET['id'] . ' GROUP BY M.id';
	
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
		echo '<h1>Details for ' . $title . '</h1>';
		echo '<h3>Title: ' . $title . '</h3><h3>Company: ' . $company . '</h3><h3>Genre: ' . $genre . '</h3><h3>Awards: ' . $awards .  '</h3>';
		echo '<ul>';
		for($x = 0; $x < count($awardlist); $x++) {
			echo '<li>' . $awardlist[$x] . '</li>';
		}
		echo '</ul>';
		echo '<h3>People: ' . count($personlist) . '</h3>';
		echo '<ul>';
		for($x = 0; $x < count($personlist); $x++) {
			echo '<li>' . $personlist[$x] . '</li>';
		}
		echo '</ul>';
	}
	
	$stmnt->close();
	
?>

<!-- add an actor or director or other -->
<div>
    <form method="post" action="add.php">
        <fieldset>
            <legend>Attach a Person to the Movie</legend>
			<p>Person: 
                <select name="Person">
                    <?php
                        if(!($stmt = $mysqli->prepare("SELECT id, first_name, last_name FROM Person"))){
                            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                        }
                        if(!$stmt->execute()){
                            echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
                        }
                        if(!$stmt->bind_result($id, $fname, $lname)){
                            echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                        }
                        while ($stmt->fetch()){
                            echo '<option value=" ' .$id . ' "> ' . $fname . ' ' . $lname . '</option>\n';
                        }
                        $stmt->close();
                    ?>

                </select>
			</p>
            <p>Job Title: <input type="text" name="job_role" /></p>
			<?php
			echo "<input type='hidden' name='Movie' value=" . $_GET['id'] . " />";
			?>
		<input type='hidden' name='database' value='Movie_to_Person' />
        <p><input type="submit" /></p>
		</fieldset>
    </form>
</div>

<!-- connect an award to the movie -->
<div>
    <form method="post" action="add.php">
        <fieldset>
            <legend>Attach an Award to the Movie</legend>
			<p>Award: 
                <select name="Award">
                    <?php
                        if(!($stmt = $mysqli->prepare("SELECT id, name FROM Award"))){
                            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                        }
                        if(!$stmt->execute()){
                            echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
                        }
                        if(!$stmt->bind_result($id, $aname)){
                            echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                        }
                        while ($stmt->fetch()){
                            echo '<option value=" ' .$id . ' "> ' . $aname . '</option>\n';
                        }
                        $stmt->close();
                    ?>

                </select>
			</p>
			<?php
			echo "<input type='hidden' name='Movie' value=" . $_GET['id'] . " />";
			?>
		<input type='hidden' name='database' value='Movie_to_Award' />
        <p><input type="submit" /></p>
		</fieldset>
    </form>
</div>

<!-- change the title -->
<div>
	<form method="post" action="edit.php">
		<fieldset>
			<legend>Edit Title</legend>
			<p>New Title: <input type="text" name="value" /></p>
			<input type='hidden' name='column' value='title' />
			<input type='hidden' name='database' value='Movie' />
			<?php
			echo "<input type='hidden' name='id' value=" . $_GET['id'] . " />";
			?>
        <p><input type="submit" /></p>
		</fieldset>
	</form>
</div>

<!-- change the company from a drop down -->
<div>
    <form method="post" action="edit.php">
        <fieldset>
            <legend>Change the Company</legend>
			<p>Company: 
                <select name="value">
                    <?php
                        if(!($stmt = $mysqli->prepare("SELECT id, name FROM Company"))){
                            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                        }
                        if(!$stmt->execute()){
                            echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
                        }
                        if(!$stmt->bind_result($id, $name)){
                            echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                        }
                        while ($stmt->fetch()){
                            echo '<option value=" ' .$id . ' "> ' . $name . '</option>\n';
                        }
                        $stmt->close();
                    ?>

                </select>
			</p>
			<input type='hidden' name='column' value='company_id' />
			<input type='hidden' name='database' value='Movie' />
			<?php
			echo "<input type='hidden' name='id' value=" . $_GET['id'] . " />";
			?>
        <p><input type="submit" /></p>
		</fieldset>
	</form>
</div>

<!-- change the genre from a drop down list -->
<div>
    <form method="post" action="edit.php">
        <fieldset>
            <legend>Change the Genre</legend>
			<p>Genre: 
                <select name="value">
                    <?php
                        if(!($stmt = $mysqli->prepare("SELECT id, name FROM Genre"))){
                            echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
                        }
                        if(!$stmt->execute()){
                            echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
                        }
                        if(!$stmt->bind_result($id, $name)){
                            echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
                        }
                        while ($stmt->fetch()){
                            echo '<option value=" ' .$id . ' "> ' . $name . '</option>\n';
                        }
                        $stmt->close();
                    ?>

                </select>
			</p>
			<input type='hidden' name='column' value='genre_id' />
			<input type='hidden' name='database' value='Movie' />
			<?php
			echo "<input type='hidden' name='id' value=" . $_GET['id'] . " />";
			?>
        <p><input type="submit" /></p>
		</fieldset>
	</form>
</div>

<h3><a href="MovieDatabase.php">Return Home</a></h3>

</body>