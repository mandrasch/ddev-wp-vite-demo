const path = require('path')

// https://github.com/fgeierst/typo3-vite-demo/blob/master/packages/typo3_vite_demo/Resources/Private/JavaScript/vite.config.js

export default {
    // root: path.resolve(__dirname, 'src/js'),
    server: {
        host: "0.0.0.0", // leave this unchanged for DDEV!
        port: 5173,
        origin: 'https://ddev-wp-vite-demo.ddev.site'
    },
    publicDir: false, // disable copy `public/` to outDir
    build: {
        // generate manifest.json in outDir
        manifest: true,
        rollupOptions: {
            // overwrite default .html entry
            input: 'app.js',
        },
        outDir: 'dist',
    }

}