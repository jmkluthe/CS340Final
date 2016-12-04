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
            $query = 'SELECT A.name FROM Award A WHERE A.id=' . $_GET['id'];
    
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
    
            //get movies
            $query = 'SELECT M.title FROM Movie M INNER JOIN'
                . ' Movie_to_Award MA ON M.id=MA.movie_id WHERE MA.award_id=' . $_GET['id'];
    
            if(!($substmnt = $mysqli->prepare($query))) {
                echo 'Prepare failed: ' . $substmnt->errno . ' ' . $substmnt->error;
            }
    
            if(!$substmnt->execute()) {
                echo 'Execute failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
            }
    
            if(!$substmnt->bind_result($title)) {
                echo 'Bind failed: ' .  $mysqli->connect_errno . ' ' . $mysqli->connect_error;
            }
    
            $movielist = array();
    
            while($substmnt->fetch()) {
                array_push($movielist, $title);
            }
    
            $substmnt->close();
    
            //get other details
            $sqlstr = 'SELECT A.name, COUNT(MA.movie_id) FROM Award A INNER JOIN'
                . ' Movie_to_Award MA ON A.id=MA.movie_id WHERE A.id=' . $_GET['id'];
    
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
                echo '<h1>Details for ' . $award . '</h1>';
                echo '<h3>Movies: ' . $movies .  '</h3>';
                echo '<ul>';
                for($x = 0; $x < count($movielist); $x++) {
                    echo '<li>' . $movielist[$x] . '</li>';
                }
                echo '</ul>';
            }
    
            $stmnt->close();
    
        ?>


    <!-- edit award name -->
    <div>
        <form method="post" action="edit.php">
            <fieldset>
                <legend>Edit Award Name</legend>
                <p>Update Name: <input type="text" name="value" /></p>
                <input type='hidden' name='column' value='name' />
                <input type='hidden' name='database' value='Award' />
                <?php
                    echo "<input type='hidden' name='id' value=" . $_GET['id'] . " />";
                ?>
                <p><input type="submit" /></p>
            </fieldset>
        </form>
    </div>

    <!-- add a movie -->
    <div>
        <form method="post" action="add.php">
            <fieldset>
                <legend>Attach a Movie to the Award</legend>
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
                <?php
                    echo "<input type='hidden' name='Award' value=" . $_GET['id'] . " />";
                ?>
                <input type='hidden' name='database' value='Movie_to_Award' />
                <p><input type="submit" /></p>
            </fieldset>
        </form>
    </div>



<h3><a href="MovieDatabase.php">Return Home</a></h3>

</body>
