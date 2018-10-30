#!/bin/bash
set -e

source $(dirname "$0")/../common.inc.sh

run_command "Clearing caches." "./bin/drush cr $ENV_DRUSH_GLOBALS"
# run_command "Importing configuration." "./bin/drush config-split:import $ENV_DRUSH_GLOBALS"
# run_command "Importing configuration." "./bin/drush fia $ENV_DRUSH_GLOBALS -y"
run_command "Updating database." "./bin/drush updatedb $ENV_DRUSH_GLOBALS -y"
run_command "Entity updates." "./bin/drush entup $ENV_DRUSH_GLOBALS"
run_command "Clearing caches." "./bin/drush cr $ENV_DRUSH_GLOBALS"

echo "Refresh complete."
