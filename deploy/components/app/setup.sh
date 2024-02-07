# install composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apk --no-cache add \
    mysql-client \
    sqlite \
    libgomp

docker-php-ext-install pdo_mysql

RUN apk --no-cache add pcre-dev magemagick-dev \
      && pecl install redis \
      && docker-php-ext-enable redis \
      && pecl install imagick \
      && docker-php-ext-enable imagick \
      && apk del pcre-dev imagemagick-dev \
      && rm -rf /tmp/pear


# add group & user for running app as non root user
addgroup -g 1000 -S app \
  && adduser -u 1000 -S app -G app \
  && chown app .