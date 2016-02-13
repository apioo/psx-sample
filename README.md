PSX Sample
===

## About

This is a sample application wich can bootstrap a project based on the PSX 
framework. You can install it through composer

> php composer.phar create-project psx/sample .

More informations about PSX at http://phpsx.org

## Configuration

In the configuration.php file change the key "psx_url" to the absolute url to
the public folder. If you have setup a vhost this is simply the domain. In case
you use mod_rewrite you can set the key "psx_dispatch" to an empty value. 
Therefor you can use the sample htaccess file in the public folder.

## Getting started

In the following a few explanations about the important parts of the API.

 * `src/Sample/Api/Population/Collection.php`  
   This is the class which represents the /population endpoint

 * `src/Sample/Service/Population.php`  
   Service class which contains the business logic of the API.

 * `src/Sample/Dependency/Container.php`  
   DI container which overwrites the connection service to use a sqlite 
   database.

 * `tests/Sample/Api/Population/CollectionTest.php`
   Contains the PHPUnit test case for the /population endpoint. If you have 
   phpunit installed you can run the tests in the root of the project with the 
   phpunit command.
