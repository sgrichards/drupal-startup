#!/bin/bash
set -e

echo -e "\e[32mRunning integration scripts\e[0m"

./bin/phpcs
./bin/phpunit
./bin/behat

