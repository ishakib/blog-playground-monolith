FROM php:8.3-fpm-alpine

ARG APP_DIR=/var/www
WORKDIR $APP_DIR

# Add repositories and install dependencies in one go
RUN set -eux && \
    rm -f /etc/apk/repositories && \
    echo "http://dl-cdn.alpinelinux.org/alpine/v3.18/main" >> /etc/apk/repositories && \
    echo "http://dl-cdn.alpinelinux.org/alpine/v3.18/community" >> /etc/apk/repositories && \
    apk update && apk add --no-cache \
        bash \
        git \
        make \
        g++ \
        gcc \
        build-base \
        icu-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        libwebp-dev \
        freetype-dev \
        imagemagick \
        imagemagick-dev \
        zlib-dev \
        curl-dev \
        postgresql-dev \
        npm \
        zip \
        vim \
        nano \
        php82-pear \
        php82-dev \
        gnu-libiconv && \
    ln -s /usr/lib/preloadable_libiconv.so /usr/lib/preloadable_libiconv.so.php

ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so.php

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        pgsql \
        bcmath \
        intl \
        gd \
        pcntl \
        zip && \
    pecl install redis && docker-php-ext-enable redis

# Install Imagick extension
RUN git clone --depth 1 https://github.com/Imagick/imagick.git /tmp/imagick && \
    cd /tmp/imagick && phpize && ./configure && make && make install && \
    docker-php-ext-enable imagick && rm -rf /tmp/imagick

# Enable opcache
RUN docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# Copy PHP configs
COPY .docker/app/opcache.ini $PHP_INI_DIR/conf.d/
COPY .docker/app/php.ini $PHP_INI_DIR/conf.d/

# Setup Laravel directories
RUN mkdir -p $APP_DIR/bootstrap/cache $APP_DIR/storage/logs && \
    touch $APP_DIR/storage/logs/worker.log && \
    chmod -R 775 $APP_DIR/bootstrap/cache $APP_DIR/storage && \
    chown -R www-data:www-data $APP_DIR

# Copy entrypoint
COPY .docker/app/init.sh /usr/bin/startx.sh
RUN chmod +x /usr/bin/startx.sh

ENTRYPOINT ["/usr/bin/startx.sh"]
