FROM php:8.3-fpm-alpine

RUN apk update && \
    apk add \
        git \
        curl \
        make \
        icu-dev \
        zlib-dev \
        openssl-dev \
        openldap-dev \
        oniguruma-dev \
        imagemagick-dev \
        gnu-libiconv \
        libtool \
        libmagic \
        libpq \
        libltdl \
        libjpeg \
        libpng-dev \
        libxpm-dev \
        libvpx-dev \
        libxml2-dev \
        libwebp-dev \
        libssh2-dev \
        libmcrypt-dev \
        libexif-dev \
        libxslt-dev \
        libmemcached-dev \
        libzip-dev \
        libjpeg-turbo-dev \
        nodejs npm

RUN apk add --no-cache nginx wget

RUN mkdir -p /run/nginx

COPY docker/nginx.conf /etc/nginx/nginx.conf

RUN mkdir -p /app
COPY . /app

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-install mbstring
RUN docker-php-ext-configure zip
RUN docker-php-ext-install zip
RUN docker-php-ext-install xml
RUN docker-php-ext-install bcmath

#RUN docker-php-ext-install iconv
RUN docker-php-ext-install simplexml
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
#RUN /usr/local/bin/composer install --no-dev
RUN cd /app && \
    /usr/local/bin/composer install --no-dev

RUN cd /app && \
    npm install && \
    npm run build;

RUN chown -R www-data: /app

CMD sh /app/docker/startup.sh
