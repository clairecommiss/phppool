<?php

if (!$_POST[remove]){
session_start();
session_destroy();
header("Location: index.php");
include("frame.php");
}
else 
	{
		include("frame.php");
		$users = file_get_contents("./data/users");
		$users = unserialize($users);
		foreach ($users as $key => $value)
		{	
			if ($value[login]=== $_SESSION[loggued_on_user]){
				unset($users[$key]);
				unset($_SESSION[loggued_on_user]);
				echo "<br />Votre compte a été supprimé. Revenez-vite !";
				echo "<script>setTimeout(\"location.href = 'logout.php';\", 100);</script>";
				echo "<br /><br/><br /><a class=\"button\" href=\"index.php\" style=\"position:relative; margin-top:15px; margin-left:15px\"> Retour a la page d'accueil </a>";
			}
		}
		
		$file = serialize($users);
		file_put_contents("./data/users", $file);
	}

?>