<?php

class AdminEditProducersCommand extends EditEntityCommand {
	public function __construct() {
		parent::__construct(AccessMode::EDITOR, 'AdminEditProducers');
	}
	
	private function GetForm() {
		$producer = new Producer();
		
		$id = -1;
		if (checkNumeric('id', $_GET)) {
			$id = escapeSqlSpecialChars($_GET['id']);
			$producer->Load($id);
		}
		
		// Filling form
		$form = new VerifiableForm('edit-producers', EditEntityCommand::GetSaveUrl('AdminEditProducers', $id));
		$form->AddRow(
			'id',
			new HiddenInputWithRegexpValidation(
				'id',
				$producer->Get('id') != "" ? $producer->Get('id') : -1,
				''
			)
		);
		$form->AddRow(
			'title',
			new TextInputWithLengthValidation(
				'Название',
				'title',
				$producer->Get('title'),
				'Название заполнено правильно',
				'Название должно быть длиннее 5 символов',
				5
			)
		);
		$form->AddRow(
			'short_description',
			new TextareaInputField(
				'Краткое описание',
				'short_description',
				$producer->Get('short_description'),
				'Краткое описание заполнено правильно',
				'Краткое описание быть длиннее 20 символов',
				20
			)
		);
		$form->AddRow('submit', new SubmitField('Сохранить'));
		
		return $form;
	}

	public function RenderTemplate($template) {
		wrapAdminTemplate('Производители', 2, $template, false)->Render();
	}
	
	public function ProcessListAction() {
		$template = $this->GetActionTemplate('List');
		
		$producer = new Producer();
		$template->SetParam('producers', $producer->Enumerate());
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

			$producer = new Producer();
			$producer->Load($id);
			$producer->Set('title', $form->GetRow('title')->GetRowValue());
			$producer->Set('short_description', $form->GetRow('short_description')->GetRowValue());
			$producer->Save($id);
			
			GlobalMessage::Set('Производитель успешно отредактирован', GlobalMessage::SUCCESS);
			location(EditEntityCommand::GetListUrl('AdminEditProducers'));
		}
		
		$template = $this->ProcessEditAction();
		GlobalMessage::Set('Ошибка редактирования производителя', GlobalMessage::ERROR);
		return $template;
	}
	
	public function ProcessDeleteAction() {
		if (!checkNumeric('id', $_GET)) {
			GlobalMessage::Set('Не удалось удалить производителя', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditProducers'));
		}
		
		$producer = new Producer();
		if (!$producer->Delete(escapeSqlSpecialChars($_GET['id']))) {
			GlobalMessage::Set('Не удалось удалить производителя', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditProducers'));
		}
		
		GlobalMessage::Set('Объявление успешно удалено', GlobalMessage::SUCCESS);
		location(EditEntityCommand::GetListUrl('AdminEditProducers'));
	}
}
