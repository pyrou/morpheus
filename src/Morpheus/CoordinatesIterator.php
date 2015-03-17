<?php

namespace Morpheus;

include_once __DIR__.'/Region.php';

class CoordinatesIterator implements \Iterator, \Countable {

	private $x;
	private $y;
	private $rect;

	function __construct(Region $rect) {
		$this->rect = $rect;
	}

	function rewind() {
		$this->x = 0;
		$this->y = 0;
	}

	function valid() {
		return ($this->x + $this->y) >= 0;
	}

	function key() {
		return ($this->y * $this->rect->w) + $this->x;
	}

	function current() {
		return array($this->x + $this->rect->x, $this->y + $this->rect->y);
	}

	function next() {
		$this->x++;
		if($this->x >= $this->rect->w) {
			$this->x = 0;
			$this->y ++;
			if($this->y >= $this->rect->h) {
				$this->x = -1;
				$this->y = -1;
			}
		}
	}

	function count() {
		return $this->rect->w * $this->rect->h;
	}

}
