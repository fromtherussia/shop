<h3>������</h3>
<hr />
<table>
	<tr>
		<th># ������</th>
		<th>������</th>
		<th></th>
	</tr>
	<?php
		foreach ($orderedProducts as $orderedProduct) {
			$orderHref = Command::GetRedirectUrl('ClientOrder', array('id' => $orderedProduct['id']));
	?>
		<tr>
			<td>5610-211<?= $orderedProduct['id']; ?></td>
			<td><?= $orderedProduct['title']; ?></td>
			<td>
				<a href="<?= $orderHref; ?>">������ ��������� �������</a>
			</td>
		</tr>
	<?php
		}
	?>
</table>
<hr />
<button onclick="window.location = window.location">�������� ������</button>