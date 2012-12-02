<?php
	include("classes/AfficheTerme.php");
	include("classes/AfficheConcept.php");
	include("classes/Connexion.php");
	
	$cone = new Connexion('system','rabah123');
	
	include("Jsfiles/genererSelect.php");
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="fr" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Thesaurus Sport</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="la description de votre site">
<meta name="keywords" content="vos mots-clés">
<meta name="author" content="nom de l'auteur">
<meta name="Robots" content="indexation par les robots">
<meta name="Identifier-URL" content="url du site">
<meta name="Revisit-after" content="10 days">

<link rel="stylesheet" href="CSS/afficheterme.css" />
<link rel="stylesheet" href="CSS/style.css" />

<script src="Jsfiles/insertTerme.js"></script>

</head>
<body>

<table border="0" align="center" cellpadding="0" cellspacing="0" width="1000" background="images/header.jpg">
	<tr height="185">
		<td><img src="images/sport.gif" border="0" width="160" height="160" hspace="100"></td>
	</tr>
</table>

<!-- ---------------------------- partie du milieu (corps) 2 cellules sur la largeur ---------------------------- -->
<table border="0" align="center" cellpadding="0" cellspacing="0" width="1000">
	<col width="178">	<col width="822">
	<tr>
		<td background="images/gauche.gif" valign="top">
		<!-- -------------- menu --------------- -->
		<?php include ("inc/menu.inc.php");	?></td>


		<td background="images/droit.gif" valign="top">
		<!-- -------------- contenu --------------- -->
		<div id="contenu">
			<form method="post" action="index.php">
				<label for="recherche">Recherche par mot-clef &nbsp;</label>
				<input type="text" name="mots_clef" id="mots_clef" class="QInput" tabindex="1" />
				<input type="submit" value="Rechercher !"/>
			</form>
			<hr color="gray" />			
			<?php 
				if(isset($_GET['terme_choisi'])) // SI on a choisi un terme
				{	
					$cone->StatTerme($_GET['terme_choisi']);
					$_SESSION['terme_choisi'] = $_GET['terme_choisi'];
					include("inc/search.inc.php");
				}
				else if(isset($_POST['mots_clef']))	// Si on a effectue une recherche
				{
					$cone->StatRech($_POST['mots_clef']);
					include("inc/search.inc.php");
				}
				else if(!empty($_GET['page'])) // Si la variable page dans l'url (index.php?page=contact) n'est pas vide
				{
					$lien = 'inc/'.$_GET['page'].'.inc.php';   //on met dans lien  le chemin du dossier où se trouve le fichier contact.inc.php (.inc.php c'est pr montrer qu'on l'inclus on est pas obligé de mettre le .inc juste une sécurité de plus, on mettra tout nos fichiers à inclure dans un dossier "inc" à la racine , changé si vous voulez..
					if (file_exists($lien))  // fonction qui vérifie si le ficher existe
					{
						   include($lien);  // si oui on inclut le fichier 
					}
					else
					{
						include("inc/erreur.inc.php"); // sinon on met une page d'erreur ou alors la page d'acceuil si on a la fleme de faire une page d'erreur
					}
				}
				else   // si $_GET['page'] est vide ou inexistant on inclut la page d'accueil 
				{
					include("inc/accueil.inc.php");
				} 
			?>
			<hr color="gray" />
		</div>
		</td>
	</tr>
</table>

<!-- ---------------------------- partie basse (footer) 1 cellule sur toute la largeur ---------------------------- -->
<table border="0" align="center" cellpadding="0" cellspacing="0" width="1000" background="images/footer.jpg">
	<tr>
		<td height="60">
			<!-- -------------- pied de page --------------- -->
			<?php include ("inc/pied-de-page.inc.php");	?>
		</td>
	</tr>
</table>
	
</body>
</html>