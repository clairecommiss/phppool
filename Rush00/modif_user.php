<?php
session_start();
include("check_login.php");
clean_entry();
if (check_login() !== "admin")
{
    echo "Vous n'êtes pas adminstrateur désolé\n";
    exit();
}
if (check_login() === "admin" && isset($_POST["login"]) && isset($_POST["submit"]) && $_POST["submit"] === "ok")
{
    $login = htmlspecialchars($_POST["login"]);
    $duck = 0;
    $fp = fopen("data/users", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/users");
    $tab = unserialize($series);
    foreach($tab as $key=>$row)
    {
        if ($row["login"] === $login)
        {
            flock($fp, LOCK_UN);
            header("location: edit_user.php?login=".$login);
            exit("found");
        }
    }
    flock($fp, LOCK_UN);
    echo("Utilisateur non-trouvé<br>");
    echo "<script>setTimeout(\"location.href = 'modif_user.php';\",1500);</script>";
    exit();
}
?>

<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <link rel="stylesheet" type="text/css" href="admin.css">
            <style>
        body{
             position: absolute;
        }
        div{
            position: absolute;
        }
        </style>
        </head>
        <h1>QUEL UTILISATEUR VOULEZ VOUS MODIFIER ?</h1>
        <br><br>
        <br>
        <div>
            <iframe
                    id="current_users" name="current_users" src="current_users.php" 
                    scrolling="yes" frameborder="2"
                    style ="position: relative; height: 1000px; width: 500px; right: -150%; top: -100%"> 
            </iframe>
        </div>
        <body>
        <div>
            <br>
            <br>
            <br>
        <form action="modif_user.php" method="POST">
            Login de l'utilisateur: <input type="text" name="login"><br>
            <input type="submit" name="submit" value="ok"><br>
        </form>
        <br><br>
        <a href="admin.php">RETOUR AU MENU ADMIN</a>
        </div>
    </body>
    </html>