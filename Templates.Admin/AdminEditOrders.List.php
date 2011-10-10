<div class="tab-content">
	<h3>Заказы</h3>
	<hr />
	Искать заказ:&emsp;<input type="text" size="60" /><button>поиск</button><br />
	<small>Искать заказ можно по номеру, клиенту, статусу</small>
	<hr />
	<table class="data-output">
		<tr>
			<th class="alleft" width="150px"># Заказа</th>
			<th class="alleft" >Статус</th>
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
