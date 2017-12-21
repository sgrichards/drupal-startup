<?php

namespace Droath\ModuleSync;

use Drupal\Core\Extension\Extension;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Define module sync generate.
 */
class ModuleSyncGenerate {

  protected $scopes = [];
  protected $excludeTypes = [];
  protected $moduleHandler;

  const DEFAULT_FILENAME = 'module-sync';

  use DrupalFileLookupTrait;

  /**
   * Constructor for module sync generate.
   */
  public function __construct(ModuleHandlerInterface $module_handler) {
    $this->moduleHandler = $module_handler;
  }

  /**
   * Add scope directive to the module sync config.
   *
   * @param string $scope
   *   The scope unique name.
   * @param array $info
   *   The scope configuration information.
   */
  public function addScope($scope, array $info = []) {
    if (isset($scope) && !isset($this->scopes[$scope])) {
      $this->scopes[$scope] = $info;
    }

    return $this;
  }

  /**
   * Exclude profile module type.
   */
  public function excludeProfile() {
    $this->excludeTypes[] = 'profile';

    return $this;
  }

  /**
   * Save generated configuration as YAML.
   *
   * @param string $filepath
   *   The filepath to where to save the configuration.
   *
   * @return int|bool
   *   Returns number of bytes that were written to the file, or FALSE.
   */
  public function save($filepath = NULL) {
    if (!isset($filepath)) {
      $filepath = $this->lookupFilePath();
    }

    if (!file_exists($filepath) || !is_dir($filepath)) {
      throw new \RuntimeException(
        sprintf('Path (%s) is not a directory or does not exist.', $filepath)
      );
    }
    $filename = $filepath . DIRECTORY_SEPARATOR . SyncConfig::DEFAULT_FILENAME;

    return file_put_contents($filename, $this->configToYaml());
  }

  /**
   * Configurations to YAML.
   *
   * @return string
   *   The exported configurations as YAML.
   */
  protected function configToYaml() {
    return Yaml::dump([
      'version' => SyncConfig::DEFAULT_VERSION,
      'scope' => $this->scopes,
      'base' => $this->installedModules(),
      'exclude_types' => $this->excludeTypes,
    ], 4, 2);
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
        if (in_array($info->getType(), $this->excludeTypes)) {
          return FALSE;
        }

          return TRUE;
      })
    );
  }

}
