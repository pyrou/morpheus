<?php

namespace Morpheus;

class Color {

	public $r;
	public $g;
	public $b;
	public $a;

	/**
     * @param integer $red   	Red value 0-255
     * @param integer $green 	Green value 0-255
     * @param integer $blue  	Blue value 0-255
     * @param integer $alpha  	Alpha value 0-255
	 */
	function __construct($red, $green, $blue, $alpha = 0) {
		$this->r = $red;
		$this->g = $green;
		$this->b = $blue;
		$this->a = $alpha;
	}

	/**
	 * Write a 3-bits-length integer in color
     * @param integer $value	Integer value between 0 (0b000) and 7 (0b111)
     */
	function writeBits($value) {
		$this->r = ($this->r & 0xFE) + ($value >> 2 & 1);
		$this->g = ($this->g & 0xFE) + ($value >> 1 & 1);
		$this->b = ($this->b & 0xFE) + ($value >> 0 & 1);
		/* // debug colors
		$this->r = 0;
		$this->g = $value << 5;
		$this->b = 0;
		$this->a = 1;
		/**/
	}

	/**
	 * Read 3-bits-length integer from color
     * @return integer 	Integer value between 0 (0b000) and 7 (0b111)
     */
	function readBits() {
		$value  = ($this->r & 1) << 2;
 		$value += ($this->g & 1) << 1;
 		$value += ($this->b & 1) << 0;

		return $value;
	}
}
