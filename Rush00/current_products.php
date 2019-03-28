<?php
session_start();
include("check_login.php");
echo "<center><h1> PRODUITS SUR LE SITE </h1></center>";
if (check_login() !== "admin")
{
    echo "Vous n'êtes pas adminstrateur désolé\n";
    exit();
}
else if (file_exists("data/produits"))
{
    $fp = fopen("data/produits", "r+");
    flock($fp, LOCK_SH);
    $data = file_get_contents("data/produits");
    $tab = unserialize($data);
    foreach($tab as $key=>$row)
    {
        echo "-<b>".$row["name"]."</b> :<br><br>";
        echo "<div><img src =".$row["img"]." width=100px height=100px></div>";
        echo "<i>Prix :".$row["prix"]."€</i><br><br>";
    }
    flock($fp, LOCK_UN);
}
else
    echo "<h1>AUCUNE COMMANDE ENREGISTREE</h1>";
?>