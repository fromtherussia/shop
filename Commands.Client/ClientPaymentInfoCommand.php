<?php

class ClientPaymentInfoCommand extends Command {
	public function Execute () {
		$paymentInfoTemplate = new Template('ClientPaymentInfo');
		$paymentInfoTemplate->SetParam('paymentInfo', NamedArticle::GetArticlesByLocation('paymentInfo'));
		wrapClientPanelTemplate('���������� �� ������', $paymentInfoTemplate);
		return true;
	}
}