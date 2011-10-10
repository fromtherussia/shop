<?php
	renderActionsPanel(
		array(
			array(
				'href' => Command::GetRedirectUrl('AdminEditClients'),
				'text' => 'Вернуться к списку клиентов'
			)
		)
	);
?>
<div class="tab-content">
	<div class="right"><a href="#">Версия для печати</a></div>
	<br class="clear" />
	<h3>Информация о клиенте</h3>
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
							echo 'Имя физ. лица';
							break;
						case 2:
							echo 'ФИО ИП';
							break;
						case 3:
							echo 'Наименование организации';
							break;
					}
				?>
			</td>
			<td><input value="<?= $name; ?>" size="60" /></td>
		</tr>
		<tr>
			<td>Электронная почта</td>
			<td><?= $email; ?></td>
		</tr>
		<tr>
			<td>Телефон</td>
			<td><input value="<?= $phone; ?>" size="60" /></td>
		</tr>
		<tr>
			<td>Дата последнего визита</td>
			<td><?= formatDate($lastVisit); ?></td>
		</tr>
		<tr>
			<td>Дата регистрации</td>
			<td><?= formatDate($registered); ?></td>
		</tr>
		<tr>
			<td>Заблокирован</td>
			<td>Нет (<a href="#">заблокировать</a>)</td>
		</tr>
		<?php
			if ($type > 1) {
		?>
		<tr>
			<td>Юридический адрес</td>
			<td><input value="<?= $client->Get('juridical_address'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>ОГРН</td>
			<td><input value="<?= $client->Get('ogrn'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>ИНН</td>
			<td><input value="<?= $client->Get('inn'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>КПП</td>
			<td><input value="<?= $client->Get('kpp'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>ОКПО</td>
			<td><input value="<?= $client->Get('okpo'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>Почтовый адрес</td>
			<td><input value="<?= $client->Get('mailing_address'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>Рассчетный счет</td>
			<td><input value="<?= $client->Get('current_account'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>Корреспондентский счет</td>
			<td><input value="<?= $client->Get('current_account'); ?>" size="60" /></td>
		</tr>
		<tr>
			<td>БИК</td>
			<td><input value="<?= $client->Get('bik'); ?>" size="60" /></td>
		</tr>
		<?php
			}
		?>
		<tr>
			<td>Комментарии</td>
			<td><textarea cols="50" rows="4" ><?= $client->Get('comments'); ?></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value="Сохранить информацию" /></td>
		</tr>
	</table>
	<script>
		$(function() {
			$('table').tableEditor();
		});
	</script>
</div>
