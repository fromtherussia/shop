<?php
	foreach ($categories as $category) {
		$href = getCategoryUrl($category['id']);
		echo "<a href=\"$href\">";
		echo $category['title'];
		echo "</a><br />";
	}
?>