<?php
session_start();
include("check_login.php");
echo "<center><h1> CATEGORIES EXISTANTES </h1></center>";
if (check_login() !== "admin")
{
    echo "Vous n'êtes pas adminstrateur désolé\n";
    exit();
}
if (file_exists("data/categories"))
{
    $fp = fopen("data/categories", "r+");
    flock($fp, LOCK_SH);
    $data = file_get_contents("data/categories");
    $tab = unserialize($data);
    foreach($tab as $key=>$row)
    {
        echo "<br>Dans la catégorie <b>".$row["cat"]."</b> :<br><br>";
        foreach($row as $ind=>$obj)
        {
            if($ind !== "cat")
            {
            echo "- ".$obj."<br>";
            }
        }
    }
    flock($fp, LOCK_UN);
}
else
{
    echo "<h1>AUCUNE CATEGORIES ENREGISTREE</h1>";
}
if (file_exists("data/produits"))
{
    $fp = fopen("data/produits", "r+");
    flock($fp, LOCK_SH);
    $data = file_get_contents("data/produits");
    $tab = unserialize($data);
    echo "<br><br><b>Tout les produits :</b> <br>";
    foreach($tab as $key=>$row)
    {
        echo "- ".$row["name"]."<br>";
    }
    flock($fp, LOCK_UN);
}
?>