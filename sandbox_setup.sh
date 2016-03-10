#!/bin/bash
if ! type "laravel" > /dev/null; then
    composer global require "laravel/installer"
fi
if ! type "adminlte-laravel" > /dev/null; then
    composer global require "acacha/adminlte-laravel-installer=~1.0"
fi

laravel new sandbox
cd sandbox
adminlte-laravel install
touch database/database.sqlite
cd ..


