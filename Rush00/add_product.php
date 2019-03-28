<?php
session_start();
include("check_login.php");
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
        </html>
    <?php
clean_entry();
if (check_login() !== "admin")
{
    echo "Vous n'êtes pas adminstrateur désolé\n";
    exit();
}
if (check_login() === "admin" && isset($_POST["name"]) && isset($_POST["prix"]) && isset($_POST["img"]) && isset($_POST["submit"]) && $_POST["submit"] === "ok")
{
    $fp = fopen("data/produits", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/produits");
    $tab = unserialize($series);
    $name = htmlspecialchars($_POST["name"]);
    $prix = htmlspecialchars($_POST["prix"]);
    $url = htmlspecialchars($_POST["img"]);
    if (!is_numeric($prix))
    {
        echo "<script>setTimeout(\"location.href = 'add_product.php';\",1500);</script>";
        exit("Entrez un prix valide\n");
    }
    foreach($tab as $value)
    {
        if ($value["name"] === $name)
        {
            echo "<script>setTimeout(\"location.href = 'add_product.php';\",1500);</script>";
            exit("Nom déjà pris\n");
        } 
    }
    if (!@file_put_contents("data/images/".$name.".jpg", @file_get_contents($url)) || (!preg_match ("/.*.jpg$/", $url)))
    {
        flock($fp, LOCK_UN);
        echo "<script>setTimeout(\"location.href = 'add_product.php';\",1500);</script>";
        exit("URL_NON_VALIDE\n");
    }
    $tab[] = array("name"=>$name, "prix"=>$prix, "img"=>"data/images/".$name.".jpg");
    $str = serialize($tab);
    file_put_contents("data/produits", $str);
    flock($fp, LOCK_UN);
    echo "<script>setTimeout(\"location.href = 'add_product.php';\",1500);</script>";
    exit("PRODUCT_ADDED_SUCCESSFULLY\n");
}

?>
<html>
    <h1>AJOUTER UN PRODUIT</h1>
    <div>
            <iframe
                    id="current_products" name="current_products" src="current_products.php" 
                    scrolling="yes" frameboder="2"
                    style ="position: relative; height: 1000px; width: 500px; right: -150%; top: -100%"> 
            </iframe>
        </div>
    <body>
    <div>
        <br>
        <br>
        <br>
        <form action="add_product.php" method="POST">
            Nom du produit à ajouter: <input type="text" name="name" required><br>
            Prix: <input type="text" name="prix" required><br>
            Url de l'image (.jpg): <input type="text" name="img" required><br>
            <input type="submit" name="submit" value="ok"><br>
        </form>
        <br><br>
        <a href="admin.php">RETOUR AU MENU ADMIN</a>
    </div>
    </body>
    </html>