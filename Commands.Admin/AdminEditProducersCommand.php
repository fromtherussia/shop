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
				'��������',
				'title',
				$producer->Get('title'),
				'�������� ��������� ���������',
				'�������� ������ ���� ������� 5 ��������',
				5
			)
		);
		$form->AddRow(
			'short_description',
			new TextareaInputField(
				'������� ��������',
				'short_description',
				$producer->Get('short_description'),
				'������� �������� ��������� ���������',
				'������� �������� ���� ������� 20 ��������',
				20
			)
		);
		$form->AddRow('submit', new SubmitField('���������'));
		
		return $form;
	}

	public function RenderTemplate($template) {
		wrapAdminTemplate('�������������', 2, $template, false)->Render();
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
			
			GlobalMessage::Set('������������� ������� ��������������', GlobalMessage::SUCCESS);
			location(EditEntityCommand::GetListUrl('AdminEditProducers'));
		}
		
		$template = $this->ProcessEditAction();
		GlobalMessage::Set('������ �������������� �������������', GlobalMessage::ERROR);
		return $template;
	}
	
	public function ProcessDeleteAction() {
		if (!checkNumeric('id', $_GET)) {
			GlobalMessage::Set('�� ������� ������� �������������', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditProducers'));
		}
		
		$producer = new Producer();
		if (!$producer->Delete(escapeSqlSpecialChars($_GET['id']))) {
			GlobalMessage::Set('�� ������� ������� �������������', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditProducers'));
		}
		
		GlobalMessage::Set('���������� ������� �������', GlobalMessage::SUCCESS);
		location(EditEntityCommand::GetListUrl('AdminEditProducers'));
	}
}
