#!/bin/bash

# Exit on failure
set -e

source $(dirname "$0")/common.inc.sh

# Copy the settings.local.php to the default site if it doesn't exist already.
if [ ! -f "$ENV_DOCROOT/sites/default/settings.local.php" ]; then
  run_command "Installing default config" "cp $ENV_DOCROOT/sites/default.settings.local.php $ENV_DOCROOT/sites/default/settings.local.php"
fi

# Run install command with progress indicator...
while :;do echo -n .;sleep 1;done &
trap "kill $!" EXIT  #Die with parent if we die prematurely
run_command "Install Site." "./bin/drush site-install --account-pass=admin $ENV_PROFILE install_configure_form.enable_update_status_module=NULL $ENV_DRUSH_GLOBALS -y"
kill $! && trap " " EXIT

run_command "Clearing the cache." "./bin/drush cr $ENV_DRUSH_GLOBALS"

echo "Setup complete."
