#!/bin/bash

# Exit on failure
set -e

source $(dirname "$0")/common.inc.sh

# Copy the settings.local.php to the default site if it doesn't exist already.
if [ ! -f "$ENV_DOCROOT/sites/default/settings.local.php" ]; then
  run_command "Installing default config" "cp $ENV_DOCROOT/sites/default.settings.local.php $ENV_DOCROOT/sites/default/settings.local.php"
fi

run_command "Install Site." "./bin/drush site-install $ENV_PROFILE --account-pass=admin install_configure_form.enable_update_status_module=NULL $ENV_DRUSH_GLOBALS -y"
run_command "Clearing the cache." "./bin/drush cr $ENV_DRUSH_GLOBALS"

echo "Setup complete."
