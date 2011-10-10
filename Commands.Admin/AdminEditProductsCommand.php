<?php

class AdminEditProductsCommand extends EditEntityCommand {
	public function __construct() {
		parent::__construct(AccessMode::EDITOR, 'AdminEditProducts');
	}
	
	private function GetForm() {
		$product = new Product();
		
		$id = -1;
		if (checkNumeric('id', $_GET)) {
			$id = escapeSqlSpecialChars($_GET['id']);
			$product->Load($id);
		}
		
		// Filling form
		$form = new VerifiableForm('edit-products', EditEntityCommand::GetSaveUrl('AdminEditProducts', $id));
		$form->AddRow(
			'id',
			new HiddenInputWithRegexpValidation(
				'id',
				$product->Get('id') != "" ? $product->Get('id') : -1,
				''
			)
		);
		$form->AddRow(
			'title',
			new TextInputWithLengthValidation(
				'��������',
				'title',
				$product->Get('title'),
				'�������� ��������� ���������',
				'�������� ������ ���� ������� 5 ��������',
				5
			)
		);
		
		$form->AddRow(
			'price_wholesale',
			new TextInputWithRegexpValidation(
				'������� ����',
				'price_wholesale',
				$product->Get('price_wholesale'),
				'������� ���� ��������� ���������',
				'������� ���� ������ ���� ������',
				'/^[0-9]{1,}$/'
			)
		);
		$form->AddRow(
			'price_retail',
			new TextInputWithRegexpValidation(
				'��������� ����',
				'price_retail',
				$product->Get('price_retail'),
				'��������� ���� ��������� ���������',
				'��������� ���� ������ ���� ������',
				'/^[0-9]{1,}$/'
			)
		);
		$form->AddRow(
			'article',
			new TextInputWithRegexpValidation(
				'�������',
				'article',
				$product->Get('article'),
				'������� �������� ���������',
				'������� ������ ����� ������ X YYYYYY, X - ����� �� 1 �� 4, Y - ����� �����',
				'/^[1-4]{1} [0-9]{6}$/'
			)
		);
		$form->AddRow(
			'published',
			new CheckboxInput(
				'���������� ����������',
				'published',
				$product->Get('published')
			)
		);
		$form->AddRow(
			'short_description',
			new TextareaInputField(
				'������� ��������',
				'short_description',
				$product->Get('short_description'),
				'������� �������� ��������� ���������',
				'������� �������� ���� ������� 20 ��������',
				20
			)
		);
		$form->AddRow(
			'short_description',
			new TextareaInputField(
				'������� ��������',
				'short_description',
				$product->Get('short_description'),
				'������� �������� ��������� ���������',
				'������� �������� ���� ������� 20 ��������',
				20
			)
		);
		$form->AddRow(
			'long_description',
			new WysywygInputField(
				'������ ��������',
				'long_description',
				$product->Get('long_description'),
				'������ �������� ��������� ���������',
				'������ �������� ���� ������� 20 ��������',
				20
			)
		);
		$form->AddRow(
			'images',
			new MultipleImagePicker(
				'�����������',
				'images',
				array(),
				'����������� �������',
				'������ ���� ������� ���� �� ���� �����������'
			)
		);
		$form->AddRow('submit', new SubmitField('���������'));
		
		return $form;
	}

	public function RenderTemplate($template) {
		wrapAdminTemplate('������', 0, $template, false)->Render();
	}
	
	public function ProcessListAction() {
		$template = $this->GetActionTemplate('List');

		$product = new Product();
		$template->SetParam('products', $product->Enumerate());
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

			$product = new Product();
			$product->Load($id);
			$product->Set('title', $form->GetRow('title')->GetRowValue());
			/*$product->Set('image', $form->GetRow('image')->GetRowValue());*/
			$product->Set('short_description', $form->GetRow('short_description')->GetRowValue());
			$product->Set('long_description', $form->GetRow('long_description')->GetRowValue());
			$product->Set('price_wholesale', $form->GetRow('price_wholesale')->GetRowValue());
			$product->Set('price_retail', $form->GetRow('price_retail')->GetRowValue());
			$product->Set('article', $form->GetRow('article')->GetRowValue());
			$product->Set('hits', 0);
			$product->Set('published', $form->GetRow('published')->GetRowValue() == 'on' ? 1 : 0);
			$product->Save($id);
			
			GlobalMessage::Set('����� ������� ��������������', GlobalMessage::SUCCESS);
			location(EditEntityCommand::GetListUrl('AdminEditProducts'));
		}
		
		$template = $this->ProcessEditAction();
		GlobalMessage::Set('������ �������������� ������', GlobalMessage::ERROR);
		return $template;
	}
	
	public function ProcessDeleteAction() {
		if (!checkNumeric('id', $_GET)) {
			GlobalMessage::Set('�� ������� ������� �����', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditProducts'));
		}
		
		$product = new Product();
		if (!$product->Delete(escapeSqlSpecialChars($_GET['id']))) {
			GlobalMessage::Set('�� ������� ������� �����', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditProducts'));
		}
		
		GlobalMessage::Set('����� ������� ������', GlobalMessage::SUCCESS);
		location(EditEntityCommand::GetListUrl('AdminEditProducts'));
	}
}
