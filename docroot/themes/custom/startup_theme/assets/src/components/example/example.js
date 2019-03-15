/**
 * Do some stuff.
 *
 * @see example.behaviors.js
 *
 * @param {HTMLElement|Document} context The document context.
 *
 * @returns {string} Either some stuff of some default stuff.
 */
export const exampleBehavior = (context) => {
  /** @type {NodeList} els */
  const els = context.querySelectorAll('.js-some-element');

  if (els.length) {
    return 'Some stuff';
  }

  return 'Some default stuff';
};

/**
 * When a button is clicked, log a data attribute to the console.
 *
 * This is mega useful, and serves many purposes.
 *
 * @param {HTMLElement|Document} context The document context.
 * @param {object} settings Drupal settings object.
 */
export const secondExampleBehavior = (context, settings) => {
  const btn = context.querySelector('.js-my-button');

  if (!btn) return;

  // settings.myTheme.mySetting is a hypothetical setting here. It's not
  // something created by default.
  if (settings.myTheme && settings.myTheme.mySetting) {
    btn.setAttribute('data-my-setting', settings.myTheme.mySetting);
  } else {
    btn.setAttribute('data-my-setting', 'default');
  }

  btn.addEventListener('click', (event) => {
    event.preventDefault();

    /** @type {HTMLButtonElement} currentTarget */
    const { currentTarget } = event;

    console.log(currentTarget.dataset.mySetting); // eslint-disable-line
  });
};
