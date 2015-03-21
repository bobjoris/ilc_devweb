#/bin/sh
php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:schema:update --force

php app/console doctrine:fixtures:load -n


#mysql -u root -p alertecobra<users.sql