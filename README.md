ErgometriX API
==============

Installation
------------
From root directory, run :
`composer install`

Adapt `app/config/parameters.yml` to your settings.

From root directory, run :
```
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
```` 
