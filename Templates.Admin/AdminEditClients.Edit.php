<?php
	renderActionsPanel(
		array(
			array(
				'href' => Command::GetRedirectUrl('AdminEditClients'),
				'text' => '��������� � ������ ��������'
			)
		)
	);
?>
<div class="tab-content">
	<div class="right"><a href="#">������ ��� ������</a></div>
	<br class="clear" />
	<h3>���������� � �������</h3>
	<hr />
	<?php
		$type = $client->Get('organization_type');
		$name = $client->Get('name');
		$email = $client->Get('login');
		$phone = $client->Get('phone');
		$lastVisit = $client->Get('last_visit');
		$registered = $client->Get('registered');
	?>
	<table>
		<tr>
			<td width="300px">
				<?php
					switch ($type) {
						case 1:
							echo '��� ���. ����';
							break;
						case 2:
							echo '��� ��';
							break;
						case 3:
							echo '������������ �����������';
							break;
					}
				?>
			</td>
			<td><input value="<?= $name; ?>" size="60" /></td>
		</tr>
		<tr>
			<td>����������� �����</td>
			<td><?= $email; ?></td>
		</tr>
		<tr>
			<td>�������</td>
			<td><input value="<?= $phone; ?>" size="60" /></td>
		</tr>
		<tr>
			<td>���� ���������� ������</td>
			<td><?= formatDate($lastVisit); ?></td>
		</tr>
		<tr>
			<td>���� �����������</td>
			<td><?= formatDate($registered); ?></td>
		</tr>
		<tr>
			<td>������������</td>
			<td>��� (<a href="#">�������������</a>)</td>
		</tr>
		<?php
			if ($type > 1) {
		?>
		<tr>
			<td>����������� �����</td>
			<td><input value="<?= $client->Get('juridical_address'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>����</td>
			<td><input value="<?= $client->Get('ogrn'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>���</td>
			<td><input value="<?= $client->Get('inn'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>���</td>
			<td><input value="<?= $client->Get('kpp'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>����</td>
			<td><input value="<?= $client->Get('okpo'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>�������� �����</td>
			<td><input value="<?= $client->Get('mailing_address'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>���������� ����</td>
			<td><input value="<?= $client->Get('current_account'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>����������������� ����</td>
			<td><input value="<?= $client->Get('current_account'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>���</td>
			<td><input value="<?= $client->Get('bik'); ?>" size="60" /></td>
		</tr>
		<?php
			}
		?>
		<tr>
			<td>�����������</td>
			<td><textarea cols="50" rows="4" ><?= $client->Get('comments'); ?></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="��������� ����������" /></td>
		</tr>
	</table>
	<script>
		$(function() {
			$('table').tableEditor();
		});
	</script>
</div>
