const path = require('path');
const outputPath = 'dist';
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

module.exports = {
  entry: './js/wcl-functions.js',
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: 'bundle.js'
  },
  plugins: [

    // Uncomment this if you want to use CSS Live reload
    new BrowserSyncPlugin({
      //  proxy: 'http://dev.site-one',
      //  proxy: 'dev.site-one',
      proxy: 'dev.site-one',
      //  хост : 'localhost', 
      //   порт : 80, 
      files: ['css/wcl-style.min.css'],
      reloadDelay: 0,
     // injectCss: true,
    }),
  ],
};