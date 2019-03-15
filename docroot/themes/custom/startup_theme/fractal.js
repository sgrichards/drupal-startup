const path = require('path');
const mandelbrot = require('@frctl/mandelbrot');

/**
 * Require the Fractal module
 */
const fractal = module.exports = require('@frctl/fractal').create(); // eslint-disable-line

/**
 * Require the Twig adapter
 */
const twigAdapter = require('@frctl/twig')({
  functions: {
    modifiers(baseClass, modifiers = []) {
      // Ensure we have an array of modifiers.
      const modifiersArray = Array.isArray(modifiers) ? modifiers : [modifiers];

      // Loop over them and prepend the baseclass.
      const classArray = modifiersArray.map(modifier => `${baseClass}--${modifier}`);
      classArray.unshift(baseClass);
      return classArray.join(' ');
    },
  },
});

fractal.components.engine(twigAdapter);
fractal.components.set('ext', '.twig');

/**
 * Give your project a title.
 */
fractal.set('project.title', 'Startup');

/**
 * Global preview layout.
 * Required as our preview template lives in themename/components/_fractal/
 */
fractal.components.set('default.preview', '@preview');

/**
 * Tell Fractal where to look for components.
 */
fractal.components.set('path', path.join(__dirname, 'assets/src/components'));

/**
 * Tell Fractal where to look for documentation pages.
 */
fractal.docs.set('path', path.join(__dirname, 'assets/src/docs'));

/**
 * Tell the Fractal web preview plugin where to look for static assets.
 */
fractal.web.set('static.path', path.join(__dirname, 'assets/dist'));

/**
 * Set the path for the styleguide
 */
fractal.web.set('builder.dest', path.join(__dirname, 'styleguide'));

/**
 * Add some basic theme configuration.
 */
const theme = mandelbrot({
  nav: ['docs', 'components'],
  skin: 'olive',
});

fractal.web.theme(theme);
