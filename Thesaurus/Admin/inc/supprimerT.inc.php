<?php
	
	if(!isset($_POST['termS']))
	{
?>
		<form method="post" action="index.php?page=supprimerT">
			<br />
			<FIELDSET>
			<LEGEND> Supprimer un Terme </LEGEND><br /><br />
				Le Terme &agrave; supprimer	<select name="termS"><?php echo $termeList;?> </select>
				<input type="submit" value="Suprimer"/>
				<input type="button" value="Annuler" onclick="javascript:location.href='index.php'"/>
				<br /><br />
			</FIELDSET>
		</form>
<?php
	}
	else
	{
		$term=$_POST['termS'];
		$isV=$cone->isVeddette($term);
		//echo $isV;
		if($term =='vide')
		{
?>
		<br/>
		<table class="inscription" align="center" style="color:green;">
		<tr>
			<td>Pas de terme Selection&egrave; </td>
		</tr> 
		</table>
<?php			

		}
		else if(!$isV=='vide')
		{
		?>
		<br/>
		<table class="inscription" align="center" style="color:green;">
		<tr>
			<td>impossible de supprimer un Terme Vedette  </td>
		</tr>
		<tr>
			<td>il faut supprimer  ou modifier le terme vedette de concept </td>
		</tr> 
		<tr>
			<td>**** <?php echo $isV;?>****</td>
		</tr> 
				
		</table>
	<?php			

		}
		else 
		{
		$cone->supprimeTerme($term);
		
?>
		<br/>
		<table class="inscription" align="center" style="color:green;">
		<tr>
			<td>Terme Supprimer avec succ&egrave;s </td>
		</tr> 
		</table>
<?php			
	}

	}
?>