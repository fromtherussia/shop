<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetListUrl('AdminEditNamedInfo'),
				'text' => 'Вернуться к списку информационных блоков',
			)
		)
	);
?>
<div class="tab-content">
	<h3>Редактирование информационного блока</h3>
	<hr />
	<?php
		$form->Render();
	?>
</div>
