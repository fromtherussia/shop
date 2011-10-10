<div class="tab-bottom information">
	Объявления, которые сегодня показываются посетителям, выделены зеленым цветом.
</div>
<?php
	renderActionsPanel(
		array(
			array(
				'href' => EditEntityCommand::GetAddUrl('AdminEditAds'),
				'text' => 'Добавить новое объявление'
			)
		)
	);
?>
<div class="tab-content">
	<h3>Список объявлений</h3>
	<hr />
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
	<table class="data-output">
		<tr>
			<th width="30px"></th>
			<th width="250px">Интервал демонстрации</th>
			<th>Название объявления</th>
		</tr>
		<?php
			foreach ($ads as $ad) {
				$id = $ad->Get('id');
				$deleteHref = EditEntityCommand::GetDeleteUrl('AdminEditAds', $id);
				$editHref = EditEntityCommand::GetEditUrl('AdminEditAds', $id);
				$name = $ad->Get('name');
				$fromDate = $ad->Get('from_date');
				$toDate = $ad->Get('to_date');
				
				//$class = $ad['showed'] ? 'showed' : $ad['showing'] ? 'showing' : 'will-be-shown';
				?>
				<tr>
					<td>
						<a href="<?= $deleteHref; ?>">
							<?php renderIconHref('ui-icon-closethick', $deleteHref); ?>
						</a>
					</td>
					<td>
						<?= formatDate($fromDate); ?>&nbsp;-&nbsp;<?= formatDate($toDate); ?>
					</td>
					<td>
						<a href="<?= $editHref; ?>" title="Нажмите для редактирования объявления"><?= $name; ?></a>
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
