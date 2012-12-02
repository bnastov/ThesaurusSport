<?php	
	
	$lib	=	htmlentities($_POST['lib']);
	$desc	=	$_POST['desc'];
	$tg		=	$_POST['TG'];
	$nbts	=	$_POST['nbTS'];
	$nbta	=	$_POST['nbTA'];
	$nbc	=	$_POST['nbC'];

	
	
	$TS=array();
	for($i=1;$i<=$nbts;$i++)
	{
		$ss="TS".$i;
		if(!isset($_POST[$ss]))	echo "erreur TS".$i."<br/>";
		else
		{
			if($_POST[$ss]!='vide' && !$cone->exitsTable($_POST[$ss],$TS))	$TS[$i]=$_POST[$ss];
			//echo $ss.":".$_POST[$ss]."<br/>";
		}
	}
	
	$TA=array();
	for($i=1;$i<=$nbta;$i++)
	{
		$ss="TA".$i;
		if(!isset($_POST[$ss]))	echo "erreur TA".$i."<br/>";
		else
		{
			if($_POST[$ss]!='vide' && !$cone->exitsTable($_POST[$ss],$TA))	$TA[$i]=$_POST[$ss];
			//echo $ss.":".$_POST[$ss]."<br/>";
		}
	}
	$Cpts=array();
	for($i=1;$i<=$nbc;$i++)
	{
		$ss="C".$i;
		if(!isset($_POST[$ss]))	echo "erreur TS".$i."<br/>";
		else
		{
			if($_POST[$ss]!='vide'  && !$cone->exitsTable($_POST[$ss],$Cpts))	$Cpts[$i]=$_POST[$ss];
			//echo $ss.":".$_POST[$ss]."<br/>";
		}
	}
	if($tg=='vide')			$tg='null';
	$test=true;
	
	if($lib==''  || preg_match("#'#",$lib))	
	{
		$test =false;
		echo "<h1> mon incorrect '".$lib."'</h1>";
	}
	if(!$cone->exist($lib) && $test)	{
		$cone->insertTerme($lib,$desc,$tg,$TS,$TA,$Cpts);
		?>
		<br/>
		<table class="inscription" align="center" style="color:green;">
		<tr>
			<td>Terme ins&eacute;r&eacute; avec succ&egrave;s </td>
		</tr> 
		</table>
		<?php			
	}
	else if($test) 					echo "TERME existe DEJA, vous pouvez le modifier<br/>";


?>

 
