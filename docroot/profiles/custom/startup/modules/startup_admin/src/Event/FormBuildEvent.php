<?php

namespace Drupal\startup_admin\Event;

use Drupal\startup_admin\StartupAdminSettingsService;
use Symfony\Component\EventDispatcher\Event;

/**
 * {@inheritDoc}
 */
class FormBuildEvent extends Event {

  const FORM_BUILD = 'startup_admin.build';

  protected $form;
  protected $language;

  public function __construct($language) {
    $this->language = $language;
  }

  public function setFormData($group_name, array $form_section) {
    $group_machine_name = $this->transform($group_name);
    if (!isset($this->form[$group_machine_name])) {
      $this->form[$group_machine_name] = [
        '#type' => 'details',
        '#title' => $group_name,
        '#group' => 'startup_admin',
      ];
    }
    $this->form[$group_machine_name] += $form_section;
  }

  public function getSetting($name, $default = '') {
    return StartupAdminSettingsService::getSetting($name, $default, $this->language);
  }

  public function getFormData() {
    return $this->form;
  }

  /**
   * Convert human readable string to machine name.
   *
   * @param $string
   * @return mixed
   */
  private function transform($string) {
    $new_value = strtolower($string);
    $new_value = preg_replace('/[^a-z0-9_]+/', '_', $new_value);
    return preg_replace('/_+/', '_', $new_value);
  }
}
