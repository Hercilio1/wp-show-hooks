const glob = require("glob");
const path = require("path");
const manifest = require("./manifest");

module.exports = {
	// Reads the pages/ folder looking for the following pattern of
	// files: index-([a-z]+)\.js
	entry: glob
		.sync("./assets/dev/js/pages/**/index*.js")
		.reduce((acc, currentPath) => {
			let entry = currentPath.match("./pages/([a-z-]+)*/index.js");
			let distName = null;
			if (entry) {
				distName = "main";
			} else {
				entry = currentPath.match("./pages/([a-z-]+)*/index-([a-z-]+)*.js");
				distName = entry[2];
			}
			if (entry && distName) {
				acc[`${entry[1]}/${distName}`] = currentPath;
			}
			return acc;
		}, {}),
	output: {
		path: path.resolve("./assets/js/dist"),
		filename: "[name].js",
		publicPath: "auto",
		clean: true,
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				loader: "babel-loader",
				options: {
					presets: ["@babel/preset-env"],
				},
			},
		],
	},
	...manifest,
	// Dev Configs:
	mode: "development",
	devtool: "hidden-source-map",
	optimization: {
		minimize: false,
	},
};
