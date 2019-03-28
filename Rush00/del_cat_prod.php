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
<?
clean_entry();
if (check_login() !== "admin")
{
    echo "Vous n'êtes pas adminstrateur désolé\n";
    exit();
}
if (check_login() === "admin" && isset($_POST["prod"]) && isset($_POST["name"]) && isset($_POST["submit"]) && $_POST["submit"] === "ok")
{
    $name = htmlspecialchars($_POST["name"]);
    $prod = htmlspecialchars($_POST["prod"]);
    $duck = 0;
    $fp = fopen("data/categories", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/categories");
    $tab = unserialize($series);
    foreach($tab as $key=>$row)
    {
        if ($row["cat"]===$name)
        {
            foreach($row as $ind=>$item)
            {
                if ($ind !== $name && $item == $prod)
                {
                    unset($tab[$key][$ind]);
                    $duck = 2;
                }
            }
        }
    }
    $str = serialize($tab);
    file_put_contents("data/categories", $str);
    flock($fp, LOCK_UN);
    echo "<script>setTimeout(\"location.href = 'del_cat_prod.php';\",1500);</script>";
    if ($duck === 2)
        exit("SUCCESSFULLY REMOVED\n");
    else
        exit("PRODUCT OR CATEGORY NOT FOUND\n");
}
?>
<html>
     <h1>ENLEVER UN PRODUIT D'UNE CATEGORIE</h1>
     <br>
     <br>
     <br>
            <div>
            <iframe
                    id="current_categories" name="current_categories" src="current_categories.php" 
                    scrolling="yes" frameboder="2"
                    style ="position: relative; height: 1000px; width: 500px; right: -150%; top: -100%"> 
            </iframe>
            </div>
    <body>
        <div>
        <form action="del_cat_prod.php" method="POST">
            Nom du produit: <input type="text" name="prod" required><br>
            Categorie: <input type="text" name="name" required><br>
            <input type="submit" name="submit" value="ok"><br>
        </form>
        <br><br>
        <a href="admin.php">RETOUR AU MENU ADMIN</a>
        </div>
    </body>
    </html>
