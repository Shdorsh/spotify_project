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
    <form action="">
        <input type="text" name="firstName" placeholder="Type your first name">
        <input type="text" name="lastName" placeholder="Type your last name">
        <input type="text" name="email" placeholder="Type your email address">
        <input type="text" name="password" placeholder="Type your password">
        <input type="text" name="confirmation" placeholder="Confirm password">
        <fieldset>
            <legend>Do you want get info about new songs?</legend>
            <div class="checkbox">
                <input type="checkbox" id="newsletter" name="newsletter">
                <label for="newsletter">Subscribe here!</label>
                <button type="submit" name="submit">Submit</button>
            </div>
        </fieldset>
    </form>
    <div class="totals">
        <?php

        if (isset($_GET['submit'])) {
            $errors = false;
            if (strlen($_GET['email']) > 50 || strlen($_GET['email']) < 8) {
                echo "Email must be at maximum 50 characters long and at least 8 characters long!";
                $errors = true;
            };
            if (empty($_GET['firstName']) || empty($_GET['lastName'])) {
                echo 'First name and last name are mandatory !';
                $errors = true;
            };
            if ((strlen($_GET['password']) < 8) || (strlen($_GET['confirmation']) < 8) || ($_GET['password']) !== ($_GET['confirmation'])) {
                echo 'The fields "Password" and "Confirmation" must be identical and have at least 8 characters!';
                $errors = true;
            };

            if ($errors == false) {
                $firstName = $_GET['firstName'];
                $lastName = $_GET['lastName'];
                $email = $_GET['email'];
                $password = $_GET['password'];
                echo "Welcome to our Music Database! Your first name is $firstName and your last name is $lastName. Your email is $email and password is equal to [$password].";
                // $_SESSION['id'] = $_GET['email'];
               

                $conn = mysqli_connect('localhost', 'root', '', 'spotify_db');
                if ($conn) {
                    echo 'Connected successfully<br>';
                    $query = "INSERT INTO users (username, email, password) 
                VALUES ('$firstName $lastName', '$email', '$password')";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        echo 'Successfully inserted in the DB.';
                    } else {
                        echo 'Problem inserting.';
                    }
                }

                if ($result)
                    echo 'Successfully inserted in the DB.';
            }
        }


        ?>
    </div>

    <style>
        body {
            width: 350px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .totals {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 10px;
            margin: 10px;
        }
    </style>
</body>

</html>