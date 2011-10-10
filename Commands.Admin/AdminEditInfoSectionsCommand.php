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
				'��������',
				'title',
				$infoSection->Get('title'),
				'�������� ��������� ���������',
				'�������� ������ ���� ����� 5 ��������',
				5
			)
		);
		$form->AddRow(
			'order_no',
			new TextInputWithRegexpValidation(
				'���������',
				'order_no',
				$infoSection->Get('order_no'),
				'��������� ������ ���� ��������',
				'��������� ������ ���� ������',
				'/^[0-9]{1,}$/'
			)
		);
		$form->AddRow('submit', new SubmitField('���������'));
		
		return $form;
	}

	public function RenderTemplate($template) {
		wrapAdminTemplate('������� / ������', 5, $template, false)->Render();
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
			
			GlobalMessage::Set('������ ������� ��������������', GlobalMessage::SUCCESS);
			location(EditEntityCommand::GetListUrl('AdminEditInfoPages'));
		}
		
		$template = $this->ProcessEditAction();
		GlobalMessage::Set('������ �������������� �������', GlobalMessage::ERROR);
		return $template;
	}
	
	public function ProcessDeleteAction() {
		if (!checkNumeric('id', $_GET)) {
			GlobalMessage::Set('�� ������� ������� ������', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditInfoPages'));
		}
		
		$infoSection = new InfoSection();
		if (!$infoSection->Delete(escapeSqlSpecialChars($_GET['id']))) {
			GlobalMessage::Set('�� ������� ������� ������, �������� �� �������� ������', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditInfoPages'));
		}
		
		GlobalMessage::Set('������ ������� ������', GlobalMessage::SUCCESS);
		location(EditEntityCommand::GetListUrl('AdminEditInfoPages'));
	}
}
