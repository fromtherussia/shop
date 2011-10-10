<?php

include "Cart.php";
// Client

function getCategoryUrl($categoryId) {
	return Command::GetRedirectUrl('Catalog', array('act' => 'subcategories-list', 'cat' => $categoryId));
}

function getProductUrl($categoryId, $productId) {
	return Command::GetRedirectUrl('Catalog', array('act' => 'product-info', 'prod' => $productId, 'cat' => $categoryId));
}

function getSearchUrl() {
	return Command::GetRedirectUrl('Catalog', array('act' => 'search'));
}

function getSectionHref($sectionId, $pageId = -1) {
	return Command::GetRedirectUrl('Section', array('sec' => $sectionId, 'pid' => $pageId));
}

function getCatalogGeneralPage() {
	return Command::GetRedirectUrl('Catalog');
}

function getAboutGeneralPage() {
	return Command::GetRedirectUrl('CompanyInfo');
}

function getClientLoginUrl() {
	return Command::GetRedirectUrl('ClientLogin');
}

function getClientCartUrl() {
	return Command::GetRedirectUrl('ClientCart');
}

function wrapClientPanelTemplate($pageTitle, $template) {
	$panelTemplate = new Template('ClientPanel');
	$panelTemplate->SetParam('temlate', $template);
	wrapSubpageTemplate($pageTitle, 1, $panelTemplate)->Render();
}

function wrapSubpageTemplate($pageTitle, $sectionNo, $template) {
	$pageTemplate = new Template('Site');
	
	$infoSection = new InfoSection();
	$pageTemplate->SetParam('pageTitle', $pageTitle);
	$pageTemplate->SetParam('sections', $infoSection->Enumerate());
	$pageTemplate->SetParam('template', $template);
	// Articles
	$pageTemplate->SetParam('importantInfoArticles', NamedArticle::GetArticlesByLocation('importantInfo'));
	$pageTemplate->SetParam('contactInfoArticles', NamedArticle::GetArticlesByLocation('contactInfo'));
	$pageTemplate->SetParam('footerArticlesLeft', NamedArticle::GetArticlesByLocation('footerInfoLeft'));
	$pageTemplate->SetParam('footerArticlesRight', NamedArticle::GetArticlesByLocation('footerInfoRight'));
	return $pageTemplate;
}

function renderImportantInfo($header, $text, $importantWeight = 1) {
?>
	<div class="notice notice-i<?= $importantWeight; ?>">
		<table>
			<tr>
				<td class="header" colspan="2">
					<h1><?= $header; ?>:</h1>
					<hr>&nbsp;</hr>
				</td>
			</tr>
			<tr>
				<td class="hand"></td>
				<td class="info"><?= $text; ?></td>
			</tr>
		</table>
	</div>
<?php
}

function renderBlockDivider() {
?>
	<div class="block-divider-spacing">
		<table class="fill">
			<tr>
				<td>
					<div class="block-divider-left">&nbsp;</div>
				</td>
				<td class="fill">
					<div class="block-divider-fill">&nbsp;</div>
				</td>
				<td>
					<div class="block-divider-right">&nbsp;</div>
				</td>
			</tr>
		</table>
	</div>
<?php
}

function beginRenderBorderedContent() {
?>
	<table class="fill">
		<tr>
			<td class="border-left-fill">
				<div class="border-fill">&nbsp;</div>
			</td>
			<td class="with-bg fill">
<?php
}

function endRenderBorderedContent() {
?>

			</td>
			<td class="border-right-fill">
				<div class="border-fill">&nbsp;</div>
			</td>
		</tr>
	</table>
<?php
}

// Manager

function renderImageUpload($id, $selectImageCallback) {
	$browserId = 'LCImageBrowser' . $id;
	$uploaderId = 'LCImageUploader' . $id;
?>
	<div id="<?= $browserId; ?>">&nbsp;</div>
	<div id="<?= $uploaderId; ?>">&nbsp;</div>
	<script>
		$(function() {
			var browser;
			
			function uploadCallback() {
				browser.updateImages();
			}
			
			browser = $('#<?= $browserId; ?>').imageBrowser({
				'url': 'admin.php<?= Command::GetRedirectUrl('ImagesList'); ?>',
				'selectCallback': <?= $selectImageCallback; ?>
			});
			browser.updateImages();
			
			$('#<?= $uploaderId; ?>').imageUploader({
				'url': 'admin.php<?= Command::GetRedirectUrl('UploadImage'); ?>',
				'uploadCallback': uploadCallback
			});
		});
	</script>
<?
}

function wrapAdminTemplate($pageTitle, $tabNumber, $template, $showInfoBanner = false) {
	$pageTemplate = new Template('Admin');
	
	$user = new User();
	if ($user->RestoreFromSession()) {
		$userInfo = $user->GetInfo();
		$userName = isExists('login', $userInfo) ? $userInfo['login'] : 'Неизвестный Пользователь';
	}
	$pageTemplate->SetParam('userName', $userName);
	$pageTemplate->SetParam('tabNumber', $tabNumber);
	$pageTemplate->SetParam('template', $template);
	$pageTemplate->SetParam('pageTitle', $pageTitle);
	$pageTemplate->SetParam('showInfoBanner', $showInfoBanner);
	return $pageTemplate;
}

function renderIconHref($class, $href) {
?>
	<a class="ui-state-default ui-corner-all icon" href="<?= $href; ?>">
		<div class="ui-icon ui-corner-all <?= $class; ?>">&nbsp;</div>
	</a>
<?php
}

function renderIconClick($class, $clickHandler) {
?>
	<a class="ui-state-default ui-corner-all icon" onclick="<?= $clickHandler; ?>(); return false;" href="#">
		<div class="ui-icon <?= $class; ?>">&nbsp;</div>
	</a>
<?php
}

function renderIconsInit() {
?>
	<script>
		$(function() {
			$('a.icon').hover(
				function() { $(this).addClass('ui-state-hover'); }, 
				function() { $(this).removeClass('ui-state-hover'); }
			);
		});
	</script>
<?php
}

function renderArticle($articleName) {
	$article = NamedArticle::GetArticlesByLocation($articleName);
	foreach ($article as $articleItem) {
		echo $articleItem['content'];
	}
}

function renderActionsPanel($actions) {
	?>
		<div class="tab-bottom normal">
			<?php
				$isFirst = true;
				foreach ($actions as $action) {
					if (!$isFirst) {
						echo '&nbsp;|&nbsp;';
					}
					$isFirst = false;
					$href = $action['href'];
					$text = $action['text'];
					$onclick = isExists('onclick', $action) ? 'onclick="' . $action['onclick'] . '();"' : '';
					?>
						<a href="<?= $href; ?>" <?= $onclick; ?>><?= $text; ?></a>
					<?php
				}
			?>
		</div>
	<?php
}
