/**
 * (C) 2018, Nurimansyah Rifwan <nurimansyah.rifwan@gmail.com>
 */
'use strict'

// Modules
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const path = require('path')
const notify = require('webpack-notifier')

// SASS Configuration
const extractSASS = new ExtractTextPlugin({
	filename: "app.css"
})

// Exports
module.exports = {
	mode: 'development',
	entry: './app.js',
	output: {
		path: path.resolve(__dirname, 'dist/assets/static'),
		filename: "app.js"
	},
	module: {
		rules: [
			{
				test: /\.sass$/,
				exclude: /(node_modules)/,
				use: extractSASS.extract({
					use: [
						{ loader: "css-loader" },
						{ loader: "sass-loader" }
					],
					fallback: "style-loader"
				})
			},
			{
				test: /\.js$/,
				exclude: /(node_modules)/,
				use: {
					loader: 'babel-loader'
				}
			}
		]
	},
	plugins: [
		extractSASS,
		new notify({ alwaysNotify: true })
	]
}