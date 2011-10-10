<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetListUrl('AdminEditInfoPages'),
				'text' => 'Вернуться к списку статей',
			)
		)
	);
?>
<div class="tab-content">
	<h3>Редактирование статьи</h3>
	<hr />
	<?php
		$form->Render();
	?>
</div>
