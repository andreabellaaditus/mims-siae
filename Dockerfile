# Usa l'immagine base PHP 8.3 FPM su Alpine
FROM php:8.4-fpm-alpine

# Aggiorna e installa pacchetti necessari
RUN apk update && apk add --no-cache \
    git \
    curl \
    make \
    icu-dev \
    zlib-dev \
    openssl-dev \
    openldap-dev \
    oniguruma-dev \
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
    nodejs npm \
    nginx \
    wget

# Crea la directory per nginx
RUN mkdir -p /run/nginx

# Copia il file di configurazione di nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf

# Crea e copia l'applicazione
RUN mkdir -p /app
COPY . /app

RUN apk add --no-cache ${PHPIZE_DEPS} imagemagick imagemagick-dev
RUN pecl install -o -f imagick\
    &&  docker-php-ext-enable imagick
RUN apk del --no-cache ${PHPIZE_DEPS}

# Installa le estensioni PHP necessarie
RUN docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install gd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install mbstring \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install xml \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install simplexml


# Installa Composer e dipendenze PHP
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN cd /app && /usr/local/bin/composer install --no-dev

# Installa le dipendenze Node.js e build
RUN cd /app && npm install && npm run build

# Assegna i permessi alla directory dell'app
RUN chown -R www-data:www-data /app
# Comando di avvio
CMD ["sh", "/app/docker/startup.sh"]
