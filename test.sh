#!/bin/bash
./sandbox_setup.sh
cd sandbox
php artisan adminlte:admin
./vendor/bin/phpunit --coverage-text --coverage-clover=../coverage.clover
php artisan dusk:install
php artisan serve --env=dusk.local &
php artisan dusk
cd ..
./sandbox_destroy.sh

