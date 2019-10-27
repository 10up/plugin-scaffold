/**
 * Babel Config.
 *
 * @param {Object} api
 * @returns {{presets: {Object}}}
 */
module.exports = api => {
	/**
	 * @link https://babeljs.io/docs/en/config-files#apicache
	 */
	api.cache.using( () => 'development' === process.env.NODE_ENV );
	const presets = [
		[
			/**
			 * @link https://babeljs.io/docs/en/babel-preset-env#corejs
			 */
			'@babel/preset-env',
			{
				useBuiltIns: 'usage',
				corejs: {
					version: 3,
					proposals: true
				},
			}
		],
	];
	return {
		presets
	};
};
