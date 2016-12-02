<?php
    ini_set('display_errors', 'On');
    //replace credentials as necessary
    $mysqli = new mysqli('', '', '', '');
    if($mysqli->connect_errno) {
        echo 'Error connecting to database: ' . $stmt->errno . " " . $stmt->error;
    }
    if(!($stmt = $mysqli->prepare("INSERT INTO  Award(name) VALUES (?)"))){
        echo "Prepare failed: " . $stmt->errno . " " . $stmt->error;
    }
    if(!($stmt->bind_param("s", $_POST['AwardName']))){
        echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
    }
    if(!$stmt->execute()){
        echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
    } else {
        echo "Added " . $stmt->affected_rows . " rows to Award.";
    }
?>
