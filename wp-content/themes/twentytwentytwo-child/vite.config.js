// https://github.com/kucrut/vite-for-wp

import create_config from '@kucrut/vite-for-wp';

export default create_config('js/src/app.js', 'js/dist', {
    plugins: [],
    server: {
        host: "0.0.0.0", // leave this unchanged for DDEV!
        port: 5173,
    }
});
