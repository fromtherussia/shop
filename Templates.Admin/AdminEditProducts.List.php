<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetAddUrl('AdminEditProducts'),
				'text' => '�������� ����� �����'
			)
		)
	);
?>
<div class="tab-content">
	<h3>������ �������</h3>
	<hr />
	<table class="data-output">
		<tr>
			<th width="30px"></th>
			<th width="250px">��������</th>
			<th width="100px">�������</th>
			<th width="100px">����<br />(���.)</th>
			<th width="100px">����<br />(����.)</th>
			<th width="200px">���������</th>
			<th width="120px">����������<br />����������</th>
			<th>������� ��������</th>
		</tr>
		<?php
			foreach ($products as $product) {
				$id = $product->Get('id');
				$deleteHref = EditEntityCommand::GetDeleteUrl('AdminEditProducts', $id);
				$editHref = EditEntityCommand::GetEditUrl('AdminEditProducts', $id);
				$title = $product->Get('title') ? $product->Get('title') : '������ ��������';
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
						<a href="<?= $editHref; ?>" title="������� ��� �������������� ���������"><?= $title; ?></a>
					</td>
					<td>
						<?= $article; ?>
					</td>
					<td>
						<?= $priceWholesale; ?>���.
					</td>
					<td>
						<?= $priceRetail; ?>���.
					</td>
					<td>
						
					</td>
					<td>
						<?= $published ? '��' : '���'; ?>
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
