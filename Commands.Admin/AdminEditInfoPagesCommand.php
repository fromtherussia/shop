<?php

class AdminEditInfoPagesCommand extends EditEntityCommand {
	public function __construct() {
		parent::__construct(AccessMode::EDITOR, 'AdminEditInfoPages');
	}
	
	private function GetForm() {
		$infoPage = new InfoPage();
		$infoSection = new InfoSection();
		
		$id = -1;
		if (checkNumeric('id', $_GET)) {
			$id = escapeSqlSpecialChars($_GET['id']);
			$infoPage->Load($id);
		}
		
		// Filling form
		$form = new VerifiableForm('edit-info-pages', EditEntityCommand::GetSaveUrl('AdminEditInfoPages', $id));
		$form->AddRow(
			'id',
			new HiddenInputWithRegexpValidation(
				'id',
				$infoPage->Get('id') != "" ? $infoPage->Get('id') : -1,
				''
			)
		);
		$form->AddRow(
			'title',
			new TextInputWithLengthValidation(
				'Название',
				'title',
				$infoPage->Get('title'),
				'Название заполнено правильно',
				'Название должно быть более 5 символов',
				5
			)
		);
		$form->AddRow(
			'info_section_id',
			new SelectWithIsSetValidation(
				'Расположение',
				'info_section_id',
				$infoPage->Get('info_section_id'), // value
				$infoSection->Enumerate(), // values
				array('id', 'title'), // entity field names
				'Расположение на сайте выбрано',
				'Расположение на сайте должно быть выбрано'
			)
		);
		$form->AddRow(
			'order_no',
			new TextInputWithRegexpValidation(
				'Приоритет',
				'order_no',
				$infoPage->Get('order_no'),
				'Приоритет должен быть заполнен',
				'Приоритет должен быть числом',
				'/^[0-9]{1,}$/'
			)
		);
		$form->AddRow(
			'content',
			new WysywygInputField(
				'Текст',
				'content',
				$infoPage->Get('content'),
				'Текст страницы заполнен',
				'Текст страницы должен быть не менее 20 символов',
				20
			)
		);
		$form->AddRow('submit', new SubmitField('Сохранить'));
		
		return $form;
	}

	public function RenderTemplate($template) {
		wrapAdminTemplate('Разделы / Статьи', 5, $template, false)->Render();
	}
	
	public function ProcessListAction() {
		$template = $this->GetActionTemplate('List');
		
		$infoSection = new InfoSection();
		$infoPage = new InfoPage();
		
		$infoSectionsOrder = array(
			array(
				'field' => 'order_no',
				'direction' => 'ASC'
			),
			array(
				'field' => 'id',
				'direction' => 'ASC'
			)
		);
		$infoPagesOrder = array(
			array(
				'field' => 'info_section_id',
				'direction' => 'ASC'
			),
			array(
				'field' => 'id',
				'direction' => 'ASC'
			)
		);
		$template->SetParam('infoSections', $infoSection->Enumerate($infoSectionsOrder));
		$template->SetParam('infoPages', $infoPage->Enumerate($infoPagesOrder));
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

			$infoPage = new InfoPage();
			$infoPage->Load($id);
			$infoPage->Set('title', $form->GetRow('title')->GetRowValue());
			$infoPage->Set('info_section_id', $form->GetRow('info_section_id')->GetRowValue());
			$infoPage->Set('order_no', $form->GetRow('order_no')->GetRowValue());
			$infoPage->Set('content', $form->GetRow('content')->GetRowValue());
			$infoPage->Save($id);
			
			GlobalMessage::Set('Статья успешно отредактирована', GlobalMessage::SUCCESS);
			location(EditEntityCommand::GetListUrl('AdminEditInfoPages'));
		}
		
		$template = $this->ProcessEditAction();
		GlobalMessage::Set('Ошибка редактирования статьи', GlobalMessage::ERROR);
		return $template;
	}
	
	public function ProcessDeleteAction() {
		if (!checkNumeric('id', $_GET)) {
			GlobalMessage::Set('Не удалось удалить статью', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditInfoPages'));
		}
		
		$infoPage = new InfoPage();
		if (!$infoPage->Delete(escapeSqlSpecialChars($_GET['id']))) {
			GlobalMessage::Set('Не удалось удалить статью', GlobalMessage::ERROR);
			location(EditEntityCommand::GetListUrl('AdminEditInfoPages'));
		}
		
		GlobalMessage::Set('Статья успешно удалена', GlobalMessage::SUCCESS);
		location(EditEntityCommand::GetListUrl('AdminEditInfoPages'));
	}
}
