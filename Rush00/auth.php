<?php

function auth($login, $passwd)
{
    if (isset($login) && isset($passwd) && $login !== null && $passwd !== null && file_exists("data/users"))
    {
        $series = file_get_contents("data/users");
        $tab = unserialize($series);
        $pass = hash("whirlpool", $passwd);
        foreach ($tab as $key=>$row)
        {
            if ($row["login"] === $login && $row["passwd"] === $pass)
            {
                return(true);
                exit();
            }
        }  
    }
    return(false);
    exit();
}
?>