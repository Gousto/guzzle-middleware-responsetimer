# Response timer for Guzzle
A simple timer and logger that records response times for requests made by a [Guzzle] client to a [PSR-3] log. Created initially to help [Gousto] get an idea of how microservices were interacting and performing.

It has some advantages over some other timers that already existed, in that it natively supports asynchronous calls, and uses the `Request` object itself as the key, therefore allowing multiple calls to the same URI to be recorded separately.

## Installation

Installation is recommended via [composer]:

```bash
composer require shrikeh/guzzle-middleware-response-timer
```

## Requirements and versioning

If installed by composer, all requirements should be taken care of.
Semantic versioning is in use and strongly adhered to in tags 1.0 and beyond; branches before that are a little bit more free as I was shopping with ideas and the interface.

Tags <2.0 are 5.6 compatible; versions 2.0 and beyond are PHP 7.1+ only.

## Basic usage

The following is a simple example using the `quickStart()` method, which accepts a `Psr\Log\LoggerInterface` logger (in this case, a simple file stream implemented by [Monolog]):
```php
<?php

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Request;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Shrikeh\GuzzleMiddleware\TimerLogger\Middleware;

require_once __DIR__.'/../vendor/autoload.php';

$logFile = __DIR__.'/logs/example.log';

// clear down log file for testing
unlink($logFile);

// create a log channel
$log = new Logger('guzzle-response-times');
$log->pushHandler(new StreamHandler(
    $logFile,
    Logger::DEBUG
));

// hand it to the middleware (this will create a default working example)
$middleware = Middleware::quickStart($log);

// now create a Guzzle middleware stack
$stack = HandlerStack::create();

// and register the middleware on the stack
$stack->push($middleware());

// then hand the stack to the client
$client = new Client(['handler' => $stack]);

$request1 = new Request('GET', 'https://www.facebook.com');
$request2 = new Request('GET', 'https://en.wikipedia.org/wiki/Main_Page');
$request3 = new Request('GET', 'https://www.google.co.uk');

$promises = [
    $client->sendAsync($request1),
    $client->sendAsync($request2),
    $client->sendAsync($request3)
];

$results = Promise\settle($promises)->wait();

print file_get_contents($logFile);
```
[composer]: https://getcomposer.org
[PSR-3]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md
[Guzzle]: http://docs.guzzlephp.org/en/stable/
[Monolog]: https://github.com/Seldaek/monolog
[Gousto]: https://www.gousto.co.uk/
