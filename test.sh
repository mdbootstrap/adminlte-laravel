    #!/bin/bash
./sandbox_setup.sh
cd sandbox
./vendor/bin/phpunit --coverage-text --coverage-clover=../coverage.clover
cd ..
./sandbox_destroy.sh

