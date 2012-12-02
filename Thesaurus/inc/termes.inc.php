
<h3><span class="lettrine">L</span>es Termes : </h3><br/>

<table>
<?php
	//$ss	=	new	afficheTerme('basketball','sport de ball',array('joueurFootball','gardienFootbal','ali'),array('basketball','rugby','handball'));
	//$ss->dessiner();
	
	$termes = $cone->listTermes();
	while ($row = oci_fetch_array($termes)){
	
		echo "<tr style=\"cursor:pointer;\" onclick=\"javascript:location.href='index.php?page=search&t=" .htmlentities($row[0]). "'\">
				<td>&bull; ". htmlentities($row[0]) . "</td>
			</tr>";

	}
	
?>
</table>

