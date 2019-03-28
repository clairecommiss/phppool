<?php
session_start();
include("check_login.php");
?>
<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="admin.css">
        <meta charset="utf-8" />
    </head>
    </html>
<?php
clean_entry();
if (check_login() !== "admin")
{
    echo "Vous n'êtes pas adminstrateur désolé\n";
    exit();
}
if (check_login() === "admin" && $_POST["submit"] === "ok" && (isset($_POST["login"]) || isset($_POST["mail"]) || isset($_POST["admin"])))
{
    $login = htmlspecialchars($_GET["login"]);
    if (isset($_POST["login"]))
        $n_login = htmlspecialchars($_POST["login"]);
    if (isset($_POST["mail"]))
        $n_mail = htmlspecialchars($_POST["mail"]);
    if (isset($_POST["admin"]))
        $n_statut = htmlspecialchars($_POST["admin"]);
    $fp = fopen("data/users", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/users");
    $tab = unserialize($series);
    foreach($tab as $key=>$row)
    {
        if ($row["login"] === $n_login || $row["mail"] === $n_mail)
        {
            echo "Login/mail déjà pris<br>";
            echo "<script>setTimeout(\"location.href = 'edit_user.php?login=".$login."';\",1500);</script>";
        exit();
        }
        if ($row["login"] === $login)
        {
            if (isset($n_login) && $n_login !== "" && $n_login !== null)
                $tab[$key]["login"] = $n_login; 
            if (isset($n_mail) && $n_mail!== "" && $n_mail !== null)
                $tab[$key]["mail"] = $n_mail; 
            if (isset($n_statut) && $n_statut !== "" && $n_statut !== null && $n_statut === "yes")
                $tab[$key]["statut"] = "admin";
            $n_login = $tab[$key]["login"];
            $n_mail = $tab[$key]["mail"];
            $n_statut = $tab[$key]["statut"];
        }
    }
    $str = serialize($tab);
    file_put_contents("data/users", $str);
    flock($fp, LOCK_UN);
    echo "<br><br>LOGIN: <b>".$n_login."</b><br>";
    echo "<i> MAIL: ".$n_mail."</i><br>";
    echo "STATUT: [".$n_statut."]<br>";
    ?>
    <!DOCTYPE html>
    <html>
        <head>
        <link rel="stylesheet" type="text/css" href="admin.css">
            <meta charset="utf-8" />
        </head>
    <body>
    <br>
        <br>
        <br>
        <h1>QUEL VOULEZ VOUS MODIFIER ?</h1>
        <br>
        <br>
        <form action="edit_user.php?login=<?php echo $n_login; ?>" method="POST">
            Le login: <input type="text" name="login"><br>
            Le mail: <input type="text" name="mail"><br>
            Elever au rang d'admin ?: <input type="checkbox" name="admin" value="yes"><br>
            <input type="submit" name="submit" value="ok"><br>
        </form>
        <a href="admin.php">RETOUR AU MENU ADMIN</a>
    </body>
    </html>
    <?php
    exit();
}
?>
<?php
if (check_login() === "admin" && isset($_GET["login"]))
{
    $login = htmlspecialchars($_GET["login"]);
    $fp = fopen("data/users", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/users");
    $tab = unserialize($series);
    foreach($tab as $key=>$row)
    {
        if ($row["login"] === $login)
        {
            $mail = $row["mail"];
            $statut = $row["statut"];
        }
    }
    flock($fp, LOCK_UN);
    echo "<br><br><b> LOGIN: ".$login."</b><br>";
    echo "<i> MAIL: ".$mail."</i><br>";
    echo "STATUT: [".$statut."]<br>";
    ?>
    <!DOCTYPE html>
    <html>
        <head>
        <link rel="stylesheet" type="text/css" href="admin.css">
            <meta charset="utf-8" />
        </head>
    <body>
        <br>
        <br>
        <br>
        <h1>QUEL VOULEZ VOUS MODIFIER ?</h1>
        <br>
        <br>
        <form action="edit_user.php?login=<?php echo $login; ?>" method="POST">
            Le login: <input type="text" name="login"><br>
            Le mail: <input type="text" name="mail"><br>
            Elever au rang d'admin ?: <input type="checkbox" name="admin" value="yes"><br>
            <input type="submit" name="submit" value="ok"><br>
        </form>
        <a href="admin.php">RETOUR AU MENU ADMIN</a>
    </body>
    </html>
    <?php
    exit();
}
?>