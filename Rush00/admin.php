<?php
session_start();
include("check_login.php");
if (check_login() !== "admin")
    header("Location: index.php");
else {
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
    <h1>PANEL ADMINISTRATEUR</h1>
        <div>
            <iframe
                    id="current_command" name="current_command" src="current_command.php" 
                    scrolling="yes" frameboder="2"
                    style ="position: relative; height: 1000px; width: 500px; right: -150%; top: -100%"> 
            </iframe>
        </div>
    <body>
        <br><br><h2>CATEGORIES</h2>
        <br>
        <div>
        <a href="add_cat.php">Ajouter Catégories</a>
        <br>
        <a href="del_cat.php">Supprimer Catégories</a>
        <br>
        <a href="modif_cat.php">Modifier Catégories</a>
        <br>
        <h2>PRODUITS</h2>
        <br>
        <a href="add_product.php">Ajouter produit</a>
        <br>
        <a href="del_product.php">Supprimer produit</a>
        <br>
        <a href="modif_product.php">Modifier produit</a>
        <br>
        <h2>GESTION D'UTILISATEURS</h2>
        <br>
        <a href="add_user.php">Ajouter un utilisateur</a>
        <br>
        <a href="del_user.php">Supprimer un utilisateur</a>
        <br>
        <a href="modif_user.php">Editer les informations d'un utilisateur </a>
        <br>
        <br>
        <a class="index" href="index.php"> <b>Retour au site<b></a>
        <br>
        </div>
    </body>
    </html>
    <?php
}
?>