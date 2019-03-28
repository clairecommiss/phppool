<?PHP
include("frame.php");

if (file_exists("./data/produits")){
$produits = file_get_contents("./data/produits");
$produits = unserialize($produits);
}

?>
<html>
	<link rel="stylesheet" href="stylesheet.css">
<div class="wrapper">
<?php
if ($produits){
foreach ($produits as $elem => $value)
{	echo "<div class=\"objets\"><a href=\"produit.php?prod=$value[name]\"><img src= \"$value[img]\">$value[name]</img></a></div> ";

}
}

?> 
</div>

</html>
