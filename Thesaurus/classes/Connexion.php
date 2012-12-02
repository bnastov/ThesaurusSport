<?php
	//include("classes/AfficheTerme.php");
		
	class Connexion
	{
		private $identifier;
		private $password;
		private $base;
		
		public function __construct($id, $ps)
		{
			$this->identifier	=	$id;
			$this->password		=	$ps;
			$this->connectToOracle();
		}
		
		function __destruct() 
		{
			//echo "ALPHA";
			//oci_close($this->base);
		}
		
		private function connectToOracle()
		{
			$this->base = oci_connect("system", "rabah123");
			if ($this->base === false)	die("Connexion impossible : " . oci_error());
			//else    			echo "Connexion réussie";
			
		}
		
		public function test()
		{
			$stid = oci_parse($this->base, 'SELECT libelle FROM Terme order by libelle');
			oci_execute($stid);

			while ($row = oci_fetch_array($stid)) {
				//foreach($row as $ele)
				echo  "<br/>".$row[0];
			}//*/
			//$row=array(1,2);
			echo count($row);
			
		}
		
		public function genererSelectTerme($arg='')
		{
			$str="<option value=\"vide\"></option>";
			$stid = oci_parse($this->base, 'SELECT libelle FROM Terme order by libelle');
			oci_execute($stid);

			while ($row = oci_fetch_array($stid)) {
				//foreach($row as $ele)
				if($row[0]==$arg)	$str=$str."<option selected value=\"".$row[0]."\">".$row[0]."</option>";
				else 				$str=$str."<option value=\"".$row[0]."\">".$row[0]."</option>";
			}//*/
			return $str;
		}
		
		public function genererSelectConcept($arg='')
		{
			$str="<option value=\"vide\"></option>";
			$stid = oci_parse($this->base, 'SELECT nom FROM Concept order by nom');
			oci_execute($stid);

			while ($row = oci_fetch_array($stid)) {
				//foreach($row as $ele)
				if($row[0]==$arg)	$str=$str."<option selected value=\"".$row[0]."\">".$row[0]."</option>";
				else 				$str=$str."<option value=\"".$row[0]."\">".$row[0]."</option>";
			}//*/
			return $str;
		}
		//
		public function listConcepts()
		{
			$stid = oci_parse($this->base, 'SELECT nom FROM Concept order by nom');
			oci_execute($stid);
			return $stid;
		}
		
		public function listTermes()
		{
			$stid = oci_parse($this->base, 'SELECT libelle FROM Terme order by libelle');
			oci_execute($stid);
			return $stid;
		}
		//
		public function exist($lib)
		{
			$req="SELECT libelle FROM terme where libelle='".$lib."'";
			$stid = oci_parse($this->base,$req );
			oci_execute($stid);
			$str=array();
			
			while ($row = oci_fetch_array($stid)) {
				$str[]=$row[0];
				echo	$row[0]."exists";
			}
			if(count($str)>0) return true;
			else 			return false;
		}
		
		public function existC($lib)
		{
			$req="SELECT nom FROM concept where nom='".$lib."'";
			$stid = oci_parse($this->base,$req );
			oci_execute($stid);
			$str=array();
			
			while ($row = oci_fetch_array($stid)) {
				$str[]=$row[0];
				echo	$row[0]."exists";
			}
			if(count($str)>0) return true;
			else 			return false;
		}
		
		public function insertConcept($nom,$tv,$cg,$cs)
		{
			///////L'INSERTION DE CONCEPT
			$req="insert into Concept values('$nom',(select ref(i) from thesaurus i where i.nom='sport'),
			(select ref(i) from terme i where i.libelle='$tv'),null,GroupeConcept())";
			//echo "<br/>".$req;
			$this->exe($req);
			
			
			$req="update terme set typet ='1' where libelle='".$tv."'";
			$this->exe($req);
			
			$req="insert into table(select CPTS from Terme where libelle='".$tv."') values (refCon((select ref(i) from Concept i where i.nom='".$nom."')))";
			$this->exe($req);
			//*/
			//echo "ISERTION OK<br/>";
			
			//////////////////Concept GEENRIQUE
			if($cg!='null')
			{
				echo $cg."<br/>";
				$req="update Concept set CG=(select ref(i) from  Concept i  where i.nom='".$cg."') where nom='".$nom."'";
				$this->exe($req);
				$req="insert into table(select CS from Concept where nom='".$cg."') values (refCon((select ref(i) from Concept i where i.nom='".$nom."')))";
				$this->exe($req);
			}
			else	echo "ce concept n'a pas de Concept generique <br/>";
			
			////////Concept SPECIFIQUE
			if(count($cs)>0)
				foreach($cs as $ele)
				{
					$req="insert into table(select CS from Concept where nom='".$nom."') values (refCon((select ref(i) from Concept i where i.nom='".$ele."')))";
					$this->exe($req);
					$req="update terme set CG=refCon((select ref(i) from Concept i where i.nom='".$nom."')) where nom='".$ele."'";
					$this->exe($req);
				}
			else echo 'ce concept n\'a pas de spécialistaion<br/>';
			
			
		}
		
		public function insertTerme($lib,$desc,$tg,$ts,$ta,$c)
		{
			///////L'INSERTION DE TERME
			$req="insert into Terme values('$lib',0,'$desc',null,GroupeTermes(),GroupeTermes(),GroupeConcept())";
			$this->exe($req);
			
			
			//////////////////TERME GEENRIQUE
			if($tg!='null')
			{
				$req="update Terme set TG=(select ref(i) from  Terme i  where i.libelle='".$tg."') where libelle='".$lib."'";
				$this->exe($req);
				$req="insert into table(select TS from Terme where libelle='".$tg."') values (refTerm((select ref(i) from terme i where i.libelle='".$lib."')))";
				$this->exe($req);
			}
			else	echo "ce terme n'a pas de Terme generique <br/>";
			
			
			////////TERME SPECIFIQUE
			if(count($ts)>0)
				foreach($ts as $ele)
				{
					$req="insert into table(select TS from Terme where libelle='".$lib."') values (refTerm((select ref(i) from terme i where i.libelle='".$ele."')))";
					$this->exe($req);
					$req="update terme set TG=refTerm((select ref(i) from terme i where i.libelle='".$lib."')) where libelle='".$ele."'";
					$this->exe($req);
				}
			else echo 'ce terme n\' pas de spécialisation<br/>';
			
			///////////TERME ASSOCIEE
			if(count($ta)>0)
				foreach($ta as $ele)
				{
					$req="insert into table(select TA from Terme where libelle='".$lib."') values (refTerm((select ref(i) from terme i where i.libelle='".$ele."')))";
					$this->exe($req);
					$req="insert into table(select TA from Terme where libelle='".$ele."') values (refTerm((select ref(i) from terme i where i.libelle='".$lib."')))";
					$this->exe($req);
				}
			else echo 'ce terme n\' pas de association<br/>';
			
			////////////LES CONCEPTS
			if(count($c)>0)
				foreach($c as $ele)
				{
					$req="insert into table(select CPTS from Terme where libelle='".$lib."') values (refCon((select ref(i) from Concept i where i.nom='".$ele."')))";
					$this->exe($req);
				}
			else echo 'ce terme n\'a partient pas à des concept<br/>';
			//*/
		}
		
		private function exe($arg)
		{
			//echo	$arg."<br/><br/>";
			$stid = oci_parse($this->base, $arg);
			oci_execute($stid);
		}
		
		public function modifieConcept($nom,$tv,$cg)
		{
			$oldTv=$this->getTV($nom);
			if($oldTv!=$tv)
			{
				$req="update Concept set Vedette=(select ref(i) from terme i where i.libelle='$tv') where nom='$nom'";
				$this->exe($req);
				$req="update Terme set typet=0 where libelle='$oldTv'";
				$this->exe($req);
				$req="update Terme set typet=1 where libelle='$tv'";
				$this->exe($req);
			}
			
			$oldCg='null';
			$req="select deref(i.cg).nom from concept i where i.nom='$nom'";
			echo $req."<br/>";
			
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			
			while ($row = oci_fetch_array($stid)) {
				$oldCg=$row[0];
			}
			if($oldCg=='')	$oldCg='null';
			if($oldCg!=$cg)
			{
				if($cg=='null')
				{
					$req="update Concept set CG=null where nom='$nom'";
					$this->exe($req);
				}
				else
				{
					$req="update Concept set CG=(select ref(i) from concept i where i.nom='$cg') where nom='$nom'";
					$this->exe($req);
					
					$req="insert into table (select CS from concept where nom='$cg') values (refCon((select ref(i) from concept i where i.nom='$nom')))";
					$this->exe($req);
				
					if($oldCg!='null')
					{
						$req="delete from table (select CS from concept where nom='$oldCg') where deref(concept).nom='$nom' ";
						$this->exe($req);
					}
				}
			}
			
	
			
			
		}
		
		
		
		
		public function getTerme($term)
		{
			$req="select libelle, description, typet from terme where libelle='".$term."'";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			
			$terme=new AfficheTerme();
			
			$test=false;
			while ($row = oci_fetch_array($stid)) {
					$terme->setProp($row[0],$row[1],$row[2]);
					$test=true;
			}
			if(!$test)	return null;
			
			$req="select deref(i.TG).libelle from terme i where i.libelle='".$term."'";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			
			while ($row = oci_fetch_array($stid)) {
					$terme->setTG($row[0]);
			}
			
			$req="select deref(t2.terme).libelle from  table( select i.TS from terme i where  i.libelle='".$term."') t2";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			
			$ts =array();
			while ($row = oci_fetch_array($stid)) {
					$ts[]=$row[0];
			}
			
			$terme->setTS($ts);
			
			
			$req="select deref(t2.terme).libelle from  table( select i.TA from terme i where  i.libelle='".$term."') t2";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			
			$ta =array();
			while ($row = oci_fetch_array($stid)) {
					$ta[]=$row[0];
			}
			
			$terme->setTA($ta);
			
			
			$req="select deref(t2.concept).nom as parentConcept from  table( select i.Cpts from terme i where  i.libelle='".$term."') t2";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			
			$cs =array();
			while ($row = oci_fetch_array($stid)) {
					$cs[]=$row[0];
			}
			
			$terme->setCs($cs);
			
			return $terme;
		}
		
		public function getConcept($concept)
		{
			$req="select nom from concept where nom='".$concept."'";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			
			$ccpt=new AfficheConcept();
			
			$test=false;
			while ($row = oci_fetch_array($stid)) {
					$ccpt->setProp($row[0]);
					$test=true;
			}
			
			$req2="select deref(vedette).libelle from concept where nom='".$concept."'";
			$stid2 = oci_parse($this->base, $req2);
			oci_execute($stid2);
			$desc='';
			while ($row = oci_fetch_array($stid2)) {
					$desc=$row[0];
			}
			
			$ccpt->setTV($desc);
			
			return $ccpt;
		}
		
		public function closeCon()
		{
			oci_close($this->base);
		}
		
		public function supprimeTerme($term)
		{
			$req="select deref(TG).libelle from  terme where libelle='$term'";
			//echo	$req."<br/><br/>";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			
			while ($row = oci_fetch_array($stid)) {
					$req="delete from table(select TS from terme where libelle='$row[0]' ) t1 where t1.terme=(select ref(i) from terme i where i.libelle='$term')";
					$this->exe($req);
			}
			
			$req="select deref(t2.terme).libelle from  table(select i.TS from terme i where  i.libelle='$term') t2";
			//echo	$req."<br/><br/>";
			
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			
			while ($row = oci_fetch_array($stid)) {
					$req="update terme set	TG='null'  where libelle='$row[0]'";
					$this->exe($req);
			}

			$req="select deref(t2.terme).libelle from  table(select i.TA from terme i where  i.libelle='$term') t2";
			//echo	$req."<br/><br/>";
			
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			
			while ($row = oci_fetch_array($stid)) {
					$req="delete from table(select TA from terme where libelle='$row[0]' ) t1 where t1.terme=(select ref(i) from terme i where i.libelle='$term')";
					$this->exe($req);		
			}
			
			$req="delete from  terme where libelle='$term'";
			//echo	$req."<br/><br/>";
			$this->exe($req);

		}
		public function supprimeConcept($term)
		{
			$req="select deref(CG).nom from  Concept where nom='$term'";
			//echo	$req."<br/><br/>";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			
			while ($row = oci_fetch_array($stid)) {
					if($row[0]!='')
					{$req="delete from table(select CS from concept where nom='$row[0]' ) t1 where t1.concept=(select ref(i) from concept i where i.nom='$term')";
					$this->exe($req);}
			}
			
			$req="select deref(t2.concept).nom from  table(select i.CS from concept i where  i.nom='$term') t2";
			//echo	$req."<br/><br/>";
			
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			
			while ($row = oci_fetch_array($stid)) {
					$req="update concept set	CG='null'  where nom='$row[0]'";
					$this->exe($req);
			}
			
			$req="delete from  concept where nom='$term'";
			//echo	$req."<br/><br/>";
			$this->exe($req);

		}
		
	
		private function insertNested($term,$type,$name,$what)
		{
			if($type == 'T')		$req="insert into table(select $name from Terme where libelle='$term') values (refTerm((select ref(i) from terme i where i.libelle='$what')))";
			else if($type == 'C')	$req="insert into table(select $name from Terme where libelle='$term') values (refCon((select ref(i) from concept i where i.nom='$what')))";
			return $req;
					
		}
		
		public function modifieTerme($terme,$desc,$tg,$TS,$TA,$Cpts)
		{
			$req="update terme set description='$desc' where libelle='$terme'";
			$this->exe($req);
			
			$req="select deref(TG).libelle from terme where libelle='$terme'";
				$oldTG='null';
				$stid = oci_parse($this->base, $req);
				oci_execute($stid);
				while ($row = oci_fetch_array($stid)) {
					$oldTG=$row[0];
				}
				
			if($oldTG=='')	$oldTG='null';
			//echo "ancien TG ".$oldTG."<br/>";
			//echo "New TG ".$tg."<br/>";
			if($oldTG!=$tg)
			{
				if($tg=='null')
				{
				
					if($oldTG!='null')
					{
					$req="delete from table(select TS from terme where libelle='$oldTG') where  deref(terme).libelle='$terme'";
					$this->exe($req);
					}
				
					$req="update terme set TG=null where libelle='$terme'";
					$this->exe($req);
				}
				else
				{
				if($oldTG!='null')
				{
				$req="delete from table(select TS from terme where libelle='$oldTG') where  deref(terme).libelle='$terme'";
				$this->exe($req);
				}
				$req="update terme set TG=(select ref(i) from terme i where i.libelle='$tg') where libelle='$terme'";
				$this->exe($req);
				$req="insert into table(select TS from terme where libelle='$tg') values (refTerm((select ref(i) from terme i where i.libelle='$terme')))";
				$this->exe($req);
				}
			}
			
			///les TSs
			if(count($TS)>0)
			{
				$req="select deref(t1.terme).libelle from table(select TS from Terme i where i.libelle='$terme') t1";
				$TSp=array();
				$stid = oci_parse($this->base, $req);
				oci_execute($stid);
				while ($row = oci_fetch_array($stid)) {
					$TSp[]=$row[0];
				}
				
				//Insertion
				foreach($TS as $ele)
				{
					$test=true;
					foreach($TSp as $elep)
					{
						if($elep == $ele) $test=false;
					}
					if($test)
					{
						//echo $ele.'à ajouter<br/>';
						$req="insert into table(select TS from terme where libelle='$terme') values (refTerm((select ref(i) from terme i where i.libelle='$ele')))";
						$this->exe($req);
						$req="update terme set TG=(select ref(i) from terme i where i.libelle='$terme') where libelle='$ele'";
						$this->exe($req);
					}
				}
				
				//Supprission
				foreach($TSp as $elep)
				{
					$test=false;
					foreach($TS as $ele)
					{
						if($elep == $ele) $test=true;
					}
					if(!$test)
					{
						//echo $elep.'à supprimer<br/>';
						$req="delete from table(select TS from terme where libelle='$terme') where  deref(terme).libelle='$elep'";
						$this->exe($req);
						$req="update terme set TG=null where libelle='$ele'";
						$this->exe($req);
					}
				}
				
			}
			///TERME associé
			if(count($TA)>0)
			{
				$req="select deref(t1.terme).libelle from table(select TA from Terme i where i.libelle='$terme') t1";
				$TAp=array();
				$stid = oci_parse($this->base, $req);
				oci_execute($stid);
				//echo "TERME associé exstante<br/>";
				while ($row = oci_fetch_array($stid)) {
					$TAp[]=$row[0];
					//echo $row[0]."<br/>";
				}
				echo "<br/><br/>";
				//Insertion
				foreach($TA as $ele)
				{
					$test=true;
					foreach($TAp as $elep)
					{
						if($elep == $ele) $test=false;
					}
					if($test)
					{
						//echo $ele.'à ajouter<br/>';
						$req="insert into table(select TA from terme where libelle='$terme') values (refTerm((select ref(i) from terme i where i.libelle='$ele')))";
						$this->exe($req);
						$req="insert into table(select TA from terme where libelle='$ele') values (refTerm((select ref(i) from terme i where i.libelle='$terme')))";
						$this->exe($req);
					}
				}
				
				//Supprission
				foreach($TAp as $elep)
				{
					$test=false;
					foreach($TA as $ele)
					{
						if($elep == $ele) $test=true;
					}
					if(!$test)
					{
						//echo $elep.'à supprimer<br/>';
						$req="delete from table(select TA from terme where libelle='$terme') where  deref(terme).libelle='$elep'";
						$this->exe($req);
						$req="delete from table(select TA from terme where libelle='$elep') where  deref(terme).libelle='$terme'";
						$this->exe($req);
					}
				}
				
			}
			///CONCEPTS
			if(count($Cpts)>0)
			{
				$req="select deref(t1.concept).nom from table(select Cpts from Terme i where i.libelle='$terme') t1";
				$Cptsp=array();
				$stid = oci_parse($this->base, $req);
				oci_execute($stid);
				//echo "Concept existe Deja<br/>";
				while ($row = oci_fetch_array($stid)) {
					//echo $row[0]."<br/>";
					$Cptsp[]=$row[0];
				}
				echo "<br/><br/>";
				
				//Insertion
				foreach($Cpts as $ele)
				{
					$test=true;
					foreach($Cptsp as $elep)
					{
						if($elep == $ele) $test=false;
					}
					if($test)
					{
						//echo $ele.' à ajouter<br/>';
						$req="insert into table(select Cpts from terme where libelle='$terme') values (refCon((select ref(i) from concept i where nom='$ele')))";
						$this->exe($req);
					}
				}
				
				//Supprission
				foreach($Cptsp as $elep)
				{
					$test=false;
					foreach($Cpts as $ele)
					{
						if($elep == $ele) $test=true;
					}
					if(!$test)
					{
						//echo $elep.'à supprimer<br/>';
						$req="delete from table(select Cpts from terme where libelle='$terme') where  deref(concept).nom='$elep'";
						$this->exe($req);
					}
				}
				
			}
			
			
		}
		public function exitsTable($el,$arry)
		{
			foreach($arry as $ele)   if($ele==$el) return true;
			return false;
		}

		public function getTV($terme){
			$req="select deref(Vedette).libelle from Concept where nom='".$terme."'";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			$desc='';
			while ($row = oci_fetch_array($stid)) {
					$desc=$row[0];
			}
			return $desc;
		}
		
		public function getCGNom($concept){
			$req="select deref(CG).nom from concept where nom='".$concept."'";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			$desc='';
			while ($row = oci_fetch_array($stid)) {
					$desc=$row[0];
			}
			return $desc;
		}
		
		public function getVedette($nom){
			$req="select deref(vedette).libelle from concept where nom='".$nom."'";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			$desc='';
			while ($row = oci_fetch_array($stid)) {
					$desc=$row[0];
			}
			return $desc;
		}
		public function isVeddette($terme)
		{
			$req="select typet from terme where libelle='$terme'";
			$isV=-1;
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			while ($row = oci_fetch_array($stid)) {
					$isV=$row[0];
			}
			$con='vide';
			if($isV==1)
			{
				$req="select nom,deref(i.vedette).libelle from concept i";
				
				$stid = oci_parse($this->base, $req);
				oci_execute($stid);
				while ($row = oci_fetch_array($stid)) {
					if($row[1]==$terme) $con=$row[0];
				}
			}
			return $con;
		}
		
		
		//=====================Fonctions BLAZO
		public function getDescription($terme){
			$req="select description from terme where libelle='".$terme."'";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			$desc='';
			while ($row = oci_fetch_array($stid)) {
					$desc=$row[0];
			}
			return $desc;
		}
		
		public function getTGLibelle($terme){
			$req="select deref(TG).libelle from terme where libelle='".$terme."'";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			$desc='';
			while ($row = oci_fetch_array($stid)) {
					$desc=$row[0];
			}
			return $desc;
		}
		
		
		
		public function genereComboTermes($lib){
			$str="<option value=\"vide\"></option>";		
			$stid = oci_parse($this->base, 'SELECT libelle FROM Terme order by libelle');
			oci_execute($stid);
			while ($row1 = oci_fetch_array($stid)) {
				if($row1[0]!=$lib)
					$str=$str."<option value=\"".$row1[0]."\">".$row1[0]."</option>";
				else 
					$str=$str."<option selected value=\"".$row1[0]."\">".$row1[0]."(par default)</option>";
			}
			return $str;
		}
		
		public function genereComboConcepts($nom){
			$str="<option value=\"vide\"></option>";		
			$stid = oci_parse($this->base, 'SELECT nom FROM concept order by nom');
			oci_execute($stid);
			while ($row1 = oci_fetch_array($stid)) {
				if($row1[0]!=$nom)
					$str=$str."<option value=\"".$row1[0]."\">".$row1[0]."</option>";
				else 
					$str=$str."<option selected value=\"".$row1[0]."\">".$row1[0]." (par default)</option>";
			}
			return $str;
		}
		
		public function genreTermes($ss,$tt){
			
			$nbTermes=$this->nbrTermes($ss,$tt);
			
			$req="select deref(t.terme).libelle from table(select ".$tt." from terme where libelle='".$ss."') t";
			$LibelleTA=Array();
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			while ($row = oci_fetch_array($stid)) {
					$LibelleTA[]=$row[0];
			}
			
			$res='';
			for($i=0;$i<$nbTermes;$i++){
				if($tt=='ts')		$ff='TSp'.($i+1);		
				else	if($tt=='ta')		$ff='TAp'.$i;
				$res=$res.($i+1).' (p) : '.'<select name='.$ff.'>'.$this->genereComboTermes($LibelleTA[$i]).'</select>'.'<br/>';
			}
			return $res;
		}
		
		public function nbrTermes($ss,$tt)
		{
			$req="select count(t.terme) from table(select ".$tt." from terme where libelle='".$ss."') t";//On recupere le nombre des termes associes
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			while ($row = oci_fetch_array($stid)) {
					$nbTermes=$row[0];
			}
			return $nbTermes;
		}
		
		public function genreConcepts($ss){
			$nbCpts = $this->nbrConcepts($ss);
			
			$req="select deref(t.concept).nom from table(select cpts from terme where libelle='".$ss."') t";
			$NomConcept=Array();
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			while ($row = oci_fetch_array($stid)) {
					$NomConcept[]=$row[0];
			}
			
			$res='';
			for($i=0;$i<$nbCpts;$i++){
				$ff='Cp'.($i+1);
				$res=$res.($i+1).'(p) : '.'<select name='.$ff.'>'.$this->genereComboConcepts($NomConcept[$i]).'</select>'.'<br/>';
			}
			return $res;
		}
		
		public function genreConceptsC($ss){
			$nbCpts = $this->nbrConceptsC($ss);
			
			$req="select deref(t.concept).nom from table(select CS from Concept where nom='".$ss."') t";
			$NomConcept=Array();
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			while ($row = oci_fetch_array($stid)) {
					$NomConcept[]=$row[0];
			}
			
		
			$res='';
			for($i=0;$i<$nbCpts;$i++){
				$ff='Cp'.($i+1);
				$res=$res.($i+1).'(p) : '.'<select name='.$ff.'>'.$this->genereComboConcepts($NomConcept[$i]).'</select>'.'<br/>';
			}
			return $res;
		}
		
		public function nbrConcepts($ss)
		{
			$req="select count(t.concept) from table(select cpts from terme where libelle='".$ss."') t";//On recupere le nombre des termes associes
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			while ($row = oci_fetch_array($stid)) {
					$nbCpts=$row[0];
			}
			return $nbCpts;
		}
		public function nbrConceptsC($ss)
		{
			$req="select count(t.concept) from table(select CS from Concept where nom='".$ss."') t";//On recupere le nombre des termes associes
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			while ($row = oci_fetch_array($stid)) {
					$nbCpts=$row[0];
			}
			return $nbCpts;
		}
		public function selectedOptionT($terme){
			
			$str="";
			$req="select deref(i.Vedette).libelle from Concept i where i.nom='".$terme."'";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			$desc='';
			while ($row = oci_fetch_array($stid)) {
					$desc=$row[0];
			}
			
			$stid = oci_parse($this->base, 'SELECT libelle,typet FROM Terme order by libelle');
			oci_execute($stid);

			while ($row1 = oci_fetch_array($stid)) {
				if($row1[0]!=$desc && $row1[1]!=1)
					$str=$str."<option value=\"".$row1[0]."\">".$row1[0]."</option>";
				else if($row1[0]==$desc)
					$str=$str."<option selected value=\"".$row1[0]."\">".$row1[0]." (par default)</option>";
			}//*/
			return $str;
		}
		
		
		
		public function selectedOption($terme){
			
			$str="<option value=\"vide\"></option>";
			$req="select deref(TG).libelle from terme where libelle='".$terme."'";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			$desc='';
			while ($row = oci_fetch_array($stid)) {
					$desc=$row[0];
			}
			
			$stid = oci_parse($this->base, 'SELECT libelle FROM Terme order by libelle');
			oci_execute($stid);
			
			
			while ($row1 = oci_fetch_array($stid)) {
				if($row1[0]!=$desc)
					$str=$str."<option value=\"".$row1[0]."\">".$row1[0]."</option>";
				else 
					$str=$str."<option selected value=\"".$row1[0]."\">".$row1[0]." (par default)</option>";
			}//*/
			return $str;
		}
		
		public function selectedOptionC($concept){
			
			$str="<option value=\"vide\"></option>";
			$req="select deref(CG).nom from concept where nom='".$concept."'";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			$desc='';
			while ($row = oci_fetch_array($stid)) {
					$desc=$row[0];
			}
			
			$stid = oci_parse($this->base, 'SELECT nom FROM Concept  order by nom');
			oci_execute($stid);

			while ($row1 = oci_fetch_array($stid)) {
				if($row1[0]!=$desc)
					$str=$str."<option value=\"".$row1[0]."\">".$row1[0]."</option>";
				else 
					$str=$str."<option selected value=\"".$row1[0]."\">".$row1[0]." (par default)</option>";
			}//*/
			return $str;
		}
		
		
		public function genererConcepts($nom)
		{
			$req="select deref(vedette).libelle from concept where nom='".$nom."'";
			$stid = oci_parse($this->base, $req);
			oci_execute($stid);
			$desc='';
			while ($row = oci_fetch_array($stid)) {
					$desc=$row[0];
			}
			
			$str="";
			$stid = oci_parse($this->base, 'SELECT nom FROM Concept order by nom');
			oci_execute($stid);
			while ($row = oci_fetch_array($stid)) {
				if($row[0]!=$desc)
					$str=$str."<option value=\"".$row[0]."\">".$row[0]."</option>";
				else
					$str=$str."<option selected value=\"".$row[0]."\">".$row[0]." (par default)</option>";
			}
			return $str;
		}
		
		
		//////Function Robin
		
		public function StatTerme($libTerme) // Ajoute un terme ou incremente de + 1 un terme dans la table Stat_terme
		{
			$req="SELECT COUNT(*) AS NUMBER_OF_ROWS FROM Stat_terme WHERE libelle='".$libTerme."'";
			$result = oci_parse($this->base, $req);
			oci_define_by_name($result, 'NUMBER_OF_ROWS', $exist);
			if(oci_execute($result))
			{
				oci_fetch($result);
				if($exist > 0)
				{
					$req_maj = "UPDATE Stat_terme SET nbvisite = nbvisite + 1 WHERE libelle ='".$libTerme."'";
				}
				else $req_maj = "INSERT INTO Stat_terme(libelle, nbvisite) VALUES ('".$libTerme."', 1)";
				
				$result_maj = oci_parse($this->base, $req_maj);
				oci_execute($result_maj);
			}
		}
			
			
		public function StatRech($motRech) // Ajoute un mot ou incremente de + 1 un mot dans la table Stat_recherche
		{
			$req="SELECT COUNT(*) AS NUMBER_OF_ROWS FROM Stat_recherche WHERE mot_rech='".$motRech."'";
			$result = oci_parse($this->base, $req);
			oci_define_by_name($result, 'NUMBER_OF_ROWS', $exist);
			if(oci_execute($result))
			{
				oci_fetch($result);
				if($exist > 0)
				{
					$req_maj = "UPDATE Stat_recherche SET nbrech = nbrech + 1 WHERE mot_rech ='".$motRech."'";
				}
				else $req_maj = "INSERT INTO Stat_recherche(mot_rech, nbrech) VALUES ('".$motRech."', 1)";
				
				$result_maj = oci_parse($this->base, $req_maj);
				oci_execute($result_maj);
			}
		}	
		
		public function affichestat()
		{
			?>
			<div id='stat' align ='center'>
			<table border ='solid 1px' style = 'border-collapse : collapse' cellpadding = '8'>
			<th colspan="2"> Mots recherch&eacute;s </th>
			<tr><td id="statST">Mots</td><td id="statST">Nombre</td></tr>
			<?php
			$req="SELECT mot_rech, nbrech FROM Stat_recherche WHERE rownum < 11 ORDER BY nbrech DESC";
			$result = oci_parse($this->base, $req);
			if(oci_execute($result))
			{
				while($row = oci_fetch_array($result))
				{
					echo "<tr id='statTR'><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
				}
			
			}
			echo "</table><br/>";
				
			echo '<a href="?suppr_tab_rech" align="center">Reinitialiser table</a>';
			
			?>
			<table width="22%" border="solid 1px" style ='border-collapse: collapse' cellpadding = '8'>
			<th colspan="2"> Termes recherch&eacute;s </th>
			<tr><td id="statST">Termes</td><td id="statST">Nombre</td></tr>
			<?php
			$req="SELECT * FROM Stat_terme WHERE rownum < 11 ORDER BY nbvisite DESC";
			$result = oci_parse($this->base, $req);
			if(oci_execute($result))
			{
				while($row = oci_fetch_array($result))
				{
					echo "<tr id='statTR'><td>".$row[0]."</td><td style='text-align : center'>".$row[1]."</td></tr>";
				}
			
			}
			echo "</table><br/>";
			
			echo '<a href="?suppr_tab_terme" align="center">Reinitialiser table</a>';
			
			?>
			<table width="22%" border="solid 1px" style ='border-collapse: collapse' cellpadding = '8'>
			<th colspan="2"> Nombre total de </th>
			<tr><td id="statST">Termes</td><td id="statST">Concepts</td></tr>
			<?php
			$reqT="SELECT COUNT(*) AS NUMBER_OF_ROWS_T FROM Terme";
			$reqC="SELECT COUNT(*) AS NUMBER_OF_ROWS_C FROM Concept";
			$resultT = oci_parse($this->base, $reqT);
			$resultC = oci_parse($this->base, $reqC);
			oci_define_by_name($resultT, 'NUMBER_OF_ROWS_T', $nbT);
			oci_define_by_name($resultC, 'NUMBER_OF_ROWS_C', $nbC);
			if(oci_execute($resultT) && oci_execute($resultC))
			{
				oci_fetch($resultT);
				oci_fetch($resultC);
				echo "<tr id='statTR'><td style='text-align : center'>".$nbT."</td><td style='text-align : center'>".$nbC."</td></tr>";
			
			}
			echo "</table></div>";
		
	
		}

		public function liste_recherche($te)
		{
			// ------------------- Recherche de termes -----------------------
		
			$mots = strtolower($te);                          // on passe les mots recherches en minuscules   

			$mots = str_replace("+", " ", trim($mots));        // on remplace les + par des espaces (trim supprime les caract?res invisible)
			$mots = str_replace("\"", " ", $mots);                  // on remplace les " par des espaces
			$mots = str_replace(",", " ", $mots);                   // on remplace les , par des espaces
			$mots = str_replace(":", " ", $mots);                   // on remplace les : par des espaces
			$tab=explode(" " , $mots);                                // on place les differents mots dans un tableau
			$nb=count($tab);                                            // on compte le nbr d'element du tableau.

			$req_terme = "select libelle, description, typet from terme WHERE libelle like '%".$tab[0]."%' ";
			for($i=1 ; $i<$nb; $i++)
			{
				$req_terme .= "AND libelle like '%".$tab[$i]."%' ";       // on boucle pour integrer tous les mots dans la requ?te
			}
			
			$stid = oci_parse($this->base, $req_terme);
			$nb_terme = oci_parse($this->base, $req_terme);
			oci_execute($stid);
			oci_execute($nb_terme);
			$nb_result = 0;
			
			while (oci_fetch_array($nb_terme)) // On compte le nombre de resultats
				{
					$nb_result ++;
				}
			
			if ($nb_result > 0) // Si il existe au moins un resultat
			{
				
				echo "<div align='center'> Votre recherche a retourn&eacute; : ".$nb_result." r&eacute;sultat(s) <br/><br/>";
				echo " Selectionnez le terme voulu : <br/><br/>";
				while ($row = oci_fetch_array($stid)) // affichage des resultats
				{
					echo "<a href='?terme_choisi=".$row[0]."'>".$row[0]."</a><br/><br/>";
				}
				echo "</div>";
			}
			else echo "<div align='center'> Votre recherche n'a retourn&eacute; aucun r&eacute;sultat </div>";
			
			// -------------------- Fin de recherche --------------------------
		}
		public function reinit_stat($num_table)
		{
			if($num_table == 0)
			{
				$req = "DELETE FROM Stat_recherche";
				$result = oci_parse($this->base, $req);
				if (oci_execute($result)) echo '<div align="center"> Reinitialisation recherche reussi !</div>';
			}
			else 
			{
				$req = "DELETE FROM Stat_terme";
				$result = oci_parse($this->base, $req);
				if (oci_execute($result)) echo '<div align="center"> Reinitialisation statistique reussi !</div>';
			}
		}
	}
?>