#!/bin/bash
./sandbox_setup.sh
cd sandbox
phpunit --coverage-text --coverage-clover=../coverage.clover
cd ..
./sandbox_destroy.sh

