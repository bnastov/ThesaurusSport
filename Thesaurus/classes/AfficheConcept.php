<?php 
	class AfficheConcept
	{
		private $nomConcept;
		private $termeVedette;
		private $CG;
		private $CS;

		public function __construct()
		{
			$this->nomConcept		=	'';
			$this->termeVedette		=	null;
			$this->CG				=	null;
			$this->CS				=	array();
		}
		
		public function setCG($cg)
		{
			$this->CG	=	$cg;
		}
		
		public function setCS($ar)
		{
			$this->CS	=	$ar;
		}
		public function setProp($nom)
		{
			$this->nomConcept 		= 	$nom;
		}
		public function isEmpty()
		{
			if($this->nomConcept=='');
		}
		
		public function setTV($tv)
		{
			$this->termeVedette	=	$tv;
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
<fieldset id='concept'>
		<legend id='legend'>Concept</legend>
		<ul>
		<li><?php echo $this->nomConcept; ?></li>
		</ul>
</fieldset>

<fieldset id='concept'>
		<legend id='legend'>Terme Vedette</legend>
		<ul>
		<?php if (isset ($this->termeVedette) && $this->termeVedette != "")
		{
?>		
	<li><a href="index.php?page=search&t=<?php echo $this->termeVedette; ?>"><?php echo $this->termeVedette; ?><a/> </li>
<?php
		}
		?>
		</ul>
</fieldset>


</div>

<?php
		}
	}
	
?>

