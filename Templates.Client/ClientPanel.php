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
					<a href="<?= $cartHref; ?>">Мой текущий заказ</a>
				</li>
				<li>
					<a href="<?= $ordersHref; ?>">Все заказы</a>
				</li>
				<li>
					<a href="<?= $contactsHref; ?>">Моя контактная информация</a>
				</li>
				<li>
					<a href="<?= $paymentInfoHref; ?>">Информация по оплате</a>
				</li>
			</ul>
		</td>
	</tr>
</table>