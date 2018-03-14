#!/bin/bash
if ! type "laravel" > /dev/null; then
    composer global require "laravel/installer"
fi
if ! type "adminlte-laravel" > /dev/null; then
    composer global require "acacha/adminlte-laravel-installer:dev-master"
fi
if ! type "llum" > /dev/null; then
    composer global require "acacha/llum"
fi
export PATH="~/.composer/vendor/bin:~/.config/composer/vendor:$PATH"
rm -rf sandbox
laravel new sandbox
cd sandbox
adminlte-laravel --dev install

