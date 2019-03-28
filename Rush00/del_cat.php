<?php
session_start();
include("check_login.php");
clean_entry();
?>

<!DOCTYPE html>
    <html>
        <head>
        <link rel="stylesheet" type="text/css" href="admin.css">
        <meta charset="utf-8" />
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
if (check_login() === "admin" && isset($_POST["name"]) && isset($_POST["submit"]) && $_POST["submit"] === "ok")
{
    $fp = fopen("data/categories", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/categories");
    $tab = unserialize($series);
    $name = htmlspecialchars($_POST["name"]);
    $duck = 1;
    foreach($tab as $row)
    {
        if ($row["cat"] !== $name)
        {
            $tab2[] = $row;
        }
        else
            $duck = 2;
    }
    $str = serialize($tab2);
    file_put_contents("data/categories", $str);
    flock($fp, LOCK_UN);
    echo "<script>setTimeout(\"location.href = 'del_cat.php';\",1500);</script>";
    if ($duck === 2)
        exit("SUCCESSFULLY REMOVED\n");
    else
        exit("CATEGORY NOT FOUND\n");
}
?>
<html>
    <h1>SUPPRIMER UNE CATEGORIE</h1>
    <div>
            <iframe
                    id="current_categories" name="current_categories" src="current_categories.php" 
                    scrolling="yes" frameboder="2"
                    style ="position: relative; height: 1000px; width: 500px; right: -150%; top: -100%"> 
            </iframe>
        </div>
    <div width= 250px>
    <body>
    <div>
        <br>
        <br>
        <br>
        <form action="del_cat.php" method="POST">
            Nom de la catégorie à supprimer: <input type="text" name="name" required><br>
            <input type="submit" name="submit" value="ok"><br>
        </form>
        <br>
        <a href="admin.php">RETOUR AU MENU ADMIN</a>
    </div>
    </body>
    </html>