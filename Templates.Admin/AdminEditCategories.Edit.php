<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetListUrl('AdminEditCategories'),
				'text' => 'Вернуться к списку категорий',
			)
		)
	);
?>
<div class="tab-content">
	<h3>Редактирование категории</h3>
	<hr />
	<?php
		$form->Render();
	?>
</div>
