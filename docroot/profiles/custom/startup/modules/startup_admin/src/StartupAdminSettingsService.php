<?php

namespace Drupal\startup_admin;

use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Drupal\Core\Config\ConfigFactory;

/**
 * Class StartupAdminSettingsService
 *
 * @package Drupal\startup_admin
 */
class StartupAdminSettingsService extends ServiceProviderBase {

  /**
   * @var \Drupal\Core\Config\ConfigFactory
   */
  private $config;

  /**
   * @var \Drupal\Core\Config\Config|\Drupal\Core\Config\ImmutableConfig
   */
  private $systemSite;

  /**
   * StartupAdminSettingsService constructor.
   *
   * Used to setup class variables.
   *
   * @param \Drupal\Core\Config\ConfigFactory $config
   */
  public function __construct(ConfigFactory $config) {
    $this->config = $config;
    $this->systemSite = $config->get('system.site');
  }

  /**
   * Get a single setting field that were saved by custom states.
   *
   * @param $name
   * @param string $default
   * @param string $language
   *
   * @return mixed|string
   */
  public static function getSetting($name, $default = '', $language = '') {
    $setting_key = 'startup_admin.';

    // If language argument is not set, use the current language.
    if (!$language) {
      $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
    }

    $setting_key .= $language . '.' . $name;
    if ($setting = \Drupal::state()->get($setting_key)) {
      return $setting;
    }
    return $default;
  }

  /**
   * Returns the site name.
   *
   * @return array|mixed|null
   */
  public function getSiteName() {
    return $this->systemSite->get('name');
  }
}
