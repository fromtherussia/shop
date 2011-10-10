<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"> 
	<head> 
	<meta http-equiv="content-type" content="text/html;charset=windows-1251" /> 
		<title>Мир Рыбалки Охоты и Туризма - <?= $pageTitle; ?></title>
		<?php
			thirdPartyScriptIncludes();
			thirdPartyStyeIncludes();
		?>
		<script type="text/javascript" src="Lightcore/LightcoreJs.php"></script>
		<script type="text/javascript" src="PluginsJs.php"></script>
		<link rel="stylesheet" href="Lightcore/LightcoreCss.php" />
		<link rel="stylesheet" href="Css/ClientStyle.css" />
		<link rel="stylesheet" href="PluginsCss.php" />
		<style>
			tr {
				vertical-align: top;
			}
		</style>
	</head> 
<body>

<div id="user-bar">
	<div class="wrapper">
		<div id="cart" class="left">
			<?php
				$loginUrl = getClientCartUrl();
			?>
			<b>В Вашем <a href="#">заказе</a> 0 позиций</b>,&nbsp;<a href="<?= $loginUrl; ?>"> получить выбранные товары</a>
		</div>
		<br class="clear" />
	</div>
</div>
	
<div id="site">
	
	<div id="header">
		<table id="links" class="top">
			<tr>
				<td class="head" width="105px">
					<table>
						<tr>
							<td class="small-venzel-left">&nbsp;</td>
							<td width="16px"><div class="border-top-fill">&nbsp;</div></td>
						</tr>
					</table>
					<table>
						<tr>
							<td width="22px">&nbsp;</td>
							<td class="links-left">&nbsp;</td>
							<td width="22px" class="links-fill with-bg">&nbsp;</td>
						</tr>
					</table>
				</td>
				<td class="head">
					<table>
						<tr>
							<td class="border-top-fill"><div class="border-top-fill">&nbsp;</div></td>
							<td class="large-venzel-left">&nbsp;</td>
						</tr>
						<tr>
							<td class="links links-fill with-bg" colspan="2">
								<?php
									$aboutCompanyHref = getAboutGeneralPage();
									$catalogHref = getCatalogGeneralPage();
								?>
								<div class="links-wrapper">
									<a class="info-page-link" href="<?= $aboutCompanyHref; ?>">Как нас найти</a>
									<a class="info-page-link" href="<?= $catalogHref; ?>">Каталог</a>
									<a class="info-page-link" href="<?= $catalogHref; ?>">Прайс</a>
								</div>
							</td>
						</tr>
					</table>
				</td>
				<td class="logo head" width="233px">&nbsp;</td>
				<td class="head">
					<table>
						<tr>
							<td class="large-venzel-right">&nbsp;</td>
							<td class="border-top-fill"><div class="border-top-fill">&nbsp;</div></td>
						</tr>
						<tr>
							<td class="links links-fill with-bg" colspan="2">
								<div class="links-wrapper">
									<?php
										foreach ($sections as $section) {
											$href = getSectionHref($section->Get('id'));
											$title = $section->Get('title');
									?>
										<a class="info-page-link" href="<?= $href; ?>"><?= $title; ?></a>
									<?php
										}
									?>
								</div>
							</td>
						</tr>
					</table>
				</td>
				<td class="head" width="95px">
					<table>
						<tr>
							<td width="36px"><div class="border-top-fill">&nbsp;</div></td>
							<td class="small-venzel-right">&nbsp;</td>
						</tr>
					</table>
					<table>
						<tr>
							<td width="22px" class="links-fill with-bg">&nbsp;</td>
							<td class="links-right">&nbsp;</td>
							<td width="22px"></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		
		<div class="content-spacing">
			<table class="fill">
				<tr>
					<td class="border-left-fill">
						<div class="border-fill">&nbsp;</div>
					</td>
					<td class="with-bg with-opacity fill">
						<hr class="double">&nbsp;</hr>
						<table>
							<tr>
								<td class="important-info">
									<?php
										foreach ($importantInfoArticles as $importantInfoArticle) {
											renderImportantInfo(
												$importantInfoArticle['name'],
												$importantInfoArticle['content'],
												1
											);
										}
									?>
								</td>
								<td class="phones">
									<?php
										foreach ($contactInfoArticles as $contactInfoArticle) {
											echo $contactInfoArticle['content'];
										}
									?>
								</td>
							</tr>
						</table>
						<hr class="double">&nbsp;</hr>
					</td>
					<td class="border-right-fill">
						<div class="border-fill">&nbsp;</div>
					</td>
				</tr>
			</table>
		</div>
		
	</div>
	
	<?php renderBlockDivider(); ?>
	
	<div id="content">
		<?php beginRenderBorderedContent(); ?>
			<div class="content-wrapper">
				<?php
					$template->Render();
				?>
			</div>
		<?php endRenderBorderedContent(); ?>
	</div>
	
	<?php renderBlockDivider(); ?>

	<div id="footer">
		<?php beginRenderBorderedContent(); ?>
			<div class="content-wrapper">
				<div class="left alleft">
					<?php
						foreach ($footerArticlesLeft as $footerArticleLeft) {
							echo $footerArticleLeft['content'];
						}
					?>
				</div>
				<div class="right alright">
					<?php
						foreach ($footerArticlesRight as $footerArticleRight) {
							echo $footerArticleRight['content'];
						}
					?>
				</div>
				<br class="clear" />
			</div>
		<?php endRenderBorderedContent(); ?>
	</div>
</div>
</body>