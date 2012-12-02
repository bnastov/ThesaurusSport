<?php
	if( isset($_POST['nom']) AND isset($_POST['TV']) ) {
	
		$nom	=	$_POST['nom'];
		$tv		=	$_POST['TV'];
		$cg		=	$_POST['CG'];
		$nbc	=	$_POST['nbC'];
		
		if($cg=='vide') $cg='null'; 	
		//echo "nom:".$nom."<br/> TV: ".$tv."<br/> CG:".$cg."<br/> NB".$nbc."<br/>";
		$Cpts=array();
		for($i=1;$i<=$nbc;$i++)
		{
			$ss="C".$i;
			if(!isset($_POST[$ss]))	echo "erreur CS".$i."<br/>";
			else
			{
				if($_POST[$ss]!='vide')	$Cpts[$i]=$_POST[$ss];
				echo $ss.":".$_POST[$ss]."<br/>";
			}
		}
		$test=true;
	
		if($nom==''  || preg_match("#'#",$nom))	
	{
		$test =false;
		echo "<h1> mot incorrect '".$nom."'</h1>";
	}
	
		if( $test)
		{
			if(!$cone->existC($nom))
			{
				$cone->insertConcept($nom,$tv,$cg,$Cpts);
				?>
		<br/>
		<table class="inscription" align="center" style="color:green;">
		<tr>
			<td>Concept ins&eacute;r&eacute; avec succ&egrave;s </td>
		</tr> 
		</table>
		<?php			
			}
			else 					echo "Concept existe DEJA, vous pouvez le modifier<br/>";
		}
		
	}
	else
	{
?>

<center>
<br/>
<form method="post" action="">
<fieldset>
<legend> Insérer un Concept </legend>
	<table class="tab">
		<tr>
			<td >Nom</td>
			<td ><input name="nom" type="text" /></td>
		</tr>
		<tr>
			<td >le Terme Vedette&nbsp;</td>
			<td ><select name="TV"><?php echo $termeList;?> </select></td>
		</tr>
		<tr>
			<td >le  Concept Generique </td>
			<td ><select name="CG"><?php echo $conceptList;?> </select></td>
		</tr>
		<tr>
			<td >les Concepts specifiques</td>
			<td ><div id='C'><input type="button"  onclick="ajouteConcept();" value="+"/></div></td>
		</tr>
		<div	id='NBR'>
				<input id="nbTS"	type="hidden" 	name="nbTS"	value="0"/>
				<input id="nbTA"	type="hidden"	name="nbTA"	value="0"/>
				<input id="nbC"		type="hidden"	name="nbC"	value="0"/>
		</div>
			
		<tr colspan="2"><td><br/><br/><br/></td></tr>
		<tr>
			<td><input type="submit"	value="Insérer le concept"/></td>
			<td align="right"><input type="button" value="Annuler" onclick="javascript:location.href='index.php'"/></td>
		</tr>
	</table>
</fieldset>
</form>
</center>
<br/><br/><br/><br/>
<?php
	}
?>