<?php

include_once __DIR__."/../../src/Morpheus/Data.php";

$im = imagecreatefrompng("../output.png");

echo base64_decode(Morpheus\Data::read($im));
