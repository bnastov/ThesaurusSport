<?php	
	$nbTS=0;
	$nbTA=0;
	$nbCs=0;
?>

<center>
<form method="post" action="index.php?page=insererT">
<br />
<FIELDSET>
<LEGEND> Ins&eacute;rer un Terme </LEGEND>
	<table class="tab">
		<tr>
			<td >Libelle</td>
			<td ><input name="lib" type="text" /></td>
		</tr>
		<tr>
			<td >Description</td>
			<td ><textarea name="desc" type="text" /></textarea></td>
		</tr>
		<tr>
			<td >le Terme Generique&nbsp;</td>
			<td ><select name="TG"><?php echo $termeList; ?> </select> </td>
		</tr>
		<tr>
			<td >Terme Specifique</td>
			<td ><div id='TS'><input type="button"  onclick="ajouteTerme(1);" value="+"/></div></td>
		</tr>
		<tr>
			<td >Terme Associee</td>
			<td ><div id='TA'><input type="button"  onclick="ajouteTerme(2);" value="+"/></div></td>
		</tr>
		<tr>
			<td >Concept</td>
			<td ><div id='C'><input type="button"  onclick="ajouteConcept();" value="+"/></div></td>
		</tr>
		<tr align="right">
			<div	id='NBR'>
				<input id="nbTS"	type="hidden" 	name="nbTS"	value="0"/>
				<input id="nbTA"	type="hidden"	name="nbTA"	value="0"/>
				<input id="nbC"		type="hidden"	name="nbC"	value="0"/>
			</div>
			<td> <input type="submit" value="Insérer le terme"/></td>
			<td> <input type="button" value="Annuler" onclick="javascript:location.href='index.php'"/></td>
		</tr>
	</table>
</FIELDSET>
</form>
</center>
<br /><br /><br /><br />
 
