Найденые товары:
<div style="border: 1px solid black">
	<div id="found_products">
		<?php
			$found_products_template->Render();
		?>
	</div>
	<script>
		var productsLowerLimit = <?= $products_lower_limit; ?>;
		var productsPerPage = <?= CATALOG_FOUND_PRODUCTS_PER_PAGE; ?>;
		var productsLocked = false;
		
		function setEnabledState(showPageControlId, state) {
			if (state) {
				$('#' + showPageControlId).addClass();
			} else {
				$('#' + showPageControlId).addClass();
			}
		}
		function searchProducts() {
			searchText = '<?= $search_text; ?>';
			urlStr = '<?= Command::GetRedirectUrl('GetSearchResults'); ?>';
			urlStr += '&tp=' + 'products' + '&ll=' + productsLowerLimit + '&ul=' + (productsLowerLimit + productsPerPage) + '&q=' + searchText;
			
			productsLocked = true;
			$.ajax({
				url: urlStr,
				success: function(data){
					productsLocked = false;
					if (data == "") {
						$('#found_products').html("Результаты не найдены");
					} else {
						$('#found_products').html(data);
					}
				},
				error: function() {
					productsLocked = false;
				}
			});
		}
		function previousProducts() {
			if (productsLocked) {
				return;
			}
			if (productsLowerLimit > 0) {
				productsLowerLimit -= productsPerPage;
			}
			searchProducts();
		}
		function nextProducts() {
			if (productsLocked) {
				return;
			}
			productsLowerLimit += productsPerPage;
			searchProducts();
		}
		$(function() {
			setEnabledState('show_previous_products', false);
			setEnabledState('show_next_products', true);
		});
	</script>
	<div>
		<a href="#" id="show_previous_products" onclick="previousProducts(); return false;">Назад</a>
		<a href="#" id="show_next_products" onclick="nextProducts(); return false;">Вперед</a>
	</div>
</div>
Найденые категории:
<div style="border: 1px solid black">
	<div id="found_categories">
		<?php
			$found_categories_template->Render();
		?>
	</div>
	<script>
		var categoriesLowerLimit = <?= $categories_lower_limit; ?>;
		var categoriesPerPage = <?= CATALOG_FOUND_CATEGORIES_PER_PAGE; ?>;
		var categoriesLocked = false;
		
		function setEnabledState(showPageControlId, state) {
			if (state) {
				$('#' + showPageControlId).addClass();
			} else {
				$('#' + showPageControlId).addClass();
			}
		}
		function searchCategories() {
			searchText = '<?= $search_text; ?>';
			urlStr = '<?= Command::GetRedirectUrl('GetSearchResults'); ?>';
			urlStr += '&tp=' + 'categories' + '&ll=' + categoriesLowerLimit + '&ul=' + (categoriesLowerLimit + categoriesPerPage) + '&q=' + searchText;
			categoriesLocked = true;
			$.ajax({
				url: urlStr,
				success: function(data){
					categoriesLocked = false;
					if (data == "") {
						$('#found_categories').html("Результаты не найдены");
					} else {
						$('#found_categories').html(data);
					}
				},
				error: function() {
					categoriesLocked = false;
				}
			});
		}
		function previousCategories() {
			if (categoriesLocked) {
				return;
			}
			if (categoriesLowerLimit > 0) {
				categoriesLowerLimit -= categoriesPerPage;
			}
			searchCategories();
		}
		function nextCategories() {
			if (categoriesLocked) {
				return;
			}
			categoriesLowerLimit += categoriesPerPage;
			searchCategories();
		}
		$(function() {
			setEnabledState('show_previous_categories', false);
			setEnabledState('show_next_categories', true);
		});
	</script>
	<div>
		<a href="#" id="show_previous_categories" onclick="previousCategories(); return false;">Назад</a>
		<a href="#" id="show_next_categories" onclick="nextCategories(); return false;">Вперед</a>
	</div>
</div>