<?php

// This script produces HTML pages in 1251 enc.
session_start();
header("content-type: text/html;charset=windows-1251");

DEFINE('DB_SILENT_MODE', false);

// Database configuration
include "Config/ConfigAdmin.php";

// Core
include "Lightcore/LightcorePhp.php";
include "ThirdParty/RenderUtils.php";

// Custom
include "DataAccess/DataAccess.php";
include "Utils/Utils.php";
include "Utils/EntityEditor/EntityEditor.php";

// Plugin initialization
include "IncludePlugins.php";

// Lightcore configuration
setSchema("shop");
ImageUploader::SetImagesPath('UploadedImages');
Template::SetTemplatesPath('Templates.Admin');
User::SetTableName('shop.managers');

PluginManager::IncludePluginsCode();

// Processing command
$commandProcessor = new CommandProcessor('Commands.Admin', 'Admin');
$commandProcessor->Run();
