/**
 * Babel Config.
 *
 * @param {Object} api The bable API
 * @return {{presets: {Object}}} The babel configuration.
 */
module.exports = (api) => {
	/**
	 * @see https://babeljs.io/docs/en/config-files#apicache
	 */
	api.cache.using(() => process.env.NODE_ENV === 'development');

	/**
	 * Presets
	 *
	 * @see https://babeljs.io/docs/en/presets
	 * @type {Array}
	 */
	const presets = [
		[
			/**
			 * @see https://babeljs.io/docs/en/babel-preset-env#corejs
			 */
			'@babel/preset-env',
			{
				useBuiltIns: 'usage',
				corejs: {
					version: 3,
					proposals: true,
				},
			},
		],
	];

	/**
	 * Plugins
	 *
	 * @see https://babeljs.io/docs/en/plugins
	 * @type {Array}
	 */
	const plugins = [];

	return {
		presets,
		plugins,
	};
};
