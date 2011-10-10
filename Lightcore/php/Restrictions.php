<?php

define('STRING_TYPE', 1);
define('INTEGER_TYPE', 2);
define('NUMERIC_TYPE', 3);
define('FLOAT_TYLE', 4);
define('DATE_TYPE', 5);
define('ARRAY_TYPE', 6);
define('NOT_ARRAY_TYPE', 7);
	
class TypeRestriction
{
	public static function GetErrorMessage ($restrictionType)
	{
		$typeName = '';
		switch ($restrictionType)
		{
			case STRING_TYPE:
				$typeName = 'string';
				break;
			case INTEGER_TYPE:
				$typeName = 'integer';
				break;
			case NUMERIC_TYPE:
				$typeName = 'numeric';
				break;
			case FLOAT_TYLE:
				$typeName = 'float';
				break;
			case DATE_TYPE:
				$typeName = 'date';
				break;
			case ARRAY_TYPE:
				$typeName = 'array';
				break;
			case NOT_ARRAY_TYPE:
				$typeName = 'not array';
				break;
			default:
				$typeName = 'unknown';
				break;
		}
		
		return "Type should be an '$typeName'";
	}
	
	public static function CheckType ($variable, $restrictionType)
	{
		switch ($restrictionType)
		{
			case STRING_TYPE:
				return is_string($variable);
			case INTEGER_TYPE:
				return is_integer($variable);
			case NUMERIC_TYPE:
				return is_numeric($variable);
			case FLOAT_TYLE:
				return is_double($variable);
			case DATE_TYPE:
				return (boolean)strtotime($variable);
			case ARRAY_TYPE:
				return is_array($variable);		
			case NOT_ARRAY_TYPE:
				return !is_array($variable);						
			default:
				return false;
		}
		
		return false;
	}
	
}

abstract class ContentsRestriction
{
	private $m_dataType;
	private $error = null;
	
	public function __construct ($dataType)
	{
		$this->m_dataType = $dataType;
	}
	
	public function IsValid($variable)
	{
		self::ResetError();
		if(!TypeRestriction::CheckType($variable, $this->m_dataType))
		{
			self::SetError('invalid data type');
			return false;
		}
		else
		{
			return $this->_IsValid($variable);
		}
	}
	
	public function GetError()
	{
		return $this->error;
	}
	
	protected function SetError($message)
	{
		$this->error = $message;
		return true;
	}
	
	protected function ResetError()
	{
		$this->error = null;
	}
	abstract protected function _IsValid($variable);	
}

class TypeCheckRestriction extends ContentsRestriction
{
	public function __construct ($type)
	{
		parent::__construct($type);
	}
	
	protected function _IsValid($variable)
	{
		return true;
	}
}

class LengthRestriction extends ContentsRestriction
{
	private $m_minLength;
	private $m_maxLength;
		
	public function __construct ($minLength, $maxLength)
	{
		if($minLength > $maxLength || $minLength < 0)
		{
			throw new OutOfRange();
		}
		parent::__construct(STRING_TYPE);
		$this->m_minLength = $minLength;
		$this->m_maxLength = $maxLength;
	}
	
	protected function _IsValid($variable)
	{
		$length = strlen($variable);
		if($length >= $this->m_minLength && $length <= $this->m_maxLength)
		{
			return true;
		}
		else
		{
			parent::_SetError('invalid length');
		}
	}
}

class EmailRestriction extends ContentsRestriction
{
	public function __construct ()
	{
		parent::__construct(STRING_TYPE);
	}
	
	protected function _IsValid($variable)
	{
		if(filter_var($variable, FILTER_VALIDATE_eMAIL))
		{
			return true;
		}
		else
		{
			parent::SetError('invalid email address syntax');
		}
	}
}

class UrlRestriction extends ContentsRestriction
{
	public function __construct ()
	{
		parent::__construct(STRING_TYPE);
	}
	
	protected function _IsValid($variable)
	{
		if(filter_var($variable, FILTER_VALIDATE_URL))
		{
			return true;
		}
		else
		{
			parent::SetError('invalid url syntax');
		}
	}
}

class IpRestriction extends ContentsRestriction
{
	public function __construct ()
	{
		parent::__construct(STRING_TYPE);
	}
	
	protected function _IsValid($variable)
	{
		if(filter_var($variable, FILTER_VALIDATE_IP))
		{
			return true;
		}
		else
		{
			parent::SetError('invalid url syntax');
		}
	}
}

class DateRangeRestriction extends ContentsRestriction
{
	private $m_minDate;
	private $m_maxDate;
		
	public function __construct ($minDate, $maxDate)
	{
		$minDate = strtotime($minDate);
		$maxDate = strtotime($maxDate);
		
		if($minDate > $maxDate || $minDate < 0)
		{
			throw new OutOfRange();
		}
		parent::__construct(DATE_TYPE);
		$this->m_minDate = $minDate;
		$this->m_maxDate = $maxDate;
	}
	
	protected function _IsValid($variable)
	{
		$time = strtotime($variable);
		if($time >= $this->m_minDate && $time <= $this->m_maxDate)
		{
			return true;
		}
		else
		{
			parent::SetError('date out of range');
		}
	}
}

class NumericRangeRestriction extends ContentsRestriction
{
	private $m_min;
	private $m_max;
		
	public function __construct ($min, $max)
	{
		if($min > $max || $min < 0)
		{
			throw new OutOfRange();
		}
		parent::__construct(NUMERIC_TYPE);
		$this->m_min = $min;
		$this->m_max = $max;
	}
	
	protected function _IsValid($variable)
	{
		if($variable >= $this->m_min && $variable <= $this->m_max)
		{
			return true;
		}
		else
		{
			parent::SetError('number out of range');
		}
	}
}