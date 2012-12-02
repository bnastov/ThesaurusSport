<?php
	$coneGeneral	=	new Connexion('system','rabah123'); 
	$termeList = $coneGeneral->genererSelectTerme();
	$conceptList = $coneGeneral->genererSelectConcept();
	
	
	echo "
		<script>  
			function listTermes(arg)
			{
				return '<select name=\"'+arg+'\" > $termeList </select>'
			}

			function listConcepts(arg)
			{
				return '<select name=\"C'+arg+'\" > $conceptList </select>'
			}
		</script>
		";
	
	$coneGeneral->closeCon();
?>