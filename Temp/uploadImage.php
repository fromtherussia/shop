<?php

include "config.hc.php";

session_start();
header("content-type: text/html;charset=windows-1251");

define("GLOBAL_eRROR_TEXT_SESSION_KEY", "global_error");

define("COMMAND_PARAM_NAME", "cmd");
define("COMMANDS_DIRECTORY", "Commands");
define("USER_TABLE_NAME", "shop.users");
define("ERROR_LOG_NAME", "errors.txt");

define("TEMPLATE_DEFAULT_COUNT_SYMBOLS", 60);
define("TEMPLATE_DEFAULT_COUNT_ROWS", 2);
define("TEMPLATES_DIRECTORY", "Templates");

include "Lightcore/LightcorePhp.php";
include "EntityEditor/EntityEditor.php";
include "DataAccess/DataAccess.php";
include "RenderUtils/RenderUtils.php";
include "Utils/Utils.php";

setSchema("shop");

ImageUploader::SetImagesPath('UploadedImages');

//printreturnText($_POST);

$form = new VerifiableForm('form1', '');


$form->AddRow('row1', new HtmlRow('Header1'));
$form->AddRow('row2', 
	new TextInputWithLengthValidation(
		'Input1',
		'input1',
		'value1',
		'Правильная длинна',
		'Неправильная длинна',
		5,
		100
	)
);
$form->AddRow('row3', 
	new TextInputWithRegexpValidation(
		'Input2',
		'input2',
		'value2',
		'Правильная длинна',
		'Неправильная длинна',
		'/^[1-4]{1} [0-9]{6}$/'
	)
);
$form->AddRow('row4', new SubmitField('Отправить'));


//echo (int)$form->Validate();

$nae = new NamedArticle();

/*$nae->Load(1);
echo $nae->Get('content');
$nae->Set('content', '123');
$nae->Save(1);*/

/*
$es = $nae->Enumerate();
foreach ($es as $e) {
	echo $e->Get('name') . "<br />";
	$d = $e->GetLinkedEntity('article_location_id');
	echo $d->Get('title') . ", " . $d->Get('name') . "<br />";
}*/

$articleLocation = new ArticleLocation();
$articleLocations = $articleLocation->Enumerate();
foreach ($articleLocations as $articleLocation) {
	echo $articleLocation->Get('name') . ", " . $articleLocation->Get('title');
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"> 
	<head> 
	<meta http-equiv="content-type" content="text/html;charset=windows-1251" /> 
		<?php
			include "ThirdParty/RenderUtils.php";
			thirdPartyScriptIncludes();
			thirdPartyStyeIncludes();
		?>
		<script type="text/javascript" src="Lightcore/LightcoreJs.php"></script>
		<link rel="stylesheet" href="Lightcore/LightcoreCss.php" />
	</head> 
<body>
<?php
	$form->Render();
?>
</body>
</html>