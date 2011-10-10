<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetAddUrl('AdminEditProducts'),
				'text' => 'Добавить новый товар'
			)
		)
	);
?>
<div class="tab-content">
	<h3>Список товаров</h3>
	<hr />
	<table class="data-output">
		<tr>
			<th width="30px"></th>
			<th width="250px">Название</th>
			<th width="100px">Артикул</th>
			<th width="100px">Цена<br />(опт.)</th>
			<th width="100px">Цена<br />(розн.)</th>
			<th width="200px">Категория</th>
			<th width="120px">Показывать<br />покупателю</th>
			<th>Краткое описание</th>
		</tr>
		<?php
			foreach ($products as $product) {
				$id = $product->Get('id');
				$deleteHref = EditEntityCommand::GetDeleteUrl('AdminEditProducts', $id);
				$editHref = EditEntityCommand::GetEditUrl('AdminEditProducts', $id);
				$title = $product->Get('title') ? $product->Get('title') : 'Корень каталога';
				$article = $product->Get('article');
				$priceWholesale = $product->Get('price_wholesale');
				$priceRetail = $product->Get('price_retail');
				$priceWholesale = $priceWholesale ? $priceWholesale : 0;
				$priceRetail = $priceRetail ? $priceRetail : 0;
				$shortDescription = $product->Get('short_description');
				$published = $product->Get('published');
				?>
				<tr>
					<td>
						<a href="<?= $deleteHref; ?>">
							<?= renderIconHref('ui-icon-closethick', $deleteHref); ?>
						</a>
					</td>
					<td>
						<a href="<?= $editHref; ?>" title="Нажмите для редактирования категории"><?= $title; ?></a>
					</td>
					<td>
						<?= $article; ?>
					</td>
					<td>
						<?= $priceWholesale; ?>руб.
					</td>
					<td>
						<?= $priceRetail; ?>руб.
					</td>
					<td>
						
					</td>
					<td>
						<?= $published ? 'да' : 'нет'; ?>
					</td>
					<td>
						<span title="<?= $shortDescription; ?>"><?= limitString($shortDescription, 40); ?></span>
					</td>
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
