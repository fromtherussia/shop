<style>
	#catalog-search {
		margin-bottom: 15px;
	}

	#catalog-search input {
		padding-left: 5px;
		font-size: 18px;
		height: 24px;
		width: 100%;
	}

	#catalog-search button {
		height: 30px;
		margin-left: 15px;
	}

	#categories-tree {
		width: 200px;
		border-right: 1px solid #000;
	}

	#catalog-content {
		padding-left: 20px;
		padding-right: 20px;
		padding-top: 10px;
		padding-bottom: 20px;
	}
	
	div.breadcrumbs {
		margin-bottom: 20px;
		padding: 10px;
		border: 1px dotted #ccc;
		line-height: 30px;
	}
	
	div.ad {
		margin-bottom: 20px;
		padding: 10px;
		border: 1px dotted #ccc;
	}
</style>
<div>
	<?php renderArticle('catalogTop'); ?>
</div>
<div class="ad">
	<?php
		echo Ad::GetRandomAd();
	?>
</div>
<div id="catalog-search">
	<?php
		$searchUrl = getSearchUrl();
	?>
	<script>
		function checkSearchRequest() {
			return $("#search-text").val().length > 0;
		}
	</script>
	<form method="POST" action="<?= $searchUrl; ?>" onsubmit="return checkSearchRequest();">
		<table>
			<tr>
				<td width="100%">
					<input id="search-text" name="q" value="<?= $search_text; ?>"/>
				</td>
				<td>
					<button type="submit">искать</button>
				</td>
			</tr>
		</table>
	</form>
</div>
<div class="breadcrumbs">
	<?php
		$href = getCatalogGeneralPage();
		echo "<a href=\"$href\">";
		echo "Каталог";
		echo "</a>";
		echo " / ";
		
		$categoriesPath = array();
		$isFirst = true;
		
		if (isset($opened_category)) {
			foreach ($path as $category) {
				if (!$isFirst) {
					echo ' / ';
				} else {
					$isFirst = false;
				}
				$href = getCategoryUrl($category['category_id']);
				echo "<a href=\"$href\">";
				echo firstUpper($category['title']);
				echo "</a>";
				$categoriesPath []= $category['category_id'];
			}
		}
		
		$opened_category = isset($opened_category) ? $opened_category : -1;
	?>
</div>
<div>
	<table>
		<tr>
			<td id="categories-tree">
				<?php
					render_treeview("tree", $categories_tree, $categoriesPath, $opened_category);
				?>
			</td>
			<td>
				<div id="catalog-content">
					<?php
						$page_template->Render();
					?>
				</div>
			</td>
		</tr>
	</table>
</div>
<div class="section-divider">&nbsp;</div>
<div>
	<table>
		<tr>
			<?php
				$catalogTailArticles = NamedArticle::GetArticlesByLocation('catalogTail');
				$articlesCount = count($catalogTailArticles);
				$counter = 0;
				foreach ($catalogTailArticles as $catalogTailArticle) {
					if ($counter == 0) {
						echo '<td width="50%">';
					}
					renderImportantInfo(
						$catalogTailArticle['name'],
						$catalogTailArticle['content'],
						2
					);
					$counter++;
					if ($counter == (int)($articlesCount / 2)) {
						echo '</td><td>';
					}
					if ($counter == $articlesCount) {
						echo '</td>';
					}
				}
			?>
		</tr>
	</table>
</div>