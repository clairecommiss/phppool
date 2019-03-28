<?php
session_start();
function check_login()
{
    if(file_exists("data/users") && isset($_SESSION["loggued_on_user"]) && $_SESSION["loggued_on_user"] !== null)
    {
        $series = file_get_contents("data/users");
        $tab = unserialize($series);
        $pass = hash("whirlpool", $passwd);
        foreach ($tab as $key=>$row)
        {
            if ($row["login"] === htmlspecialchars($_SESSION["loggued_on_user"]) && $row["statut"] === "admin")
            {
                return("admin");
            }
        }
        return($_SESSION["loggued_on_user"]);
    }
    return(false);
    exit();
}

function clean_entry()
{
    $array = array('é'=>'e', 'û'=>'u', 'è'=>'e', 'ê'=>'e', 'ë'=>'e', 'î'=>'i', 'ï'=>'i', 'à' => 'a', 'â' => 'a', 'ä' => 'a');
    if (isset($_POST))
    {
        foreach ($_POST as $key=>$value)
        {
            if ($key !== "img" && $key !== "url" && $key !=="passwd")
            {
            $_POST[$key] = strtr(htmlspecialchars($_POST[$key]), $array);
            $_POST[$key] = strtolower($_POST[$key]);
            }
        }
    }
    if (isset($_GET))
    {
        foreach ($_GET as $key=>$value)
        {
            if ($key !== "img" && $key !== "url" && $key !=="passwd")
            {
                $_GET[$key] = strtr(htmlspecialchars($_GET[$key]), $array);
                $_GET[$key] = strtolower($_GET[$key]);
            }
        }
    }
}
?>