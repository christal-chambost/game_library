# game_library

composer require symfony/webpack-encore-bundle

https://symfony.com/doc/current/security.html

composer require symfony/security-bundle
php bin/console security:hash-password

## migration bdd
php bin/console make:migration
php bin/console doctrine:migrations:migrate

## crér un user
php bin/console make:user

## créer un entity
php bin/console make:entity

## créer un controller 
php bin/console make:controller

## lancer le serveur 
symfony server:start

## lancer apache2 et mysql
sudo service apache2 start
sudo service mysql start

## fixtures
https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html

composer require --dev orm-fixtures
php bin/console doctrine:fixtures:load

## SensioFrameworkExtraBundle
$ composer require sensio/framework-extra-bundle