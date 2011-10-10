<?php

include 'RenderUtils.php';

class EntityEditor {
	private $m_commandName;
	private $m_entity;
	private $m_viewPageActionsList;
	private $m_viewPageRows;
	private $m_editPageActionsList;
	private $m_editPageRows;
	private $m_listPageActionsList;
	private $m_listPageRenderColumns;
	
	public function __construct(
		$commandName,
		$entity,
		$viewPageActionsList,
		$viewPageRows,
		$editPageActionsList,
		$editPageRows,
		$listPageActionsList,
		$listPageRenderColumns) {
		$this->m_commandName = $commandName;
		$this->m_entity = $entity;
		$this->m_viewPageActionsList = $viewPageActionsList;
		$this->m_viewPageRows = $viewPageRows;
		$this->m_editPageActionsList = $editPageActionsList;
		$this->m_editPageRows = $editPageRows;
		$this->m_listPageActionsList = $listPageActionsList;
		$this->m_listPageRenderColumns = $listPageRenderColumns;
	}
	
	public function CreateViewTemplate($entity) {
		$template = new Template('TemplateView', 'Utils/EntityEditor');
		
		$template->SetParam('command_name', $this->m_commandName);
		$template->SetParam('actions_list', $this->m_viewPageActionsList);
		$template->SetParam('rows', $this->m_viewPageRows);
		$template->SetParam('entity', $entity);
		return $template;
	}
	
	public function CreateEditTemplate($entity) {
		$template = new Template('TemplateEdit', 'Utils/EntityEditor');
		$template->SetParam('command_name', $this->m_commandName);
		$template->SetParam('actions_list', $this->m_editPageActionsList);
		$template->SetParam('rows', $this->m_editPageRows);
		$template->SetParam('entity', $entity);
		return $template;
	}
	
	public function CreateListTemplate($entity) {
		$entityClass = $entity->GetClassName();
		$template = new Template('TemplateList', 'Utils/EntityEditor');
		$pager = new Pager($entityClass, $entity->TotalCount(), 20, 'Страницы: ');
		
		$searchRequestParam = $entityClass . '_search_request';
		if (array_key_exists($searchRequestParam, $_POST) || array_key_exists($searchRequestParam, $_COOKIE)) {
			// В первую очередь поисковый запрос берется из POST, иначе из COOKIE
			$searchRequest = array_key_exists($searchRequestParam, $_POST) ? $_POST[$searchRequestParam] : $_COOKIE[$searchRequestParam];
			$entities = $entity->Find($searchRequest, $pager->getLowerLimit(), $pager->getUpperLimit());
			$template->SetParam('pager', NULL);
		} else {
			$searchRequest = '';
			$entities = $entity->Enumerate($pager->getLowerLimit(), $pager->getUpperLimit());
			$template->SetParam('pager', $pager);
		}
		setcookie($searchRequestParam, $searchRequest);
		
		$template->SetParam('command_name', $this->m_commandName);
		$template->SetParam('actions_list', $this->m_listPageActionsList);
		$template->SetParam('render_columns', $this->m_listPageRenderColumns);
		$template->SetParam('search_request', $searchRequest);
		$template->SetParam('total_entities_count', $entity->TotalCount());
		$template->SetParam('entities', $entities);
		return $template;
	}
	
	public function GetTemplate() {
		$entity = $this->m_entity;
		$action = 'list';
		if (checkString('act', $_GET)) {
			$action = $_GET['act'];
		}
		$entityClass = $entity->GetClassName();
		
        switch($action) {
			case 'list':
                $template = EntityEditor::CreateListTemplate($entity);
                break;
            case 'view':
				$entityId = checkNumeric('eid', $_GET) ? escapeSqlSpecialChars($_GET['eid']) : -1;
				if ($entityId == -1) {
					Command::Redirect($this->m_commandName);
				}
                $template = EntityEditor::CreateViewTemplate($entity);
				$template->SetParam('entity', $entity->GetById($entityId));
				break;
			case 'edit':
				$entityId = checkNumeric('eid', $_GET) ? escapeSqlSpecialChars($_GET['eid']) : -1;
				$template = EntityEditor::CreateEditTemplate($entity);
				if ($entityId != -1) {
					$template->SetParam('entity', $entity->GetById($entityId));
				} else {
					$template->SetParam('entity', array());
				}
                break;
            case 'save':
				if ($entity->Save()) {
					Command::Redirect($this->m_commandName);
                }
				$template = EntityEditor::CreateEditTemplate($entity);
				GlobalError::Set('Не удалось сохранить отредактированный объект. Ошибки отмечены на странице красным.');
                break;
            case 'delete':
                if ($entityClass->Delete()) {
					Command::Redirect($this->m_commandName);
                }
				GlobalError::Set('Не удалось удалить выбранный объект.');
                break;
            case 'edit-multiple':
				if ($entityClass->EditMultiple()) {
					Command::Redirect($this->m_commandName);
                }
				GlobalError::Set('Не удалось начать редактирование объектов.');
				break;
			case 'save-multiple':
				if ($entityClass->SaveMultiple()) {
					Command::Redirect($this->m_commandName);
                }
				GlobalError::Set('Не удалось сохранить отредактированные объекты. Ошибки отмечены на странице красным.');
				break;
			case 'delete-multiple':
				if ($entityClass->DeleteMultiple()) {
					Command::Redirect($this->m_commandName);
                }
				GlobalError::Set('Не удалось удалить выбранные объекты.');
				break;
		}
		return $template;
	}
}