<?php

class SectionCommand extends Command {
	private static function GetSectionIdFromRequest () {
		if (array_key_exists('sec', $_GET)) {
			return $_GET['sec'];
		} else {
			// ≈сли не указана категори€ - переходим на заглушку
			Command::Redirect('Default');
		}
	}
	
	private static function GetInfoPageIdFromRequest () {
		if (array_key_exists('pid', $_GET)) {
			return $_GET['pid'];
		} else {
			return -1;
		}
	}
	
	public function Execute() {
		$sectionId = SectionCommand::GetSectionIdFromRequest();
		
		$infoPage = new InfoPage();
		$infoPages = $infoPage->Enumerate(array(array('field' => 'order_no', 'direction' => 'ASC')), "info_section_id = $sectionId");
		
		if (count($infoPages) == 0) {
			Command::Redirect('Default');
		}
		
		$pageId = SectionCommand::GetInfoPageIdFromRequest();
		if ($pageId == -1) {
			$page = each($infoPages);
			$page = $page[1];
			$infoPage->Load($page->Get('id'));
		} else {
			$infoPage->Load($pageId);
		}
		
		$template = new Template('InfoPages');
		$template->SetParam('sectionId', $sectionId);
		$template->SetParam('infoPages', $infoPages);
		$template->SetParam('infoPage', $infoPage);

		wrapSubpageTemplate($infoPage->Get('title'), 1, $template)->Render();
		return true;
	}
}