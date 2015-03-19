<?php

namespace Morpheus;

include_once __DIR__.'/Region.php';
include_once __DIR__.'/CoordinatesIterator.php';
include_once __DIR__.'/Color.php';

abstract class Image {

	const NUL = "\x00";
	const SOH = "\x01";
	const STX = "\x02";
	const ETX = "\x03";
	const EOT = "\x04";

	private $image;
	private $coordinates;
	private $offset = 0;
	private $length = 0;

	/**
	 * Create a new Morpheus\Image instance.
	 *
	 * @param resource|Imagick GD Resource or Imagick instance
	 * @return Morpheus\Image
	 */
	static function create($im) {

		if(is_resource($im) && get_resource_type($im)) {
			return new ImageGD($im);
		}
		if($im instanceof \Imagick) {
			return new ImageImagick($im);
		}
	}

	abstract function getWidth();
	abstract function getHeight();
	abstract function getColor($x, $y);
	abstract function setColor($x, $y, Color $color);

	/**
	 * Image object can't be instanciate directly.
	 * Use Morpheus\Image::create() method instead.
	 * @see Morpheus\Image::create
	 */
	protected function __construct() {
		$region = new Region(0, 0, $this->getWidth(), $this->getHeight());
		$this->coordinates = new CoordinatesIterator($region);
	}

	/**
	 * Calculate the XOR parity of the given byte.
	 * @param integer byte between 0x00 and 0xFF
	 * @return bool
	 */
	private function parity($byte) {
		$parity = 0;
		for($i=7; $i>=0; $i--) {
			$parity ^= ($byte >> $i) & 1;
		}
		return (bool) $parity;
	}

	/**
	 * Store a byte at the current coordinates pointer
	 * @param integer byte between 0x00 and 0xFF
	 */
	private function writeByte($byte) {
		// byte :    0b11010100
		// parity :          0b1
		// pixel 1 :   110
		// pixel 2 :      101
		// pixel 3 :         001

		list($x, $y) = $this->coordinates->current();
		$color = $this->getColor($x, $y);
		$color->writeBits(($byte>>5) & 7);
		$this->setColor($x, $y, $color);

		$this->coordinates->next();
		list($x, $y) = $this->coordinates->current();
		$color = $this->getColor($x, $y);
		$color->writeBits(($byte>>2) & 7);
		$this->setColor($x, $y, $color);

		$this->coordinates->next();
		list($x, $y) = $this->coordinates->current();
		$color = $this->getColor($x, $y);
		$color->writeBits(($byte<<1) & 7 | $this->parity($byte));
		$this->setColor($x, $y, $color);

		$this->coordinates->next();
	}

	/**
	 * Write a binary payload in the image.
	 * Consider using serialize/unserialize for storing mixed payloads
	 * @param string $payload
	 * @return boolean Return FALSE in case of failure
	 */
	public function write($payload) {
		$this->coordinates->rewind();

		$size = strlen($payload);

		$header = pack("aVa", self::SOH, $size, self::STX);
		$footer = pack("aa", self::ETX, self::EOT);
		$payload = $header.$payload.$header;
		$size += strlen($header.$footer);

		if(ceil(count($this->coordinates) / 3) < $size) {
			// Image too small
			return false;
		}

 		for($cursor = 0; $cursor < $size; $cursor ++) {
			$byte = ord($payload[$cursor]);
			$this->writeByte($byte);
		}

		return true;
	}

	public function read() {
		$this->coordinates->rewind();

		$payload = "";

		for($cursor = 0; $cursor < 6; $cursor ++) {
			$byte = $this->readByte();
			$payload .= chr($byte);
		}

		$header = unpack("aSOH/Vlength/aSTX", $payload);
		$payload = "";

		for($cursor = 0; $cursor < $header['length']; $cursor ++) {
			$byte = $this->readByte();
			$payload .= chr($byte);
		}

		return $payload;
	}

	private function readByte() {

		list($x, $y) = $this->coordinates->current();
		$color = $this->getColor($x, $y);
		$byte = $color->readBits() << 5;

		$this->coordinates->next();
		list($x, $y) = $this->coordinates->current();
		$color = $this->getColor($x, $y);
		$byte += $color->readBits() << 2;

		$this->coordinates->next();
		list($x, $y) = $this->coordinates->current();
		$color = $this->getColor($x, $y);
		$bits = $color->readBits();
		$byte += $bits >> 1;
		$parity = $bits & 1;

		$this->coordinates->next();

		return $byte;
	}

	public function clear() {

		$this->coordinates->rewind();
		foreach($this->coordinates as $pixel) {
			list($x, $y) = $pixel;
			$color = $this->getColor($x, $y);
			$color->writeBits(0x00);
			$this->setColor($x, $y, $color);
		}
	}
}

class ImageGD extends Image {

	protected $im;

	protected function __construct($im) {
		$this->im = $im;
		imagealphablending($im, false);
 		imagesavealpha($im, true);
		parent::__construct();
	}

	function getWidth() {
		return imagesx($this->im);
	}

	function getHeight() {
		return imagesy($this->im);
	}

	function getColor($x, $y) {
		$color = imagecolorat($this->im, $x, $y);
		$a = ($color >> 24) & 0x7F;
		$r = ($color >> 16) & 0xFF;
		$g = ($color >> 8) & 0xFF;
		$b = ($color >> 0) & 0xFF;
		return new Color($r, $g, $b, $a);
	}

	function setColor($x, $y, Color $color) {
		$r = (int) $color->r;
		$g = (int) $color->g;
		$b = (int) $color->b;
		$a = (int) $color->a;

		if($a > 0) {
			$im_color = imagecolorallocatealpha($this->im,$r,$g,$b,$a);
		} else {
			$im_color = imagecolorallocate($this->im,$r,$g,$b);
		}
		imagesetpixel($this->im,$x,$y,$im_color);
        imagecolordeallocate($this->im, $im_color);
	}
}

class ImageImagick extends Image {

	protected $im;

	protected function __construct(\Imagick $im) {
		$this->im = $im;
		parent::__construct();
	}

	function getWidth() {
		return $this->im->getImageWidth();
	}

	function getHeight() {
		return $this->im->getImageHeight();
	}

	function getColor($x, $y) {
		$pixel = $this->im->getImagePixelColor($x, $y);
		$colors = $pixel->getColor();

		// Determine alpha value
		$ncolors = $pixel->getColor($normalized = true);
		$alpha = round($ncolors['a'] * 0xFF);

		return new Color($colors['r'], $colors['g'], $colors['b'], $alpha);
	}

	function setColor($x, $y, Color $color) {
		$pixel = $this->im->getImagePixelColor($x, $y);

		$pixel->setColorValue(\Imagick::COLOR_RED,   $color->r / 0xFF);
		$pixel->setColorValue(\Imagick::COLOR_GREEN, $color->g / 0xFF);
		$pixel->setColorValue(\Imagick::COLOR_BLUE,  $color->b / 0xFF);
		$pixel->setColorValue(\Imagick::COLOR_ALPHA, max($color->a, 1) / 0xFF);

		$draw  = new \ImagickDraw();
      	$draw->setFillColor($pixel);
      	$draw->point($x, $y);
      	$this->im->drawImage($draw);
	}

}
