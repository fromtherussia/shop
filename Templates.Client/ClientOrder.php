<h3>������ ���������� �������</h3>
<hr />
<table>
	<tr>
		<th class="alleft">�������</th>
		<th class="alleft">������������</th>
		<th class="alleft">�����������</th>
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