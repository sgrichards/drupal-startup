// Non-Webpack imports.
const path = require('path');

// Webpack imports.
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const ImageminPlugin = require('imagemin-webpack');
const imageminSvgo = require('imagemin-svgo');
const imageminPNGQuant = require('imagemin-pngquant');
const TerserPlugin = require('terser-webpack-plugin');

// Utilities
const prodMode = process.env.NODE_ENV === 'production';

// Webpack config.
module.exports = {
  entry: {
    main: [
      './assets/src/components/main.scss',
      './assets/src/components/main.js',
    ],
  },
  mode: prodMode ? 'production' : 'development',
  output: {
    path: path.resolve(__dirname, 'assets', 'dist'),
    filename: '[name].min.js',
  },
  devtool: 'source-map',
  resolve: {
    extensions: ['.js'],
  },
  optimization: {
    minimizer: [new TerserPlugin()],
  },
  plugins: [
    // Stylesheet plugins.
    new MiniCssExtractPlugin({
      filename: '[name].min.css',
      chunkFilename: '[id].css',
      sourceMap: true,
    }),
    new ImageminPlugin({
      bail: prodMode,
      cache: true,
      imageminOptions: {
        plugins: [
          imageminSvgo({
            removeViewBox: false,
            removeDimensions: true,
            convertStyleToAttrs: true,
            cleanupIDs: true,
            cleanupAttrs: true,
          }),
          imageminPNGQuant(),
        ],
      },
    }),
  ],
  module: {
    rules: [
      // JAVASCRIPT
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: [{
          loader: 'babel-loader',
          options: { cacheDirectory: true },
        }],
      },
      // STYLESHEETS.
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          { loader: 'css-loader', options: { sourceMap: true } },
          { loader: 'postcss-loader', options: { sourceMap: true } },
          { loader: 'resolve-url-loader', options: { sourceMap: true } },
          { loader: 'sass-loader', options: { sourceMap: true } },
        ],
      },
      // FILES.
      {
        test: /\.(jpg|png|svg|gif)$/,
        use: [{
          loader: 'file-loader',
          options: {
            outputPath: '/assets/dist/images',
            publicPath: './assets/dist/images',
          },
        }],
      },
      {
        test: /\.woff2?/,
        use: [{
          loader: 'file-loader',
          options: {
            name: '[name].[ext]',
            outputPath: '/assets/dist/fonts',
            publicPath: './assets/dist/fonts',
          },
        }],
      },
    ],
  },
};
