<?php

class CompanyInfoCommand extends Command {
	public function Execute () {
		$template = new Template('CompanyInfo');
		$template->SetParam('wholesaleAddress', NamedArticle::GetArticlesByLocation('wholesaleAddress'));
		$template->SetParam('retailAddress', NamedArticle::GetArticlesByLocation('retailAddress'));
		$template->SetParam('companyInfo', NamedArticle::GetArticlesByLocation('companyInfo'));
		$template->SetParam('kuibyshevAddress', NamedArticle::GetArticlesByLocation('kuibyshevAddress'));
		wrapSubpageTemplate('О нас', 1, $template)->Render();
		return true;
	}
}