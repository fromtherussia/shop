<div class="tab-content">
	<h3>Клиенты</h3>
	<hr />
	<?php
		$searchHref = EditEntityCommand::GetSearchUrl('AdminEditClients');
	?>
	<form method="POST" action="<?= $searchHref; ?>">
		Искать клиента:&emsp;<input type="text" name="search_query" size="60" /><button type="submit">искать</button><br />
	</form>
	<small>Поиск по имени, email, номеру телефона</small>
	<hr />
	<table class="data-output">
		<tr>
			<th>Имя</th>
			<th>Тип</th>
			<th>Электронная почта</th>
			<th width="170px">Телефон</th>
			<th width="150px">Оплаченых заказов</th>
			<th width="170px">Не оплаченых заказов</th>
			<th width="150px">Заблокирован</th>
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
								echo 'Физ. лицо';
								break;
							case 2:
								echo 'ИП';
								break;
							case 3:
								echo 'Юр. лицо';
								break;
						}
					?>
				</td>
				<td><?= $email; ?></td>
				<td><?= $phone; ?></td>
				<td>0</td>
				<td>0</td>
				<td>Нет</td>
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
