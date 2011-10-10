<?php

class AdminEditAdsCommand extends EditEntityCommand {
	public function __construct() {
		parent::__construct(AccessMode::EDITOR, 'AdminEditAds');
	}

	private function GetForm() {
		$id = getFieldValue('id', FiledType::TYPE_NUMERIC, RequestType::GET, -1);
		$ad = new Ad();
		$ad->Load($id);

		// Filling form
		$form = new VerifiableForm('edit-ads', EditEntityCommand::GetSaveUrl('AdminEditAds', $id));

		$form->AddRow(
			'id',
			new HiddenInputWithRegexpValidation(
				'id',
				$ad->GetPkValue(),
				''
			)
		);

		$form->AddRow(
			'name',
			new TextInputWithLengthValidation(
				'Название',
				'name',
				$ad->Get('name'),
				'Название заполнено правильно',
				'Название должно быть более 5 символов',
				5
			)
		);

		$form->AddRow(
			'from_date',
			new DatePickerInputField(
				'Начало демонстрации',
				'from_date',
				$ad->Get('from_date'),
				'Дата начала показа заполнена',
				'Дата начала показа должна быть заполнена'
			)
		);

		$form->AddRow(
			'to_date',
			new DatePickerInputField(
				'Окончание демонстрации',
				'to_date',
				$ad->Get('to_date'),
				'Дата окончания показа заполнена',
				'Дата окончания показа должна быть заполнена'
			)
		);

		$form->AddRow(
			'content',
			new WysywygInputField(
				'Текст',
				'content',
				$ad->Get('content'),
				'Текст объявления заполнен',
				'Текст объявления должен быть не менее 20 символов',
				20
			)
		);

		$form->AddRow('submit', new SubmitField('Сохранить'));
		
		return $form;
	}

	public function RenderTemplate($template) {
		wrapAdminTemplate('Объявления', 6, $template, false)->Render();
	}
	
	public function ProcessListAction() {
		$template = $this->GetActionTemplate('List');
		$ad = new Ad();
		$adsOrder = array(
			array(
				'field' => 'from_date',
				'direction' => 'ASC'
			)
		);
		$template->SetParam('ads', $ad->Enumerate($adsOrder));
		return $template;
	}
	
	public function ProcessEditAction() {
		$template = $this->GetActionTemplate('Edit');
		$template->SetParam('form', $this->GetForm());
		return $template;
	}
	
	public function ProcessSaveAction() {
		$form = $this->GetForm();
		
		if ($form->Validate()) {
			$id = $form->GetRow('id')->GetRowValue();

			$ad = new Ad();
			$ad->Load($id);
			$ad->Set('content', $form->GetRow('content')->GetRowValue());
			$ad->Set('name', $form->GetRow('name')->GetRowValue());
			$ad->Set('from_date', $form->GetRow('from_date')->GetRowValue());
			$ad->Set('to_date', $form->GetRow('to_date')->GetRowValue());
			$ad->Save($id);
			
			GlobalMessage::Set('Объявление успешно отредактировано', GlobalMessage::SUCCESS);
			location(EditEntityCommand::GetListUrl('AdminEditAds'));
		}
		
		$template = $this->ProcessEditAction();
		GlobalMessage::Set('Ошибка редактирования объявления', GlobalMessage::ERROR);
		return $template;
	}
	
	public function ProcessDeleteAction() {
		$id = getFieldValue('id', FiledType::TYPE_NUMERIC, RequestType::GET);
		if ($id === NULL) {
			GlobalMessage::Set('Не удалось удалить объявление', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditAds'));
		}
		
		$ad = new Ad();
		if (!$ad->Delete($id)) {
			GlobalMessage::Set('Не удалось удалить объявление', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditAds'));
		}
		
		GlobalMessage::Set('Объявление успешно удалено', GlobalMessage::SUCCESS);
		location(EditEntityCommand::GetListUrl('AdminEditAds'));
	}
}
