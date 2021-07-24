# Timer
Tiny PHP timer utility to measure time

## Install 
```console
$ composer require gabrielef/timer
```
## Usage
Start a new timer with name and precision:
```php
use gabrielef\Timer;

$t = new Timer();
$t->start('firstTimer', 3);
```

Retrieve the amount of time passed of a specific timer:
```php
use gabrielef\Timer;

$t = new Timer();
$t->start('firstTimer', 3);

//...
//after 1s

echo $t->look('firstTimer'); //ex. 1.234
```

Stop the timer (this will also delete the timer):
```php
use gabrielef\Timer;
$t = new Timer();
$t->start('firstTimer');

//...
//after 3s

echo $t->end('firstTimer'); //ex. 3
```

List all the available timer key:
```php
use gabrielef\Timer;

$t = new Timer();
$t->start('firstTimer');
$t->start('secondTimer');
$t->start('thirdTimer');

$list = $t->list(); // ['firstTimer', 'secondTimer', 'thirdTimer]
```

## Test

Currently using PHPUnit with the following command:
```console
$ docker run --rm -v $(pwd):/app -w /app php:7.3-cli ./vendor/bin/phpunit --debug
```