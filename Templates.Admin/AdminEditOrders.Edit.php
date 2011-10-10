<?php
	renderActionsPanel(
		array(
			array(
				'href' => Command::GetRedirectUrl('AdminEditOrders'),
				'text' => 'Вернуться к списку заказов'
			)
		)
	);
?>
<div class="tab-content">
	<div class="right"><a href="#">Версия для печати</a></div>
	<br class="clear" />
	<h3>Информация о заказе</h3>
	<hr />
	<form method="POST" action="<?= Command::GetRedirectUrl('AdminEditOrders', array('id' => $id)); ?>">
		Статус:&emsp;
		<select name="status_id">
			<option value="1">Проведение платежа</option>
			<option value="2">Оплачен</option>
			<option value="3">Комплектуется</option>
			<option value="4">Отправлен</option>
		</select>
		<button type="submit">Изменить статус</button>
		<script>
			$(function () {
				$('select').val(<?= $statusId; ?>);
			});
		</script>
	</form>
	<hr />
	<h3>Список заказанных товаров</h3>
	<hr />
	<table class="data-output">
		<tr>
			<th width="150px" class="alleft">Артикул</th>
			<th width="150px" class="alleft">Колличество</th>
			<th class="alleft">Наименование</th>
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
