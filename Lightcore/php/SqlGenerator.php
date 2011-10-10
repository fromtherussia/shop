<?php

class SqlGenerator {
	const WORDS_BY_OR = 1;
	const WORDS_BY_AND = 2;
	
	public static function WhereForTextSearch($params, $searchCase, $search, $preciseSearch = false) {
		$searchKeywords = explode(',', $search);
		$paramWhere = array();
		
		foreach ($searchKeywords as $keyword) {
			$keywordTrimmed = strtolower(trim($keyword));
			if (strlen($keywordTrimmed) > 0) {
				$first = true;
				$paramWhereStr = '';
				foreach ($params as $param) {
					if (!$first) {
						$paramWhereStr .= ' OR ';
					}
					$first = false;
					$param = str_replace('.', '`.`', "`$param`");
                    if ($preciseSearch) {
                        $paramWhereStr .= "lower($param) = '$keywordTrimmed'";
                    } else {
                        $paramWhereStr .= "lower($param) LIKE '%$keywordTrimmed%'";
                    }
				}
				if ($paramWhereStr) {
					$paramWhere []= "$paramWhereStr";
				}
			}
		}
		$glue = '';
		switch ($searchCase) {
			default:			
			case WORDS_BY_AND:
				$glue = 'AND';
				break;				
			case WORDS_BY_OR:
				$glue = 'OR';
				break;
		}
		$queryWhere = implode(" $glue ", $paramWhere);
		return "$queryWhere";
	}
}