<?php
	
	if(!isset($_POST['cptsS']))
	{
?>
		<form method="post" action="index.php?page=supprimerC">
			<br />
			<FIELDSET>
			<LEGEND> Supprimer un Concept </LEGEND><br /><br />
				Le Concept &agrave; supprimer	<select name="cptsS"><?php echo $conceptList;?> </select>
				<input type="submit" value="Suprimer"/>
				<input type="button" value="Annuler" onclick="javascript:location.href='index.php'"/>
				<br /><br />
			</FIELDSET>
		</form>
<?php
	}
	else
	{
		$sc=$_POST['cptsS'];
		// le code pour supprimer concept
		echo $sc."<br/>";
		$cone->supprimeConcept($sc);
	}
?>