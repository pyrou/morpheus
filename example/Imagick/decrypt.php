<?php

include_once __DIR__."/../../src/Morpheus/Data.php";

$im = new Imagick("../output.png");

var_dump(Morpheus\Data::read($im));
