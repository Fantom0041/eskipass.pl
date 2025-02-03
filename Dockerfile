FROM php:7.4-fpm



# Install system dependencies
RUN apt-get update && \
    apt-get install -qy \
    git \
    curl \
    libmcrypt-dev \
    zlib1g-dev \
    libz-dev \
    libpq-dev \
    libjpeg-dev \
    libssl-dev \
    libmcrypt-dev \
    libxml2-dev \
    libbz2-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    ca-certificates \
    apache2-utils

# Create Apache directories and set permissions
RUN mkdir -p /usr/local/apache2/logs && \
    mkdir -p /usr/local/apache2/run && \
    mkdir -p /var/log/apache2 && \
    chown -R www-data:www-data /usr/local/apache2/logs && \
    chown -R www-data:www-data /usr/local/apache2/run && \
    chown -R www-data:www-data /var/log/apache2 && \
    chmod -R 777 /usr/local/apache2/logs && \
    chmod -R 777 /usr/local/apache2/run && \
    chmod -R 777 /var/log/apache2



# Download and install MongoDB extension manually
RUN curl -L https://pecl.php.net/get/mongodb-1.15.0.tgz -o mongodb.tgz && \
    pecl install mongodb.tgz && \
    rm mongodb.tgz && \
    docker-php-ext-enable mongodb

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    zip \
    gd \
    mysqli

# Install composer with proxy settings
COPY --from=composer:2.2 /usr/bin/composer /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_HOME=/composer

# Create app user and group
RUN groupadd -g 1000 appgroup && \
    useradd -u 1000 -g appgroup -m -s /bin/bash appuser

# Create necessary directories with proper permissions
RUN mkdir -p /var/run/php-fpm && \
    mkdir -p /code/versions && \
    mkdir -p /code/storage/logs && \
    mkdir -p /code/storage/cache && \
    mkdir -p /code/versions/_engine_v1_0/libs && \
    mkdir -p /code/versions/website_v1_0 && \
    chown -R appuser:appgroup /code /var/run/php-fpm && \
    chmod -R 755 /code && \
    chmod -R 775 /code/storage && \
    chmod -R 775 /code/versions

# Copy PHP-FPM configuration
COPY php/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf
RUN chown -R appuser:appgroup /usr/local/etc/php-fpm.d

# Configure PHP for proxy
RUN echo "curl.cainfo=/etc/ssl/certs/ca-certificates.crt" >> /usr/local/etc/php/conf.d/curl.ini && \
    echo "openssl.cafile=/etc/ssl/certs/ca-certificates.crt" >> /usr/local/etc/php/conf.d/openssl.ini

WORKDIR /code

USER appuser