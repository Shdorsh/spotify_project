<?php
    function searchSong($input) {
        // If submit wasn't pressed or someone pressed it wthout entering anything in the searchbar, return
        if(!isset($_POST["submit"]))
            return null;
        
        // Connect to the database and search for the artist and his genres
        $dbConnection = mysqli_connect("localhost","root",null,"spotify_db");
        $query = "SELECT artists.*, categories.title FROM artists
        INNER JOIN songs ON songs.artist_id = artists.id
        INNER JOIN categories ON songs.categ_id = categories.id
        WHERE artists.name LIKE '%$input%'";

        // This is the data we got. it got multiple entries in case a certain artist has 2 genres
        $fetchAll = mysqli_fetch_all(mysqli_query($dbConnection, $query),MYSQLI_ASSOC);

        $returnData = array();

        foreach($fetchAll as $value) {
            // If a certain $value['name'] entry is already in the database, only update some values and go to the next $fetchAll entry
            if(isset($returnData[$value['name']])) {
                $returnData[$value['name']]['songsnum']++;
                $returnData[$value['name']]['genre'][] = $value['title'];
                continue;
            }

            // Else, create a new entry in the database
            $returnData[$value['name']] = array();
            $returnData[$value['name']]['name'] = $value['name'];
            $returnData[$value['name']]['bio'] = substr($value['bio'],0,20);
            $returnData[$value['name']]['genre'][] = $value['title'];
            $returnData[$value['name']]['songsnum'] = 1;

        }
        // Returns an array with all the rappers, and their genres
        return $returnData;
    }

    // Creates the divcard for each artist
    function createCard($name, $songNum, $genre, $bio) {
        echo "<div class='card-container'>
                <div class='card-title'>
                    <div>" . $name . "</div>
                    <div>(" . $songNum . ")</div>
                </div>
                <div>" . implode(", ", array_unique($genre)) . "</div>
            <div>" . $bio . "...</div>
        </div>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../php/reset.css">
    <link rel="stylesheet" href="../php/style.css">
</head>
<body> 
    <form method="post">
        <input type="text" name="artistSearch" id="" /><input type="submit" name="submit" value="Search songs" />
    </form>

    <?php
        // Search for a given artist. The default name is an empty string, unless someone types in a name
        $searchArtistName = "";
        if(isset($_POST['artistSearch'])) {
            $searchArtistName = $_POST['artistSearch'];
        }
        $returnArray = searchSong($searchArtistName);

        // If the return array isn't empty, show the divcards. might add a message when nothing found
        if($returnArray) {
            foreach($returnArray as $artist)
                createCard($artist['name'],$artist['songsnum'],$artist['genre'],$artist['bio']);
        }
    ?>
</body>
</html>