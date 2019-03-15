module.exports = {
  extends: ['stylelint-config-standard'],
  plugins: ['stylelint-scss', 'stylelint-a11y'],
  rules: {
    'at-rule-no-unknown': null,
    'scss/at-rule-no-unknown': true,
    'selector-max-id': 0,
    'declaration-no-important': true,
    'max-nesting-depth': 3,
    'no-empty-source': null,
    // Accessibility
    // @see https://github.com/YozhikM/stylelint-a11y
    'a11y/media-prefers-reduced-motion': true,
    'a11y/no-outline-none': true,
    'a11y/selector-pseudo-class-focus': true,
    'a11y/font-size-is-readable': true,
  },
  ignoreFiles: ['assets/dist/**'],
};
