

📣 **See new project as well:
https://github.com/mandrasch/ddev-wp-acf-blocks-svelte 📣** 


<hr>


# DDEV + WordPress + Vite?

🚧 Work in progress 🚧

Tools / Libraries used:

- https://ddev.readthedocs.io/en/stable/
- https://github.com/torenware/ddev-viteserve
- https://github.com/idleberg/php-wordpress-vite-assets

Inspired by https://github.com/fgeierst/typo3-vite-demo. 

This could be more effective when [roots/bedrock](https://roots.io/bedrock/) is used I guess.

## Local setup

Clone it, then

```bash
ddev start
ddev wp core download
# finish install in browser:
ddev launch

ddev wp theme activate twentytwentytwo-child

# Jump into DDEV container and run composer there
# TODO: Can I trigger this from outside via 'ddev composer ...'?
# (Or should I just use roots/bedrock? ;-))
ddev ssh
cd wp-content/themes/twentytwentytwo-child
composer install
exit

ddev vite-serve start && ddev launch

# Stop vite-server
ddev vite-serve stop

# If you want to start this the classic way,
# jump into DDEV container and do the following:
ddev ssh
cd wp-content/themes/twentytwentytwo-child
npm run dev
```

Current quick & dirty way to distinguish between local dev and production:

Use `define('WP_ENV','production');` or `define('WP_ENV','development');` in wp-config.php to either include compiled assets or the vite dev server client script. 

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

# Install vite + idleberg/wordpress-vite-assets
# jump into DDEV container via ddev ssh:
ddev ssh
cd wp-content/themes/twentytwentytwo-child
npm init -y
npm i --save-dev vite
npm i --save-dev sass
composer require idleberg/wordpress-vite-assets
exit

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

## Contributors 🤝

- [Furo42](https://github.com/Furo42) - https://github.com/mandrasch/ddev-wp-vite-demo/pull/2

## More resources

See https://my-ddev-lab.mandrasch.eu/ for more tutorials and infos.
