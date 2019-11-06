Fortune Game - mini game

Symfony based

Use:

FosUserBundle - for work with users

EasyAdminBundle - for admin

Unirest-php - for http request to remote api(bank)

INSTALL

It is understood that you already have: php^5.4, pdo_sqlite or pdo_mysql.
if you use pdo_mysql you need to customize fortune/app/config/config.yml file

run:

git clone https://github.com/igorkryvoruchko/fortune.git

composer install

php bin/console doctrine:database:create

php bin/console doctrine:schema:update --force

to run dev-server: php bin/console server:run

hello i am commit


