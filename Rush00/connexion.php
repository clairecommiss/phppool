<?php

session_start();
include("auth.php");
include("check_login.php");
clean_entry();
if (!$_SESSION["loggued_on_user"] && isset($_POST) && $_POST["login"] !== null && $_POST["passwd"] !==  null && isset($_POST["login"]) && isset($_POST["passwd"]) && isset($_POST["submit"]))
{
    if (auth(htmlspecialchars($_POST["login"]), htmlspecialchars($_POST["passwd"])))
    {
        $_SESSION["loggued_on_user"] = htmlspecialchars($_POST["login"]);
        $result = "ok";
        header("Location:index.php?value=$result");
        echo $_SESSION["loggued_on_user"];
    }
    else
    {
        $_SESSION["loggued_on_user"] = "";
        $result = "ko";
        header("Location:index.php?value=$result");
    }
   
}

?>
