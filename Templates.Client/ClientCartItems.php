<table>
	<tr>
		<th width="35px"></th>
		<th class="alleft" width="100px">�������</th>
		<th class="alleft" width="300px">��������</th>
		<th class="alleft" width="100px">����������</th>
		<th class="alleft" width="130px">���� �� ��.</th>
		<th class="alleft" width="130px">����� ����</th>
	</tr>
	<?php
		foreach ($products as $product) {
	?>
		<tr>
			<td>
				<div class="ui-state-default ui-corner-all icon" href="#">
					<div class="ui-icon ui-icon-closethick">&nbsp;</div>
				</div>
			</td>
			<td><?= $product['article']; ?></td>
			<td>
				<b><?= $product['title']; ?><br /></b>
				<i><?= $product['short_description']; ?></i>
			</td>
			<td><?= $product['amount']; ?></td>
			<td><?= $product['price_wholesale']; ?> ���.</td>
			<td><?= $product['amount'] * $product['price_wholesale']; ?> ���.</td>
		</tr>
	<?php
		}
	?>
	<tr>
		<td colspan="6">
			<hr />
		</td>
	</tr>
	<tr>
		<td colspan="4"></td>
		<td colspan="2" class="alright price-total">�����, ����: <?= $price; ?> ���.</td>
	</tr>
	<tr>
		<td colspan="4"></td>
		<td colspan="2" class="alright price-discounted">����, �� ������� <?= $precent; ?>%: <?= $priceDiscounted; ?> ���.</td>
	</tr>
</table>