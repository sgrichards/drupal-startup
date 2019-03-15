module.exports = {
  plugins: {
    cssnano: {},
    'postcss-preset-env': {
      // We define stage 3 as they are features that are embraced by vendors,
      // and almost vertain to become standards.
      // https://preset-env.cssdb.org/features#stage-3
      stage: 3,
    },
  },
};
