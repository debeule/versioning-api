curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

apk --no-cache add \
    mysql-client \
    sqlite \
    libgomp \
    pcre-dev \
    autoconf \
    imagemagick-dev \   
    build-base

# Install PHP extensions
docker-php-ext-install pdo_mysql pcntl  \
    && pecl install redis \
    && docker-php-ext-enable redis

addgroup -g 1000 -S app \
  && adduser -u 1000 -S app -G app \
  && chown app .