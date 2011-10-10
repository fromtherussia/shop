<?php

// This script produces HTML pages in 1251 enc.
session_start();
header("content-type: text/html;charset=windows-1251");

// Database configuration
include "Config/ConfigClient.php";

// Core
include "Lightcore/LightcorePhp.php";
include "ThirdParty/RenderUtils.php";

// Custom
include "DataAccess/DataAccess.php";
include "Utils/Utils.php";

// Plugin initialization
include "IncludePlugins.php";

// Lightcore configuration
setSchema("shop");
ImageUploader::SetImagesPath('UploadedImages');
Template::SetTemplatesPath('Templates.Client');
User::SetTableName('shop.clients');

PluginManager::IncludePluginsCode();

// Processing command
$commandProcessor = new CommandProcessor('Commands.Client', 'CompanyInfo');
$commandProcessor->Run();
