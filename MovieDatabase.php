
<!--Turn on error reporting and connect to the database.-->
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
<title>Movies Database</title>
</head>
<body>
<h1>Hello! Welcome to the movies database!</h1>


<!--Display the list of movies in the database and allow the user to add to the Movie table.-->
<div>
    <table>
        <tr>
            <td>Movies</td>
        
        </tr>
        <tr>
            <td>Title</td>
            <td>Production Company</td>
            <td>Genre</td>
        </tr>
        <!--Retrieve and display Movie data--!>
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
                echo "<tr>\n<td>" . $title . "\n</td>\n<td>" . $company_id . "</td>\n<td>" . $genre_id . "</td>\n<td>";
				//add delete button
				echo "<td><form method='post' action='delete.php'><input type='hidden' name='database' value='Movie' />"
					. "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Delete Record' /></form></td>";
            }
            $stmt->close();
        ?>
    </table>
</div>

<!--Allow the user to add a movie to the database-->
<div>
    <form method="post" action="addMovie.php">
        <!--Input the movie title into a textbox-->
        <fieldset>
            <legend>Movie Title</legend>
            <p>Title: <input type="text" name="MovieTitle" /></p>
        </fieldset>
        
        <!--The user selects the production company from a dynamically populated drop-down list. The list is populated from the Company table.-->
        <fieldset>
            <legend>Production Company</legend>
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
        </fieldset>

        <!--The user selects the genre from a dynamically populated drop-down list. The list is populated from the Genre table.-->
        <fieldset>
            <legend>Movie Genre</legend>
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
        </fieldset>
        <p><input type="submit" /></p>
    </form>
</div>

<!--Display the list of people in the database that have a job/role in a movie and allow the user to add to the Person table.-->
<div>
    <table>
        <tr>
            <td>People</td>
        </tr>
        <tr>
            <td>ID</td>
            <td>First Name</td>
            <td>Last Name</td>
            <td>DOB</td>
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
                echo "<tr>\n<td>" . $id . "\n</td>\n<td>" . $first_name . "</td>\n<td>" . $last_name . "</td>\n<td>" . $dob . "</td>\n<td>";
				//add delete button
				echo "<td><form method='post' action='delete.php'><input type='hidden' name='database' value='Person' />"
					. "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Delete Record' /></form></td>";
			}
            $stmt->close();
        ?>
</table>
</div>

<!--Allow the user to add a person to the database-->
<div>
    <form method="post" action="addPerson.php">

    <!--Input the cast/crew member name and date of birth-->
    <fieldset>
        <legend>Cast/Crew Name</legend>
        <p>First Name: <input type="text" name="FirstName" /></p>
    </fieldset>

    <!--Input the last name into a textbox-->
    <fieldset>
        <p>Last Name: <input type="text" name="LastName" /></p>
    </fieldset>

    <!--Input the DOB into a textbox-->
    <fieldset>
        <p>Date of Birth: <input type="text" name="DOB" /></p>
    </fieldset>
    <p><input type="submit" /></p>
    </form>
</div>

<!--Display the list of genres in the database and allow the user to add to the Genre table.-->
<div>
    <table>
        <tr>
            <td>Genre</td>
        </tr>
        <tr>
            <td>ID</td>
            <td>Type</td>
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
            echo "<tr>\n<td>" . $id . "\n</td>\n<td>" . $name . "</td>\n<td>";
			//add delete button
				echo "<td><form method='post' action='delete.php'><input type='hidden' name='database' value='Genre' />"
					. "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Delete Record' /></form></td>";
        }
        $stmt->close();
        ?>
    </table>
</div>

<!--Allow the user to add a genre to the database-->
<div>
    <form method="post" action="addGenre.php">

    <!--Input the genre type-->
    <fieldset>
        <legend>Movie Genre</legend>
        <p>Genre Type: <input type="text" name="GenreType" /></p>
    </fieldset>
    <p><input type="submit" /></p>
    </form>
</div>

<!--Display the list of production companies in the database and allow the user to add to the Company table.-->
<div>
    <table>
        <tr>
            <td>Production Company</td>
        </tr>
        <tr>
            <td>ID</td>
            <td>Name</td>
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
                echo "<tr>\n<td>" . $id . "\n</td>\n<td>" . $name . "</td>\n<td>";
				//add delete button
				echo "<td><form method='post' action='delete.php'><input type='hidden' name='database' value='Company' />"
					. "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Delete Record' /></form></td>";
            }
            $stmt->close();
        ?>
    </table>
</div>

<!--Allow the user to add a production company to the database-->
<div>
    <form method="post" action="addCompany.php">

        <!--Input the genre type-->
        <fieldset>
            <legend>Production Company</legend>
            <p>Company Name: <input type="text" name="CompanyName" /></p>
        </fieldset>
        <p><input type="submit" /></p>
    </form>
</div>

<!--Display the list of awards in the database and allow the user to add to the Award table.-->
<div>
    <table>
        <tr>
            <td>Movie Awards</td>
        </tr>
        <tr>
            <td>ID</td>
            <td>Name</td>
        </tr>
        <!--Retrieve and display genre data from the Genre table-->
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
                echo "<tr>\n<td>" . $id . "\n</td>\n<td>" . $name . "</td>\n<td>";
				//add delete button
				echo "<td><form method='post' action='delete.php'><input type='hidden' name='database' value='Award' />"
					. "<input type='hidden' name='id' value='" . $id . "' /><input type='submit' value='Delete Record' /></form></td>";
            }
            $stmt->close();
            ?>
</table>
</div>

<!--Allow the user to add an award to the database-->
<div>
    <form method="post" action="addAward.php">

        <!--Input the genre type-->
        <fieldset>
            <legend>Movie Award</legend>
            <p>Award Name: <input type="text" name="AwardName" /></p>
        </fieldset>
        <p><input type="submit" /></p>
    </form>
</div>

</body>
</html>
