<?php

function thirdPartyScriptIncludes($prefix = 'ThirdParty/') {
?>
	<script type="text/javascript" src="<?= $prefix; ?>jquery/jquery.js"></script>
	<script type="text/javascript" src="<?= $prefix; ?>jquery/jquery-ui.datepicker-ru.js"></script>
	<script type="text/javascript" src="<?= $prefix; ?>jquery/jquery.treeview.js"></script>
	<script type="text/javascript" src="<?= $prefix; ?>jquery/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?= $prefix; ?>jquery/jquery-ui.js"></script>
	<!-- Redactor (wysiwyg) -->
	<script type="text/javascript" src="<?= $prefix; ?>redactor/js/redactor/redactor.js"></script>
	<!-- TipTip (tooltip) -->
	<script type="text/javascript" src="<?= $prefix; ?>tiptip/jquery.tipTip.minified.js"></script>
	<!-- Captify (tooltip under image) -->
	<script type="text/javascript" src="<?= $prefix; ?>captify/captify.js"></script>
	<!-- In field label -->
	<script type="text/javascript" src="<?= $prefix; ?>infieldlabel/jquery.infieldlabel.min.js"></script>
<?php
}

function thirdPartyStyeIncludes($prefix = 'ThirdParty/') {
?>
	<link rel="stylesheet" href="<?= $prefix; ?>jquery/jquery-ui.css" />
	<!-- Redactor (wysiwyg) -->
	<link rel="stylesheet" href="<?= $prefix; ?>redactor/js/redactor/css/redactor.css" />
	<!-- TipTip (tooltip) -->
	<link rel="stylesheet" href="<?= $prefix; ?>tiptip/tipTip.css" />
	<!-- Captify (tooltip under image) -->
	<link rel="stylesheet" href="<?= $prefix; ?>captify/sample.css" />
	<!-- In field label -->
	<link rel="stylesheet" href="<?= $prefix; ?>infieldlabel/jquery.infieldlabel.css" />
<?php
}

function renderTextEditor($id, $content, $height) {
?>
	<textarea id="<?= $id; ?>" name="<?= $id; ?>" style="width: 100%; height: <?= $height; ?>px;"><?= $content; ?></textarea>
<?php
}

function renderTipTip($selector) {
?>
	<script>
		$(function() {
			$('<?= $selector; ?>').tipTip();
		});
	</script>
<?php
}

?>