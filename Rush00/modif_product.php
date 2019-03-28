<?php
session_start();
include("check_login.php");
clean_entry();
if (check_login() !== "admin")
{
    echo "Vous n'êtes pas adminstrateur désolé\n";
    exit();
}
if (check_login() === "admin" && isset($_POST["prod"]) && isset($_POST["submit"]) && $_POST["submit"] === "ok")
{
    $prod = htmlspecialchars($_POST["prod"]);
    $duck = 0;
    $fp = fopen("data/categories", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/produits");
    $tab = unserialize($series);
    foreach($tab as $key=>$row)
    {
        if ($row["name"] === $prod)
        {
            flock($fp, LOCK_UN);
            header("location: edit_product.php?name=".$prod);
            exit("found");
        }
    }
    flock($fp, LOCK_UN);
    echo "<script>setTimeout(\"location.href = 'modif_product.php';\",1500);</script>";
    exit("PRODUCT NOT FOUND\n");
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
        <h1>QUEL PRODUIT VOULEZ VOUS MODIFIER ?</h1>
        <br>
        <br>
        <div>
            <iframe
                    id="current_products" name="current_products" src="current_products.php" 
                    scrolling="yes" frameborder="2"
                    style ="position: relative; height: 1000px; width: 500px; right: -150%; top: -100%"> 
            </iframe>
        </div>
    <body>
        <div>
            <br>
            <br>
            <br>
        <form action="modif_product.php" method="POST">
            Nom du produit: <input type="text" name="prod" required><br>
            <input type="submit" name="submit" value="ok"><br>
        </form>
        <br><br>
        <a href="admin.php">RETOUR AU MENU ADMIN</a>
        </div>
    </body>
    </html>
