#!/bin/bash
if ! type "laravel" > /dev/null; then
    composer global require "laravel/installer"
fi
if ! type "adminlte-laravel" > /dev/null; then
    composer global require "acacha/adminlte-laravel-installer=dev-master"
fi
if ! type "llum" > /dev/null; then
    composer global require "acacha/llum=~1.0"
fi
export PATH="~/.composer/vendor/bin:~/.config/composer/vendor:$PATH"
rm -rf sandbox
if [ -e ~/.composer/vendor/bin/laravel ];then
    ~/.composer/vendor/bin/laravel new sandbox
elif [ -e ~/.config/composer/vendor/bin/laravel ];then
  ~/.config/composer/vendor/bin/laravel new sandbox
fi
cd sandbox
if [ -e ~/.composer/vendor/bin/adminlte-laravel ];then
  ~/.composer/vendor/bin/adminlte-laravel --dev install
elif [ -e ~/.config/composer/vendor/bin/adminlte-laravel ];then
  ~/.config/composer/vendor/bin/adminlte-laravel --dev install
fi
rm -f database/database.sqlite
touch database/database.sqlite
rm -f database/testing.database.sqlite
touch database/testing.database.sqlite
