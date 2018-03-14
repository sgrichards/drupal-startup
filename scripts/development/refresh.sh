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
run_command "Clearing caches." "./bin/drush cr"
run_command "Updating database." "./bin/drush updatedb -y"
run_command "Importing configuration." "./bin/drush config-split:import -y"
run_command "Clearing caches." "./bin/drush cr"

echo "Restoration complete."
