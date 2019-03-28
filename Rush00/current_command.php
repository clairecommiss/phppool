<?php
session_start();
include("check_login.php");
echo "<center><h1> COMMANDES EN COURS </h1></center>";
if (check_login() !== "admin")
{
    echo "Vous n'êtes pas adminstrateur désolé\n";
    exit();
}
if (file_exists("data/commandes") && (isset($_GET["key"])  || $_GET["key"] == 0) && $_GET["key"] !== "" && $_GET["key"] !== null)
{
    $fp = fopen("data/commandes", "r+");
    flock($fp, LOCK_EX);
    $data = file_get_contents("data/commandes");
    $tab = unserialize($data);
    foreach($tab as $key=>$row)
    {
        if ($key == htmlspecialchars($_GET["key"]))
        {
            unset($tab[$key]);
        }
    }
    $str = serialize($tab);
    file_put_contents("data/commandes", $str);
    flock($fp, LOCK_UN);
}
if (file_exists("data/commandes"))
{
    $fp = fopen("data/commandes", "r+");
    flock($fp, LOCK_SH);
    $data = file_get_contents("data/commandes");
    $tab = unserialize($data);
    $i = 0;
    foreach($tab as $key=>$row)
    {
        $i++;
        echo "<br>".$row["user"]." a commandé :<br>";
        foreach($row["panier"] as $value)
            echo "- ".$value["qte"]." ".$value["nom_produit"]."s pour ".$value["prix_produit"]."€<br>";
        echo "<b>total: ".$row["total"]."€</b><br>";
        echo "<a href=current_command.php?key=".$key.">SUPPRIMER COMMANDE ?</a><br><br>";
    }
    flock($fp, LOCK_UN);
}
else
    echo "<h3>AUCUNE COMMANDE ENREGISTREE</h3>";
if ($i === 0)
    echo "<h3>AUCUNE COMMANDE ENREGISTREE</h3>";
?>