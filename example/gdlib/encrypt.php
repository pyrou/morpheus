<?php

include_once __DIR__."/../../src/Morpheus/Data.php";

$im = imagecreatefrompng("../source.png");

$data = base64_encode(
	"L'homme est un homme tant qu'il s'évertue ".
	"à s'élever au dessus de la nature, et cette ".
	"nature est à la fois intérieure et extérieure.");

Morpheus\Data::write($data, $im);
imagepng($im, "../output.png");
