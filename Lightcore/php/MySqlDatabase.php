<?php

class QueryResult
{
	private $m_queryResult = null;
	
	public function __construct($result)
	{
		if($result == null)
		{
			throw new InvalidArgument('argument null');
		}
		$this->m_queryResult = $result;
	}
	
	public function __destruct()
	{
		mysql_free_result($this->m_queryResult);
	}
	
	public function GetRowsCount ()
	{
		return mysql_num_rows($this->m_queryResult);
	}
	
	public function GetRows ()
	{
		$resultArray = array();
		while($row = mysql_fetch_assoc($this->m_queryResult)) 
		{
			$resultArray[] = $row;
		}
		return $resultArray;
	}
	
	public function GetRow ()
	{
		if($row = mysql_fetch_assoc($this->m_queryResult)) 
		{
			return $row;
		}
		return array();
	}
	
	public function GetOne ($columnName)
	{
		if($columnName == '')
		{
			if($row = mysql_fetch_row($this->m_queryResult)) 
			{
				return $row[0];
			}
		}
		else
		{
			if($row = mysql_fetch_assoc($this->m_queryResult)) 
			{
				if(array_key_exists($columnName, $row))
				{
					return $row[$columnName];
				}
				return null;
			}
		}
		return null;
	}
}

class DatabaseHandler
{
	private $m_rResource = null;
	private static $n_queriesCount = 0;
	
	function __construct($databaseURL, $databaseLogin, $databasePassword, $databaseName) 
	{
		if(!$this->Connect($databaseURL, $databaseLogin, $databasePassword, $databaseName))
		{
			throw new LogicError('can not connect to database');
		}
    }
	
	function __destruct()
	{
		$this->Disconnect();
	}
	
	public function Connect($databaseURL, $databaseLogin, $databasePassword, $databaseName)
	{
		if($this->Connected())
		{
			return false;
		}
		
		$tmpResource = @mysql_connect($databaseURL, $databaseLogin, $databasePassword);
		if($tmpResource === false)
		{
			return false;
		}
		
		$this->m_rResource = $tmpResource;
		if(@mysql_select_db($databaseName, $this->m_rResource) == false)
		{
			$this->Disconnect();
			return false;
		}
		
		return true;
	}
	
	public function Disconnect()
	{
		if(!$this->Connected())
		{
			return false;
		}
		
		@mysql_close($this->m_rResource);
		$this->m_rResource = null;
		return true;
	}
	
	public function Connected()
	{
		return $this->m_rResource != null;
	}
	
	public function Query($query)
	{
		if( !$this->Connected() )
		{
			return null;
		}
		
		$result = @mysql_query($query, $this->m_rResource);	
		if( $result === false )
		{
			return null;
		}
		
		$n_queriesCount ++;
		if($result === true)
		{
			return true;
		}
		
		try
		{
			return new QueryResult($result);			
		}
		catch(Exception $exception)
		{
		}
		return null;
	}
	
	public static function GetQueriesCount ()
	{
		return $n_queriesCount;
	}
	
	public function GetLastInsertId ()
	{
		return mysql_insert_id($this->m_rResource);
	}
}

$g_connection = null;
function get_connection()
{
	global $g_connection;
	if($g_connection == null)
	{
		try
		{
			$g_connection = new DatabaseHandler(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		}
		catch(Exception $e)
		{
		}
	}
	return $g_connection;
}

function select_one($query, $columnName = '')
{
	$connection = get_connection();
	if($connection == null)
	{
		return null;
	}
	$result = $connection->Query($query);
	if($result === true || $result == null)
	{
		return null;
	}
	return $result->GetOne($columnName);
}

function select_row($query)
{
	$connection = get_connection();
	if($connection == null)
	{
		return null;
	}
	$result = $connection->Query($query);
	if($result === true || $result == null)
	{
		return null;
	}
	return $result->GetRow();
}

function select_all($query)
{
	$connection = get_connection();
	if($connection == null)
	{
		return null;
	}
	$result = $connection->Query($query);
	if($result === true || $result == null)
	{
		return null;
	}
	return $result->GetRows();
}

$lastInsertedId = null;

function query($query)
{
	$connection = get_connection();
	if($connection == null)
	{
		return false;
	}
	$result = $connection->Query($query) === true; 
	
	if($result)
	{
		global $lastInsertedId;
		$lastInsertedId = $connection->GetLastInsertId();
	}
	
	return $result;
}

function get_last_inserted_id ()
{
	global $lastInsertedId;
	return $lastInsertedId;
}