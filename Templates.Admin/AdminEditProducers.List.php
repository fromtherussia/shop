<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetAddUrl('AdminEditProducers'),
				'text' => '�������� ������ �������������'
			)
		)
	);
?>
<div class="tab-content">
	<h3>������ ��������������</h3>
	<hr />
	<table class="data-output">
		<tr>
			<th width="30px"></th>
			<th width="250px">�������� �������������</th>
			<th>�������� �������������</th>
		</tr>
		<?php
			foreach ($producers as $producer) {
				$id = $producer->Get('id');
				$deleteHref = EditEntityCommand::GetDeleteUrl('AdminEditProducers', $id);
				$editHref = EditEntityCommand::GetEditUrl('AdminEditProducers', $id);
				$title = $producer->Get('title');
				$shortDescription = $producer->Get('short_description');
				?>
				<tr>
					<td>
						<a href="<?= $deleteHref; ?>">
							<?= renderIconHref('ui-icon-closethick', $deleteHref); ?>
						</a>
					</td>
					<td>
						<a href="<?= $editHref; ?>" title="������� ��� �������������� �������������"><?= $title; ?></a>
					</td>
					<td>
						<span title="<?= $shortDescription; ?>"><?= limitString($shortDescription, 80); ?></span>
					</td>
				</tr>
				<?php
			}
		?>
	</table>
	<script>
		$(function() {
			$('table').tableEditor();
		});
	</script>
</div>
