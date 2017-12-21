<?php

/**
 * @file
 * Implements module sync commands with Drush 8.
 */

use Droath\ModuleSync\ModuleSync;
use Droath\ModuleSync\ModuleSyncGenerate;
use Droath\ModuleSync\SyncConfig;

/**
 * Implements hook_drush_command().
 */
function module_sync_drush_command() {
  $commands['module-sync'] = [
    'callback' => 'drush_module_sync_execute',
    'callback arguments' => [],
    'description' => 'Sync Drupal modules between different scopes.',
    'arguments' => [],
    'options' => [
      'scope' => [
        'description' => 'The scope that should be synced.',
        'example-value' => 'scope',
        'required' => true,
      ],
      'config-path' => [
        'description' => 'The path to the YAML configuration file.',
        'example-value' => 'path'
      ],
    ],
    'aliases' => ['ms'],
    'bootstrap' => DRUSH_BOOTSTRAP_DRUPAL_FULL,
  ];
  $commands['module-sync-generate'] = [
    'callback' => 'drush_module_sync_generate',
    'callback arguments' => [],
    'description' => 'Generate module sync configuration.',
    'options' => [
      'path' => [
        'description' => 'The path where the module sync configuration should be saved. If not set, it defaults to the Drupal site path.',
        'example-value' => 'path'
      ],
      'scopes' => [
        'description' => 'A list of scopes to add to the module sync configuration.',
        'example-value' => 'local,stg,prod'
      ],
      'exclude-profile' => [
        'description' => 'Exclude profile module type.',
      ]
    ],
    'aliases' => ['msg'],
  ];

  return $commands;
}

/**
 * Module sync execute command.
 */
function drush_module_sync_execute() {
  $scope = drush_get_option('scope');

  if (!is_string($scope) || empty($scope)) {
    return drush_set_error(
      '--scope parameter requires a string argument.'
    );
  }
  $config_path = drush_get_option('config-path');

  $instance = create_module_sync_instance($config_path);

  drush_module_sync_print_info(dt('Scope set to: @scope.', ['@scope' => $scope]));
  drush_module_sync_print_info(dt('Config loaded from: @filename', [
    '@filename' => $instance->getConfig()->getConfigFilename()
  ]));

  try {
    $instance->setScope($scope);
    $install_modules = $instance->listInstalls();

    // Display the module install table.
    drush_module_sync_print_module_table(
      $install_modules,
      dt('Modules to Install')
    );

    if (!empty($install_modules)) {
      $continue = drush_confirm('Continue with installing modules?');

      if ($continue) {
        $instance->confirmInstall();
      }
    }
    $uninstall_modules = $instance->listUninstalls();

    // Display the module uninstall table.
    drush_module_sync_print_module_table(
      $uninstall_modules,
      dt('Modules to Uninstall')
    );

    if (!empty($uninstall_modules)) {
      $continue = drush_confirm('Continue with uninstalling modules?');

      if ($continue) {
        $instance->confirmUninstall();
      }
    }
    $instance->execute();
    drush_module_sync_print_success('Module sync has finished.');
  }
  catch (\Exception $e) {
    drush_set_error('MODULE_SYNC_EXECUTE_ERROR', dt('@message', ['@message' => $e->getMessage()]));
  }
}

/**
 * Module sync generate command.
 */
function drush_module_sync_generate() {
  $instance = new ModuleSyncGenerate(
    \Drupal::service('module_handler')
  );
  drush_module_sync_print_title('Generate Module Sync Configuration');

  $filepath = drush_get_option('path');
  $scopes = drush_get_option_list('scopes');
  $exclude_profile = drush_get_option('exclude-profile', FALSE);

  if (empty($scopes)) {
    do {
      $scope = drush_prompt('Add scope (input nothing to stop prompt)', NULL, FALSE);
      $instance->addScope($scope, [
        'modules' => [],
        'extend_base' => TRUE,
      ]);
    } while ($scope);
  }
  else {
    foreach ($scopes as $scope) {
      $instance->addScope($scope, [
        'modules' => [],
        'extend_base' => TRUE,
      ]);
    }
  }

  if (!$exclude_profile) {
    $confirm = drush_confirm('Exclude profile module type?');

    if ($confirm) {
      $instance->excludeProfile();
    }
  }
  else {
    $instance->excludeProfile();
  }
  $status = $instance->save($filepath);

  if ($status !== FALSE) {
    drush_module_sync_print_success('Module sync configuration has been generated.');
  }
}

/**
 * Print formatted title output.
 *
 * @param string $title
 *   The title to print.
 */
function drush_module_sync_print_title($title) {
  drush_module_sync_draw_line();
  drush_print(ucwords($title), 1);
  drush_module_sync_draw_line();
}

/**
 * Print error message.
 *
 * @param string $message
 *   The error message.
 */
function drush_module_sync_print_error($message) {
  drush_print(
    sprintf("\n\033[1;31;40m\033[1m%s\033[0m\n", $message)
  );
}

/**
 * Print info message.
 *
 * @param string $message
 *   The info message.
 */
function drush_module_sync_print_info($message) {
  drush_print(
    sprintf("\n\033[1;33;40m\033[1m%s\033[0m\n", $message)
  );
}

/**
 * Print success message.
 *
 * @param string $message
 *   The success message.
 */
function drush_module_sync_print_success($message) {
  drush_print(
    sprintf("\n\033[1;32;40m\033[1m%s\033[0m\n", $message)
  );
}

/**
 * Draw a line to the output.
 *
 * @param string $symbol
 *   The line symbol.
 * @param int $length
 *   How long the line should be.
 */
function drush_module_sync_draw_line($symbol = '-', $length = 60) {
  drush_print(str_repeat($symbol, $length));
}

/**
 * Print module table output.
 *
 * @param array $modules
 *   An array of modules.
 * @param string $title
 *   The module table title.
 *
 * @return Console_Table
 *   The console table instance.
 */
function drush_module_sync_print_module_table(array $modules, $title = NULL) {
  if (isset($title)) {
    drush_module_sync_print_title($title);
  }
  $rows = [];

  if (!empty($modules)) {
    foreach ($modules as $module) {
      $rows[] = [$module];
    }
  }
  else {
    $rows[] = ['No modules need to be synced.'];
  }
  $table = drush_print_table($rows, TRUE);

  drush_print(str_repeat('-', 60));

  return $table;
}

/**
 * Create module sync instance.
 */
function create_module_sync_instance($config_path = NULL) {
  return new ModuleSync(
    new SyncConfig($config_path),
    \Drupal::service('module_handler'),
    \Drupal::service('module_installer')
  );
}
