<?php
include("check_login.php");
clean_entry();
?>
<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <meta charset="utf-8" />
    <style>
        body{
             position: absolute;
        }
        div{
            position: absolute;
        }
        </style>
    </head>
    </html>
<?php
if (check_login() !== "admin")
{
    echo "Vous n'êtes pas adminstrateur désolé\n";
    exit();
}
if (check_login() === "admin" && isset($_POST["login"]) && isset($_POST["submit"]) && $_POST["login"] !== "")
{   
    if ($_SESSION["loggued_on_user"] == htmlspecialchars($_POST["login"]))
    {
        echo"Vous ne pouvez pas vous supprimer vous même<br>";
        echo "<script>setTimeout(\"location.href = 'del_user.php';\",1500);</script>";
        exit();
    }
    $fp = fopen("data/users", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/users");
    $tab = unserialize($series);
    foreach ($tab as $key=>$row)
    {
        foreach ($row as $ind=>$value)
        {
            if ($ind === "login" && $value === htmlspecialchars($_POST["login"]) && $row["statut"] === "admin")
            {
                echo("Vous ne pouvez pas supprimer un administrateur<br>");
                echo "<script>setTimeout(\"location.href = 'del_user.php';\",1500);</script>";
                flock($fp, LOCK_UN);
                exit();
            } 
            if ($ind === "login" && $value === htmlspecialchars($_POST["login"]) && $row["statut"] !== "admin")
            {
                unset($tab[$key]);
                $base = serialize($tab);
                file_put_contents('data/users', $base);
                flock($fp, LOCK_UN);
                echo("Utilisateur supprimé<br>");
                echo "<script>setTimeout(\"location.href = 'del_user.php';\",1500);</script>";
                exit();
            }
        }
    }
    echo("Utilisateur non-trouvé<br>");
    echo "<script>setTimeout(\"location.href = 'del_user.php';\",1500);</script>";
    exit();
    flock($fp, LOCK_UN);
}
if (check_login() === "admin")
{
?>
<html>
    <h1>QUEL UTILISATEUR VOULEZ VOUS SUPPRIMER ?</h1>
    <br>
    <br>
    <br>
    <div>
            <iframe
                    id="current_users" name="current_users" src="current_users.php" 
                    scrolling="yes" frameboder="2"
                    style ="position: relative; height: 1000px; width: 500px; right: -150%; top: -100%"> 
            </iframe>
        </div>
<body>
<div>
    <br><br><br>
    <form action="del_user.php" method="POST">
        Son identifiant: <input type="text" name="login"><br>
        <input type="submit" name="submit" value ="ok"><br>
    </form>
    <br>
    <br>
    <a href="admin.php">RETOUR AU MENU ADMIN</a>
</div>
</body>
</html>
<?php
exit();
}
else
    echo "VOUS N'ETES PAS ADMIN\n"
?>