<?php

class AdminEditCategoriesCommand extends EditEntityCommand {
	public function __construct() {
		parent::__construct(AccessMode::EDITOR, 'AdminEditCategories');
	}
	
	private function GetForm() {
		$category = new Category();
		
		$id = -1;
		if (checkNumeric('id', $_GET)) {
			$id = escapeSqlSpecialChars($_GET['id']);
			$category->Load($id);
		}
		
		// Filling form
		$form = new VerifiableForm('edit-categories', EditEntityCommand::GetSaveUrl('AdminEditCategories', $id));
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
		
		return $form;
	}

	public function RenderTemplate($template) {
		wrapAdminTemplate('Категории', 1, $template, false)->Render();
	}
	
	public function ProcessListAction() {
		$template = $this->GetActionTemplate('List');

		$category = new Category();
		$template->SetParam('categories', $category->Enumerate());
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

			$category = new Category();
			$category->Load($id);
			$category->Set('title', $form->GetRow('title')->GetRowValue());
			/*$category->Set('image', $form->GetRow('image')->GetRowValue());*/
			$category->Set('short_description', $form->GetRow('short_description')->GetRowValue());
			$category->Set('long_description', $form->GetRow('long_description')->GetRowValue());
			$category->Set('published', $form->GetRow('published')->GetRowValue() == 'on' ? 1 : 0);
			$category->Save($id);
			
			GlobalMessage::Set('Категория успешно отредактирована', GlobalMessage::SUCCESS);
			location(EditEntityCommand::GetListUrl('AdminEditCategories'));
		}
		
		$template = $this->ProcessEditAction();
		GlobalMessage::Set('Ошибка редактирования категории', GlobalMessage::ERROR);
		return $template;
	}
	
	public function ProcessDeleteAction() {
		if (!checkNumeric('id', $_GET)) {
			GlobalMessage::Set('Не удалось удалить категорию', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditCategories'));
		}
		
		$category = new Category();
		if (!$category->Delete(escapeSqlSpecialChars($_GET['id']))) {
			GlobalMessage::Set('Не удалось удалить категорию. Возможно она содержит подкатегории или товары', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditCategories'));
		}
		
		GlobalMessage::Set('Категория успешно удалена', GlobalMessage::SUCCESS);
		location(EditEntityCommand::GetListUrl('AdminEditCategories'));
	}
}
