<table>
	<tr>
		<td id="panel-content">
			<?php
				$temlate->Render();
			?>
		</td>
		<td id="panel-links">
			<ul>
				<?php
					$cartHref = Command::GetRedirectUrl('ClientCart');
					$ordersHref = Command::GetRedirectUrl('ClientOrders');
					$contactsHref = Command::GetRedirectUrl('ClientContacts');
					$paymentInfoHref = Command::GetRedirectUrl('ClientPaymentInfo');
				?>
				<li>
					<a href="<?= $cartHref; ?>">��� ������� �����</a>
				</li>
				<li>
					<a href="<?= $ordersHref; ?>">��� ������</a>
				</li>
				<li>
					<a href="<?= $contactsHref; ?>">��� ���������� ����������</a>
				</li>
				<li>
					<a href="<?= $paymentInfoHref; ?>">���������� �� ������</a>
				</li>
			</ul>
		</td>
	</tr>
</table>