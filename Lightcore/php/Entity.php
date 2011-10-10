<?php

/*
	Использование:
	
	Создание новой сущности:
		$entity = new CustomEntityType();
		$entity->Load(-1);
		$entity->Set('...', '...');
		...
		$entity->Save(-1);
		
	Редактирование сущности:
		$entity = new CustomEntityType();
		$entity->Load($id);
		$entity->Set('...', '...');
		...
		$entity->Save($id);
		
	Удаление сущности:
		$entity = new CustomEntityType();
		$entity->Delete($id);
		
	Поиск:
		$customEntity = new CustomEntityType();
		$entities = $customEntity->Enumerate(NULL, $where);
		foreach ($entities as $pk => $entity) {
			...
		}
	
	Список сущностей:
		$customEntity = new CustomEntityType();
		$entities = $customEntity->Enumerate(array(
			array(
				'field' => 'fieldName',
				'direction' => 'ASC'
			),
			array(
				'field' => 'fieldName',
				'direction' => 'DESC'
			),
		));
		foreach ($entities as $pk => $entity) {
			...
		}
		
*/
abstract class Entity {
	private $m_tableName;
	private $m_pkName;
	private $m_fieldNames;
	private $m_linkedEntities; // Сущности, свзязанные с данной внешним ключом
	private $m_row;
	
	/*
		$fieldNames - array('...', '...', ...)
		$linkedEntities - array(array(fkName => CustomEntityType), ...)
	*/
	public function __construct($tableName, $pkName, $fieldNames, $linkedEntities = NULL) {
		$this->m_tableName = $tableName;
		$this->m_pkName = $pkName;
		$this->m_fieldNames = $fieldNames;
		$this->m_linkedEntities = $linkedEntities;
		$this->m_row = array();
		foreach ($this->m_fieldNames as $fieldName) {
			$this->m_row[$fieldName] = NULL;
		}
	}
	
	public function Load($pkValue) {
		if ($pkValue == -1) {
			return false;
		}
		
		$this->m_row = fetch_row(select($this->GetSelectOneEntitySql($pkValue)));
		return true;
	}
	
	public function Save($pkValue) {
		if ($pkValue == -1) {
			return update($this->GetInsertOneEntitySql());
		} else {
			return update($this->GetUpdateOneEntitySql($pkValue));
		}
	}
	
	/*
		Возвращает массив сущностей отсортированных и удовлетворяющих условию
		$orderBy - array(array('field' => '...', 'direction' => 'ASC/DESC'), ...)
		$where - строка SQL WHERE
	*/
	public function Enumerate($orderBy = NULL, $whereString = '') {
		$rows = fetch_all(select($this->GetSelectEntitiesSql($orderBy, $whereString)));
		$entities = array();
		foreach ($rows as $row) {
			// new Entity($this->m_tableName, $this->m_pkName, $this->m_fieldNames, $this->m_linkedEntities);
			$entity = $this->CloneEntity();
			$entity->m_row = $row;
			$entities[$entity->GetPkValue()] = $entity;
		}
		return $entities;
	}
	
	/*
		Для текущей сущности по имени внешнего ключа загружается сущность, связанная с внешним ключом
	*/
	public function GetLinkedEntity($fkName) {
		if ($this->m_linkedEntities == NULL) {
			return NULL;
		}
		
		if (!isExists($fkName, $this->m_linkedEntities)) {
			return NULL;
		}
		
		$fkValue = $this->Get($fkName);
		if ($fkValue == NULL) {
			return NULL;
		}
		
		$linkedEntity = $this->m_linkedEntities[$fkName]->CloneEntity();
		$linkedEntity->Load($fkValue);
		return $linkedEntity;
	}
	
	/*
		Отрицательные значения pk не допускаются
	*/
	public function Delete($pkValue) {
		if ($pkValue == -1) {
			return false;
		}
		
		return update($this->GetDeleteOneEntitySql($pkValue));
	}
	
	/*
		Если поле не задано или не существует возвращает NULL
		Иначе значение поля
	*/
	public function Get($fieldName) {
		if ($this->m_row == NULL) {
			return NULL;
		}
		
		if (!array_key_exists($fieldName, $this->m_row)) {
			return NULL;
		}
		
		return $this->m_row[$fieldName];
	}
	
	/*
		Значение primary key
		Если не задано возвращает -1
	*/
	public function GetPkValue() {
		$pkValue = $this->Get($this->m_pkName);
		return $pkValue == NULL ? -1 : $pkValue;
	}
	
	public function Set($fieldName, $fieldValue) {
		if ($this->m_row == NULL) {
			return false;
		}
		
		if (!array_key_exists($fieldName, $this->m_row)) {
			return false;
		}
		
		$this->m_row[$fieldName] = $fieldValue;
	}
	
	// Should return instance of current entity
	
	abstract protected function CloneEntity();
	
	// Private. SQL generation
	
	private function GetSelectOneEntitySql($pkValue) {
		$fieldsStr = implode(',', $this->m_fieldNames);
		$pkName = $this->m_pkName;
		$tableName = $this->m_tableName;
		return "SELECT $pkName, $fieldsStr FROM $tableName WHERE $pkName = '$pkValue' LIMIT 1;";
	}
	
	private function GetSelectEntitiesSql($ordersBy, $whereString) {
		$ordersByStr = '';
		if ($ordersBy != NULL && count($ordersBy) > 0) {
			$isFirst = true;
			foreach ($ordersBy as $orderBy) {
				if (!$isFirst) {
					$ordersByStr .= ',';
				}
				$isFirst = false;
				$ordersByStr .= $orderBy['field'] . ' ' . $orderBy['direction'];
			}
		}
		$fieldsStr = implode(',', $this->m_fieldNames);
		$pkName = $this->m_pkName;
		$tableName = $this->m_tableName;
		$where = $whereString != '' ? "WHERE $whereString" : '';
		$orderBy = $ordersByStr != '' ? "ORDER BY $ordersByStr" : "ORDER BY $pkName";
		return "SELECT $pkName, $fieldsStr FROM $tableName $where $orderBy;";
	}
	
	private function GetDeleteOneEntitySql($pkValue) {
		$pkName = $this->m_pkName;
		$tableName = $this->m_tableName;
		return "DELETE FROM $tableName WHERE $pkName = '$pkValue';";
	}
	
	private function GetUpdateOneEntitySql($pkValue) {
		$fieldsStr = '';
		$isFirst = true;
		$tableName = $this->m_tableName;
		foreach ($this->m_fieldNames as $fieldName) {
			if (!$isFirst) {
				$fieldsStr .= ',';
			}
			$isFirst = false;
			$fieldValue = $this->m_row[$fieldName];
			$fieldsStr .= "$fieldName = '$fieldValue'";
		}
		$pkName = $this->m_pkName;
		return "UPDATE $tableName SET $fieldsStr WHERE $pkName = '$pkValue';";
	}
	
	private function GetInsertOneEntitySql() {
		$fieldsStr = '';
		$valuesStr = '';
		$isFirst = true;
		foreach ($this->m_fieldNames as $fieldName) {
			if (!$isFirst) {
				$fieldsStr .= ',';
				$valuesStr .= ',';
			}
			$isFirst = false;
			$fieldValue = $this->m_row[$fieldName];
			$fieldsStr .= $fieldName;
			$valuesStr .= "'$fieldValue'";
		}
		$tableName = $this->m_tableName;
		$pkName = $this->m_pkName;
		return "INSERT INTO $tableName ($fieldsStr) VALUES ($valuesStr);";
	}
}

?>