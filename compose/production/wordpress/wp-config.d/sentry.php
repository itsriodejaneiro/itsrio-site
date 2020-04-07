<?php
/* Set Sentry Project to Wordpress. */
getenv('WP_SENTRY_DSN') && define('WP_SENTRY_DSN', getenv('WP_SENTRY_DSN'));
getenv('WP_SENTRY_PUBLIC_DSN') && define('WP_SENTRY_PUBLIC_DSN', getenv('WP_SENTRY_PUBLIC_DSN'));
define('WP_SENTRY_ERROR_TYPES', E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_USER_DEPRECATED );