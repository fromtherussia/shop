<div class="tab-content">
	<h3>������</h3>
	<hr />
	������ �����:&emsp;<input type="text" size="60" /><button>�����</button><br />
	<small>������ ����� ����� �� ������, �������, �������</small>
	<hr />
	<table class="data-output">
		<tr>
			<th class="alleft" width="150px"># ������</th>
			<th class="alleft" >������</th>
		</tr>
	<?php
		foreach ($orders as $order) {
			$id = $order['id'];
			$status = $order['title'];
			$href = Command::GetRedirectUrl('AdminEditOrders', array('id' => $id));
		?>
			<tr>
				<td><a href="<?= $href; ?>"><?= $id; ?></a></td>
				<td><?= $status; ?></td>
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
