<?php
    function searchSong() {
        // If submit wasn't pressed or someone pressed it wthout entering anything in the searchbar, return
        if(!isset($_POST["submit"]) || !isset($_POST["artistSearch"]))
            return null;
        
        // Connect to the database and search for the artist and his genres
        $dbConnection = mysqli_connect("localhost","root",null,"spotify_db");
        $query = "SELECT artists.*, categories.title FROM artists
        INNER JOIN songs ON songs.artist_id = artists.id
        INNER JOIN categories ON songs.categ_id = categories.id";

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

    function createCard($name, $songNum, $genre, $bio) {
        echo "<div class='card-container'>
                <div class='card-title'>
                    <div>" . $name . "</div>
                    <div>(" . $songNum . ")</div>
                </div>
                <div>";
        foreach($genre as $category) {
            echo $category . ", ";
        }

        echo "</div>
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
</head>
<body> 
    <form method="post">
        <input type="text" name="artistSearch" id="" /><input type="submit" name="submit" value="Search songs" />
    </form>

    <?php
        $returnArray = searchSong();

        if($returnArray) {
            foreach($returnArray as $artist)
                createCard($artist['name'],$artist['songsnum'],$artist['genre'],$artist['bio']);
        }
    ?>
</body>
</html>