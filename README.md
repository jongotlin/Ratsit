# Ratsit/Checkbiz API wrapper

[![Build Status](https://img.shields.io/travis/jongotlin/Ratsit/master.svg)](https://travis-ci.org/jongotlin/Ratsit)

## Installation
```bash
$ composer require jongotlin/ratsit
```

## Usage
```php
$token = '****';
$ratsit = new \JGI\Ratsit\Ratsit($token);
$ratsit->setHttpClient($client); // $client is a \Http\Client\HttpClient
$persons = $ratsit->searchPerson('Per Fredrik', 'EKEBY');
$person = $ratsit->findPersonBySocialSecurityNumber('194107081111');
```

## Symfony Bundle
See [jongotlin/ratsit-bundle](https://github.com/jongotlin/RatsitBundle)
 

