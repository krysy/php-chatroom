<?php
    session_start();
    if (!isset($_SESSION["use"])){
        header("Location: login.php", true, 301);
        exit();
    } else {
        if (isset($_POST["actionLogout"])) {
            session_destroy();
            header("Location: login.php", true, 301);
            exit();
        }
        $link = mysqli_connect("127.0.0.1", $_SERVER["PHP_MYSQL_USER"], $_SERVER["PHP_MYSQL_PASSWORD"], $_SERVER["PHP_MYSQL_DATABASE"]);
        if (isset($_POST["actionSubmitPost"])) {
            if ($_POST["postText"] !== ""){
                //echo addslashes($_POST["postText"]);
                $statement = $link->prepare("INSERT INTO posts (text, posterId) VALUES ( ?, ?)");
                $statement->bind_param("ss" , addslashes($_POST["postText"]),$_SESSION["userid"]);
                $statement->execute();
                header("Location: board.php", true, 301);
                exit();
            } else {
                echo "<div class='warning'>Invalid post!</div>";
            }
        }
    }
?>
<!doctype html>
<head>
    <meta charset="utf-8">
    <title>Very Unique BBS - Board</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/main.css">

    <meta name="theme-color" content="#fafafa">
</head>

<body>
<?php
    echo "
        <header id='board_header'>
            <span>Hello {$_SESSION["username"]}!<span>
            <form method='post' action='board.php'>
               <input name='actionLogout' type='submit' value='Logout'/>
            </form>
        </header>";

        $statement = $link->prepare("SELECT posts.text, users.username as poster FROM posts INNER JOIN users ON posts.posterId=users.id");
        $statement->execute();
        $result = $statement->get_result();

        while($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }

        echo "<div id='posts'>";
        if(!$arr){
            echo "No posts yet!";
        } else {
            foreach ($arr as $row){
                echo "
                    <div class='post'>
                        <div class='posterName'>{$row["poster"]}</div>
                        <div class='postText'>{$row["text"]}</div>
                    </div>
                ";
            }
        }
        echo "</div>";

?>
<footer>
    <form method="post" id="board_chat_form" action="board.php">
        <input name="postText" type="text" style="width: 80%" autocomplete="off"/>
        <input name="actionSubmitPost" type="submit" style="position: absolute; width: 15%; right: 5px;"value="Post">
    </form>
    <marquee>Just a simple forum</marquee>
</footer>
</body>
