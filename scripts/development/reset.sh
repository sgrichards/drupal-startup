#!/bin/bash
set -e

source $(dirname "$0")/../common.inc.sh

run_command "Remove generated files." "rm -Rf docroot/core docroot/*/contrib vendor composer.lock"

echo "Reset complete."
