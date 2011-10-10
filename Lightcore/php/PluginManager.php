<?php

class PluginManager {
	private static $m_defaultPath;
	private static $m_plugins = array();

	public static function SetPluginsPath($defaultPath) {
		self::$m_defaultPath = $defaultPath;
	}
	
	public static function GetPluginsPath() {
		return $templatesDirectory = self::$m_defaultPath;
	}
	
	public static function AddPlugin($pluginName, $styleName = 'Default') {
		self::$m_plugins[$pluginName] = new Plugin($pluginName, $styleName);
	}
	
	public static function GetPlugin($pluginName) {
		return safeGetItem($pluginName, self::$m_plugins, NULL);
	}
	
	public static function IncludePluginsCode() {
		foreach (self::$m_plugins as $plugin) {
			$plugin->IncludeCode();
		}
	}
	
	public static function IncludePluginsDesigns() {
		header("content-type: text/css;charset=windows-1251");
		foreach (self::$m_plugins as $plugin) {
			$plugin->IncludeDesign();
		}
	}
	
	public static function IncludePluginsScripts() {
		header("content-type: application/x-javascript;charset=windows-1251");
		foreach (self::$m_plugins as $plugin) {
			$plugin->IncludeScripts();
		}
	}
}

class Plugin {
	const CODE_FILE_POSTFIX = 'Plugin.php';
	const DESIGN_SUBFOLDER = 'Design';
	const DESIGN_STYLE_FILE = 'Style.css';
	const CLIENT_SCRIPTS_FILE_POSTFIX = 'Plugin.js';
	
	private $m_styleName;
	private $m_name;
	
	public function __construct($pluginName, $styleName = 'Default') {
		$this->m_styleName = $styleName;
		$this->m_name = $pluginName;
	}
	
	private function GetPluginFolder() {
		return PluginManager::GetPluginsPath() . '/' . $this->m_name;
	}
	
	public function IncludeCode() {
		require_once $this->GetPluginFolder() . '/' . $this->m_name . Plugin::CODE_FILE_POSTFIX;
	}
	
	public function IncludeDesign() {
		require_once $this->GetPluginFolder() . '/' . Plugin::DESIGN_SUBFOLDER . '/' . $this->m_styleName . '/' . Plugin::DESIGN_STYLE_FILE;
	}
	
	public function IncludeScripts() {
		require_once $this->GetPluginFolder() . '/' . $this->m_name . Plugin::CLIENT_SCRIPTS_FILE_POSTFIX;
	}
}
