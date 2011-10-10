<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetAddUrl('AdminEditCategories'),
				'text' => '�������� ����� ���������'
			)
		)
	);
?>
<div class="tab-content">
	<h3>������ ���������</h3>
	<hr />
	<table class="data-output">
		<tr>
			<th width="30px"></th>
			<th width="200px">���������</th>
			<th width="200px">������������<br />���������</th>
			<th width="120px">����������<br />����������</th>
			<th width="120px">������������</th>
			<th width="120px">�������</th>
			<th>������� ��������</th>
		</tr>
		<?php
			foreach ($categories as $category) {
				$id = $category->Get('id');
				$deleteHref = EditEntityCommand::GetDeleteUrl('AdminEditCategories', $id);
				$editHref = EditEntityCommand::GetEditUrl('AdminEditCategories', $id);
				$title = $category->Get('title') ? $category->Get('title') : '������ ��������';
				$parentCategoryTitle = $category->GetParentCategoryTitle();
				$parentCategoryTitle = $parentCategoryTitle ? $parentCategoryTitle : '������ ��������';
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
						<a href="<?= $editHref; ?>" title="������� ��� �������������� ���������"><?= $title; ?></a>
					</td>
					<td>
						<?= $parentCategoryTitle; ?>
					</td>
					<td>
						<?= $published ? '��' : '���'; ?>
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
