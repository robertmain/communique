# Communique

[![Join the chat at https://gitter.im/robertmain/communique](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/robertmain/communique?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![Build Status](https://travis-ci.org/robertmain/communique.svg?branch=master)](https://travis-ci.org/robertmain/communique) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/robertmain/communique/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/robertmain/communique/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/robertmain/communique/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/robertmain/communique/?branch=master)  

[![Latest Stable Version](https://poser.pugx.org/robertmain/communique/v/stable)](https://packagist.org/packages/robertmain/communique)
[![Total Downloads](https://poser.pugx.org/robertmain/communique/downloads)](https://packagist.org/packages/robertmain/communique)
[![Latest Unstable Version](https://poser.pugx.org/robertmain/communique/v/unstable)](https://packagist.org/packages/robertmain/communique)
[![License](https://poser.pugx.org/robertmain/communique/license)](https://packagist.org/packages/robertmain/communique)
[![Monthly Downloads](https://poser.pugx.org/robertmain/communique/d/monthly)](https://packagist.org/packages/robertmain/communique)
[![Daily Downloads](https://poser.pugx.org/robertmain/communique/d/daily)](https://packagist.org/packages/robertmain/communique)

##What is it?
A flexible pluggable REST client using middleware. The aim of this project is to provide a REST client that is flexible enough to permit the modification of the request and response using request and response interceptors(conceptually similar to AngularJS, although implemented somewhat differently).

##Usage

###Typical Usage
You can make a request with the REST library using the code below. It is worth noting, the get, put, post, delete etc. methods 
do not return the raw response payload, but an encapsulation object of type [\Communique\RESTClientResponse](http://robertmain.github.io/communique/classes/Communique.RESTClientResponse.html). This object contains

1. The HTTP status code (200, 201, 404, 500 etc.)
1. The response payload (the response body from the server)
1. The server headers (any headers that the server returned with the payload, these are often useful for cache control).

You can find more information from the [\Communique\RESTClientResponse](http://robertmain.github.io/communique/classes/Communique.RESTClientResponse.html) documentation

```php
<?php
     $rest = new \Communique\Communique('http://api.company.com/');
     $response = $rest->get('users/1'); //Contains information about user number 1
     // Since $response is actually a RESTClientResponse object (rather than the raw response payload), we can get
     // properties of the request like so:
     echo $response->status; //This will be the HTTP status code
     // If we want the raw request payload we do this:
     echo $response->payload;
     // Headers can be retrieved like so:
     echo $response->getHeader('header_key');
?>
```
###Request Interceptors
Whilst the above example is useful for making simple requests and returning the result from the API,
you may wish to have a little more control over the request. Communique provides a method to do this using Interceptors. 
An interceptor is a class with request and response methods. The request method of each interceptor is called on each request
and each the response interceptor method is called on each response. This allows the complex modification of requests juts before
they are sent and just after they are retured. This allows for things like JSON parsing, OAuth request signing or caching.
Interceptors are executed in the order in which they are provided.
If you wish to add an interceptor, you may do so by passing an array with an instance of your interceptor as the second constructor
argumment to Communique. Interceptors should implement the [\Communique\Interceptor](http://robertmain.github.io/communique/classes/Communique.Interceptor.html) interface

```php
<?php
     $rest = new \Communique\Communique('http://api.company.com/', array(new JSONParser(), new OAuth()));
     // Use the library as before
?>
```
###Custom HTTP Client
This library ships out of the box with a cURL implementation, however if you wish to provide your own you may do so
using the third constructor argument as follows:
```php
<?php
    $rest = new \Communique\Communique('http://api.company.com/', array(new JSONParser(), new OAuth()), new CustomHTTPClient());
    // Use the library as before
?>
```

##Licensing
Licensed under the GPL - please see the file called LICENSE for more info.

##Contacts
- If you want to submit a bug report or issue, please do so using the issue tracker on GitHub

##Documentation
The documentation can be found [here](http://robertmain.github.io/communique)
