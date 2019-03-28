<?php
session_start();
include("check_login.php");
?>
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
        <body>
<?php
clean_entry();
if (check_login() !== "admin")
{
    echo "Vous n'êtes pas adminstrateur désolé\n";
    exit();
}
if (check_login() === "admin" && isset($_POST["prod"]) && isset($_POST["name"]) && isset($_POST["submit"]) && $_POST["submit"] === "ok")
{
    $duck = 0;
    $name = htmlspecialchars($_POST["name"]);
    $prod = htmlspecialchars($_POST["prod"]);
    $fp = fopen("data/produits", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/produits");
    $tab = unserialize($series);
    foreach($tab as $row)
    {
        if ($row["name"]===$prod)
        {
            $duck=1;
        }
    }
    if ($duck === 0)
    {
        flock($fp, LOCK_UN);
        echo "<script>setTimeout(\"location.href = 'add_cat_prod.php';\",1500);</script>";
        exit("PRODUCT NOT FOUND\n");
    }
    flock($fp, LOCK_UN);
    $fp = fopen("data/categories", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/categories");
    $tab = unserialize($series);
    foreach($tab as $key=>$row)
    {
        if ($row["cat"]===$name)
        {
            foreach($row as $value)
            {
                if ($value == $prod)
                {
                    echo "<script>setTimeout(\"location.href = 'add_cat_prod.php';\",1500);</script>";
                    exit ("Ce produit est déjà dans la catégorie\n");
                }

            }
            $tab[$key][] = $prod;
            $duck=2;
        }
    }
    $str = serialize($tab);
    file_put_contents("data/categories", $str);
    flock($fp, LOCK_UN);
    if ($duck === 2)
    {
        echo "<script>setTimeout(\"location.href = 'add_cat_prod.php';\",1500);</script>";
        exit("SUCCESSFULLY ADDED\n");
    }
    echo "<script>setTimeout(\"location.href = 'add_cat_prod.php';\",1500);</script>";
    exit ("Cette catégorie n'existe pas\n");
}
?>
</body>
        <h1>AJOUTER UN PRODUIT A UNE CATEGORIE</h1>
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
        <form action="add_cat_prod.php" method="POST">
            Nom du produit: <input type="text" name="prod" required><br>
            Categorie: <input type="text" name="name" required><br>
            <input type="submit" name="submit" value="ok"><br>
        </form>
        <br>
        <br>
        <a href="admin.php">RETOUR AU MENU ADMIN</a>
        </div>
    </body>
    </html>
