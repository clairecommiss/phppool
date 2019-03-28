<?php
include("check_login.php");
clean_entry();
if (!file_exists("data"))
{
    mkdir("data");
}
    if (!file_exists("data/categories"))
    {
        $tab[] = array("cat"=>"legumes","courgette", "aubergine");
        $tab[] = array("cat"=>"fruits","banane", "peche");
        $tab[] = array("cat"=>"epiceries","riz", "pates");
        $str = serialize($tab);
        file_put_contents("data/categories", $str);
    }
    if (!file_exists("data/produits"))
    {
        if (!file_exists("data/images"))
        {
            mkdir("data/images");
        }
        file_put_contents("data/images/"."courgette.jpg", file_get_contents("https://www.lesfruitsetlegumesfrais.com/_upload/cache/ressources/produits/courgette/courgette_346_346_filled.jpg"));
        file_put_contents("data/images/"."banane.jpg", file_get_contents("https://img-3.journaldesfemmes.fr/dZMGY3kjaLpXk883IjnEf7BOZlc=/910x607/smart/d47b1bd18da64f2a94a7ee7286be5ee9/ccmcms-jdf/10662309.jpg"));
        file_put_contents("data/images/"."aubergine.jpg", file_get_contents("https://upload.wikimedia.org/wikipedia/commons/thumb/f/fb/Aubergine.jpg/200px-Aubergine.jpg"));
        file_put_contents("data/images/"."peche.jpg", file_get_contents("https://www.atelierdeschefs.com/media/techniques-e476-comment-monder-une-peche.jpg"));
        file_put_contents("data/images/"."riz.jpg", file_get_contents("https://previews.123rf.com/images/jamakosy/jamakosy1711/jamakosy171100210/90375945-riz-blanc-en-sac-sac-de-jute-isol%C3%A9-sur-fond-blanc.jpg"));
        file_put_contents("data/images/"."pates.jpg", file_get_contents("https://i2.cdscdn.com/pdt2/6/7/8/1/700x700/bari012678/rw/barilla-penne-rigate-500g.jpg"));
        $tab2[] = array("name"=>"courgette", "prix"=>"0.30", "img"=>"data/images/courgette.jpg");
        $tab2[] = array("name"=>"banane", "prix"=>"0.40", "img"=>"data/images/banane.jpg");
        $tab2[] = array("name"=>"aubergine", "prix"=>"0.10", "img"=>"data/images/aubergine.jpg");
        $tab2[] = array("name"=>"peche", "prix"=>"0.30", "img"=>"data/images/peche.jpg");
        $tab2[] = array("name"=>"riz", "prix"=>"2.00", "img"=>"data/images/riz.jpg");
        $tab2[] = array("name"=>"pates", "prix"=>"1.80", "img"=>"data/images/pates.jpg");
        $str = serialize($tab2);
        file_put_contents("data/produits", $str);
    }
if (!file_exists("data/users") && isset($_POST) && isset($_POST["login"]) && isset($_POST["passwd"]) && isset($_POST["submit"]))
{
    $zou = hash("whirlpool", htmlspecialchars($_POST["passwd"]));
    $tab3[] = array("login"=>htmlspecialchars($_POST["login"]), "passwd"=>$zou, "mail"=>"admin@admin.ru", "statut"=>"admin");
    $str = serialize($tab3);
    file_put_contents("data/users", $str);
    header("location: index.php");
}
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8" />
        </head>
    <body>
        <form action="install.php" method="post">
            Identifiant admin: <input type="text" name="login"><br>
            Mot de passe admin: <input type="password" name="passwd"><br>
            <input type="submit" name="submit" value="ok">
        </form>
    </body>
    </html>

