FROM hacklab/wordpress:v5.3.2-php7.3
# COPY custom themes
COPY themes /var/www/themes
RUN chown -R www-data: /var/www/themes
USER www-data

COPY compose/entrypoint-extra /docker-entrypoint-extra
COPY compose/production/wordpress/php/extra.ini /usr/local/etc/php/conf.d/extra.ini
COPY compose/production/wordpress/wp-config.d/ /var/www/html/wp-config.d

#COPY custom plugins 
COPY plugins /var/www/plugins
COPY mu-plugins /var/www/mu-plugins


# Fix file permissions
USER root
RUN chown -R www-data:www-data wp-content

RUN a2enmod headers remoteip          \
    && {                              \
        date;                         \
        printf "%-45s %-45s %s";      \
    } > /var/www/html/versioninfo.txt