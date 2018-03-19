#!/bin/bash

# Exit on failure
# set -e

source $(dirname "$0")/common.inc.sh

clean

# Copy the settings.local.php to the default site if it doesn't exist already.
if [ ! -f "docroot/sites/default/settings.local.php" ]; then
  run_command "Installing default config" "cp docroot/sites/default.settings.local.php docroot/sites/default/settings.local.php"
fi

run_command "Install Site." "./bin/drush site-install --account-pass=admin $PROFILE $DRUSH_GLOBALS -y"
run_command "Resetting the site UUID." "./bin/drush config-set system.site uuid $UUID $DRUSH_GLOBALS"
run_command "Clearing the cache." "./bin/drush cr -r $ROOT"
run_command "Creating reference database dump" "./bin/drush -r $ROOT sql-dump --result-file=../$ASSETSDIR/post-install.sql"

echo "Setup complete."
