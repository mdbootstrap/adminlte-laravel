#!/bin/bash
./sandbox_setup.sh
cd sandbox
phpunit
cd ..
./sandbox_destroy.sh

