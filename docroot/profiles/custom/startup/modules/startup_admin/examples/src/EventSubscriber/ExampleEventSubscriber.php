<?php

namespace Drupal\example_module\EventSubscriber;

use Drupal\startup_admin\Event\FormBuildEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * {@inheritDoc}
 */
class ExampleEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritDoc}
   */
  public static function getSubscribedEvents() {
    $events[FormBuildEvent::FORM_BUILD][] = ['exampleReaction'];
    return $events;
  }

  /**
   * @param \Drupal\startup_admin\Event\FormBuildEvent $event
   */
  public function settingsForm(FormBuildEvent $event) {
    $settings = [];

    $settings['some_setting'] = [
      '#type' => 'textfield',
      '#title' => t('Some setting'),
      '#default_value' => $event->getSetting('some_setting'),
    ];

    $settings['another_setting'] = [
      '#type' => 'checkboxes',
      '#title' => t('Another setting'),
      '#options' => [
        'option1' => 'Option 1',
        'option2' => 'Option 2',
        'option3' => 'Option 3',
      ],
      '#default_value' => $event->getSetting('another_setting'),
    ];

    $event->setFormData('Fieldset Name', $settings);
  }
}
