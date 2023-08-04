const common = require("./webpack.config.js");

module.exports = {
	...common,
	mode: "production",
	devtool: "hidden-source-map",
	optimization: {
		minimize: true,
	},
};
