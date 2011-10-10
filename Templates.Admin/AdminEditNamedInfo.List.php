<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetAddUrl('AdminEditNamedInfo'),
				'text' => 'Добавить информационный блок',
			)
		)
	);
?>
<div class="tab-content">
	<h3>Список информационных блоков</h3>
	<hr />
	<table class="data-output">
		<tr>
			<th width="30px"></th>
			<th width="500px">Расположение на сайте</th>
			<th>Название блока</th>
		</tr>
		<?php
			foreach ($namedArticles as $namedArticle) {
				$id = $namedArticle->Get('id');
				$deleteHref = EditEntityCommand::GetDeleteUrl('AdminEditNamedInfo', $id);
				$editHref = EditEntityCommand::GetEditUrl('AdminEditNamedInfo', $id);
				$name = $namedArticle->Get('name');
				$articleLocation = $articleLocations[$namedArticle->Get('article_location_id')]->Get('title');
				?>
				<tr>
					<td>
						<a href="<?= $deleteHref; ?>">
							<?= renderIconHref('ui-icon-closethick', $deleteHref); ?>
						</a>
					</td>
					<td>
						<?= $articleLocation; ?>
					</td>
					<td>
						<a href="<?= $editHref; ?>" title="Нажмите для редактирования информационного блока"><?= $name; ?></a>
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
<?php
	renderIconsInit();
?>
