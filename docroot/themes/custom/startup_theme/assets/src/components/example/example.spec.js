import { fireEvent } from 'dom-testing-library';
import { exampleBehavior, secondExampleBehavior } from './example';

/* eslint-disable no-console */
describe('example', () => {
  describe('exampleBehavior', () => {
    it('does some stuff', () => {
      document.body.innerHTML = `
        <div>
          <p class="js-some-element"></p>
        </div>
      `;

      expect(exampleBehavior(document)).toBe('Some stuff');
    });

    it('does some default stuff when element does not exist', () => {
      document.body.innerHTML = `
        <div></div>
      `;

      expect(exampleBehavior(document)).toBe('Some default stuff');
    });
  });

  describe('secondExampleBehavior', () => {
    /** @type {HTMLButtonElement} button */
    let button;

    beforeEach(() => {
      document.body.innerHTML = `
        <div>
          <button class="js-my-button">Hello world</button>
        </div>
      `;

      button = document.querySelector('.js-my-button');
    });

    it('sets a data attribute based on a settings parameter', () => {
      const settings = {
        myTheme: {
          mySetting: 'my test setting',
        },
      };

      secondExampleBehavior(document, settings);
      expect(button.dataset.mySetting).toBe('my test setting');
    });

    it('Sets a default data attribute value if myTheme doesn\'t exist', () => {
      const settings = {};

      secondExampleBehavior(document, settings);
      expect(button.dataset.mySetting).toBe('default');
    });

    it('Sets a default data attribute value if myTheme.mySetting doesn\'t exist', () => {
      const settings = {
        myTheme: {},
      };

      secondExampleBehavior(document, settings);
      expect(button.dataset.mySetting).toBe('default');
    });

    it('logs data attribute (my-data-setting) value to the console', () => {
      const settings = {
        myTheme: {
          mySetting: 'my test setting',
        },
      };

      const logSpy = jest.fn();
      console.log = logSpy;

      secondExampleBehavior(document, settings);
      fireEvent.click(button);

      expect(logSpy).toHaveBeenCalledWith('my test setting');
    });
  });
});
