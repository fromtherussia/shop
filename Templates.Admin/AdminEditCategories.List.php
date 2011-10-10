<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetAddUrl('AdminEditCategories'),
				'text' => 'Добавить новую категорию'
			)
		)
	);
?>
<div class="tab-content">
	<h3>Список категорий</h3>
	<hr />
	<table class="data-output">
		<tr>
			<th width="30px"></th>
			<th width="200px">Категория</th>
			<th width="200px">Родительская<br />категория</th>
			<th width="120px">Показывать<br />покупателю</th>
			<th width="120px">Подкатегорий</th>
			<th width="120px">Товаров</th>
			<th>Краткое описание</th>
		</tr>
		<?php
			foreach ($categories as $category) {
				$id = $category->Get('id');
				$deleteHref = EditEntityCommand::GetDeleteUrl('AdminEditCategories', $id);
				$editHref = EditEntityCommand::GetEditUrl('AdminEditCategories', $id);
				$title = $category->Get('title') ? $category->Get('title') : 'Корень каталога';
				$parentCategoryTitle = $category->GetParentCategoryTitle();
				$parentCategoryTitle = $parentCategoryTitle ? $parentCategoryTitle : 'Корень каталога';
				$countProducts = $category->GetProductsCount();
				$countSubcategories = $category->GetSubcategoriesCount();
				$shortDescription = $category->Get('short_description');
				$published = $category->Get('published');
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
						<?= $parentCategoryTitle; ?>
					</td>
					<td>
						<?= $published ? 'да' : 'нет'; ?>
					</td>
					<td>
						<?= $countSubcategories; ?>
					</td>
					<td>
						<?= $countProducts; ?>
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
