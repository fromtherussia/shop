<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"> 
	<head> 
	<meta http-equiv="content-type" content="text/html;charset=windows-1251" /> 
		<title>��� ������� ����� � ������� - ������ �������������� - <?= $pageTitle; ?></title>
		<?php
			thirdPartyScriptIncludes();
			thirdPartyStyeIncludes();
		?>
		<script type="text/javascript" src="Lightcore/LightcoreJs.php"></script>
		<script type="text/javascript" src="PluginsJs.php"></script>
		<script type="text/javascript" src="Js/ckeditor/ckeditor.js"></script>
		<link rel="stylesheet" href="Lightcore/LightcoreCss.php" />
		<link rel="stylesheet" href="Css/AdminStyle.css" />
		<link rel="stylesheet" href="PluginsCss.php" />
	</head> 
<body>

<!-- Login info -->
<?php
	if ($userName) {
		$siteHref = Command::GetRedirectUrl('Catalog');
		$logoutHref = Command::GetRedirectUrl('AdminLogout');
?>
<div id="login-panel">
	<div class="left">
		<a target="_blank" href="<?= $siteHref; ?>">������� ����</a>
	</div>
	<div class="right">
		���� �������� ��� �������: <?php printText($userName); ?>&nbsp;(<a href="<?= $logoutHref; ?>">�����</a>)
	</div>
	<br class="clear" />
</div>
<div id="about-panel">
	<h1>��� ������� ����� � �������</h1>
	<h2><?= $pageTitle; ?></h2>
</div>
<?php
	$tabs = array(
		0 => array(
			'name' => '������',
			'highlighted' => 0,
			'url' => 'AdminEditProducts'),
		1 => array(
			'name' => '���������',
			'highlighted' => 0,
			'url' => 'AdminEditCategories'),
		2 => array(
			'name' => '�������������',
			'highlighted' => 0,
			'url' => 'AdminEditProducers'),
		3 => array(
			'name' => '���������� ��������',
			'highlighted' => 0,
			'url' => 'AdminEditWholesaleDiscounts'),
		4 => array(
			'name' => '�������������� �����',
			'highlighted' => 0,
			'url' => 'AdminEditNamedInfo'),
		5 => array(
			'name' => '������� / ������',
			'highlighted' => 0,
			'url' => 'AdminEditInfoPages'),
		6 => array(
			'name' => '����������',
			'highlighted' => 0,
			'url' => 'AdminEditAds'),
		7 => array(
			'name' => '�������',
			'highlighted' => 1,
			'url' => 'AdminEditClients'),
		8 => array(
			'name' => '������',
			'highlighted' => 1,
			'url' => 'AdminEditOrders')
	);
?>
<div id="tabs-panel">
	<?php
		$subsectionHref = '';
		foreach ($tabs as $tabNo => $tab) {
			$tabClass = $tab['highlighted'] ? ' highlighted' : ($tabNo == $tabNumber ? ' selected' : ' normal');
			$href = Command::GetRedirectUrl($tab['url']);
			if ($tabNo == $tabNumber) {
				$subsectionHref = $href;
			}
		?>
			<div class="left">
				<a href="<?= $href; ?>">
					<div class="tab<?= $tabClass; ?>">
						<div class="wrapper">
							<?= $tab['name'] ?>
						</div>
					</div>
				</a>
			</div>
		<?
		}
	?>
	<br class="clear" />
</div>
<?php
	}
?>

<!-- Content -->
<div id="tab-content">
	<!-- Error message -->
	<?php
		$template->RenderMessage();	
	?>
	
	<!-- Information banner -->
	<?php
		if ($showInfoBanner) {
	?>
	<div class="tab-bottom information">
		<script>
			function reloadPage() {
				window.location = window.location;
			}
		</script>		
		<span>
			���� ������� �� ������ �������, �� ����� ������ "���������" ����� ��������, �� ��� ������������� ��������� ����� ��������.<br />
			���� ��, ��������, ������ ������ �������� ��������� � ������� ���������� ���������� - <a href="#" onclick="reloadPage(); return false;">�������� �� ���� ������</a>.
		</span>
	</div>
	<?php 
		}
	?>
	
	<!-- Page content -->
	<?php
		$template->Render();
		renderIconsInit();
	?>
</div>
</body>