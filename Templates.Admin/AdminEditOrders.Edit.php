<?php
	renderActionsPanel(
		array(
			array(
				'href' => Command::GetRedirectUrl('AdminEditOrders'),
				'text' => '��������� � ������ �������'
			)
		)
	);
?>
<div class="tab-content">
	<div class="right"><a href="#">������ ��� ������</a></div>
	<br class="clear" />
	<h3>���������� � ������</h3>
	<hr />
	<form method="POST" action="<?= Command::GetRedirectUrl('AdminEditOrders', array('id' => $id)); ?>">
		������:&emsp;
		<select name="status_id">
			<option value="1">���������� �������</option>
			<option value="2">�������</option>
			<option value="3">�������������</option>
			<option value="4">���������</option>
		</select>
		<button type="submit">�������� ������</button>
		<script>
			$(function () {
				$('select').val(<?= $statusId; ?>);
			});
		</script>
	</form>
	<hr />
	<h3>������ ���������� �������</h3>
	<hr />
	<table class="data-output">
		<tr>
			<th width="150px" class="alleft">�������</th>
			<th width="150px" class="alleft">�����������</th>
			<th class="alleft">������������</th>
		</tr>	
		<?php
			foreach ($orderProducts as $orderProduct) {
		?>
			<tr>
				<td><?= $orderProduct['article']; ?></td>
				<td><?= $orderProduct['amount']; ?></td>
				<td><?= $orderProduct['title']; ?></td>
			</tr>
		<?php
			}
		?>
	</table>
	<hr />

	<script>
		$(function() {
			$('table').tableEditor();
		});
	</script>
</div>
