var TSi=0;
var TAi=0;
var Ci=0;

function ajouteTerme(arg)
{
	if(arg==1)
	{
		TSi++;
		var ajo = TSi+' : '+listTermes("TS"+TSi);
		var corps=document.getElementById('TS').innerHTML;
		document.getElementById('TS').innerHTML=corps+ "<br/>"+ajo;
		document.getElementById('nbTS').value=TSi;
		
	}
	else
	{
		TAi++;
		var ajo = TAi+' : '+listTermes("TA"+TAi);
		var corps=document.getElementById('TA').innerHTML;
		document.getElementById('TA').innerHTML=corps+ "<br/>"+ajo;
		document.getElementById('nbTA').value=TAi;
		
	}
}

function ajouteConcept()
{
	Ci++;
	var ajo = Ci+':'+listConcepts(Ci);
	var corps=document.getElementById('C').innerHTML;
	document.getElementById('C').innerHTML=corps+ "<br/>"+ajo;
	document.getElementById('nbC').value=Ci;
		
}	
	


