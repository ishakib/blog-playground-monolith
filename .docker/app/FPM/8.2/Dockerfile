FROM php:8.2-fpm-alpine

ARG APP_DIR=/var/www
WORKDIR $APP_DIR

# Install prebuilt PHP extensions and dependencies
RUN set -eux && \
    apk add --no-cache \
        bash git icu-dev libzip-dev libpng-dev libjpeg-turbo-dev libwebp-dev freetype-dev \
        imagemagick imagemagick-dev \
        zlib-dev curl-dev postgresql-dev npm zip vim nano \
        php82-gd php82-intl php82-pgsql php82-pdo_pgsql php82-bcmath php82-zip php82-pcntl \
        php82-pecl-redis php82-pecl-imagick php82-opcache gnu-libiconv && \
    ln -s /usr/lib/preloadable_libiconv.so /usr/lib/preloadable_libiconv.so.php

ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so.php

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Copy PHP configuration
COPY .docker/app/FPM/8.2/opcache.ini $PHP_INI_DIR/conf.d/
COPY .docker/app/FPM/8.2/php.ini $PHP_INI_DIR/conf.d/

# Create Laravel directories with correct permissions
RUN mkdir -p $APP_DIR/bootstrap/cache $APP_DIR/storage/logs && \
    touch $APP_DIR/storage/logs/worker.log && \
    chmod -R 775 $APP_DIR/bootstrap/cache $APP_DIR/storage && \
    chown -R www-data:www-data $APP_DIR

# Add entrypoint
COPY .docker/app/FPM/8.2/init.sh /usr/bin/startx.sh
RUN chmod +x /usr/bin/startx.sh

ENTRYPOINT ["/usr/bin/startx.sh"]
