<?php 
	class InsertTerme
	{
		private $libelleTerme;
		private $description;
		private $type;
		private $termeGenerique;
		private $termeSpecifiques;
		private $termeAssociees;
		private $concepts;
		

		public function __construct($nom,$type, $des, $termG)
		{
			$this->libelleTerme 	= 	$nom;
			$this->description		=	$des;
			$this->type				=	$type;
			$this->termeGenerique	=	null;
			$this->termeSpecifiques	=	array();
			$this->termeAssociees	=	array();
			$this->concepts			=	array();
		}
		
		public  function setTG($TG)
		{
			$this->termeGenerique	=	$TG;
		}
		
		
		public  function setTS($TS)
		{
			$this->termeSpecifiques	=	$TS;
		}
		
		
		public  function setTA($TA)
		{
			$this->termeAssociees	=	$TA;
		}
		
		public function setC($Cs)
		{
			$this->concepts			=	$Cs;
		}
		
		public  function affiche()
		{
			echo 	"libelle: ".$this->libelleTerme."<br/>
					Description:	".$this->description."<br/> 
					type:	".$this->type." <br>
					TG : ".$this->termeGenerique."<br/>";
			echo	"TERME SPECIFIQUES <br/>";
			foreach($this->termeSpecifiques	as	$ts)	echo $ts."<br/>";
			echo	"TERME Associies <br/>";
			foreach($this->termeAssociees	as	$ta)	echo $ta."<br/>";
			echo	"TERME SPECIFIQUES <br/>";
			foreach($this->concepts	as	$c)	echo $c."<br/>";
		}
		
		public function verif()
		{
			$c = oci_connect('system', 'jawad123');
			if ($c === false)
					die("Connexion impossible : " . oci_error());
			else    echo "Connexion réussie";
		}
		
		
		public function insert()
		{
			verif();
			
			$reqTG="(select ref(t) from Terme t where t.libelle='".$libelle."'";
			
			$req="insert into Terme values('".$libelle."','".description."','".type."',".$reqTG.",null,null)";
			
			echo $req;
		}
		
		private function updateTG()
		{
			
		}
		
		private function updateTA()
		{
			
		}
		
		private function updateTS()
		{
			
		}
		
		
		
	}	
	
?>

