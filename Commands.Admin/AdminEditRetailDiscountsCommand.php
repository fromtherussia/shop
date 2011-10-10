<?php

class AdminEditRetailDiscountsCommand extends Command {
	public function __construct () {
		parent::__construct(EDITOR);
	}
	
	private function RenderTemplate($template) {
		$template->SetParam('discounts', Discounts::GetRetailDiscounts());
		wrapAdminTemplate('Управление скидками', 3, $template, true)->Render();
	}
	
	public function Execute() {
		$template = new Template('AdminEditRetailDiscounts');
		if (isExists('discount-precent', $_POST) &&
			isExists('discount-range-begin', $_POST) &&
			isExists('discount-range-end', $_POST) &&
			isArray($_POST['discount-precent']) &&
			isArray($_POST['discount-range-begin']) &&
			isArray($_POST['discount-range-end'])) {
			$discountPrecents = $_POST['discount-precent'];
			$discountRangesBegin = $_POST['discount-range-begin'];
			$discountRangesEnd = $_POST['discount-range-end'];
			$discounts = array();
			foreach ($discountPrecents as $c => $discountPrecent) {
				$precent = $discountPrecents[$c];
				$rangeBegin = $discountRangesBegin[$c];
				$rangeEnd = $discountRangesEnd[$c];
				
				if ($precent < 0 || $rangeBegin < 0 || $rangeBegin > 100000 || $rangeEnd < 0 || $rangeEnd > 100000) {
					$template->SetError('Не удалось изменить политику скидок. Внутренняя ошибка.');
					$this->RenderTemplate($template);
					return true;
				}
				
				if ($precent >= 50) {
					// TODO: generate report
					$template->SetError('Не удалось изменить политику скидок. Указана скидка более 50%.');
					$this->RenderTemplate($template);
					return true;
				}
				
				$discounts[$c] = array(
					'precent' => $precent,
					'rangeBegin' => $rangeBegin,
					'rangeEnd' => $rangeEnd
				);
			}
			Discounts::SetRetailDiscounts($discounts);
			$template->SetMessage('Политика скидок успешно изменена.');
		}
		
		$template->SetParam('saveHref', Command::GetRedirectUrl('AdminEditRetailDiscounts'));
		$this->RenderTemplate($template);
		return true;
	}
}