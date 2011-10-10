<?php

class ClientPaymentInfoCommand extends Command {
	public function Execute () {
		$paymentInfoTemplate = new Template('ClientPaymentInfo');
		$paymentInfoTemplate->SetParam('paymentInfo', NamedArticle::GetArticlesByLocation('paymentInfo'));
		wrapClientPanelTemplate('Информация по оплате', $paymentInfoTemplate);
		return true;
	}
}