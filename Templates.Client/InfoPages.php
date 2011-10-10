<style>
	#information-page-content {
		padding: 20px 10px;
	}
</style>
<div class="breadcrumbs">
	<?php
		echo "Разделы:&emsp;";
		$isFirst = true;
		foreach ($infoPages as $page) {
			if (!$isFirst) {
				echo ",&emsp;";
			}
			$isFirst = false;
			$href = getSectionHref($page->Get('info_section_id'), $page->Get('id'));
			$title = $page->Get('title');
			?>
				<a href="<?= $href; ?>"><?= $title; ?></a>
			<?php
		}
	?>
</div>
<div id="information-page-content">
	<?= $infoPage->Get('content'); ?>
</div>