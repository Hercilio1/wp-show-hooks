const glob = require("glob");
const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const RemoveEmptyScriptsPlugin = require("webpack-remove-empty-scripts");

const getEntries = () => {
	const entries = {};
	glob.sync("./assets/dev/sass/*.scss").forEach((currentPath) => {
		const entry = currentPath.match("./assets/dev/sass/([a-z-]+)*.scss");
		const distName = entry.length > 1 ? entry[1] : null;
		if (distName) {
			entries[`${distName}`] = currentPath;
		}
		return entries;
	});
	return entries;
};

module.exports = {
	entry: getEntries(),
	output: {
		path: path.resolve("./assets/css/dist"),
		publicPath: "auto",
		clean: true,
	},
	module: {
		rules: [
			{
				test: /\.s[ac]ss$/i,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: "css-loader", // translates CSS into CommonJS modules
					},
					{
						loader: "postcss-loader", // Run post css actions
						options: {
							postcssOptions: {
								plugins() {
									return [require("precss"), require("autoprefixer")];
								},
							},
						},
					},
					{
						loader: "sass-loader",
						options: {
							sourceMap: true,
							sassOptions: {
								outputStyle: "compressed",
							},
						},
					},
				],
			},
		],
	},
	plugins: [
		new RemoveEmptyScriptsPlugin(),
		new MiniCssExtractPlugin({
			filename: "[name].css",
		}),
	],
	// Dev Configs:
	mode: "development",
	devtool: "hidden-source-map",
	optimization: {
		minimize: false,
	},
};
