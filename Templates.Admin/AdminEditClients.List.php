<div class="tab-content">
	<h3>�������</h3>
	<hr />
	<?php
		$searchHref = EditEntityCommand::GetSearchUrl('AdminEditClients');
	?>
	<form method="POST" action="<?= $searchHref; ?>">
		������ �������:&emsp;<input type="text" name="search_query" size="60" /><button type="submit">������</button><br />
	</form>
	<small>����� �� �����, email, ������ ��������</small>
	<hr />
	<table class="data-output">
		<tr>
			<th>���</th>
			<th>���</th>
			<th>����������� �����</th>
			<th width="170px">�������</th>
			<th width="150px">��������� �������</th>
			<th width="170px">�� ��������� �������</th>
			<th width="150px">������������</th>
		</tr>
	<?php
		foreach ($clients as $client) {
			$name = $client->Get('name');
			$email = $client->Get('login');
			$phone = $client->Get('phone');
			$type = $client->Get('organization_type');
			$href = Command::GetRedirectUrl('AdminEditClients', array('id' => $client->Get('id')));
		?>
			<tr>
				<td><a href="<?= $href; ?>"><?= limitString($name, 30); ?></a></td>
				<td>
					<?php
						switch ($type) {
							case 1:
								echo '���. ����';
								break;
							case 2:
								echo '��';
								break;
							case 3:
								echo '��. ����';
								break;
						}
					?>
				</td>
				<td><?= $email; ?></td>
				<td><?= $phone; ?></td>
				<td>0</td>
				<td>0</td>
				<td>���</td>
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
