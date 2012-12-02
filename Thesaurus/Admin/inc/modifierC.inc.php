			<FIELDSET>
			<LEGEND> Modifier un Concept </LEGEND><br /><br />


<?php
	
	if(!isset($_POST['cptsM']) && !isset($_POST['valide']))
	{
?>
		<form method="post" action="index.php?page=modifierC">
			<br />
				Le Concept &agrave; modifier	<select name="cptsM"><?php echo $conceptList;?> </select>
				<input type="submit" value="Modifier"/>
				<input type="button" value="Annuler" onclick="javascript:location.href='index.php'"/>
				<br /><br />
		</form>
<?php
	}

	else if(!isset($_POST['valide']))
	{
		$mc=$_POST['cptsM'];
		
		// le code pour modifier concept
?>
	<center>
	<form method="post" action="index.php?page=modifierC">
	<input name="nom" type="hidden" value="<?php echo $mc;?>">
	<input name="valide" type="hidden" value="<?php echo $mc;?>">
		<table style="width: 50%">
			<tr>
				<td >Nom</td>
				<td ><input name="lib" type="text" value='<?php echo $mc;?>' DISABLED></td>
			</tr>
			<tr>
				<td >Terme Vedette</td>
				<td ><select name="TV"><?php echo $cone->selectedOptionT($mc);?> </select></td>
			</tr>
			
			<tr>
				<td >le Concept Generique</td>
				<td ><select name="CG"><?php echo $cone->selectedOptionC($mc);?> </select></td>
			</tr>
			<tr align=center">
				<div	id='NBR'>
					<input id="nbTS"	type="hidden" 	name="nbTS"	value="0"/>
					<input id="nbTA"	type="hidden"	name="nbTA"	value="0"/>
					<input id="nbC"		type="hidden"	name="nbC"	value="0"/>
				</div>
				<td> <input type="submit"	value="Modifier le Concept"/></td>
				<td><input type="button" value="Annuler" onclick="javascript:location.href='index.php'"/></td>
			</tr>
		</table>
	</form>
	<strong> Notice important :</strong> pour modifier les Concepts spécifiques, il est de preference de modifier le <br/>
    Concept Generique de ces concepts   	

	</center>
<?php
	}
	else
	{
		
		$nom	=	$_POST['nom'];
		$tv		=	$_POST['TV'];
		$cg		=	$_POST['CG'];
		
		echo "Concpet : ".$nom."<br/>Concepet generique : ".$cg."<br/>Terme vedette : ".$tv."<br/>";
		
		if($cg=='vide') $cg='null'; 	
		
		$cone->modifieConcept($nom,$tv,$cg);
		
		
		
		
		
	}
?>

</FIELDSET>
