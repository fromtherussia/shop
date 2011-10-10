<?php

class AdminEditClientsCommand extends EditEntityCommand {
	public function __construct() {
		parent::__construct(AccessMode::EDITOR, 'AdminEditClients');
	}
	
	private function GetForm() {
		/*$category = new Category();
		
		$id = -1;
		if (checkNumeric('id', $_GET)) {
			$id = escapeSqlSpecialChars($_GET['id']);
			$category->Load($id);
		}
		*/
		// Filling form
		/*
		$form = new VerifiableForm('edit-categories', EditEntityCommand::GetSaveUrl('AdminEditClients', $id));
		$form->AddRow(
			'id',
			new HiddenInputWithRegexpValidation(
				'id',
				$category->Get('id') != "" ? $category->Get('id') : -1,
				''
			)
		);
		$form->AddRow(
			'title',
			new TextInputWithLengthValidation(
				'Название',
				'title',
				$category->Get('title'),
				'Название заполнено правильно',
				'Название должно быть длиннее 5 символов',
				5
			)
		);
		$form->AddRow(
			'published',
			new CheckboxInput(
				'Показывать покупателю',
				'published',
				$category->Get('published')
			)
		);
		$form->AddRow(
			'short_description',
			new TextareaInputField(
				'Краткое описание',
				'short_description',
				$category->Get('short_description'),
				'Краткое описание заполнено правильно',
				'Краткое описание быть длиннее 20 символов',
				20
			)
		);
		$form->AddRow(
			'short_description',
			new TextareaInputField(
				'Краткое описание',
				'short_description',
				$category->Get('short_description'),
				'Краткое описание заполнено правильно',
				'Краткое описание быть длиннее 20 символов',
				20
			)
		);
		$form->AddRow(
			'long_description',
			new WysywygInputField(
				'Полное описание',
				'long_description',
				$category->Get('long_description'),
				'Полное описание заполнено правильно',
				'Полное описание быть длиннее 20 символов',
				20
			)
		);
		$form->AddRow('submit', new SubmitField('Сохранить'));
		*/
		return $form;
	}

	public function RenderTemplate($template) {
		wrapAdminTemplate('Категории', 1, $template, false)->Render();
	}
	
	public function ProcessListAction() {
		$template = $this->GetActionTemplate('List');

		$client = new Client();
		$template->SetParam('clients', $client->Enumerate());
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

			$client = new Client();
			$client->Load($id);
			
			$category->Load($id);
			$category->Set('title', $form->GetRow('title')->GetRowValue());
			$category->Save($id);
			
			GlobalMessage::Set('Информация о клиенте успешно отредактирована', GlobalMessage::SUCCESS);
			location(EditEntityCommand::GetListUrl('AdminEditClients'));
		}
		
		$template = $this->ProcessEditAction();
		GlobalMessage::Set('Ошибка редактирования информации о клиенте', GlobalMessage::ERROR);
		return $template;
	}
	
	public function ProcessSearchAction() {
		$template = $this->GetActionTemplate('List');

		$client = new Client();
		if (!isExists('login', $_POST)) {
			$searchQuery = escapeSqlSpecialChars($_POST['searchQuery']);
			$clients = $client->Enumerate(NULL, );
		} else {
			$clients = $client->Enumerate();
		}
		$template->SetParam('clients', $client->Enumerate());
		return $template;
	}
}

/*
class AdminEditClients extends Command {
	public function __construct () {
		parent::__construct(VIEWER);
	}
	
	public function Execute() {
		if (checkNumeric('id', $_GET)) {
			$id = escapeSqlSpecialChars($_GET['id']);
			
			
			$template = new Template('AdminEditClients.Edit');
			$template->SetParam('client', $client);
			
			// DIRTY:
			$template->SetParam('orders', Cart::GetOrderedProducts($id));
			$template->SetParam('orderProducts', Cart::GetOrderProductsByClient($id));
		} else {
			
		}
		wrapAdminTemplate('Клиенты', 7, $template, false)->Render();
		return true;
	}
};*/