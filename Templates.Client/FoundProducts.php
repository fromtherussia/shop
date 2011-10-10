<?php
	foreach ($products as $product) {
		$href = getProductUrl($product['category_id'], $product['id']);
		echo "<a href=\"$href\">";
		echo $product['title'];
		echo "</a><br />";
	}
?>