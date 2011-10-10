<?php

class AdminEditNamedInfoCommand extends EditEntityCommand {
	public function __construct() {
		parent::__construct(AccessMode::EDITOR, 'AdminEditNamedInfo');
	}
	
	private function GetForm() {
		$id = getFieldValue('id', FiledType::TYPE_NUMERIC, RequestType::GET, -1);
		$namedArticle = new NamedArticle();
		$articleLocation = new ArticleLocation();
		$namedArticle->Load($id);
		
		// Filling form
		$form = new VerifiableForm('edit-named-info', EditEntityCommand::GetSaveUrl('AdminEditNamedInfo', $id));
		
		$form->AddRow(
			'id',
			new HiddenInputWithRegexpValidation(
				'id',
				$namedArticle->GetPkValue(),
				''
			)
		);
		
		$form->AddRow(
			'name',
			new TextInputWithLengthValidation(
				'��������',
				'name',
				$namedArticle->Get('name'),
				'�������� ��������� ���������',
				'�������� ������ ���� ����� 5 ��������',
				5
			)
		);
		
		$form->AddRow(
			'location',
			new SelectWithIsSetValidation(
				'������������',
				'location',
				$namedArticle->Get('article_location_id'),
				$articleLocation->Enumerate(),
				array('id', 'title'),
				'������������ �� ����� �������',
				'������������ �� ����� ������ ���� �������'
			)
		);
		
		$form->AddRow(
			'content',
			new WysywygInputField(
				'����������',
				'content',
				$namedArticle->Get('content'),
				'���������� ��������������� ����� ��������� ���������',
				'���������� ��������������� ����� ������ ���� ����� 20 ��������',
				20
			)
		);
		
		$form->AddRow('submit', new SubmitField('���������'));
		
		return $form;
	}

	public function RenderTemplate($template) {
		wrapAdminTemplate('�������������� �����', 4, $template, false)->Render();
	}
	
	public function ProcessListAction() {
		$template = $this->GetActionTemplate('List');
		$articleLocation = new ArticleLocation();
		$namedArticle = new NamedArticle();
		$template->SetParam('namedArticles', $namedArticle->Enumerate(array(array('field' => 'article_location_id', 'direction' => 'asc'))));
		$template->SetParam('articleLocations', $articleLocation->Enumerate());
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
			$namedArticle = new NamedArticle();
			$namedArticle->Load($id);
			$namedArticle->Set('article_location_id', $form->GetRow('location')->GetRowValue());
			$namedArticle->Set('name', $form->GetRow('name')->GetRowValue());
			$namedArticle->Set('content', $form->GetRow('content')->GetRowValue());
			$namedArticle->Save($id);
			
			GlobalMessage::Set('�������������� ���� ������� ��������������', GlobalMessage::SUCCESS);
			location(EditEntityCommand::GetListUrl('AdminEditNamedInfo'));
		}
		
		$template = $this->ProcessEditAction();
		GlobalMessage::Set('������ �������������� ��������������� �����', GlobalMessage::ERROR);
		return $template;
	}
	
	public function ProcessDeleteAction() {
		$id = getFieldValue('id', FiledType::TYPE_NUMERIC, RequestType::GET);
		if ($id === NULL) {
			GlobalMessage::Set('�� ������� ������� �������������� ����', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditNamedInfo'));
		}
		
		$namedArticle = new NamedArticle();
		if (!$namedArticle->Delete($id)) {
			GlobalMessage::Set('�� ������� ������� �������������� ����', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditNamedInfo'));
		}
		
		GlobalMessage::Set('�������������� ���� ������� ������', GlobalMessage::SUCCESS);
		location(EditEntityCommand::GetListUrl('AdminEditNamedInfo'));
	}
}