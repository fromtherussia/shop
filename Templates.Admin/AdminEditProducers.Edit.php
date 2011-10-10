<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetListUrl('AdminEditProducers'),
				'text' => 'Вернуться к списку производителей',
			)
		)
	);
?>
<div class="tab-content">
	<h3>Редактирование производителя</h3>
	<hr />
	<?php
		$form->Render();
	?>
</div>
