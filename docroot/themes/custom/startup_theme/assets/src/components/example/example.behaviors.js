import { exampleBehavior, secondExampleBehavior } from './example';

Drupal.behaviors.exampleBehaviour = {
  attach(context) {
    exampleBehavior(context);
  },
};

Drupal.behaviors.exampleBehaviour = {
  attach(context, settings) {
    secondExampleBehavior(context, settings);
  },
};
