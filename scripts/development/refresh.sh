#!/bin/bash
# set -e

KEEPDB=FALSE

source $(dirname "$0")/common.inc.sh

if [[ $1 ]]; then
  case "$1" in
    "--keepdb") 
      KEEPDB=TRUE
      ;;
    * ) 
      echo "Invalid option: $1. Valid options --keepdb"
      exit 255
      ;;
  esac
fi

if [[ ! $KEEPDB ]]; then
  run_command "Restoring database" "./bin/drupal database:restore --file=../assets/post-install.sql"
fi
run_command "Composer install." "composer install"
run_command "Clearing caches." "./bin/drush cr -r $ROOT"
run_command "Module sync." "./bin/drush module-sync --scope=$SCOPE $DRUSH_GLOBALS"
run_command "Importing configuration." "./bin/drush config-split:import $DRUSH_GLOBALS"
run_command "Updating database." "./bin/drush updatedb $DRUSH_GLOBALS"
run_command "Entity updates." "./bin/drush entup -r $ROOT"
run_command "Clearing caches." "./bin/drush cr -r $ROOT"

echo "Refresh complete."
