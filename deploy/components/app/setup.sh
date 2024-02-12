curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

apk --no-cache add \
    make \
    g++ \
    autoconf \
    mysql-client \
    sqlite \
    libgomp \
    pcre-dev \
    imagemagick-dev

# Install PHP extensions
docker-php-ext-install pdo_mysql pcntl

# Install redis
pecl install redis

addgroup -g 1000 -S app \
  && adduser -u 1000 -S app -G app \
  && chown app .