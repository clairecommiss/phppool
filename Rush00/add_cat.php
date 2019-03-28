<?php
session_start();
include("check_login.php");
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
clean_entry();
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
    foreach($tab as $value)
    {
        if ($value["cat"] == htmlspecialchars($_POST["name"]))
        {
            echo "<script>setTimeout(\"location.href = 'add_cat.php';\",1500);</script>";
            exit("La catégorie existe déjà\n");
        }

    }
    $name = htmlspecialchars($_POST["name"]);
    $tab[] = array("cat"=>$name);
    $str = serialize($tab);
    file_put_contents("data/categories", $str);
    flock($fp, LOCK_UN);
    echo "<script>setTimeout(\"location.href = 'add_cat.php';\",1500);</script>";
    exit("SUCCESSFULLY_ADDED\n");;
}
?>
<html>
    <body>
        <h1>AJOUTER UNE CATEGORIE</h1>
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
        <form action="add_cat.php" method="POST">
            Nom de la catégorie à ajouter: <input type="text" name="name" required><br>
            <input type="submit" name="submit" value="ok"><br>
        </form>
        <br><br>
        <a href="admin.php">RETOUR AU MENU ADMIN</a>
        </div>

    </body>
    </html>
