module.exports = {
    publicPath: process.env.NODE_ENV === 'production'
    ? 'rl/'
    : '/',

    pluginOptions: {
      i18n: {
        locale: 'en',
        fallbackLocale: 'en',
        localeDir: 'locales',
        enableInSFC: true
      }
    }
}