<?php

namespace Drupal\startup_admin\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\Language;
use Drupal\Core\Url;
use Drupal\startup_admin\Event\FormBuildEvent;

/**
 * {@inheritDoc}
 */
class StartupAdminSettingsForm extends FormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'startup_admin_settings_form';
  }

  /**
   * Form constructor.
   *
   * Provides the base form with language options and allows other modules to
   * add new elements.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $language_manager = \Drupal::getContainer()->get('language_manager');
    /** @var Language[] $languages */
    $languages = $language_manager->getLanguages();
    $current_language = $language_manager->getCurrentLanguage();
    // Get the language for the form, or the current language.
    $setting_language = (isset($_GET['lang'])) ? $_GET['lang'] : $current_language->getId();

    // Validate the language ID is legit. If not set to the current language.
    if ($setting_language && !isset($languages[$setting_language])) {
      $setting_language = $current_language->getId();
    }

    $system_config = $this->config('system.site');

    $form_intro = '<h2>' . $system_config->get('name') . ' settings</h2>';
    $form_intro .= <<<EOT
<p>Here you can configure site specific settings<br>
<small>If you are a developer and want to add to this settings form please see: <code>startup_admin/examples</code></small></p>
EOT;

    $form['intro'] = [
      '#type' => '#markup',
      '#markup' => $form_intro,
      '#weight' => -99,
    ];

    $form['setting_language'] = [
      '#type' => 'hidden',
      '#value' => $setting_language,
    ];

    // If there is more than one language then provide the ability to "switch"
    // settings forms for each language.
    if (count($languages) > 1) {
      $language_links = '<span class="language-switch-title">Language specific settings: </span><ul class="language-switch">';
      foreach ($languages as $language) {
        if ($language->getId() == $setting_language) {
          $language_links .= '<li class="active">' . $language->getName() . '</li>';
        }
        else {
          // Print a link to direct the user to the specific language settings.
          $url = Url::fromRoute('startup_admin.settings_form', ['lang' => $language->getId()]);
          $language_links .= '<li>' . \Drupal\Core\Link::fromTextAndUrl($language->getName(), $url)->toString() . '</li>';
        }
      }
      $language_links .= '</ul>';
      $form['language_switcher'] = [
        '#type' => '#markup',
        '#markup' => $language_links,
      ];
    }

    $form['startup_admin'] = [
      '#type' => 'vertical_tabs',
    ];

    // Allow other modules to add to the form.
    $dispatcher = \Drupal::service('event_dispatcher');
    $e = new FormBuildEvent($setting_language);
    $event = $dispatcher->dispatch(FormBuildEvent::FORM_BUILD, $e);
    if ($form_data = $event->getFormData()) {
      $form = $form + $form_data;

      $form['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Save settings'),
      ];
    }

    $form['#attached']['library'][] = 'startup_admin/form';

    return $form;
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $defaults = array_flip(['submit', 'form_build_id', 'form_token', 'form_id', 'op']);
    $values = array_diff_key($form_state->getValues(), $defaults);

    $language = $values['setting_language'];
    unset($values['setting_language']);

    foreach ($values as $key => $value) {
      $setting_key = 'startup_admin.';
      $setting_key .= ($language) ? $language . '.' . $key : $key;
      \Drupal::state()->set($setting_key, $value);
    }
  }
}
