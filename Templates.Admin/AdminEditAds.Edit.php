<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetListUrl('AdminEditAds'),
				'text' => '��������� � ������ ����������',
			)
		)
	);
?>
<div class="tab-content">
	<h3>�������������� ����������</h3>
	<hr />
	<?php
		$form->Render();
	?>
</div>
