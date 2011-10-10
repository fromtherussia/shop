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
				'Название',
				'name',
				$namedArticle->Get('name'),
				'Название заполнено правильно',
				'Название должно быть более 5 символов',
				5
			)
		);
		
		$form->AddRow(
			'location',
			new SelectWithIsSetValidation(
				'Расположение',
				'location',
				$namedArticle->Get('article_location_id'),
				$articleLocation->Enumerate(),
				array('id', 'title'),
				'Расположение на сайте выбрано',
				'Расположение на сайте должно быть выбрано'
			)
		);
		
		$form->AddRow(
			'content',
			new WysywygInputField(
				'Содержание',
				'content',
				$namedArticle->Get('content'),
				'Содержание информационного блока заполнено правильно',
				'Содержание информационного блока должно быть более 20 символов',
				20
			)
		);
		
		$form->AddRow('submit', new SubmitField('Сохранить'));
		
		return $form;
	}

	public function RenderTemplate($template) {
		wrapAdminTemplate('Информационные блоки', 4, $template, false)->Render();
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
			
			GlobalMessage::Set('Информационный блок успешно отредактирован', GlobalMessage::SUCCESS);
			location(EditEntityCommand::GetListUrl('AdminEditNamedInfo'));
		}
		
		$template = $this->ProcessEditAction();
		GlobalMessage::Set('Ошибка редактирования информационного блока', GlobalMessage::ERROR);
		return $template;
	}
	
	public function ProcessDeleteAction() {
		$id = getFieldValue('id', FiledType::TYPE_NUMERIC, RequestType::GET);
		if ($id === NULL) {
			GlobalMessage::Set('Не удалось удалить информационный блок', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditNamedInfo'));
		}
		
		$namedArticle = new NamedArticle();
		if (!$namedArticle->Delete($id)) {
			GlobalMessage::Set('Не удалось удалить информационный блок', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditNamedInfo'));
		}
		
		GlobalMessage::Set('Информационный блок успешно удален', GlobalMessage::SUCCESS);
		location(EditEntityCommand::GetListUrl('AdminEditNamedInfo'));
	}
}