
<!--Turn on error reporting and connect to the database.-->
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
<h1>Hello! Welcome to the movies database!</h1>

<br />
<!--Display the list of movies in the database and allow the user to add to the Movie table.-->
<div>
    <table>
        <tr>
            <th>Movies</th>
        
        </tr>
        <tr>
            <th>Title</th>
            <th>Production Company</th>
            <th>Genre</th>
        </tr>
        <!--Retrieve and display Movie data-->
        <?php
            if(!($stmt = $mysqli->prepare("SELECT id, title, company_id, genre_id FROM Movie"))){
                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }
            if(!$stmt->execute()){
                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
            }
            if(!$stmt->bind_result($id, $title, $company_id, $genre_id)){
                echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
            }
            while ($stmt->fetch()){
                echo "<tr>\n<td>" . $title . "\n</td>\n<td>" . $company_id . "</td>\n<td>" . $genre_id . "</td>\n";
				//add edit/detail buttton
				echo "<td><form method='get' action='movie_detail.php'>"
					. "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Show Details/Edit' /></form></td>";
				//add delete button
				echo "<td><form method='post' action='delete.php'><input type='hidden' name='database' value='Movie' />"
					. "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Delete Record' /></form></td></tr>";
            }
            $stmt->close();
        ?>
    </table>
</div>
<br />
<!--Allow the user to add a movie to the database-->
<div>
    <form method="post" action="add.php">
        <!--Input the movie title into a textbox-->
        <fieldset>
            <legend>Add a Movie</legend>
            <p>Title: <input type="text" name="MovieTitle" /></p>
        
        
        <!--The user selects the production company from a dynamically populated drop-down list. The list is populated from the Company table.-->
			<p>Company: 
                <select name="Company">
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

        <!--The user selects the genre from a dynamically populated drop-down list. The list is populated from the Genre table.-->
			<p>Genre: 
                <select name="Genre">
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
		<input type='hidden' name='database' value='Movie' />
        <p><input type="submit" /></p>
		</fieldset>
    </form>
</div>
<br />
<!--Display the list of people in the database that have a job/role in a movie and allow the user to add to the Person table.-->
<div>
    <table>
        <tr>
            <th>People</th>
        </tr>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>DOB</th>
        </tr>
        <!--Retrieve and display People data from the Person table-->
        <?php
            if(!($stmt = $mysqli->prepare("SELECT id, first_name, last_name, dob FROM Person"))){
                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }
            if(!$stmt->execute()){
                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
            }
            if(!$stmt->bind_result($id, $first_name, $last_name, $dob)){
                echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
            }
            while ($stmt->fetch()){
                echo "<tr>\n<td>" . $id . "\n</td>\n<td>" . $first_name . "</td>\n<td>" . $last_name . "</td>\n<td>" . $dob . "</td>\n";
                //add edit/detail buttton
                echo "<td><form method='get' action='person_detail.php'>"
                . "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Show Details/Edit' /></form></td>";
                //add delete button
				echo "<td><form method='post' action='delete.php'><input type='hidden' name='database' value='Person' />"
					. "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Delete Record' /></form></td></tr>";
			}
            $stmt->close();
        ?>
</table>
</div>
<br />
<!--Allow the user to add a person to the database-->
<div>
    <form method="post" action="add.php">

    <!--Input the cast/crew member name and date of birth-->
    <fieldset>
        <legend>Add a Person</legend>
        <p>First Name: <input type="text" name="FirstName" /></p>
    

    <!--Input the last name into a textbox-->
    
        <p>Last Name: <input type="text" name="LastName" /></p>
    

    <!--Input the DOB into a textbox-->
    
        <p>Date of Birth: <input type="text" name="DOB" /></p>
    <input type='hidden' name='database' value='Person' />
    <p><input type="submit" /></p>
	</fieldset>
    </form>
</div>
<br />
<!--Display the list of genres in the database and allow the user to add to the Genre table.-->
<div>
    <table>
        <tr>
            <th>Genre</th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Type</th>
        </tr>
    <!--Retrieve and display genre data from the Genre table-->
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
            echo "<tr>\n<td>" . $id . "\n</td>\n<td>" . $name . "</td>\n";
            //add edit/detail buttton
            echo "<td><form method='get' action='genre_detail.php'>"
            . "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Show Details/Edit' /></form></td>";
            
            //add delete button
				echo "<td><form method='post' action='delete.php'><input type='hidden' name='database' value='Genre' />"
					. "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Delete Record' /></form></td></tr>";
        }
        $stmt->close();
        ?>
    </table>
</div>
<br />
<!--Allow the user to add a genre to the database-->
<div>
    <form method="post" action="add.php">

    <!--Input the genre type-->
    <fieldset>
        <legend>Add a Genre</legend>
        <p>Genre Type: <input type="text" name="GenreType" /></p>
    <input type='hidden' name='database' value='Genre' />
    <p><input type="submit" /></p>
	</fieldset>
    </form>
</div>
<br />
<!--Display the list of production companies in the database and allow the user to add to the Company table.-->
<div>
    <table>
        <tr>
            <th>Production Company</th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        <!--Retrieve and display production company data from the Company table-->
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
                echo "<tr>\n<td>" . $id . "\n</td>\n<td>" . $name . "</td>\n";
                
                //add edit/detail buttton
                echo "<td><form method='get' action='company_detail.php'>"
                . "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Show Details/Edit' /></form></td>";
                
                //add delete button
				echo "<td><form method='post' action='delete.php'><input type='hidden' name='database' value='Company' />"
					. "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Delete Record' /></form></td></tr>";
            }
            $stmt->close();
        ?>
    </table>
</div>
<br />
<!--Allow the user to add a production company to the database-->
<div>
    <form method="post" action="add.php">

        <!--Input the genre type-->
        <fieldset>
            <legend>Add a Production Company</legend>
            <p>Company Name: <input type="text" name="CompanyName" /></p>
			<input type='hidden' name='database' value='Company' />
        <p><input type="submit" /></p>
        </fieldset>
    </form>
</div>
<br />
<!--Display the list of awards in the database and allow the user to add to the Award table.-->
<div>
    <table>
        <tr>
            <th>Movie Awards</th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        <!--Retrieve and display award data from the Award table-->
        <?php
            if(!($stmt = $mysqli->prepare("SELECT id, name FROM Award"))){
                echo "Prepare failed: "  . $stmt->errno . " " . $stmt->error;
            }
            if(!$stmt->execute()){
                echo "Execute failed: " . $stmt->errno . " " . $stmt->error;
            }
            if(!$stmt->bind_result($id, $name)){
                echo "Bind failed: " . $stmt->errno . " " . $stmt->error;
            }
            while ($stmt->fetch()){
                echo "<tr>\n<td>" . $id . "\n</td>\n<td>" . $name . "</td>\n";
				
                //add edit/detail buttton
                echo "<td><form method='get' action='awards_detail.php'>"
                . "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Show Details/Edit' /></form></td>";
                
                //add delete button
				echo "<td><form method='post' action='delete.php'><input type='hidden' name='database' value='Award' />"
					. "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Delete Record' /></form></td></tr>";
            }
            $stmt->close();
            ?>
</table>
</div>
<br />
<!--Allow the user to add an award to the database-->
<div>
    <form method="post" action="add.php">

        <!--Input the genre type-->
        <fieldset>
            <legend>Add a Movie Award</legend>
            <p>Award Name: <input type="text" name="AwardName" /></p>
			<input type='hidden' name='database' value='Award' />
        <p><input type="submit" /></p>
        </fieldset>
    </form>
</div>

</body>
</html>
