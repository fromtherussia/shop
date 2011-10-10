<?php

class AdminEditInfoSectionsCommand extends EditEntityCommand {
	public function __construct() {
		parent::__construct(AccessMode::EDITOR, 'AdminEditInfoSections');
	}
	
	private function GetForm() {
		$infoSection = new InfoSection();
		
		$id = -1;
		if (checkNumeric('id', $_GET)) {
			$id = escapeSqlSpecialChars($_GET['id']);
			$infoSection->Load($id);
		}
		
		// Filling form
		$form = new VerifiableForm('edit-info-sections', EditEntityCommand::GetSaveUrl('AdminEditInfoSections', $id));
		$form->AddRow(
			'id',
			new HiddenInputWithRegexpValidation(
				'id',
				$infoSection->Get('id') != "" ? $infoSection->Get('id') : -1,
				''
			)
		);
		$form->AddRow(
			'title',
			new TextInputWithLengthValidation(
				'Название',
				'title',
				$infoSection->Get('title'),
				'Название заполнено правильно',
				'Название должно быть более 5 символов',
				5
			)
		);
		$form->AddRow(
			'order_no',
			new TextInputWithRegexpValidation(
				'Приоритет',
				'order_no',
				$infoSection->Get('order_no'),
				'Приоритет должен быть заполнен',
				'Приоритет должен быть числом',
				'/^[0-9]{1,}$/'
			)
		);
		$form->AddRow('submit', new SubmitField('Сохранить'));
		
		return $form;
	}

	public function RenderTemplate($template) {
		wrapAdminTemplate('Разделы / Статьи', 5, $template, false)->Render();
	}
	
	public function ProcessListAction() {
		//
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

			$infoSection = new InfoSection();
			$infoSection->Load($id);
			$infoSection->Set('title', $form->GetRow('title')->GetRowValue());
			$infoSection->Set('order_no', $form->GetRow('order_no')->GetRowValue());
			$infoSection->Save($id);
			
			GlobalMessage::Set('Раздел успешно отредактирован', GlobalMessage::SUCCESS);
			location(EditEntityCommand::GetListUrl('AdminEditInfoPages'));
		}
		
		$template = $this->ProcessEditAction();
		GlobalMessage::Set('Ошибка редактирования раздела', GlobalMessage::ERROR);
		return $template;
	}
	
	public function ProcessDeleteAction() {
		if (!checkNumeric('id', $_GET)) {
			GlobalMessage::Set('Не удалось удалить раздел', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditInfoPages'));
		}
		
		$infoSection = new InfoSection();
		if (!$infoSection->Delete(escapeSqlSpecialChars($_GET['id']))) {
			GlobalMessage::Set('Не удалось удалить раздел, возможно он содержит статьи', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditInfoPages'));
		}
		
		GlobalMessage::Set('Раздел успешно удален', GlobalMessage::SUCCESS);
		location(EditEntityCommand::GetListUrl('AdminEditInfoPages'));
	}
}
