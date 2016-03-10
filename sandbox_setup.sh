#!/bin/bash
if ! type "laravel" > /dev/null; then
    composer global require "laravel/installer"
fi
if ! type "adminlte-laravel" > /dev/null; then
    composer global require "acacha/adminlte-laravel-installer=~1.0"
fi
rm -rf sandbox
~/.composer/vendor/bin/laravel new sandbox
cd sandbox
~/.composer/vendor/bin/adminlte-laravel install
touch database/database.sqlite


