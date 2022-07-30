const { createProxyMiddleware } = require('http-proxy-middleware');

module.exports = function (app) {
    app.use(
        '/api',
        createProxyMiddleware({
            target: 'http://localhost/api/v1',
            pathRewrite: {
                '^/api': '',
            },
            changeOrigin: true,
        })
    );
};
