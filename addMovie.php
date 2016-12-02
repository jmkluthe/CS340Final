<?php
    
    ini_set('display_errors', 'On');
    //replace credentials as necessary
   $mysqli = new mysqli('', '', '', '');
    if($mysqli->connect_errno) {
        echo 'Error connecting to database: ' . $stmt->errno . " " . $stmt->error;
    }
    if(!($stmt = $mysqli->prepare("INSERT INTO  Movie(title, company_id, genre_id) VALUES (?, ?, ?)"))){
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    }
    if(!($stmt->bind_param("sii", $_POST['MovieTitle'], $_POST['Company'], $_POST['Genre']))){
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->execute()){
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    } else {
        echo "Added " . $stmt->affected_rows . " rows to Movie.";
      }
    
    

?>
