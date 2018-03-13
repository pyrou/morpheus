# Morpheus

![License](https://img.shields.io/packagist/l/pyrou/morpheus.svg)
[![Code Climate](https://codeclimate.com/github/pyrou/morpheus/badges/gpa.svg)](https://codeclimate.com/github/pyrou/morpheus)

Morpheus is a library to encrypt and decrypt data in colors of a picture. Process also known as steganography.

The library works regardless with imageMagick or GD library. 

### Installing via Composer

The recommended way to install Morpheus is through [Composer](http://getcomposer.org).

```bash
composer require pyrou/morpheus
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```
### How to use it

With GD library

```php 
# write data in image
$im = imagecreatefrompng("source.png");
Morpheus\Data::write("Helloworld", $im);
imagepng($im, "output.png");

# read data from image
$im = imagecreatefrompng("output.png");
assert("Helloworld" === Morpheus\Data::read($im));

```

With Image Magick

```php 
# write data in image
$im = new Imagick("source.png");
Morpheus\Data::write("Helloworld", $im);
$im->writeImage("output.png");

# read data from image
$im = new Imagick("output.png");
assert("Helloworld" === Morpheus\Data::read($im));

```

### How does it work ?

Let's explain how it works with an example. Consider this beautiful octocat

![input](https://raw.githubusercontent.com/pyrou/Morpheus/master/docs/example.png)

```php 
require 'vendor/autoload.php';
$im = imagecreatefrompng("source.png");
$data = base64_encode(
	"L'homme est un homme tant qu'il s'évertue ".
	"à s'élever au dessus de la nature, et cette ".
	"nature est à la fois intérieure et extérieure.");
Morpheus\Data::write($data, $im);
imagepng($im, "output.png");
```

Bellow is how humans and computers (or perspicuous humans) can see the `output.png` file.

| source.png | output.png | `--debug`* |
| --- | --- | --- |
| ![input](https://raw.githubusercontent.com/pyrou/Morpheus/master/docs/example.png) | ![output.png](https://raw.githubusercontent.com/pyrou/Morpheus/master/docs/output@3x.png) | ![What library sees](https://raw.githubusercontent.com/pyrou/Morpheus/master/docs/whatLibrarySees@3x.png) |

In fact, the library has slightly changed the coloration of each pixels in upper-half of the file. So slightly that human eyes are NOT able to detect it.

*For understand what Morpheus did, and what he sees now.
