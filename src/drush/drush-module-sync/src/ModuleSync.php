<?php

namespace Droath\ModuleSync;

use Drupal\Core\Extension\Extension;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Extension\ModuleInstallerInterface;

/**
 * Define module sync class.
 */
class ModuleSync {

  protected $scope;
  protected $config;
  protected $confirmInstall = FALSE;
  protected $confirmUninstall = FALSE;

  /**
   * Construct for module sync.
   *
   * @param \Droath\ModuleSync\SyncConfig $config
   *   The sync configuration object.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The Drupal module handler.
   * @param \Drupal\Core\Extension\ModuleInstallerInterface $module_installer
   *   The Drupal module installer.
   */
  public function __construct(
    SyncConfig $config,
    ModuleHandlerInterface $module_handler,
    ModuleInstallerInterface $module_installer
  ) {
    $this->config = $config;
    $this->moduleHandler = $module_handler;
    $this->moduleInstaller = $module_installer;
  }

  /**
   * Set the sync scope.
   *
   * @param string $scope
   *   The scope to use.
   */
  public function setScope($scope) {
    if (!$this->config->hasScope($scope)) {
      throw new \InvalidArgumentException(
        sprintf("Undefined module sync scope has been set.", $scope)
      );
    }

    $this->scope = $scope;

    return $this;
  }

  /**
   * List the Drupal modules to install.
   *
   * @return array
   *   A list of modules that need to be installed.
   */
  public function listInstalls() {
    $install = [];

    foreach ($this->modulesByScope() as $name) {
      if ($this->moduleHandler->moduleExists($name)) {
        continue;
      }

      $install[] = $name;
    }

    return $install;
  }

  /**
   * List the Drupal modules to uninstall.
   *
   * @return array
   *   A list of modules that need to be uninstalled.
   */
  public function listUninstalls() {
    $uninstall = [];
    $modules = $this->modulesByScope();

    foreach ($this->installedModules() as $name) {
      if (in_array($name, $modules)) {
        continue;
      }
      $uninstall[] = $name;
    }

    return $uninstall;
  }

  /**
   * Set confirmation for install to true.
   */
  public function confirmInstall() {
    $this->confirmInstall = TRUE;

    return $this;
  }

  /**
   * Set confirmation for uninstall to true.
   */
  public function confirmUninstall() {
    $this->confirmUninstall = TRUE;

    return $this;
  }

  /**
   * Execute the module sync.
   *
   * @return array
   *   An array of status information keyed by the operation.
   */
  public function execute() {
    $status = [];

    if ($this->confirmInstall) {
      $status['installed'] = $this->moduleInstaller
        ->install($this->listInstalls());
    }

    if ($this->confirmUninstall) {
      $status['uninstalled'] = $this->moduleInstaller
        ->uninstall($this->listUninstalls());
    }

    return $status;
  }

  /**
   * Get the configuration object.
   *
   * @return \Droath\ModuleSync\SyncConfig
   *   The sync configuration object.
   */
  public function getConfig() {
    return $this->config;
  }

  /**
   * Get modules by scope.
   *
   * @return array
   *   An array of modules for a given scope.
   */
  protected function modulesByScope() {
    if (!isset($this->scope)) {
      throw new \Exception(
        "Undefined scope. Ensure setScope() was invoked."
      );
    }

    return $this->config
      ->getModulesByScope($this->scope);
  }

  /**
   * Get Drupal installed modules.
   *
   * @return array
   *   An array of installed Drupal modules.
   */
  protected function installedModules() {
    $modules = $this->moduleHandler->getModuleList();
    return array_keys(
      array_filter($modules, function (Extension $info) {
        $type = $info->getType();
        if (in_array($type, $this->config->getExcludeTypes())) {
            return FALSE;
        }

        return TRUE;
      })
    );
  }

}
