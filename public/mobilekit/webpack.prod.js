const path = require('path');
const fs = require('fs');
const TerserPlugin = require('terser-webpack-plugin');

// Fungsi untuk mencari semua script.js di dalam folder Pages/
function getAllScripts() {
  const baseDir = path.resolve(__dirname, '../../app');
  const scripts = [];

  function readDirRecursive(directory) {
    fs.readdirSync(directory).forEach(file => {
      const fullPath = path.join(directory, file);
      if (fs.statSync(fullPath).isDirectory()) {
        readDirRecursive(fullPath);
      } else if (file === 'script.js') {
        scripts.push(fullPath);
      }
    });
  }

  readDirRecursive(baseDir);
  return scripts;
}

module.exports = {
  mode: 'production',
  entry: {
    'helpers.bundle.min': './helpers.js', // Production pakai helpers.bundle.min.js
    'pagescript.min': getAllScripts() // Production menghasilkan pagescript.min.js
  },
  output: {
    filename: '[name].js', // Nama output dengan .min untuk production
    path: path.resolve(__dirname, 'assets/js'),
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
          },
        },
      },
    ],
  },
  optimization: {
    minimize: true,
    minimizer: [
      new TerserPlugin({
        terserOptions: {
          compress: {
            drop_console: true, // Menghapus console.log di production
          },
        },
      }),
    ],
  },
};
