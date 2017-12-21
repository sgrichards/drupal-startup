<?php

namespace Droath\ModuleSync;

/**
 * Define Drupal filepath lookup trait.
 */
trait DrupalFileLookupTrait {

  /**
   * Lookup file path for module sync YAML configuration.
   *
   * At the moment there is only one location, but this method can easily be
   * expanded to search for module sync configurations in other locations in the
   * future.
   *
   * @return string
   *   The path to the configuration directory.
   */
  protected function lookupFilePath() {
    return $this->drupalSitePath();
  }

  /**
   * Get Drupal site path.
   *
   * @return string
   *   The absolute path to the current Drupal site.
   */
  protected function drupalSitePath() {
    return DRUPAL_ROOT . DIRECTORY_SEPARATOR . \Drupal::service('site.path');
  }

}
