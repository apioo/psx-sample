PSX Sample
===

## About

This is an sample application wich can bootstrap a project based on the PSX 
framework. You can install this sample through composer

php composer.phar create-project psx/sample .

More informations about PSX at http://phpsx.org

## Configuration

In the configuration.php file change the key "psx_url" to the absolute url to
the public folder. If you have setup an vhost this is simply the domain. In case
you use mod_rewrite you can set the key "psx_dispatch" to an empty value. 
Therefor you can use the sample htaccess file in the public folder.
