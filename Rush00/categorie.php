<?php
include("frame.php");

if(!$_GET[cat])
{
	echo "<br>Page non disponible";
	echo "<br /><a href=\"index.php\" class=\"button\" style=\"position:relative; top:10px; left: -10px \" > Retour a la page d'accueil </a>";
}


if ($_GET[cat])
{
$catprod = file_get_contents("data/categories");
$to_find_cat = unserialize($catprod);
foreach ($to_find_cat as $key)
{
	if ($key[cat] === $_GET[cat])
	{	
		foreach($key as $value)
		{
			if ($value !== $_GET[cat])
			$arrayprod[] = $value;
		}
	
	}
}
}
?>
<HTML>

<div class="wrapper">
	
<?php
if ($arrayprod){
foreach ($arrayprod as $elem)
{
	echo "<div class=\"objets\"><a href=\"produit.php?prod=$elem\"><img src=\"./data/images/$elem.jpg\"> $elem</a></div>";
}
}

?> 
</div>




</HTML>