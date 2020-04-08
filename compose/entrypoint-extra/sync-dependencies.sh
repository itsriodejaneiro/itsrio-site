#!/bin/bash

DEV_MUPLUGINS="/var/www/mu-plugins"
WP_MUPLUGINS="/var/www/html/wp-content/mu-plugins"

DEV_PLUGINS="/var/www/plugins"
WP_PLUGINS="/var/www/html/wp-content/plugins"

DEV_THEMES="/var/www/themes"
WP_THEMES="/var/www/html/wp-content/themes"

UPLOADS_DIR="/var/www/html/wp-content/uploads"

mkdir -p $WP_MUPLUGINS $WP_PLUGINS $WP_THEMES $UPLOADS_DIR && chown www-data: $WP_MUPLUGINS $WP_PLUGINS $WP_THEMES $UPLOADS_DIR

if [ -d "$DEV_MUPLUGINS" ];
then
    find "$DEV_MUPLUGINS" \
        -maxdepth 1 \
        -mindepth 1 \
        -exec cp -a {} $WP_MUPLUGINS/TMP \; \
        -exec echo 'rm -rf '$WP_MUPLUGINS'/$(basename {})'  \; \
        -exec sh -c 'rm -rf '$WP_MUPLUGINS'/$(basename {})'  \; \
        -exec echo 'mv '$WP_MUPLUGINS'/TMP '$WP_MUPLUGINS'/$(basename {})' \; \
        -exec sh -c 'mv '$WP_MUPLUGINS'/TMP '$WP_MUPLUGINS'/$(basename {})' \;
fi


if [ -d "$DEV_PLUGINS" ];
then
    find "$DEV_PLUGINS" \
        -maxdepth 1 \
        -mindepth 1 \
        -exec cp -a {} $WP_PLUGINS/TMP \; \
        -exec echo 'rm -rf '$WP_PLUGINS'/$(basename {})'  \; \
        -exec sh -c 'rm -rf '$WP_PLUGINS'/$(basename {})'  \; \
        -exec echo 'mv '$WP_PLUGINS'/TMP '$WP_PLUGINS'/$(basename {})' \; \
        -exec sh -c 'mv '$WP_PLUGINS'/TMP '$WP_PLUGINS'/$(basename {})' \;
fi


if [ -d "$DEV_THEMES" ];
then
    find "$DEV_THEMES" \
        -maxdepth 1 \
        -mindepth 1 \
        -exec cp -a {} $WP_THEMES/TMP \; \
        -exec echo 'rm -rf '$WP_THEMES'/$(basename {})'  \; \
        -exec sh -c 'rm -rf '$WP_THEMES'/$(basename {})'  \; \
        -exec echo 'mv '$WP_THEMES'/TMP '$WP_THEMES'/$(basename {})' \; \
        -exec sh -c 'mv '$WP_THEMES'/TMP '$WP_THEMES'/$(basename {})' \;
fi
cp -ra plugins/* wp-content/plugins/
cp -ra themes/* wp-content/themes/
chown -R www-data:www-data /var/www/html/wp-content
