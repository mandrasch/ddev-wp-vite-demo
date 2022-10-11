# DDEV + WordPress + Vite?

🚧 Work in progress 🚧

Currently broken:

```
client.ts:78 Mixed Content: The page at 'https://ddev-wp-vite-demo.ddev.site/' was loaded over HTTPS, but attempted to connect to the insecure WebSocket endpoint 'ws://0.0.0.0:5173/'. This request has been blocked; this endpoint must be available over WSS.
```

Tools / Libraries used:

- https://ddev.readthedocs.io/en/stable/
- https://github.com/kucrut/vite-for-wp
    - modified for DDEV because we need to serve vite from https://DDEV_PROJECT.ddev.site:5173 via DDEV reverse proxy, but leave server.host setting in vite config as "0.0.0.0". 
    - See [DDEV example for CraftCMS](https://nystudio107.com/docs/vite/#local-development-environment-setup) as reference implementation
- https://github.com/torenware/ddev-viteserve

## Local setup

Clone it, then

```bash
ddev wp core download
# finish install in browser:
ddev launch

ddev wp theme activate twentytwentytwo-child

ddev vite-serve start && ddev launch
```

## Build

```bash
ddev ssh
cd wp-content/themes/twentytwentytwo-child
npm run build
```

## How was this created?

```bash
# https://ddev.readthedocs.io/en/latest/users/quickstart/#wp-cli
ddev config --project-type=wordpress
ddev start
ddev wp core download
ddev launch

ddev wp theme activate twentytwentytwo-child

# install vite
ddev ssh
cd wp-content/themes/twentytwentytwo-child
npm init -y
npm i --save-dev vite

# https://github.com/kucrut/vite-for-wp
npm i --save-dev @kucrut/vite-for-wp
# (create vite.config.js, add to scripts in package.json, ...)
# (add script to functions.php)

# add viteserve to ddev
ddev get torenware/ddev-viteserve
# modify .ddev/.env, adjust
#   VITE_PROJECT_DIR=wp-content/themes/twentytwentytwo-child/
#   VITE_JS_PACKAGE_MGR=npm
ddev restart

ddev vite-serve start && ddev launch

# for debug / viewing error messages:
# TODO: How can we check the logs via viteserve?
ddev vite-serve stop
ddev ssh
cd wp-content/themes/twentytwentytwo-child
npm run dev
```