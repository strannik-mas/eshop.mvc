<table border="1" cellpadding="5" cellspacing="0" width="100%">
	<tr>
	<?php foreach($this->params as $key => $item) { 
		echo '<td><a href="/index/catalog/'.($key+1).'">'.$item["name"].'</a></td>';
	}
	?>
	</tr>
</table>
