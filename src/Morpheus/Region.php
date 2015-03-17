<?php

namespace Morpheus;

class Region {

	public $x;
	public $y;
	public $w;
	public $h;

	/**
	 * @param integer $x
	 * @param integer $y
	 * @param integer $w
	 * @param integer $h
	 */
	function __construct($x, $y, $w, $h) {
		$this->x = (int) $x;
		$this->y = (int) $y;
		$this->w = (int) $w;
		$this->h = (int) $h;
	}
}
