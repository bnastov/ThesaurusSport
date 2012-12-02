
<h3><span class="lettrine">L</span>es concepts : </h3><br/>

<table>
<?php
	
	$concepts = $cone->listConcepts();
	while ($row = oci_fetch_array($concepts)){
	
		echo "<tr style=\"cursor:pointer;\" onclick=\"javascript:location.href='index.php?page=search&c=". $row[0] ."'\">
				<td>&bull; ". $row[0] ."</td>
			</tr>";

	}

?>
</table>
<br/><br/>

