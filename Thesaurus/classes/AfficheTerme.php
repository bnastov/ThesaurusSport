<?php 
	class AfficheTerme
	{
		private $nomTerme;
		private $description;
		private $type;
		private $termeGenerique;
		private $termeSpecifiques;
		private $termeAssociees;
		private $concepts;

		public function __construct()
		{
			$nom 			='';
			$description	='';
			$typee			='';
			$this->termeGenerique	=	null;
			$this->termeSpecifiques = 	array();
			$this->termeAssociees	= 	array();
			$this->concepts			= 	array();

		}
		
		
		public function setProp($nom, $description,$typee)
		{
			$this->nomTerme 		= 	$nom;
			$this->description		=	$description;
			$this->type				=	$typee;
			
		}
		public function isEmpty()
		{
			if($this->nomTerme=='');
		}
		
		public function setTG($tg)
		{
			$this->termeGenerique	=	$tg;
		}
		public function setTS($tg)
		{
			$this->termeSpecifiques	=	$tg;
		}
		public function setTA($tg)
		{
			$this->termeAssociees	=	$tg;
		}
		public function setCs($tg)
		{
			$this->concepts			=	$tg;
		}
		
		public function dessiner()
		{
/*	

************************* Ancien affichage *************************
	
?>
<center>
<table class="tableGlobale">
	<tr height = "33%">
		<td colspan='3'  align="center">
		
		<table class="TermeGenerique">
			<tr>
				<td >TermeGenerique</td>
			</tr>
			<tr>
				<td ><?php echo $this->termeGenerique; ?></td>
			</tr>
		</table>
		
		</td>
	</tr>
	<tr height = "34%">
		<td width="33%">
		<table class="Concept">
			<tr>
				<td >Concept</td>
			</tr>
			<tr>
				<td >nom</td>
			</tr>
		</table>
		</td>
		<td width="34%">
		<table class="Terme" >
			<tr>
				<td >LE TERME choisi</td>
			</tr>
			<tr>
				<td><?php echo $this->nomTerme; ?></td>
			</tr>
		</table>
		
		<td width="33%">
		<table class="TermeAssociee" >
			<tr>
				<td >TermeAssociées</td>
			</tr>
<?php
	foreach ($this->termeAssociees as $elem)
	{
?>
			<tr>
				<td ><?php	echo $elem	?></td>
			</tr>
<?php
	}
?>		
		</table>
		</td>
	</tr>
	<tr height = "33%">
		<td colspan='3' align="center">
		<table class="TermeSpecifique">
			<tr>
				<td>termeSpecifique</td>
			</tr>
<?php
	foreach ($this->termeSpecifiques as $elem)
	{
?>
			<tr>
				<td ><?php	echo $elem	?></td>
			</tr>
<?php
	}
?>		
		</table>
		</td>
	</tr>
</table>
</center>
		<?php

************************* Nouvel affichage *************************		

*/	
?>	
<div id='general'>
<fieldset id='terme'>
		<legend id='legend'>Terme choisi</legend>
		<ul>
		<li>Libelle : <?php echo $this->nomTerme; ?> </li>
		<li>Description : <?php echo $this->description; ?> </li>
		<li>Type : <?php echo $this->type; ?> </li>
		</ul>
</fieldset>

<fieldset id='concept'>
		<legend id='legend'>Concept</legend>
		<ul>
		<?php
		foreach ($this->concepts as $elem)
		{
		?>
			<li><a href="index.php?page=search&t=<?php echo $elem; ?>"><?php echo $elem; ?><a/> </li>
		<?php
		}
		?>
		</ul>
</fieldset>

<fieldset id='termeG'>
		<legend id='legend'>Terme Generique</legend>
		<ul>
		<?php if (isset ($this->termeGenerique) && $this->termeGenerique != "")
		{
?>
		<li><a href="index.php?page=search&t=<?php echo $this->termeGenerique; ?>"><?php echo $this->termeGenerique; ?><a/> </li>
<?php
		}
		?>
		</ul>
</fieldset>

<div id='termeAS'>

<fieldset id='termeA'>
		<legend id='legend'>Termes Associes</legend>
		<ul>
		<?php
		foreach ($this->termeAssociees as $elem)
		{
		?>
			<li><a href="index.php?page=search&t=<?php echo $elem; ?>"><?php echo $elem; ?><a/> </li>
		<?php
		}
		?>
		</ul>
</fieldset>

<fieldset id='termeS'>
		<legend id='legend'>Termes Specifiques</legend>
		<ul>
		<?php
		foreach ($this->termeSpecifiques as $elem)
		{
		?>
			<li><a href="index.php?page=search&t=<?php echo $elem; ?>"><?php echo $elem; ?><a/> </li>
		<?php
		}
		?>
		</ul>
</fieldset>
<br/><br/><br/><br/><br/><br/><br/>
</div>

</div>
<?php
		}
	}
	
?>

