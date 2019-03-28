<?php
session_start();
include("check_login.php");
echo "<center><h1> UTILISATEURS ENREGISTRES </h1></center>";
if (check_login() !== "admin")
{
    echo "Vous n'êtes pas adminstrateur désolé\n";
    exit();
}
else if (file_exists("data/users"))
{
    $fp = fopen("data/users", "r+");
    flock($fp, LOCK_SH);
    $data = file_get_contents("data/users");
    $tab = unserialize($data);
    foreach($tab as $row)
    {
        echo "<br><br>LOGIN: <b>".$row["login"]."</b><br>";
        echo "<i> MAIL: ".$row["mail"]."</i><br>";
        echo "STATUT: [".$row["statut"]."]<br>";
    }
    flock($fp, LOCK_UN);
}
else
    echo "<h1>AUCUN USER ENREGISTRE</h1>";
?>