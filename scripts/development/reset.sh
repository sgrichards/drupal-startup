#!/bin/bash
# set -e

source $(dirname "$0")/common.inc.sh

run_command "Remove generated files." "rm -Rf docroot bin vendor composer.lock"

echo "Reset complete."
