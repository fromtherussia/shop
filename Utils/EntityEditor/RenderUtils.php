<?php

function renderEntitiesListPage($commandName, $searchRequest, $actionsList, $pager, $renderColumns, $entities, $totalEntitiesCount) {
	?>
	
	<!-- Actions panel -->
	<div class="tab-actions">
		<?php
			foreach ($actionsList as $action) {
				$actionTitle = $action['title'];
				$actionHref = $action['href'];
				?>
				<a href="<?= $actionHref; ?>"><?= $actionTitle; ?></a>
				<?php
			}
		?>
	</div>
	
	<!-- Search form -->
	<form method="post" action="<?= Command::GetRedirectUrl($commandName, array('act' => 'list')); ?>" id="search-form">
		<div class="search-panel">
			Искать:&nbsp;
			<input type="text" id="<?= returnText($commandName) ?>_search_request" name="<?= returnText($commandName); ?>_search_request" size="50" value="<?= returnText($searchRequest); ?>" />
			<button type="submit">Искать</button>
			<button type="button" onclick="clearSearch();">Очистить</button>
			<script>
				function clearSearch() {
					$('#<?php printText($commandName) ?>_search_request').val('');
					$('#search-form').submit();
				}
			</script>
		</div>
	</form>

	<!-- Statistics -->
	<div class="pager-statistics">
		<h5>
			Объектов на странице: <?= count($entities); ?>, всего: <?= $totalEntitiesCount; ?>
		</h5>
	</div>
	
	<!-- Pager -->
	<?php
		if ($pager) {
			$pager->render('changePage');
		?>
		<script>		
			function changePage(pageNo) {
					window.location.reload();
			}
		</script>
		<?php
		}
	?>
	
	<!-- Scroll -->
	<div id="top-scroll-container" style="height: 20px; overflow: scroll; overflow-y: hidden;">
		<div id="top-scroll" style="">&nbsp;</div>
	</div>
	<script>
		function addScroll() {
			var topScroll = $("#top-scroll-container");
			var bottomScroll = $("#entities-list");
			$("#top-scroll").width($("#list-items").width() + "px");
			bottomScroll.bind(
				"scroll", 
				function() {
					topScroll.scrollLeft(bottomScroll.scrollLeft());
				}
			);
			topScroll.bind (
				"scroll", 
				function() {
					bottomScroll.scrollLeft(topScroll.scrollLeft());
				}
			);
		}
		$(function() {
			addScroll();
		});
	</script>
	
	<!-- Entities list -->
	<div id="entities-list" class="entities-list">
		<form method="post" action="<?= Command::GetRedirectUrl($commandName, array('act' => 'list')); ?>" id="list-form">
			<table id="list-items" width="100%">
				<?php
					if (count($entities) == 0) {
						echo "<tr><td>Поиск не дал результатов</td></tr>";
					} else {
						// Header rendering
						echo "<tr>";
						foreach ($renderColumns as $renderColumn) {
							$columnHeader = $renderColumn['column_header'];
							echo "<th nowrap=\"nowrap\">$columnHeader</th>";
						}
						echo '</tr>';
						
						// Data rendering
						$rowNo = 0;
						foreach ($entities as $entity) {
							echo "<tr class=\"r$rowNo\">";
							foreach ($renderColumns as $renderColumn) {
								if (array_key_exists('cell_renderer', $renderColumn)) {
									$cellRendererFunction = $renderColumn['cell_renderer'];
									$argsValues = array();
									foreach ($renderColumn['cell_renderer_args'] as $rendererArgName) {
										$argsValues[] = returnText($entity[$rendererArgName]);
									}
									$cellRenderer = $cellRendererFunction  . '("' . implode($argsValues, '","') . '");';
									echo '<td>';
									eval($cellRenderer);
									echo '</td>';
								} else {
									$fieldName = $renderColumn['field_name'];
									echo '<td nowrap="nowrap">' . returnText($entity[$fieldName]) . '</td>';
								}
							}
							$rowNo = $rowNo == 0 ? 1 : 0;
							echo '</tr>';
						}
					}
				?>
			</table>
		</form>
	</div>
	<?php
}

/**
	actionsList: 
		array (
			array (
				'title' => ...,
				'href' => ...
			),
			...
		)
	
	rowList:
		array (
			array (
				'title' => '...'
				[optional]
				'field_name' => '...'
				or
				'input_render' => '...'
				'input_render_args' => array (
					entity_some_field_name,
					...
				)
			),
			...
		)
*/
function renderEntityPage($commandName, $actionsList, $rowsList, $entity, $isEditMode) {
	?>
	<div class="tab-actions">
		<?php
			foreach ($actionsList as $action) {
				$actionTitle = $action['title'];
				$actionHref = $action['href'];
				?>
				<a href="<?= $actionHref; ?>"><?= $actionTitle; ?></a>
				<?php
			}
		?>
	</div>
	
	
	<div class="entity-information">
		<?php 
			if ($isEditMode) {
				$href = Command::GetRedirectUrl($commandName, array('act' => 'save'));
		?>
		<form id="entity_editor" method="post" action="<?= $href; ?>">
		<?php
			} 
		?>
			<table>
				<tr>
					<th width="200"></th>
					<th></th>
				</tr>
			<?php
				function getParam($paramName, $entity) {
					if ($entity) {
						if (array_key_exists($paramName, $entity)) {
							return $entity[$paramName];
						}
					}
					if (array_key_exists($paramName, $_POST)) {
						return $_POST[$paramName];
					}
					return "";
				}
				
				foreach($rowsList as $row) {
					$headerTitle = $row['title'];
					echo '<tr>';
					if (count($row) == 1) {
						echo '<td colspan="2"><h3>' . returnText($headerTitle) . '</h3></td>';
					} else {
						echo '<td><label>' . returnText($headerTitle) . ':</label></td>';
						if (array_key_exists('input_renderer', $row)) {
							$inputRendererFunction = $row['input_renderer'];
							$argsValues = array();
							foreach ($row['input_renderer_args'] as $fieldName) {
								$argsValues[] = getParam($fieldName, $entity);
							}
							echo '<td>';
							call_user_func_array($inputRendererFunction, $argsValues);
							echo '</td>';
						} else {
							$fieldName = $row['field_name'];
							$fieldValue = getParam($fieldName, $entity);
							echo '<td>' . returnText($fieldValue) . '</td>';
						}
					}
					echo '</tr>';
				}
			?>
			<?php if($isEditMode) { ?>
			<tr>
				<td>
				</td>
				<td>
					<button type="submit">Сохранить</button>
				</td>
			</tr>
			<?php } ?>
			</table>
		<?php if ($isEditMode) { ?>
		</form>
		<?php } ?>
	</div>
	<?php
}

?>