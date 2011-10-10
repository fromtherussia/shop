<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetListUrl('AdminEditInfoPages'),
				'text' => 'Вернуться к списку разделов',
			)
		)
	);
?>
<div class="tab-content">
	<h3>Редактирование раздела</h3>
	<hr />
	<?php
		$form->Render();
	?>
</div>
