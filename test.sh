#!/bin/bash
./sandbox_setup.sh
cd sandbox
php artisan dusk:install
php artisan serve --env=dusk.local &
php artisan dusk
php artisan adminlte:admin
./vendor/bin/phpunit --coverage-text --coverage-clover=../coverage.clover
cd ..
./sandbox_destroy.sh

