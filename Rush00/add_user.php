<?php
session_start();
include("check_login.php");
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
    <html>
<?php
clean_entry();
if (check_login() !== "admin")
{
    echo "Vous n'êtes pas adminstrateur désolé\n";
    exit();
}
if (check_login() === "admin" && isset($_POST["login"]) && isset($_POST["passwd"]) && isset($_POST["submit"]) && isset($_POST["mail"]))
{   
    $fp = fopen("data/users", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/users");
    $tab = unserialize($series);
    foreach ($tab as $row)
    {
        foreach ($row as $key=>$value)
        {
            if ($key === "login" && $value === htmlspecialchars($_POST["login"]))
            {
                echo("Login déjà utilisé<br>");
                echo "<script>setTimeout(\"location.href = 'add_user.php';\",1500);</script>";
                exit();
            }
            if ($key === "mail" && $value === htmlspecialchars($_POST["mail"]))
            {
                echo("Mail déjà utilisé<br>");
                echo "<script>setTimeout(\"location.href = 'add_user.php';\",1500);</script>";
                exit();
            }
        }
    }
    $data = hash("whirlpool", htmlspecialchars($_POST["passwd"]));
    if (htmlspecialchars($_POST["admin"]) == "yes")
        $tab[] = array("login"=>htmlspecialchars($_POST["login"]), "passwd"=>$data, "mail"=>htmlspecialchars($_POST["mail"]), "statut"=>"admin");
    else
        $tab[] = array("login"=>htmlspecialchars($_POST["login"]), "passwd"=>$data, "mail"=>htmlspecialchars($_POST["mail"]), "statut"=>"user");
    $base = serialize($tab);
    file_put_contents('data/users', $base);
    flock($fp, LOCK_UN);
    echo("Utilisateur ajouté<br>");
    echo "<script>setTimeout(\"location.href = 'add_user.php';\",1500);</script>";
    exit();
}
if (check_login() === "admin")
{
?>
<html>
    <h1>REMPLISSEZ LES INFORMATIONS DU NOUVEL UTILISATEUR</h1>
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
        <br>
        <br>
        <br>
    <form action="add_user.php" method="POST">
        Son identifiant: <input type="text" name="login" required><br>
        Son mot de passe: <input type="password" name="passwd" required><br>
        Son mail: <input type="text" name="mail" required><br>
        Est-ce un administrateur ?   <input type="checkbox" name="admin" value="yes"><br>
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