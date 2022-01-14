<?php

namespace Nin\Providers;

use Nin\Provider;

class ArrayProvider extends Provider
{
	public $array = [];
	public $iterator = 0;

	public function __construct($array)
	{
		$this->array = $array;
	}

	public function begin()
	{
		$this->iterator = 0;
	}

	public function end()
	{
	}

	public function count()
	{
		return count($this->array);
	}

	public function getNext()
	{
		if($this->iterator >= count($this->array)) {
			return null;
		}
		return $this->array[$this->iterator++];
	}
}
