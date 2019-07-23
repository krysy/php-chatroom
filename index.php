<?php
    session_start();
    if (isset($_SESSION["use"])){
       header("Location: board.php", true, 301);
       exit();
    } else {
        if (isset($_POST["actionLogin"])) {
            $link = mysqli_connect("127.0.0.1", $_SERVER["PHP_MYSQL_USER"], $_SERVER["PHP_MYSQL_PASSWORD"], $_SERVER["PHP_MYSQL_DATABASE"]);
           //+ $link = mysqli_connect("127.0.0.1", "debian-sys-maint", "8yyDgy9ov9J5ydB0", "uniproj1");
            // create new user
            $statement = $link->prepare("SELECT password_hash, id FROM users WHERE username=?");
            $statement->bind_param("s" ,$_POST["username"]);
            $statement->execute();
            $result = $statement->get_result()->fetch_assoc();

            //get_result()->fetch_all()[0][0];

            if (password_verify($_POST["password"], $result["password_hash"])) {
                $_SESSION["use"] = true;
                $_SESSION["username"] = $_POST["username"];
                $_SESSION["userid"] = $result["id"];
                header("Location: index.php", true, 301);
                exit();
            } else {
                header("Location: login.php", true, 301);
                exit();
            }
        } else if(isset($_POST["actionRegister"])) {
            header("Location: register.php", true, 301);
            exit();
        } else if(!isset($_POST["username"]) && !isset($_POST["password"])){
            header("Location: login.php", true, 301);
            exit();
        }
    }
?>
<!doctype html>
<head>
    <meta charset="utf-8">
    <title>Very Unique BBS</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="site.webmanifest">
    <!-- Place favicon.ico in the root directory -->

    <link rel="stylesheet" href="css/main.css">

    <meta name="theme-color" content="#fafafa">
</head>

<body>

</body>
</html>
