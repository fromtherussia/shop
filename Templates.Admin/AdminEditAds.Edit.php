<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetListUrl('AdminEditAds'),
				'text' => '¬ернутьс€ к списку объ€влений',
			)
		)
	);
?>
<div class="tab-content">
	<h3>–едактирование объ€влени€</h3>
	<hr />
	<?php
		$form->Render();
	?>
</div>
