<?php
session_start();
include("check_login.php");
clean_entry();
if (isset($_POST["login"]) && isset($_POST["passwd"]) && isset($_POST["submit"]) && isset($_POST["mail"]))
{   
    $fp = fopen("data/users", "r+");
    flock($fp, LOCK_EX);
    $series = file_get_contents("data/users");
    $tab = unserialize($series);
    foreach ($tab as $row)
    {
        foreach ($row as $key=>$value)
        {
            if ($key === "login" && $value === htmlspecialchars($_POST["login"]))
            {
                header("Location:index.php?value=loginissue");
                return;
            }
            if ($key === "mail" && $value === htmlspecialchars($_POST["mail"]))
            {
                header("Location:index.php?value=mailissue");
                return;
            }
        }
    }
    $data = hash("whirlpool", htmlspecialchars($_POST["passwd"]));
    $tab[] = array("login"=>htmlspecialchars($_POST["login"]), "passwd"=>$data, "mail"=>htmlspecialchars($_POST["mail"]), "statut"=>"user");
    $base = serialize($tab);
    file_put_contents('data/users', $base);
    flock($fp, LOCK_UN);
    header("Location:index.php?");
}
?>
