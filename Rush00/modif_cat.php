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
if (check_login() !== "admin")
{
    echo "Vous n'êtes pas adminstrateur désolé\n";
    exit();
}
else{
?>
<html>
        <h1> MODIFIER LES CATEGORIES</h1>
        <div>
            <iframe
                    id="current_categories" name="current_categories" src="current_categories.php" 
                    scrolling="yes" frameboder="2"
                    style ="position: relative; height: 1000px; width: 500px; right: -150%; top: -100%"> 
            </iframe>
        </div>
    <body>
    <div>
        <br>
        <br>
        <br>
        <br>
        <a href="add_cat_prod.php">Ajouter un produit à une catégorie</a>
        <br>
        <br>
        <br>
        <a href="del_cat_prod.php">Enlever un produit à une catégorie</a>
        <br>
        <br><br>
        <a href="admin.php">RETOUR AU MENU ADMIN</a>
    </div>
    </html>
    </body>
    <?php
}
?>