const Webpack = require("webpack");
const Path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const CopyWebpackPlugin = require("copy-webpack-plugin");
const HardSourceWebpackPlugin = require("hard-source-webpack-plugin");
const FileManagerPlugin = require("filemanager-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");

const opts = {
  rootDir: process.cwd(),
  devBuild: process.env.NODE_ENV !== "production"
};

module.exports = {
  entry: {
    app: ["jquery", "./src/js/app"],
    settings: "./src/js/settings"
  },
  mode: process.env.NODE_ENV === "production" ? "production" : "development",
  devtool:
    process.env.NODE_ENV === "production" ? "source-map" : "inline-source-map",
  output: {
    path: Path.join(opts.rootDir, "dist"),
    pathinfo: opts.devBuild,
    filename: "js/[name].js"
  },
  performance: { hints: false },
  optimization: {
    minimizer: [
      new TerserPlugin({
        parallel: true,
        terserOptions: {
          ecma: 6
        }
      }),
      new OptimizeCSSAssetsPlugin({})
    ]
  },
  plugins: [
    // Extract css files to seperate bundle
    new MiniCssExtractPlugin({
      filename: "css/[name].css",
      chunkFilename: "css/[id].css"
    }),
    // jQuery and PopperJS
    new Webpack.ProvidePlugin({
      $: "jquery",
      jQuery: "jquery",
      jquery: "jquery",
      "window.jQuery": "jquery",
      "window.$": "jquery",
      Popper: ["popper.js", "default"]
    }),
    // Copy images to dist
    new CopyWebpackPlugin([{ from: "src/img", to: "img" }]),
    // Speed up webpack build
    new HardSourceWebpackPlugin(),
    // Copy dist folder to docs/dist
    new FileManagerPlugin({
      onEnd: {
        copy: [{ source: "./dist/**/*", destination: "./docs" }]
      }
    })
  ],
  module: {
    rules: [
      // Babel-loader
      {
        test: /\.js$/,
        exclude: /(node_modules)/,
        loader: ["babel-loader?cacheDirectory=true"]
      },
      // Css-loader & sass-loader
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          "css-loader",
          "postcss-loader",
          "sass-loader"
        ]
      },
      // Load fonts
      {
        test: /\.(ttf|eot|svg|woff(2)?)(\?[a-z0-9=&.]+)?$/,
        loader: "file-loader",
        options: {
          name: "[name].[ext]",
          outputPath: "fonts",
          publicPath: "../fonts"
        }
      },
      // Load images
      {
        test: /\.(png|jpg|jpeg|gif?)(\?[a-z0-9=&.]+)?$/,
        loader: "file-loader",
        options: {
          name: "[name].[ext]",
          outputPath: "img",
          publicPath: "../img"
        }
      },
      // Expose loader
      {
        test: require.resolve("jquery"),
        use: [
          {
            loader: "expose-loader",
            options: "jQuery"
          },
          {
            loader: "expose-loader",
            options: "$"
          }
        ]
      }
    ]
  },
  resolve: {
    extensions: [".js", ".scss"],
    modules: ["node_modules"],
    alias: {
      request$: "xhr"
    }
  },
  devServer: {
    contentBase: Path.join(__dirname, "docs"),
    compress: true,
    port: 8080,
    open: true
  }
};
