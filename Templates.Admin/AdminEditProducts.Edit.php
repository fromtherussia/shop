<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetListUrl('AdminEditProducts'),
				'text' => 'Вернуться к списку товаров',
			)
		)
	);
?>
<div class="tab-content">
	<h3>Редактирование товара</h3>
	<hr />
	<?php
		$form->Render();
	?>
</div>
