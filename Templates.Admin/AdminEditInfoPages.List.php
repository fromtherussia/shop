<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetEditUrl('AdminEditInfoSections', $id),
				'text' => 'Добавить новый раздел'
			),
			array(
				'href' => EditEntityCommand::GetEditUrl('AdminEditInfoPages', $id),
				'text' => 'Добавить новую статью'
			)
		)
	);
?>
<div class="tab-content">
	<style>
		tr.showed {
		}
		
		tr.showing {
			color: #062300;
			background-color: #e0ffda;
		}
		
		tr.will-be-shown {
		}
		
		td, th {
			padding: 10px;
		}
	</style>
	<h3>Список разделов</h3>
	<hr />
	<table class="data-output">
		<tr>
			<th width="30px"></th>
			<th width="100px">Приоритет</th>
			<th>Название раздела</th>
		</tr>
		<?php
			foreach ($infoSections as $infoSection) {
				$id = $infoSection->Get('id');
				$deleteHref = EditEntityCommand::GetDeleteUrl('AdminEditInfoSections', $id);
				$editHref = EditEntityCommand::GetEditUrl('AdminEditInfoSections', $id);
				$title = $infoSection->Get('title');
				$order = $infoSection->Get('order_no');
				?>
				<tr>
					<td>
						<a href="<?= $deleteHref; ?>">
							<?= renderIconHref('ui-icon-closethick', $deleteHref); ?>
						</a>
					</td>
					<td>
						<?= $order; ?>
					</td>
					<td>
						<a href="<?= $editHref; ?>" title="Нажмите для редактирования раздела"><?= $title; ?></a>
					</td>
				</tr>
				<?php
			}
		?>
	</table>
	
	<h3>Список статей</h3>
	<hr />
	<table class="data-output">
		<tr>
			<th width="30px"></th>
			<th width="100px">Приоритет</th>
			<th width="150px">Раздел</th>
			<th>Название статьи</th>
		</tr>
		<?php
			foreach ($infoPages as $infoPage) {
				$id = $infoPage->Get('id');
				$deleteHref = EditEntityCommand::GetDeleteUrl('AdminEditInfoPages', $id);
				$editHref = EditEntityCommand::GetEditUrl('AdminEditInfoPages', $id);
				$title = $infoPage->Get('title');
				$order = $infoPage->Get('order_no');
				$section = $infoPage->GetLinkedEntity('info_section_id')->Get('title');
				?>
				<tr>
					<td>
						<a href="<?= $deleteHref; ?>">
							<?= renderIconHref('ui-icon-closethick', $deleteHref); ?>
						</a>
					</td>
					<td>
						<?= $order; ?>
					</td>
					<td>
						<?= $section; ?>
					</td>
					<td>
						<a href="<?= $editHref; ?>" title="Нажмите для редактирования информационной статьи"><?= $title; ?></a>
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
