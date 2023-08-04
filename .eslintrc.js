module.exports = {
	env: {
		browser: true,
		es2021: true,
		node: true,
	},

	ignorePatterns: ["assets/js/**/*.js"],

	extends: [
		"eslint:recommended",
		"plugin:prettier/recommended",
		"plugin:@wordpress/eslint-plugin/recommended",
	],

	rules: {
		"prettier/prettier": ["error"],
	},

	parser: "@babel/eslint-parser",

	parserOptions: {
		sourceType: "module",
	},
};
