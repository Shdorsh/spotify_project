<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Listen to the most popular music here!" />
    <meta name="author" content="BuildUp Project Spotify" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="/css/favicon-tv.png" />
    <link rel="stylesheet" href="/css/reset.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,100;1,400;1,700&display=swap" rel="stylesheet" />
    <title>Like Spotify</title>
</head>

<body id="body">
    <?php
    $email = "";
    if (isset($_GET['submitButton'])) {
        if (isset($_GET['email']) && !empty($_GET['email'])) {
            echo "Your e-mail is OK <br>";
            $email = $_GET['email'];
            $password = $_GET['Password'];
        } else {
            echo "Please enter your e-mail.<br>";
        };
        if (isset($_GET['Password']) && !empty($_GET['Password'])) {
            echo "Your password is OK<br>";
        } else {
            echo "Please enter your password.<br>";
        }

        if (!empty($_GET['email']) && !empty($_GET['Password'])) {
            $conn = mysqli_connect('localhost', 'root', '', 'spotify_db');
            if ($conn) {
                echo 'Connected successfully<br>';
                $query = "SELECT email, password 
                FROM users
                WHERE users.email = '$email'";
                $results = mysqli_query($conn, $query);
                $userCheck = mysqli_fetch_all($results, MYSQLI_ASSOC);
                if ($userCheck[0]['password'] == $password) {
                    header("Location: http://www.songs.php");
                    exit();
                }
            }
        }
    }
    ?>

    <form method="GET" action="">
        <input type="text" name="email" placeholder="e-mail" value=<?php echo $email; ?>><br>
        <input type="text" name="Password" placeholder="Password"><br>
        <input type="submit" name="submitButton" value="Send" />
    </form>

    <style>
        form {
            display: flex;
            flex-direction: column;
            gap: 2px;
            width: 200px;
        }
    </style>
</body>

</html>