<h3>Список заказанных товаров</h3>
<hr />
<table>
	<tr>
		<th class="alleft">Артикул</th>
		<th class="alleft">Наименование</th>
		<th class="alleft">Колличество</th>
	</tr>	
	<?php
		foreach ($orderProducts as $orderProduct) {
	?>
		<tr>
			<td><?= $orderProduct['article']; ?></td>
			<td><?= $orderProduct['title']; ?></td>
			<td><?= $orderProduct['amount']; ?></td>
		</tr>
	<?php
		}
	?>
</table>
<hr />