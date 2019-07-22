<?php
    session_start();
    if (isset($_SESSION["use"])){
        header("Location: board.php", true, 301);
        exit();
    }
?>
<!doctype html>
<head>
    <meta charset="utf-8">
    <title>Very Unique BBS - Login</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/main.css">

    <meta name="theme-color" content="#fafafa">
</head>

<body>
    <div id="login_page">
        <form method="post" action="index.php">
            <h2>Username:</h2>
            <input name="username" type="text"/>
            <h2>Password:</h2>
            <input name="password" type="password"/><br>
            <input name="actionLogin" value="Login" type="submit"/>
            <input name="actionRegister" value="Register" type="submit"/>
        </form>
    </div>
</body>