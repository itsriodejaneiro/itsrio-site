
FROM node:11
LABEL mantainer "hacklab/ <contato@hacklab.com.br>"

COPY themes /var/www/themes
WORKDIR /var/www/themes/its-rio 

RUN npm install --global gulp-cli
RUN npm install
RUN gulp


FROM hacklab/wordpress:v5.3.2-php7.3

USER www-data
COPY --from=0 /var/www/themes/its-rio /var/www/html/wp-content/themes/its-rio

COPY compose/entrypoint-extra /docker-entrypoint-extra
COPY compose/production/wordpress/php/extra.ini /usr/local/etc/php/conf.d/extra.ini
COPY compose/production/wordpress/wp-config.d/ /var/www/html/wp-config.d

#COPY custom plugins 
COPY plugins /var/www/html/wp-content/plugins

# Fix file permissions
USER root
RUN a2enmod headers remoteip          \
    && {                              \
        date;                         \
        printf "%-45s %-45s %s";      \
    } > /var/www/html/versioninfo.txt