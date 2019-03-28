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
if (check_login() === "admin" && isset($_POST["name"]) && isset($_POST["submit"]) && $_POST["submit"] === "ok")
{
    $fp = fopen("data/produits", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/produits");
    $tab = unserialize($series);
    $duck = 1;
    foreach($tab as $key=>$row)
    {
        if ($row["name"] !== htmlspecialchars($_POST["name"]))
        {
            $tab2[] = $row;
        }
        else
            $duck = 2;
    }
    $str = serialize($tab2);
    file_put_contents("data/produits", $str);
    flock($fp, LOCK_UN);
    if ($duck === 2)
        echo("SUCCESSFULLY REMOVED<br><br>\n");
    else
        echo("PRODUCT NOT FOUND<br><br>\n");
    $prod = htmlspecialchars($_POST["name"]);
    $duck = 0;
    $fp = fopen("data/categories", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/categories", $str);
    $tab = unserialize($series);
    foreach($tab as $key=>$row)
    {
        foreach($row as $ind=>$item)
        {
            if ($item === $prod && $item !== $row["name"])
            {
                unset($tab[$key][$ind]);
                $duck = 2;
            }
        }
    }
    $str = serialize($tab);
    file_put_contents("data/categories", $str);
    flock($fp, LOCK_UN);
    echo "<script>setTimeout(\"location.href = 'del_product.php';\",1500);</script>";
    if ($duck === 2)
        exit("SUCCESSFULLY REMOVED FROM CATEGORY/IES\n");
    else
        exit("PRODUCT NOT FOUND IN ANY CATEGORY\n");
}
?>
</html>
    <h1>SUPPRIMER UN PRODUIT</h1>
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
        <form action="del_product.php" method="POST">
            Nom du produit à supprimer: <input type="text" name="name" required><br>
            <input type="submit" name="submit" value="ok"><br>
        </form>
        <br><br>
        <a href="admin.php">RETOUR AU MENU ADMIN</a>
    </div>
    </body>
    </html>