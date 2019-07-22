<?php
    session_start();
    if (isset($_SESSION["use"])){
        header("Location: board.php", true, 301);
        exit();
    }
    $valid = true;
    if ($_POST["username"]=="") {
        $valid = false;
        echo "<div class='warning'>Username not entered</div>";
    }
    if ($_POST["password"]=="") {
        $valid = false;
        echo "<div class='warning'>Password not entered</div>";
    }

    if ($_POST["email"]==""){
        $valid = false;
        echo "<div class='warning'>Email not entered</div>";
    }

    if (isset($_POST["password"]) && isset($_POST["password_again"])) {
        if (!($_POST["password"] === $_POST["password_again"])){
            $valid = false;
            echo "<div class='warning'>Passwords do not match!</div>";
        }
    }

    if($valid){
        $link = mysqli_connect("127.0.0.1", $_SERVER["PHP_MYSQL_USER"], $_SERVER["PHP_MYSQL_PASSWORD"], $_SERVER["PHP_MYSQL_DATABASE"]);

        // hash and salt password
        $hashed_password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        // create new user
        $statement = $link->prepare("INSERT INTO users (username, password_hash, email) VALUES ( ?, ?, ?)");
        $statement->bind_param("sss" ,$_POST["username"], $hashed_password, $_POST["email"]);
        if (!$statement->execute()) {
            echo "<div class='warning'>Duplicate user or email!</div>";
        } else {
            $statement->close();
            header("Location: login.php", true, 301);
            exit();
        }

    }

?>
<!doctype html>
<head>
    <meta charset="utf-8">
    <title>Very Unique BBS - Register</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/main.css">

    <meta name="theme-color" content="#fafafa">
</head>

<body>
    <div id="login_page">
        <form method="post">
            <h2>Username:</h2>
            <input name="username" type="text"/>
            <h2>Password:</h2>
            <input name="password" type="password"/><br>
            <h2>Password again:</h2>
            <input name="password_again" type="password"/><br>
            <h2>Email:</h2>
            <input name="email" type="text"/><br>
            <input value="Register" type="submit"/>
        </form>
    </div>
</body>