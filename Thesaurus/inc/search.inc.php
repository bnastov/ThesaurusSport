<br/>
<?php
 
	if(isset($_POST['mots_clef']))$te = $_POST['mots_clef'];
	if(isset($_GET['t']))$_SESSION['terme_choisi'] = $_GET['t'];	
	if(isset($_GET['c']))$_SESSION['concept_choisi'] = $_GET['c'];

	if(isset($_SESSION['terme_choisi']))
	{
		$te_choisi = $_SESSION['terme_choisi'];
		$terme = $cone->getTerme($te_choisi);
		if($terme==null)				echo "PROOOOOOOOOOOOBLEEEEEEEEEEEEEEMEEMEMEME";
		else 							$terme->dessiner();
		if (isset ($_SESSION['terme_choisi']))
		{
			unset ($_SESSION['terme_choisi']);
		} 
		$cone->closeCon();
	}
	else if(isset($_SESSION['concept_choisi']))
	{
		$cpt_choisi = $_SESSION['concept_choisi'];
		$concept = $cone->getConcept($cpt_choisi);
		if($concept==null)				echo "PROOOOOOOOOOOOBLEEEEEEEEEEEEEEMEEMEMEME";
		else 							$concept->dessiner();
		if (isset ($_SESSION['concept_choisi']))
		{
			unset ($_SESSION['concept_choisi']);
		} 
		$cone->closeCon();
	}
	else
	{
		$test = $cone->liste_recherche($te);
	}
	
	
?>
<br/><br/>
