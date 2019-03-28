<?PHP
session_start();
include ("check_login.php");
if (file_exists("./data/categories")){
$cat = file_get_contents("./data/categories");
$cat = unserialize($cat);
}
?>
<html>
<link rel="stylesheet" href="stylesheet.css">
<link href="https://fonts.googleapis.com/css?family=Just+Another+Hand" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Thasadith" rel="stylesheet">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<title>Site</title>
</head>
<body>
<h1><a href=index.php><b style="color:white;
      1px 0 black, 0 -1px black; margin:100px; margin-bottom:10px; line-height:250px; letter-spacing: 0.1em ">Bobios épicerie </b></a></h1>

<div class="colonneidleft">
<?php
if ($_SESSION[loggued_on_user])
{	echo "<div style=\"margin: 20px; font-family: 'Just Another Hand', cursive; font-size:70px\"> Bonjour, $_SESSION[loggued_on_user] ! </div>";
	echo "<div style=\"margin: 20px; font-size:20px\"> Ravis de vous retrouver :) Bonnes courses chez Bobios ! </div>";
}

if (!$_SESSION[loggued_on_user])
{
	echo "
	<form method=\"post\" action=\"connexion.php\" style=\"margin: 20px\" >
		<b>Déjà client ?</b><br /><br />
 		<span> Identifiant :  <input type=\"text\" name=\"login\" /></span>
	
		<span style=\"position:relative ; top:22px\"> Mot de passe : <input type=\"password\" name=\"passwd\"/></span>
		<input type=\"submit\" name=\"submit\" value=\"Je me connecte\" />
	</form>";

	if ($_GET[value] === "ko")
		echo "<div style=\"color:red;margin:20px\"> Mauvaise combinaison.</div>";


echo "<form method=\"post\" action=\"creation.php\" style=\"margin: 20px\">
	<b>Pas encore client ? <br>
	Inscrivez-vous! </b><br /><br />
 	Identifiant: <input type=\"text\" name=\"login\" required/>
	<br />
	<span style=\"position:relative ; top:22px\"> 
	Adresse mail : <input type=\"text\" name=\"mail\" required/>
	<br /><br>
	<span style=\"position:relative\"> 
	Mot de passe: <input type=\"password\" name=\"passwd\" required/><br/>
	<input type=\"submit\" name=\"submit\" value=\"Je m'inscris\"/></form><br /><br /><br />";

	 	if ($_GET[value] === "mailissue")
			echo "<div style=\"color:red;margin:20px\"> Mail déja utilisé.</div>";
		if ($_GET[value] === "loginissue")
			echo "<div style=\"color:red;margin:20px\"> Login déja utilisé </div>";
}
?>

<a href="panier.php"><img src="./imagesdebase/panier.png" style="width:60px; position:relative; top:10px"><span style="margin:10px">Accéder à mon panier</a>

<?php
if ($_SESSION[panier]){
	foreach ($_SESSION[panier] as $key => $elem)
	{
		$total_nb_prod = $total_nb_prod + ($elem[qte]);
		$prix_total = $prix_total + ($elem[prix_produit]);
	}
	echo "<br/><div style=\"margin-left:24px;margin-top:10px; line-height:30px; font-family: 'Just Another Hand', cursive; font-size:30px; letter-spacing:0px\">$total_nb_prod <br/></div>";
	echo "<div style=\"margin:18px\"> Prix total : $prix_total €</div>";
}
else {
	echo "<br/><div style=\"margin-left:20px;line-height:30px; font-size:20px; letter-spacing:-3px\">0<br/></div>";
	echo "<div style=\"margin:18px\"> Prix total : 0 € </div>";
}
?>

<br/>
<br/>
<?php 
if ($_SESSION[loggued_on_user]) 
{
?>
<html>
<form method="post" action="logout.php">
	<input type="submit" name="logout" value="Se deconnecter"/>
</form>

<?php 

if (check_login() !== "admin")
{ 
?>
<form method="post" action="logout.php">
	<input type="submit" name="remove" value="Supprimer mon compte"/>
</form>
<?php
}
}
if (check_login() === "admin") 
	echo "<a class=\"button\" href=admin.php style=\"background-color:white\"=> Aller sur la page admin </a>";
?>
</div>
<?php
if (file_exists("./data/categories"))
{
foreach ($cat as $key)
	echo "<li class=\"cat\"><a href=\"categorie.php?cat=$key[cat]\"> $key[cat]</a></li>";
}
?> 

<br />
</body>
</html>