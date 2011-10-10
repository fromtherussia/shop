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
				'��������',
				'name',
				$ad->Get('name'),
				'�������� ��������� ���������',
				'�������� ������ ���� ����� 5 ��������',
				5
			)
		);

		$form->AddRow(
			'from_date',
			new DatePickerInputField(
				'������ ������������',
				'from_date',
				$ad->Get('from_date'),
				'���� ������ ������ ���������',
				'���� ������ ������ ������ ���� ���������'
			)
		);

		$form->AddRow(
			'to_date',
			new DatePickerInputField(
				'��������� ������������',
				'to_date',
				$ad->Get('to_date'),
				'���� ��������� ������ ���������',
				'���� ��������� ������ ������ ���� ���������'
			)
		);

		$form->AddRow(
			'content',
			new WysywygInputField(
				'�����',
				'content',
				$ad->Get('content'),
				'����� ���������� ��������',
				'����� ���������� ������ ���� �� ����� 20 ��������',
				20
			)
		);

		$form->AddRow('submit', new SubmitField('���������'));
		
		return $form;
	}

	public function RenderTemplate($template) {
		wrapAdminTemplate('����������', 6, $template, false)->Render();
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
			
			GlobalMessage::Set('���������� ������� ���������������', GlobalMessage::SUCCESS);
			location(EditEntityCommand::GetListUrl('AdminEditAds'));
		}
		
		$template = $this->ProcessEditAction();
		GlobalMessage::Set('������ �������������� ����������', GlobalMessage::ERROR);
		return $template;
	}
	
	public function ProcessDeleteAction() {
		$id = getFieldValue('id', FiledType::TYPE_NUMERIC, RequestType::GET);
		if ($id === NULL) {
			GlobalMessage::Set('�� ������� ������� ����������', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditAds'));
		}
		
		$ad = new Ad();
		if (!$ad->Delete($id)) {
			GlobalMessage::Set('�� ������� ������� ����������', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditAds'));
		}
		
		GlobalMessage::Set('���������� ������� �������', GlobalMessage::SUCCESS);
		location(EditEntityCommand::GetListUrl('AdminEditAds'));
	}
}
