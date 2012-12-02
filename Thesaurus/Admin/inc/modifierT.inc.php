<br />
<FIELDSET>
<LEGEND> Modifier un Terme </LEGEND><br /><br />

<?php	
	$nbTS=0;
	$nbTA=0;
	$nbCs=0;
	if(!isset($_POST['termS']) && !isset($_POST['libelle']))
	{
	
?>
	
	<form method="post" action="">
			Le Terme &agrave; modifier	<select name="termS"><?php echo $termeList;?> </select>
			<input type="submit" value="Modfier"/>
			<input type="button" value="Annuler" onclick="javascript:location.href='index.php'"/>
			<br /><br />
	</form>
	

<?php
	}
	else if(!isset($_POST['desc']))
	{
	
		$ss=$_POST['termS'];
?>
	<center>
	<form method="post" action="">
	<input type="hidden" name="libelle" value="<?php echo $ss ?>" />
	
	
		<table style="width: 50%">
			<tr>
				<td >Libelle</td>
				<td ><input name="lib" type="text" value='<?php echo $ss;?>' DISABLED></td>
			</tr>
			<tr>
				<td >Description</td>
				<td ><textarea name="desc" type="text"><?php echo $cone->getDescription($ss);?></textarea></td>
			</tr>
			<tr>
				<td >le Terme Generique&nbsp;</td>
				<td ><select name="TG"><?php echo $cone->selectedOption($ss);?> </select></td>
			</tr>
			<tr>
				<td >Terme Specifique</td>
				<td ><fieldset width="100%"><legend><input type="button"  onclick="ajouteTerme(1);" value="+"/></legend>
						<div id='TS'>
						<?php echo $cone->genreTermes($ss,'ts');?>
					</div></fieldset></td>
			</tr>
			<tr>
				<td >Terme Associee</td>			
				<td ><fieldset><legend><input type="button"  onclick="ajouteTerme(2);" value="+"/></legend>
						<div id='TA'>
						<?php echo $cone->genreTermes($ss,'ta');?>
					</div></fieldset></td>
			</tr>
			<tr>
				<td >Concept</td>
				<td ><fieldset><legend><input type="button"  onclick="ajouteConcept();" value="+"/></legend>
				<div id='C'>
						<?php echo $cone->genreConcepts($ss);?>
					</div></td>
			</tr>
			<tr align=center">
				<div	id='NBR'>
					<input id="nbTS"	type="hidden" 	name="nbTS"	value="0"/>
					<input id="nbTA"	type="hidden"	name="nbTA"	value="0"/>
					<input id="nbC"		type="hidden"	name="nbC"	value="0"/>
				</div>
				<td> <input type="submit"	value="Modifier le terme"/></td>
				<td><input type="button" value="Annuler" onclick="javascript:location.href='index.php'"/></td>
			</tr>
		</table>
	</form>
	<strong> Notice important :</strong> éviter de modifier les terme spécifique  parce qu'il est de preference de modifier le <br/>
    Generique de ces termes a cause de complexité de thesaurus  	

	</center>
<?php
	}
	else 
	{
		$terme	=	htmlentities($_POST['libelle']);
		$desc	=	$_POST['desc'];
		$tg		=	$_POST['TG'];
		$nbts	=	$_POST['nbTS'];
		$nbta	=	$_POST['nbTA'];
		$nbc	=	$_POST['nbC'];
		$nbtsp   =	$cone->nbrTermes($terme,'ts');
		$nbtap   =	$cone->nbrTermes($terme,'ta');
		$nbcp	=	$cone->nbrConcepts($terme);
	
	//echo $terme."<br/>".$tg."<br/>".$desc."<br/>".$nbta."<br/>";
	
	if($tg=='vide')	$tg='null';
	//////////TERME specifique
	$TS=array();
	for($i=1;$i<=$nbts;$i++)
	{
		$ss="TS".$i;
		if(!isset($_POST[$ss]))	echo "erreur TS".$i."<br/>";
		else
		{
			if($_POST[$ss]!='vide' && !$cone->exitsTable($_POST[$ss],$TS))	$TS[]=$_POST[$ss];
			echo $ss.":".$_POST[$ss]."<br/>";
		}
	}
	/////////////precedents
	for($i=1;$i<=$nbtsp;$i++)
	{
		$ss="TSp".$i;
		if(!isset($_POST[$ss]) && !$cone->exitsTable($_POST[$ss],$TS))	echo "erreur TS".$i."<br/>";
		else
		{
			if($_POST[$ss]!='vide')	$TS[]=$_POST[$ss];
			echo $ss.":".$_POST[$ss]."<br/>";
		}
	}
	
	
	
	
	///////////TERME associee
	$TA=array();
	for($i=1;$i<=$nbta;$i++)
	{
		$ss="TA".$i;
		if(!isset($_POST[$ss]))	echo "erreur TA".$i."<br/>";
		else
		{
			if($_POST[$ss]!='vide' && !$cone->exitsTable($_POST[$ss],$TA))	$TA[]=$_POST[$ss];
			//echo $ss.":".$_POST[$ss]."<br/>";
		}
	}
	
	//////precedete
	for($i=0;$i<$nbtap;$i++)
	{
		$ss="TAp".$i;
		if(!isset($_POST[$ss]) && !$cone->exitsTable($_POST[$ss],$TA))	echo "erreur TA".$i."<br/>";
		else
		{
			if($_POST[$ss]!='vide' && !$cone->exitsTable($_POST[$ss],$TA))	$TA[]=$_POST[$ss];
			//echo $ss.":".$_POST[$ss]."<br/>";
		}
	}
	
	
	
	/////////////Concepts
	$Cpts=array();
	for($i=1;$i<=$nbc;$i++)
	{
		$ss="C".$i;
		if(!isset($_POST[$ss]) && !$cone->exitsTable($_POST[$ss],$Cpts))	echo "erreur TS".$i."<br/>";
		else
		{
			if($_POST[$ss]!='vide')	$Cpts[]=$_POST[$ss];
		//	echo $ss.":".$_POST[$ss]."<br/>";
		}
	}

	//////////precedent
	for($i=1;$i<=$nbcp;$i++)
	{
		$ss="Cp".$i;
		if(!isset($_POST[$ss]))	echo "erreur TS".$i."<br/>";
		else
		{
			if($_POST[$ss]!='vide' && !$cone->exitsTable($_POST[$ss],$Cpts))	$Cpts[]=$_POST[$ss];
	//		echo $ss.":".$_POST[$ss]."<br/>";
		}
	}

	/*echo "<br/><br/>LECONTENUE DEs TABLEAU<br/>";

	
	$i=1;
	foreach($TS as $ele)
	{
		$ss="TS".$i;
		echo $ss.":".$ele."<br/>";
		$i++;
	}

	$i=1;
	foreach($TA as $ele)
	{
		$ss="TA".$i;
		echo $ss.":".$ele."<br/>";
		$i++;
	}
	$i=1;
	foreach($Cpts as $ele)
	{
		
		$ss="C".$i;
		echo $ss.":".$ele."<br/>";
		$i++;
	}
*/
	$test=true;
	
	
	
	$isVed=$cone->isVeddette($terme);
	//echo "COPTE VEDETTE".$isVed."<br/>";
	if($isVed != 'vide' && !$cone->exitsTable($isVed,$Cpts) && $test)
	{
?>
<center>
		<table class="inscription" align="center" style="color:green;">
		<tr>
			<td>IMPOSSIBLE DE SUPRIMMER UN TERME VEDETTE  </td>
		</tr>
		<tr>
			<td> il faut modifier le terme vedette ou supprimer le concept  </td>
		</tr> 
		<tr>
			<td>  ****<?php echo $isVed; ?>**** </td>
		</tr> 
				
		</table>
</center>
<?php
	}
	else if($test) 
	{
		$cone->modifieTerme($terme,$desc,$tg,$TS,$TA,$Cpts);
?>
		<br/>
		<table class="inscription" align="center" style="color:green;">
		<tr>
			<td>Terme Modifier avec succ&egrave;s </td>
		</tr> 
		</table>
<?php			
	}
	}
?>
</FIELDSET>
<br /><br />