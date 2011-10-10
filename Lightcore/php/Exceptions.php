<?php

/// Logic errors 

class LogicError extends Exception
{
	public function __construct($message = null)
	{
		parent::__construct($message);
	}
}

class DomainError extends LogicError
{
	public function __construct($message = null)
	{
		parent::__construct($message);
	}
}

class InvalidArgument extends LogicError
{
	public function __construct($message = null)
	{
		parent::__construct($message);
	}
}
class LengthError extends LogicError
{
	public function __construct($message = null)
	{
		parent::__construct($message);
	}
}
class OutOfRange extends LogicError
{
	public function __construct($message = null)
	{
		parent::__construct($message);
	}
}

/// Runtime errors

class RuntimeError extends Exception
{
	public function __construct($message = null)
	{
		parent::__construct($message);
	}
}

class RangeError extends RuntimeError
{
	public function __construct($message = null)
	{
		parent::__construct($message);
	}
}

class OverflowError extends RuntimeError
{
	public function __construct($message = null)
	{
		parent::__construct($message);
	}
}

class UnderflowError extends RuntimeError
{
	public function __construct($message = null)
	{
		parent::__construct($message);
	}
}