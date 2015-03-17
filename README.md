### Installing via Composer

The recommended way to install Morpheus is through [Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php

# Add Guzzle as a dependency
php composer.phar require pyrou/morpheus
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```
### How to use it

```php
# to write data in image
$im = imagecreatefrompng("source.png");
Morpheus\Data::write("Helloworld", $im);
imagepng($im, "output.png");

# to read data from image
$im = imagecreatefrompng("output.png");
assert("Helloworld" === Morpheus\Data::read($im));

```

### How it's work ?

Let's explain how it's work with an example.

![input](https://raw.githubusercontent.com/pyrou/Morpheus/master/images/docs/example.png)

Bellow is how humans and computers (or perspicuous humans) can see the `output.png` file.

| output.png | `--debug`* |
| --- | --- |
| ![output.png](https://raw.githubusercontent.com/pyrou/Morpheus/master/images/docs/output@3x.png) | ![What library sees](https://raw.githubusercontent.com/pyrou/Morpheus/master/images/docs/whatLibrarySees@3x.png) |

In fact, the library has slightly changed the coloration of each pixels in upper-half of the file. So slightly than a human eye is NOT able to detect it.

*For understand what Morpheus did, and what he sees now.
