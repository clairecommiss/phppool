<?php
session_start();
include("check_login.php");
?>
<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="admin.css">
    <meta charset="utf-8" />
    </head>
</html>
<?php
clean_entry();
if (check_login() !== "admin")
{
    echo "Vous n'êtes pas adminstrateur désolé\n";
    exit();
}
if (check_login() === "admin" && $_POST["submit"] === "ok" && (isset($_POST["prix"]) || isset($_POST["img"]) || isset($_POST["prod"])))
{
    $fp = fopen("data/produits", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/produits");
    $tab = unserialize($series);
    $prod = htmlspecialchars($_GET["name"]);
    if (isset($_POST["prod"]) && $_POST["prod"] !== "" && $_POST["prod"] !== null)
    {
         $n_prod = htmlspecialchars($_POST["prod"]);
         foreach($tab as $row)
         {
             if ($row["name"] === $n_prod)
             {
                echo "<script>setTimeout(\"location.href = 'edit_product.php?name=".$prod."';\",1500);</script>";
                exit("Ce nom est déjà pris\n");
             }
         }
    }
    else 
        $n_prod = $prod;
    if (isset($_POST["prix"]) && $_POST["prix"] !== "" && $_POST["prix"] !== null)
    {
        $n_prix = htmlspecialchars($_POST["prix"]);
        if (!is_numeric($n_prix))
        {
            echo "<script>setTimeout(\"location.href = 'edit_product.php?name=".$prod."';\",1500);</script>";
            exit("Entrez un prix valide\n");
        }
    }
    if (isset($_POST["img"]) && $_POST["img"] !== "" && $_POST["img"] !== null)
    {
        $n_img = htmlspecialchars($_POST["img"]);
        if(!@file_put_contents("data/images/".$test666.".jpg", @file_get_contents($n_img)) || (!preg_match ("/.*.jpg$/", $n_img)))
        {
            echo "<script>setTimeout(\"location.href = 'edit_product.php?name=".$prod."';\",1500);</script>";
            exit("URL_NON_VALIDE\n");
        }
    }
    foreach($tab as $key=>$row)
    {
        if ($row["name"] === $prod)
        {
            if (isset($n_prod) && $n_prod !== "" && $n_prod !== null)
                $tab[$key]["name"] = $n_prod; 
            if (isset($n_prix) && $n_prix!== "" && $n_prix !== null)
                $tab[$key]["prix"] = $n_prix; 
            if (isset($n_img) && $n_img !== "" && $n_img !== null && isset($_POST["img"]) && $_POST["img"] !== "" && $_POST["img"] !== null)
            {
                $back = $row["img"];
                if (!file_put_contents("data/images/".$n_prod.".jpg", file_get_contents($n_img)))
                {
                    flock($fp, LOCK_UN);
                    print_r($tab);
                    echo "<script>setTimeout(\"location.href = 'edit_product.php?name=".$prod."';\",1500);</script>";
                    exit("URL_NON_VALIDE\n");
                }
                else
                { 
                     if (isset($n_prod) && $n_prod !== "" && $n_prod !== null)
                        $tab[$key]["img"] = "data/images/".$n_prod.".jpg";
                }
            }
            $n_img =  $tab[$key]["img"];
            $n_prod = $tab[$key]["name"];
            $n_prix = $tab[$key]["prix"];
        }
    }
    $str = serialize($tab);
    file_put_contents("data/produits", $str);
    flock($fp, LOCK_UN);
    $fp = fopen("data/categories", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/categories");
    $tab = unserialize($series);
    foreach($tab as $key=>$row)
    {
        foreach($row as $ind=>$obj)
        {
            if ($obj === $prod)
            {
                $tab[$key][$ind] = $n_prod;
            }
        }
    }
    flock($fp, LOCK_UN);
    echo "<h1>".$n_prod."</h1><br>";
    echo "<div><img src =".$n_img." width=100px height=100px></div><br>";
    echo "<h1>Prix :".$n_prix."</h1><br>";
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
            <link rel="stylesheet" type="text/css" href="admin.css">
        </head>
    <body>
        <br>
        <br>
        <h1>QUE VOULEZ VOUS MODIFIER ?</h1>
        <form action="edit_product.php?name=<?php echo $n_prod; ?>" method="POST">
            Le nom du produit (entrez le nouveau nom): <input type="text" name="prod"><br>
            Le prix du produit (entrez le nouveau prix): <input type="text" name="prix"><br>
            L'image du produit (entrez la nouvelle url en .jpg uniquement): <input type="text" name="img"><br>
            <input type="submit" name="submit" value="ok"><br>
        </form>
    </body>
    <a href="admin.php">RETOUR AU MENU ADMIN</a>
    </html>
    <?php
    exit();
}
?>
<?php
if (check_login() === "admin" && isset($_GET["name"]))
{
    $prod = htmlspecialchars($_GET["name"]);
    $fp = fopen("data/produits", "r+");
    flock($fp, LOCK_SH);
    $series = file_get_contents("data/produits");
    $tab = unserialize($series);
    foreach($tab as $key=>$row)
    {
        if ($row["name"] === $prod)
        {
            $prix = $row["prix"];
            $img = $row["img"];
        }
    }
    flock($fp, LOCK_UN);
    echo "<h1>".$prod."</h1><br>";
    echo "<div><img src =".$img." width=100px height=100px></div><br>";
    echo "<h1>Prix :".$prix."</h1><br>";
   ?>
   <html>
    <body>
        <br>
        <br>
        <br>
        <h1>QUE VOULEZ VOUS MODIFIER ?</h1>
        <form action="edit_product.php?name=<?php echo $prod; ?>" method="POST">
            Le nom du produit (entrez le nouveau nom): <input type="text" name="prod"><br>
            Le prix du produit (entrez le nouveau prix): <input type="text" name="prix"><br>
            L'image (entrez la nouvelle url en .jpg uniquement): <input type="text" name="img"><br>
            <input type="submit" name="submit" value="ok"><br>
        </form>
        <a href="admin.php">RETOUR AU MENU ADMIN</a>
    </body>
    </html>
    <?php
}
?>
